 @extends('front.layout.layout')
 @section('content')

<style>
    .product-singl-filter {
  display: flex;
  align-items: center;
  margin-bottom: 1rem;
}
.product-singl-filter label {
  margin-right: 4.2rem;
  min-width: 5rem;
  margin-bottom: 0;
  color: #777;
  font-weight: 400;
  font-family: "Open Sans", sans-serif;
  letter-spacing: 0.005em;
  text-transform: uppercase;
}
.product-singl-filter .config-swatch-list {
  display: inline-flex;
  margin: 0;
}
.product-singl-filter .config-size-list li {
  margin-bottom: 0;
  margin-right: 0;
  color: #777;
}
.product-singl-filter .config-size-list li a {
  margin: 3px 6px 3px 0;
  min-width: 3.2rem;
  height: 2.6rem;
  border: 1px solid #eee;
  color: inherit;
  font-size: 1.1rem;
  font-weight: 500;
  line-height: 2.6rem;
  background-color: #fff;
}
.product-singl-filter .config-size-list li a:not(.disabled):hover {
  border-color: #08C;
  background-color: #08C;
  color: #fff;
}
.product-singl-filter .config-size-list li a.disabled {
  cursor: not-allowed;
  text-decoration: none;
  background-color: transparent;
  opacity: 0.5;
}
.product-singl-filter .config-size-list li a.filter-color {
  height: 2.8rem;
  min-width: 2.8rem;
}
.product-singl-filter .config-size-list li.active a {
  border-color: #08C;
  outline: none;
  color: #fff;
  background-color: #08C;
}
.product-singl-filter .config-size-list li.active a.filter-color:before {
  display: inline-block;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translateX(-50%) translateY(-50%);
  font-family: "porto";
  font-size: 1.1rem;
  line-height: 1;
  content: "";
}

    </style>
  <main class="main">
            <div class="container">
                <nav aria-label="breadcrumb" class="breadcrumb-nav">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home"></i></a></li>
                        @if($product->category)
                        {{-- if parent category exists --}}
                        @if($product->category->parentcategory)
                        <li class="breadcrumb-item">
                            <a href="{{ url($product->category->parentcategory->url) }}">
                            {{ $product->category->parentcategory->name }}
                        </a>
                        </li>
                        @endif

                        {{-- current category --}}
                         <li class="breadcrumb-item">
                            <a href="{{ url($product->category->url) }}">
                            {{ $product->category->name }}
                        </a>
                        </li>
                        @endif

                        {{-- product name --}}
                        <li class="breadcrumb-item active" aria-current="page">{{ $product->product_name }}</li>

                    </ol>
                </nav>

                <div class="product-single-container product-single-default">
                    <div class="cart-message d-none">
                        <strong class="single-cart-notice">“Men Black Sports Shoes”</strong>
                        <span>has been added to your cart.</span>
                    </div>

                    <div class="row">
                        <div class="col-lg-5 col-md-6 product-single-gallery">
                            <div class="product-slider-container">
                                @php
                                    $images = [];
                                    if($product->main_image){
                                        $images[] = $product->main_image;
                                    }
                                    foreach ($product->product_images as $img) {
                                        $images[] = $img->image;
                                    }
                                @endphp

                                @if($product->product_discount >0)
                                <div class="label-group">
                                    <div class="product-label label-hot">HOT</div>
                                    <!---->
                                    <div class="product-label label-sale">
                                       {{ $product->product_discount }}%
                                    </div>
                                </div>
                                @endif

                              <div class="product-single-carousel owl-carousel owl-theme show-nav-hover">
                                    @foreach($images as $image)
                                        <div class="product-item">

                                                <img
                                                    class="product-single-image zoom-image"
                                                    src="{{ asset('front/img/products/' . $image) }}"
                                                    data-zoom-image="{{ asset('front/img/products/' . $image) }}"
                                                    width="468"
                                                    height="468"
                                                    alt="product"
                                                    style="display:block; width:100%; height:auto;"
                                                />

                                        </div>
                                    @endforeach
                                    {{-- Product Video (As Last Slide) --}}
                                    @if (!empty($product->product_video))
                                          <div class="product-item">

                                            <video class="product-single-image zoom-image" controls>
                                                <source src="{{ asset('front/videos/products/' . $product->product_video) }}"
                                                    type="video/mp4">
                                                    Your Browser does not support the video tag.
                                            </video>
                                           </div>

                                    @endif
                                </div>

                                <!-- End .product-single-carousel -->
                                <span class="prod-full-screen">
                                    <i class="icon-plus"></i>
                                </span>
                            </div>

                            <div class="prod-thumbnail owl-dots">
                                                            @foreach($images as $image)
                                                                    <div style="width:100%; aspect-ratio: 1 / 1; overflow:hidden;">
                                        <img
                                            src="{{ asset('front/img/products/' . $image) }}"
                                            alt="product-thumbnail"
                                            style="
                                                width:100%;
                                                height:100%;
                                                object-fit:cover;
                                                display:block;
                                            "
                                        />
                                    </div>
                                @endforeach


                            </div>
                        </div>
                        <!-- End .product-single-gallery -->

                        <div class="col-lg-7 col-md-6 product-single-details">
                           <form id="addToCart" method="POST" action="{{ route('cart.store') }}">
                                        @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <h1 class="product-title">{{ $product->product_name }}</h1>



                            <div class="ratings-container">
                                <div class="product-ratings">
                                    <span class="ratings" style="width:60%"></span>
                                    <!-- End .ratings -->
                                    <span class="tooltiptext tooltip-top"></span>
                                </div>
                                <!-- End .product-ratings -->

                                <a href="#" class="rating-link">( 6 Reviews )</a>
                            </div>
                            <!-- End .ratings-container -->

                            <hr class="short-divider">

                            <div class="price-box getAttributePrice">
                                @if($pricing['has_discount'])
                                <span class="old-price">{{ formatCurrency(number_format($pricing['base_price'])) }}</span>
                                <span class="new-price">${{ formatCurrency(number_format($pricing['final_price'])) }}</span>
                                @else
                                <span class="new-price">${{ formatCurrency(number_format($pricing['final_price'])) }}</span>
                                @endif
                            </div>
                            <!-- End .price-box -->

                             @if(!empty($product->description))
                            <div class="product-desc">
                                <p>
                                    {{ $product->description }}
                                </p>
                            </div>
                                @endif
                            <!-- End .product-desc -->

                            <ul class="single-info-list">
                                <!---->
                                <li>
                                SKU:
                                <strong class="skuText">{{ optional($product->attributes->first())->sku ?? 'N/A' }}</strong>
                            </li>


                                <li>
                                    CATEGORY:
                                    <strong>
                                        <a href="#" class="product-category">{{ $product->category->name }}</a>
                                    </strong>
                                </li>


                            </ul>

                            <div class="product-filters-container">
                            @if($product->group_products->isNotEmpty())
                                <div class="product-singl-filter">
                                    <label>Color:</label>
                                    <ul class="config-size-list config-color-list config-filter-list">
                                        @foreach($product->group_products as $gp)
                                            <li class="color-swatch {{ $gp->id == $product->id ? 'active' : '' }}">
                                                <a href="{{ $gp->id == $product->id ? '#' : url($gp->product_url) }}"
                                                class="filter-color border-0"
                                                style="background-color: {{ strtolower($gp->family_color) }};
                                                        @if(strtolower($gp->family_color) == 'white') border:1px solid #ccc; @endif"
                                                title="{{ ucfirst($gp->family_color) }}"></a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif




                               <div class="product-single-filter d-flex align-items-center flex-wrap">
                                        <label class="mb-0 mr-2">Size:</label>

                                        <div class="d-flex align-items-center flex-wrap">
                                            @foreach ($product->attributes as $loopAttr)
                                                <div class="custom-control custom-radio mr-3 mb-2">
                                                    <input type="radio"
                                                        class="custom-control-input getPrice"
                                                        id="size-{{ $loopAttr->id }}"
                                                        name="size"
                                                        value="{{ $loopAttr->size }}"
                                                        data-product-id="{{ $product->id }}"
                                                        {{ $pricing['preselected_size'] == $loopAttr->size ? 'checked' : ($loop->first ? 'checked' : '') }}>

                                                    <label class="custom-control-label" for="size-{{ $loopAttr->id }}">
                                                        {{ $loopAttr->size }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>

                                 <div class="product-action">
                                <div class="product-single-qty">
                                    <input class="horizontal-quantity form-control" type="text" name="qty">
                                </div>
                                <!-- End .product-single-qty -->
                                @if($product->attributes->count() > 0)
                               <button type="submit" class="btn btn-primary px-3">
                                <i class="fa fa-shopping-cart mr-1"></i> Add To Cart
                               </button>
                               @else
                                <p class="text-danger"> This Product is not Availabel for Purchase </p>
                               @endif


                             {{-- Success/Error Message --}}
                             <div class="print-success-msg" style="display:none;font-size:14px;"></div>
                             <div class="print-error-msg" style="display:none;font-size:14px;"></div>
                            </div>


                            <!-- End .product-action -->

                            <hr class="divider mb-0 mt-0">

                            <div class="product-single-share mb-2">
                                <label class="sr-only">Share:</label>

                                <div class="social-icons mr-2">
                                    <a href="#" class="social-icon social-facebook icon-facebook" target="_blank" title="Facebook"></a>
                                    <a href="#" class="social-icon social-twitter icon-twitter" target="_blank" title="Twitter"></a>
                                    <a href="#" class="social-icon social-linkedin fab fa-linkedin-in" target="_blank" title="Linkedin"></a>
                                    <a href="#" class="social-icon social-gplus fab fa-google-plus-g" target="_blank" title="Google +"></a>
                                    <a href="#" class="social-icon social-mail icon-mail-alt" target="_blank" title="Mail"></a>
                                </div>
                                <!-- End .social-icons -->

                                <a href="wishlist.html" class="btn-icon-wish add-wishlist" title="Add to Wishlist"><i
                                        class="icon-wishlist-2"></i><span>Add to
                                        Wishlist</span></a>
                            </div>
                            <!-- End .product single-share -->
                            </form>
                        </div>
                        <!-- End .product-single-details -->
                    </div>
                    <!-- End .row -->
                </div>
                <!-- End .product-single-container -->

                <div class="product-single-tabs">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="product-tab-desc" data-toggle="tab" href="#product-desc-content" role="tab" aria-controls="product-desc-content" aria-selected="true">Description</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="product-tab-size" data-toggle="tab" href="#product-size-content" role="tab" aria-controls="product-size-content" aria-selected="true">Size Guide</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="product-tab-tags" data-toggle="tab" href="#product-tags-content" role="tab" aria-controls="product-tags-content" aria-selected="false">Wash Care</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="product-tab-reviews" data-toggle="tab" href="#product-reviews-content" role="tab" aria-controls="product-reviews-content" aria-selected="false">Reviews (1)</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="product-desc-content" role="tabpanel" aria-labelledby="product-tab-desc">
                            <div class="product-desc-content">
                                <p>{{ $product->description }} </p>
                            </div>
                            <!-- End .product-desc-content -->
                        </div>
                        <!-- End .tab-pane -->

                        <div class="tab-pane fade" id="product-size-content" role="tabpanel" aria-labelledby="product-tab-size">
                            <div class="product-size-content">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="{{ asset('front/img/elements/banners/slide1.jpg') }}" alt="body shape" width="217" height="398">
                                    </div>
                                    <!-- End .col-md-4 -->

                                    <div class="col-md-8">
                                        <table class="table table-size">
                                            <thead>
                                                <tr>
                                                    <th>SIZE</th>
                                                    <th>CHEST (in.)</th>
                                                    <th>WAIST (in.)</th>
                                                    <th>HIPS (in.)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>XS</td>
                                                    <td>34-36</td>
                                                    <td>27-29</td>
                                                    <td>34.5-36.5</td>
                                                </tr>
                                                <tr>
                                                    <td>S</td>
                                                    <td>36-38</td>
                                                    <td>29-31</td>
                                                    <td>36.5-38.5</td>
                                                </tr>
                                                <tr>
                                                    <td>M</td>
                                                    <td>38-40</td>
                                                    <td>31-33</td>
                                                    <td>38.5-40.5</td>
                                                </tr>
                                                <tr>
                                                    <td>L</td>
                                                    <td>40-42</td>
                                                    <td>33-36</td>
                                                    <td>40.5-43.5</td>
                                                </tr>
                                                <tr>
                                                    <td>XL</td>
                                                    <td>42-45</td>
                                                    <td>36-40</td>
                                                    <td>43.5-47.5</td>
                                                </tr>
                                                <tr>
                                                    <td>XLL</td>
                                                    <td>45-48</td>
                                                    <td>40-44</td>
                                                    <td>47.5-51.5</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- End .row -->
                            </div>
                            <!-- End .product-size-content -->
                        </div>
                        <!-- End .tab-pane -->

                        <div class="tab-pane fade" id="product-tags-content" role="tabpanel" aria-labelledby="product-tab-tags">
                            <div class="product-desc-content">
                                <p>{{ $product->wash_care }} </p>
                            </div>
                        </div>
                        <!-- End .tab-pane -->

                        <div class="tab-pane fade" id="product-reviews-content" role="tabpanel" aria-labelledby="product-tab-reviews">
                            <div class="product-reviews-content">
                                <h3 class="reviews-title">1 review for Men Black Sports Shoes</h3>

                                <div class="comment-list">
                                    <div class="comments">
                                        <figure class="img-thumbnail">
                                            <img src="assets/images/blog/author.jpg" alt="author" width="80" height="80">
                                        </figure>

                                        <div class="comment-block">
                                            <div class="comment-header">
                                                <div class="comment-arrow"></div>

                                                <div class="ratings-container float-sm-right">
                                                    <div class="product-ratings">
                                                        <span class="ratings" style="width:60%"></span>
                                                        <!-- End .ratings -->
                                                        <span class="tooltiptext tooltip-top"></span>
                                                    </div>
                                                    <!-- End .product-ratings -->
                                                </div>

                                                <span class="comment-by">
                                                    <strong>Joe Doe</strong> – April 12, 2018
                                                </span>
                                            </div>

                                            <div class="comment-content">
                                                <p>Excellent.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="divider"></div>

                                <div class="add-product-review">
                                    <h3 class="review-title">Add a review</h3>

                                    <form action="#" class="comment-form m-0">
                                        <div class="rating-form">
                                            <label for="rating">Your rating <span class="required">*</span></label>
                                            <span class="rating-stars">
                                                <a class="star-1" href="#">1</a>
                                                <a class="star-2" href="#">2</a>
                                                <a class="star-3" href="#">3</a>
                                                <a class="star-4" href="#">4</a>
                                                <a class="star-5" href="#">5</a>
                                            </span>

                                            <select name="rating" id="rating" required="" style="display: none;">
                                                <option value="">Rate…</option>
                                                <option value="5">Perfect</option>
                                                <option value="4">Good</option>
                                                <option value="3">Average</option>
                                                <option value="2">Not that bad</option>
                                                <option value="1">Very poor</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Your review <span class="required">*</span></label>
                                            <textarea cols="5" rows="6" class="form-control form-control-sm"></textarea>
                                        </div>
                                        <!-- End .form-group -->


                                        <div class="row">
                                            <div class="col-md-6 col-xl-12">
                                                <div class="form-group">
                                                    <label>Name <span class="required">*</span></label>
                                                    <input type="text" class="form-control form-control-sm" required>
                                                </div>
                                                <!-- End .form-group -->
                                            </div>

                                            <div class="col-md-6 col-xl-12">
                                                <div class="form-group">
                                                    <label>Email <span class="required">*</span></label>
                                                    <input type="text" class="form-control form-control-sm" required>
                                                </div>
                                                <!-- End .form-group -->
                                            </div>

                                            <div class="col-md-12">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="save-name" />
                                                    <label class="custom-control-label mb-0" for="save-name">Save my
                                                        name, email, and website in this browser for the next time I
                                                        comment.</label>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="submit" class="btn btn-primary" value="Submit">
                                    </form>
                                </div>
                                <!-- End .add-product-review -->
                            </div>
                            <!-- End .product-reviews-content -->
                        </div>
                        <!-- End .tab-pane -->
                    </div>
                    <!-- End .tab-content -->
                </div>
                <!-- End .product-single-tabs -->

                <div class="products-section pt-0">
                    <h2 class="section-title">Related Products</h2>

                    <div class="products-slider owl-carousel owl-theme dots-top dots-small">
                        @foreach($product->similar_products as $similar)
                        @php
                            $fallbackImage = asset('front/img/products/no-image.jpg');

                            $images = $similar->product_images ?? collect();

                            $mainImage = $similar->main_image
                                ? asset('product-image/medium/' . $similar->main_image)
                                : ($images->isNotEmpty()
                                    ? asset('product-image/medium/' . $images->first()->image)
                                    : $fallbackImage);

                            // Hover image = second image if exists, otherwise fallback
                            $hoverImage = $images->count() > 1
                                ? asset('product-image/medium/' . $images->get(0)->image)
                                : $fallbackImage;
                        @endphp

                        <div class="product-default">
                            <figure>
                               <a href="{{ url($similar['product_url']) }}">
                                    <img src="{{ $mainImage }}"
                                        alt="{{ $similar->product_name }}"
                                        onerror="this.src='{{ $fallbackImage }}'">

                                    <img src="{{ $hoverImage }}"
                                        alt="{{ $similar->product_name }}"
                                        onerror="this.src='{{ $fallbackImage }}'">
                                </a>
                                 @if($similar['product_discount']>0)
                                <div class="label-group">
                                    <div class="product-label label-hot">HOT</div>
                                    <div class="product-label label-sale">{{
                                    $similar['product_discount']}}%</div>
                                </div>
                                @endif
                            </figure>
                            <div class="product-details">
                                <div class="category-list">
                                    <a href="{{ url($similar['product_url']) }}" class="product-category">
                                        {{ $similar->category->name ?? 'Uncategorized' }}
                                    </a>
                                </div>
                                <h3 class="product-title">
                                  <a href="{{ url($similar['product_url']) }}">{{ $similar['product_name'] }}</a>
                                </h3>
                                <div class="ratings-container">
                                    <div class="product-ratings">
                                        <span class="ratings" style="width:80%"></span>
                                        <!-- End .ratings -->
                                        <span class="tooltiptext tooltip-top"></span>
                                    </div>
                                    <!-- End .product-ratings -->
                                </div>
                                <!-- End .product-container -->
                                       @if($similar['product_discount']>0)
                                <div class="price-box">
                                    <del class="old-price">${{ $similar['product_price'] }}</del>
                                    <span class="product-price">${{ $similar['final_price'] }}</span>
                                </div>
                                @else
                                 <div class="price-box">
                                   <span class="product-price">${{ $similar['final_price'] }}</span>
                                </div>
                                @endif
                                <!-- End .price-box -->
                                <div class="product-action">

                                    <a href="#" class="btn-icon btn-add-cart"><i
											class="fa fa-arrow-right"></i><span>Add to Cart</span></a>
                                    {{-- <a href="ajax/product-quick-view.html" class="btn-quickview" title="Quick View"><i
											class="fas fa-external-link-alt"></i></a> --}}
                                </div>
                            </div>
                            <!-- End .product-details -->
                        </div>
                        @endforeach




                    </div>
                    <!-- End .products-slider -->
                </div>
                <!-- End .products-section -->

                <hr class="mt-0 m-b-5" />


                <!-- End .row -->
            </div>
            <!-- End .container -->
        </main>
        <!-- End .main -->



 @endsection
