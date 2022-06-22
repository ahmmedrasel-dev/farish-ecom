<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\States;
use App\Models\Transaction;
use App\Models\UserDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
  private $VIEW_PATH = 'frontend.pages.';

  public function checkout()
  {
    if (session('cart')) {
      $states = States::get();
      return view($this->VIEW_PATH . 'checkout', compact('states'));
    }
    return redirect('/');
  }

  public function coupon(Request $request)
  {
    try {
      $cart = getCart();
      $product_ids = [];
      $category_ids = [];

      foreach ($cart['cart'] as $item) {
        if(!in_array($item['product_id'], $product_ids)){
          array_push($product_ids, $item['product_id']);
        }

        $product = Product::find($item['product_id']);
        if(!empty($product)){
          if (!in_array($product->category_id, $category_ids)) {
            array_push($category_ids, $product->category_id);
          }
        }
      }
      
      $coupon = Coupon::where('code', $request->coupon)->first();
      if (!empty($coupon)) {
        if (Carbon::now()->format('Y-m-d') <= $coupon->end) {
          if ($cart['total'] >= $coupon->min_shopping_amount) {
            if ($coupon->type == 'Cart') {
              $discount = $coupon->discount;
            } elseif ($coupon->type == 'Product') {
              $arr = json_decode($coupon->product_ids);
              $product_arr = [];
              foreach ($arr as $item) {
                if(!in_array($item, $product_arr)){
                  array_push($product_arr, $item);
                }
              }
              if(count(array_values(array_intersect($product_ids, $product_arr))) > 0){
                $discount = $coupon->discount;
              }else{
                return redirect()->back()->with('error', 'This coupon is not for those products !');
              }
            } elseif ($coupon->type == 'Category') {
              $arr = json_decode($coupon->category_ids);
              $cat_arr = [];
              foreach ($arr as $item) {
                $cat_id = explode('-', $item)[1];
                if(!in_array($cat_id, $cat_arr)){
                  array_push($cat_arr, $cat_id);
                }
              }
              if(count(array_values(array_intersect($category_ids, $cat_arr))) > 0){
                $discount = $coupon->discount;
              }else{
                return redirect()->back()->with('error', 'This coupon is not for those categories !');
              }
            }
            if ($coupon->discount_type == 'Percent') {
              $discount = $cart['total'] * ($discount / 100);
            }
            if ($discount > $coupon->max_discount_amount) {
              $discount = $coupon->max_discount_amount;
            }
            Session::put('coupon', [
              'discount' => $discount,
              'code' => $coupon->code
            ]);
            return redirect()->back()->with('success', 'Coupon added successfully !');
          }
          return redirect()->back()->with('error', 'Minimum shopping amount not added for this coupon !');
        }
        return redirect()->back()->with('error', 'Expired coupon !');
      }
      return redirect()->back()->with('error', 'Invalid coupon !');
    } catch (\Throwable $th) {
      return redirect()->back()->with('error', $th->getMessage());
    }
  }

  public function removeCoupon()
  {
    Session::forget('coupon');
    return redirect()->back()->with('info', 'Coupon removed successfully !');
  }

  public function orderPlace(Request $request)
  {
    return $request->all();
    $request->validate([
      'phone' => 'required',
      'state' => 'required',
      'city' => 'required',
      'postal_code' => 'required',
      'address' => 'required'
    ]);

    DB::beginTransaction();
    try {
      $cart = getCart();
      $coupon = Session::get('coupon');
      if ($request->payment_method == 'COD') {
        $userDetails = new UserDetail;
        $userDetails->phone = $request->phone;
        $userDetails->state = $request->state;
        $userDetails->city = $request->city;
        $userDetails->postal_code = $request->postal_code;
        $userDetails->address = $request->address;
        $userDetails->save();

        $order = new Order;
        $order->user_id = auth()->id();
        $order->coupon_id = Coupon::where('code', $coupon['code'])->first()->id;
        $order->shipping_cost = 30;
        $order->amount = $cart['total'];
        $order->payment_method = 'COD';
        $order->save();

        foreach ($cart['cart'] as $item) {
          $product = Product::findOrFail($item->product_id);
          $orderDetails = new OrderDetails;
          $orderDetails->order_id = $order->id;
          $orderDetails->seller_id = $product->seller_id;
          $orderDetails->product_id = $product->id;
          $orderDetails->price = $order->amount;
          $orderDetails->color = $item->ucfirst($item['color']);
          $orderDetails->size = $item->ucfirst($item['size']);
          $orderDetails->save();
        }
        Transaction::create([
          'user_id' => auth()->id(),
          'order_id' => $order->id,
          'amount' => $order->amount,
        ]);
        return redirect('/order-placed/' . $order->id)->with('success', 'Place message !');
      }
      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
      return redirect()->back()->with('error', $e->getMessage());
    }
  }
}
