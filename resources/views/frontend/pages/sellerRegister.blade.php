@extends('frontend.master')
@section('content')
<section class="seller-register">
  <div class="container">
    <div class="row">
      <!-- Shipping Address -->
      <div class="col-lg-7 p-0 left">
        <div class="shipping-form">
          <div class="heading-checkout">
            <h4>Seller Information</h4>
          </div>
          <div class="row mt-3 g-3">
            <div class="col-lg-6">
              <label for="fullName" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="fullName" placeholder="Your Full Name">
            </div>

            <div class="col-lg-6">
              <label for="fullName" class="form-label">Shop Name</label>
              <input type="text" class="form-control" id="fullName" placeholder="Your Full Name">
            </div>

            <div class="col-lg-6">
              <label for="fullName" class="form-label">Shop Logo</label>
              <input type="file" class="form-control" id="fullName" placeholder="Your Full Name">
            </div>

            <div class="col-lg-6">
              <label for="fullName" class="form-label">Selected Package</label>
              <input type="text" class="form-control" id="fullName" value="Basic" readonly>
            </div>

            <div class="col-lg-6">
              <label for="email" class="form-label">Email Address</label>
              <input type="email" class="form-control" id="email" placeholder="Your Email Address">
            </div>
            <div class="col-5 col-md-6 col-lg-6">
              <label for="email" class="form-label">Phone Number</label>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">05</div>
                </div>
                <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Phone Number">
              </div>
            </div>

            <div class="col-lg-5 col-md-6">
              <label for="state" class="form-label">State</label>
              <select id="state" class="form-select state">
                <option selected>Choose State</option>
                <option>Eastern Provence</option>
              </select>
            </div>

            <div class="col-lg-4 col-md-6">
              <label for="city" class="form-label">City</label>
              <select id="city" class="form-select city">
                <option selected>Choose City</option>
                <option>Dammam</option>
              </select>
            </div>

            <div class="col-lg-3 col-md-6">
              <label for="inputZip" class="form-label">Postal Code</label>
              <input type="text" class="form-control" id="inputZip">
            </div>

            <div class="col-12">
              <label for="address" class="form-label">Address</label>
              <input type="text" class="form-control" id="address" placeholder="Apartment, studio, or floor">
            </div>

          </div>
        </div>

        <div class="order-summary">
          <div class="heading-checkout">
            <h4>Your Selected Package</h4>
          </div>
          <div class="row order-item">
            <div class="col-9">
              <h5>Package Name: <strong>Basic</strong></h5>
            </div>
            <div class="col-3 text-end">
              <h4><strong>SAR 2280</strong></h4>
            </div>
          </div>

        </div>

      </div>

      <!-- Order Item % Calculation -->
      <div class="col-lg-5 p-0 right">

        <div class="payment-method">
          <div class="heading-checkout">
            <h4>Select Payment Method</h4>
          </div>
          <ul class="payment-method-list">
            <li>
              <input id="bank" type="checkbox">
              <label for="bank">Direct Bank Transfer</label>
            </li>
            <li>
              <input id="paypal" type="checkbox">
              <label for="paypal">Paypal</label>
            </li>
            <li>
              <input id="card" type="checkbox">
              <label for="card">Credit Card</label>
            </li>
          </ul>
        </div>

        <div class="order-calculation">
          <div class="heading-checkout">
            <h4>Payment Calculation</h4>
          </div>
          <div class="row mt-3 g-3">
            <div class="col-6">
              <h6>Subtotal:</h6>
            </div>
            <div class="col-6">
              <h6 class="price-text sub-total-text text-end"> SAR 2880.00 </h6>
            </div>


            <div class="col-6">
              <h6>Tax:</h6>
            </div>
            <div class="col-6">
              <h6 class="price-text sub-total-text text-end"> SAR 41.40 </h6>
            </div>

            <hr>
            <div class="col-6">
              <h5>Total Amount</h5>
            </div>
            <div class="col-6">
              <h5 class="price-text sub-total-text text-end"> SAR 441.40 </h5>
            </div>
          </div>
        </div>

        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="gridCheck">
          <label class="form-check-label" for="gridCheck">
            By Clicking Registraion, you agree to Terms of Service and Privacy Policy
          </label>
        </div>

        <div class="place-order">
          <button class="place-order-button">Register</button>
        </div>
      </div>
    </div>
  </div>
</section>

<!------------------------------- 
            Subscription Section
      -------------------------------->
<section id="subscription">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-12 p-md-4">
        <div class="row align-items-center">
          <div class="col-md-6 col-lg-7">
            <div class="subscribe-content">
              <h2>Get your update news</h2>
              <p>If you are going to use a passage of Lorem Ipsum, you need to <br>be sure there isn't anything
                embarrassing.</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-5">
            <form action="" class="subscribe-from">
              <div class="input-group">
                <input class="form-control subscribe-input" type="email" placeholder="Put Your Email">
                <button class="subscribe-btn" type="submit">Subscribe</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection