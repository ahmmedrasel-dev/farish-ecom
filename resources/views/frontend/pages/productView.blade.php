@extends('frontend.master')
@section('header_css')
<link rel="stylesheet" href="{{ asset('/frontend/assets') }}/css/jquery.nice-number.min.css">
<link rel="stylesheet" href="{{ asset('/frontend/assets') }}/css/jquery-picZoomer.css">
<link rel="stylesheet" href="{{ asset('/frontend/assets') }}/css/reset.css">
@endsection
@section('content')

<main>
  <section id="product-detials">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="product-image">
            <div class="slider">

              <div class="slide-item">
                <img id="img_01" class="img-fluid"
                  data-zoom-image="{{ asset('backend/uploads/' . $product->thumbnail ) }}"
                  src="{{ asset('backend/uploads/' . $product->thumbnail) }}" alt="Feature Images">
              </div>

              @foreach($product->images as $image)
              <div class="slide-item">
                <img id="img_01" data-zoom-image="{{ asset('backend/uploads/' . $image->image) }}" class="img-fluid"
                  src="{{ asset('backend/uploads/' . $image->image) }}" alt="Feature Images">
              </div>
              @endforeach

            </div>

            <div class="slide-nav">
              <div class="slide-nav-item">
                <img class="w-75" src="{{ asset('backend/uploads/' . $product->thumbnail) }}" alt="product-thubnail">
              </div>

              @foreach($product->images as $image)
              <div class="slide-nav-item">
                <img class="w-75" src="{{ asset('backend/uploads/' . $image->image) }}" alt="product-thubnail">
              </div>
              @endforeach

            </div>
          </div>
        </div>

        <!--------------------------
              Product Content Details
          ---------------------------->
        @php
        $discountAmount = ($product->price - ($product->discount / 100) * $product->price);

        $discount = (($product->discount * 100) / $product->price)
        @endphp

        <div class="col-md-6">
          <div class="product-content">
            <h3 class="title">{{ $product->name }}</h3>
            <p class="summary">{!! Str::limit($product->description, 120) !!}</p>

            @if($product->discount == null )
            <h3 class="price">SAR {{ $product->price }}</h3>
            @endif

            @if($product->discount !== null && $product->discount_type == 'Flat')
            <h3 class="price" data-price="{{ $product->price - $product->discount }}">SAR {{ $product->price -
              $product->discount }}</h3>

            <p class="previous-price">SAR <span class="old-price">{{ $product->price }}</span> <span
                class="discount">OFF {{ $product->discount }} SAR</span>
            </p>
            @endif

            @if($product->discount !== null && $product->discount_type == 'Percent')
            <h3 class="price" data-price="{{ $discountAmount }}">SAR {{ $discountAmount }}</h3>

            <p class="previous-price">SAR <span class="old-price">{{ $product->price }}</span> <span
                class="discount">OFF {{
                round($product->discount) }}%</span>
            </p>
            @endif

            @if(!empty($colors))
            <div class="product-color">
              <p>Color: </p>
              <ul class="d-flex">
                @foreach($colors as $item)
                <li><a href="" onclick="return false" title="{{ $item }}" data-color="{{ $item }}" class="color"
                    style="background-color: {{ strtolower($item) }} !important"></a></li>
                @endforeach
              </ul>
            </div>
            @endif

            @if(!empty($sizes))
            <div class="product-size">
              <p>Size: </p>
              <ul class="d-flex">
                @foreach($sizes as $item)
                <li><a href="" onclick="return false" class="size" data-size="{{ $item }}">{{ ucfirst($item) }}</a></li>
                @endforeach
              </ul>
            </div>
            @endif

            <div class="product-qty mt-5">
              <div class="nice-number">
                <input class="qty-input" type="number" value="1" min="0">
              </div>
              <a href="javascript:void(0)" class="cart-btn" data-productId="{{ $product->id }}">add to cart</a>
              <a href="javascript:void(0)" class="cart-btn-hidden" data-productId="{{ $product->id }}">add to cart</a>
              <a href="" class="add-wishlist"><img src="{{ asset('frontend/assets/') }}/images/heart.png"
                  alt="user-profile"></a>
            </div>

            <p class="category">Category: {{ $product->subcategory->name }}</p>
            <div class="d-flex share-product">
              <p>Share This Item:</p>
              <ul class="d-flex">
                <li class="me-3"><a href="#"><i class="fab fa-twitter"></i></a></li>
                <li class="me-3"><a href="#"><i class="fab fa-instagram"></i></li>
                <li class="me-3"><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
              </ul>
            </div>

            <p class="category">Available Quantity: {{ $product->quantity }} {{ $product->unit }}</p>

            <!-- <div class="installment-payment d-flex border justify-content-between align-items-center">
              <p>or 4 interest-free payment of <br> 300 AED. <a href="#">Learn More</a></p>

              <a href="#"><img class="img-fluid" src="{{ asset('frontend/assets/') }}/images/fitbit-logo.png"
                  alt=""></a>
            </div> -->
          </div>
        </div>
      </div>
    </div>
  </section>

  <!--------------------------
        Product Details
    ---------------------------->
  <section id="product-description">
    <div class="container">
      <div class="row">
        <div class="col-12 product-descriptio-title">
          <ul class="nav mb-3 justify-content-center description-head" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                type="button" role="tab" aria-controls="pills-home" aria-selected="true">Product Description</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
                type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Product
                Information</a>
            </li>
          </ul>
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">{!!
              $product->description !!}</div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
              <table class="table table-bordered">
                <tr>
                  <td class="w-25">Product Name</td>
                  <td>
                    <h6>{{ $product->name }}</h6>
                  </td>
                </tr>
                <tr>
                  <td class="w-25">Product Category: </td>
                  <td>
                    <h6>{{ $product->subcategory->name }}</h6>
                  </td>
                </tr>
                <tr>
                  <td class="w-25">Product Price:</td>
                  <td>
                    @if($product->discount == null )
                    <h6 class="price">SAR {{ $product->price }}</h6>
                    @endif

                    @if($product->discount !== null && $product->discount_type == 'Flat')
                    <h6>SAR {{ $product->price- $product->discount }}</h6>
                    @endif

                    @if($product->discount !== null && $product->discount_type == 'Percent')
                    <h6>SAR {{ $product->price- $product->discount }}</h6>
                    @endif
                  </td>
                </tr>
                <tr>
                  <td class="w-25">Discount:</td>
                  <td>
                    <h6>
                      @if($product->discount !== null && ($product->discount_type == 'Flat' || $product->discount_type
                      == 'Percent'))
                      <span class="discount">OFF {{ $product->discount }} SAR</span>
                      @else
                      <span class="discount">Not Available</span>
                      @endif
                    </h6>
                  </td>
                </tr>
                <tr>
                  <td class="w-25">Available Quantity:</td>
                  <td>
                    <h6>{{ $product->quantity }} {{ $product->unit }}</h6>
                  </td>
                </tr>

                <tr>
                  <td class="w-25">Brand Name:</td>
                  <td>{{ $product->brand ? $product->brand->name : 'N/A' }}</td>
                </tr>

                <tr>
                  <td class="w-25">Color(s)</td>
                  <td>
                    {{ implode(', ', $colors) }}
                  </td>
                </tr>
                <tr>
                  <td class="w-25">Size(s)</td>
                  <td>
                    {{ implode(', ', $sizes) }}
                  </td>
                </tr>

              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!--------------------------
        Related Product
    --------------------------->
  <section id="related-category-product">
    <div class="container">
      <h2 class="section-title text-center mb-4">Related Product</h2>

      <div id="product" class="owl-carousel">
        @foreach($reletedProduct as $item)
        @php
        $discountAmount = ($item->price - ($item->discount / 100) * $item->price);

        $discount = (($item->discount * 100) / $item->price)
        @endphp

        <div class="item">
          <div class="releted-product-item">
            <div class="product-img">
              <a class="w-100" href="{{ route('productView', $item->slug) }}"><img class="img-fluid"
                  src="{{ asset('backend/uploads/' . $item->thumbnail) }}" alt="product-img-1"></a>
            </div>

            <div class="p-3">
              <a href="{{ route('productView', $item->slug) }}" class="product-title">{{ Str::limit($item->name, 25)
                }}</a>

              @if($item->discount == null )
              <div class="d-flex justify-content-between align-items-center">
                <h3 class="new-price my-3 text-dark">SAR <span> {{ $item->price ?? '' }}</span></h3>

                <span class="wishlist"><i class="far fa-heart"></i></span>
              </div>
              @endif

              @if($item->discount !== null && $item->discount_type == 'Flat')
              <h3 class="new-price my-3 text-dark">SAR <span class="text-dark">{{ $item->price- $item->discount
                  }}</span></h3>

              <div class="d-flex justify-content-between">
                <div class="off">
                  <span class="old-price text-dark">SAR {{ $item->price ?? '' }}</span>
                  <span class="discount">SAR {{ $item->discount }} OFF</span>
                </div>
                <span class="wishlist"><i class="far fa-heart"></i></span>
              </div>
              @endif

              @if($item->discount !== null && $item->discount_type == 'Percent')
              <h3 class="new-price my-3 text-dark">SAR <span class="text-dark">{{ $discountAmount }}</span></h3>

              <div class="d-flex justify-content-between">
                <div class="off">
                  <span class="old-price text-dark">SAR {{ $item->price ?? '' }}</span>
                  <span class="discount">{{ round($item->discount) }}% OFF</span>
                </div>
                <span class="wishlist"><i class="far fa-heart"></i></span>
              </div>
              @endif
            </div>
          </div>
        </div>
        @endforeach
      </div>


    </div>
  </section>

</main>
@endsection
@section('footer_js')
<!-- Nice Number -->
<script src="{{ asset('/frontend/assets/') }}/js/jquery.nice-number.min.js"></script>
<script src="https://cdn.rawgit.com/igorlino/elevatezoom-plus/1.1.6/src/jquery.ez-plus.js"></script>

<script>
  // Actice Attributes
  $(document).ready(function () {
    $('.color').click(function () {
      $('li a').removeClass("color-active");
      $(this).addClass("color-active");
    });

    $('.size').click(function () {
      $('li a').removeClass("size-active");
      $(this).addClass("size-active");
    })
  });

  $(document).ready(function () {
    $('.cart-btn').on('click', function (e) {
      e.preventDefault()
      $('.cart-btn').hide()
      $('.cart-btn-hidden').show()
      let productId = $(this).attr('data-productId')
      let quantity = $('.qty-input').val()
      let color = $('.color-active').attr('data-color')
      let size = $('.size-active').attr('data-size')
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      })
      $.ajax({
        url: "{{ url('add-to-cart') }}",
        method: 'POST',
        data: {
          'product_id': productId,
          'quantity': quantity,
          'color': color,
          'size': size
        },
        datType: 'json',
        success: function (data) {
          getCart()
          alert(data)
          $('.cart-btn-hidden').hide()
          $('.cart-btn').show()
        }
      })
    })
  })
</script>
@endsection