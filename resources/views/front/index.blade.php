 @extends('front.layout.layout')
 @section('content')
 <main class="main">
            <div class="home-slider slide-animate owl-carousel owl-theme show-nav-hover nav-big mb-2 text-uppercase" data-owl-options="{
				'loop': false
			}">
            @foreach($homeSliderBanner as $key => $sliderBanner)
                <div class="home-slide home-slide1 banner" style="height: 500px;overflow: hidden;">
                    <img class="slide-bg" src="{{ asset('front/img/banners/' . $sliderBanner['image']) }}"
                    style="width:100%;height:100%;object-fit:cover;" alt="slider image">
                    <div class="container d-flex align-items-center">
                        <div class="banner-layer appear-animate" data-animation-name="fadeInUpShorter">
                           <h2 class="text-transform-none mb-0">{{ $sliderBanner['title'] }}</h2>
                            <h3 class="m-b-3">{{ $sliderBanner['alt'] }}</h3>

                            <a href="#" class="btn btn-dark btn-lg">Shop Now!</a>
                        </div>
                        <!-- End .banner-layer -->
                    </div>
                </div>
                @endforeach
                <!-- End .home-slide -->


                <!-- End .home-slide -->
            </div>
            <!-- End .home-slider -->

            <div class="container">
                <div class="info-boxes-slider owl-carousel owl-theme mb-2" data-owl-options="{
					'dots': false,
					'loop': false,
					'responsive': {
						'576': {
							'items': 2
						},
						'992': {
							'items': 3
						}
					}
				}">
                    <div class="info-box info-box-icon-left">
                        <i class="icon-shipping"></i>

                        <div class="info-box-content">
                            <h4>FREE SHIPPING &amp; RETURN</h4>
                            <p class="text-body">Free shipping on all orders over $99.</p>
                        </div>
                        <!-- End .info-box-content -->
                    </div>
                    <!-- End .info-box -->

                    <div class="info-box info-box-icon-left">
                        <i class="icon-money"></i>

                        <div class="info-box-content">
                            <h4>MONEY BACK GUARANTEE</h4>
                            <p class="text-body">100% money back guarantee</p>
                        </div>
                        <!-- End .info-box-content -->
                    </div>
                    <!-- End .info-box -->

                    <div class="info-box info-box-icon-left">
                        <i class="icon-support"></i>

                        <div class="info-box-content">
                            <h4>ONLINE SUPPORT 24/7</h4>
                            <p class="text-body">Lorem ipsum dolor sit amet.</p>
                        </div>
                        <!-- End .info-box-content -->
                    </div>
                    <!-- End .info-box -->
                </div>
                <!-- End .info-boxes-slider -->

                <div class="banners-container mb-2">
                    <div class="banners-slider owl-carousel owl-theme" data-owl-options="{
						'dots': false
					}">
                    @foreach($homeFixBanner as $key => $fixBanner)
                        <div class="banner banner1 banner-sm-vw d-flex align-items-center appear-animate" style="background-color: #ccc;" data-animation-name="fadeInLeftShorter" data-animation-delay="500">
                            <figure class="w-100">
                                <img src="{{ asset('front/img/banners/' .$fixBanner['image']) }}" alt="banner" width="380" height="175" />
                            </figure>
                            <div class="banner-layer">
                                <h3 class="m-b-2 mt-5">{{ $fixBanner['title'] }}</h3>
                                <h4 class="m-b-3 text-primary">{{ $fixBanner['alt'] }}</h4>
                                <a href="#" class="btn btn-sm btn-dark">Shop Now</a>
                            </div>
                        </div>
                        <!-- End .banner -->
                        @endforeach

                    </div>
                </div>
            </div>
            <!-- End .container -->

            <section class="featured-products-section">
                <div class="container">
                    <h2 class="section-title heading-border ls-20 border-0">Featured Products</h2>

                    <div class="products-slider custom-products owl-carousel owl-theme nav-outer show-nav-hover nav-image-center" data-owl-options="{
						'dots': false,
						'nav': true
					}">
                    @foreach($featuredProducts as $product)
                           @php
                            $fallbackImage = asset('front/img/products/no-image.jpg');

                            $images = $product->product_images ?? collect();

                            $mainImage = $product->main_image
                                ? asset('product-image/medium/' . $product->main_image)
                                : ($images->isNotEmpty()
                                    ? asset('product-image/medium/' . $images->first()->image)
                                    : $fallbackImage);

                            // Hover image = second image if exists, otherwise fallback
                            $hoverImage = $images->count() > 1
                                ? asset('product-image/medium/' . $images->get(0)->image)
                                : $fallbackImage;
                        @endphp

                        <div class="product-default appear-animate" data-animation-name="fadeInRightShorter">
                            <figure>
                              <a href="#">
                                    <img src="{{ $mainImage }}"
                                        alt="{{ $product->product_name }}"
                                        onerror="this.src='{{ $fallbackImage }}'">

                                    <img src="{{ $hoverImage }}"
                                        alt="{{ $product->product_name }}"
                                        onerror="this.src='{{ $fallbackImage }}'">
                                </a>
                                @if($product['product_discount']>0)
                                <div class="label-group">
                                    <div class="product-label label-hot">HOT</div>
                                    <div class="product-label label-sale">{{ $product['product_discount'] }}%</div>
                                </div>
                                @endif
                            </figure>
                            <div class="product-details">
                               <div class="category-list">
                                    <a href="#" class="product-category">
                                        {{ $product->category->name ?? 'Uncategorized' }}
                                    </a>
                                </div>
                                <h3 class="product-title">
                                    <a href="product.html">{{ $product['product_name'] }}</a>
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
                                  @if($product['product_discount']>0)
                                <div class="price-box">
                                    <del class="old-price">{{ formatCurrency($product['product_price']) }}</del>
                                    <span class="product-price">{{ formatCurrency($product['final_price']) }}</span>
                                </div>
                                @else
                                 <div class="price-box">
                                   <span class="product-price">{{ formatCurrency($product['final_price']) }}</span>
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
                    <!-- End .featured-proucts -->
                </div>
            </section>

            <section class="new-products-section">
                <div class="container">
                    <h2 class="section-title heading-border ls-20 border-0">New Arrivals</h2>

                    <div class="products-slider custom-products owl-carousel owl-theme nav-outer show-nav-hover nav-image-center mb-2" data-owl-options="{
						'dots': false,
						'nav': true,
						'responsive': {
							'992': {
								'items': 4
							},
							'1200': {
								'items': 5
							}
						}
					}">

                         @foreach($newArrivalProducts as $newproduct)
                    @php
                            $fallbackImage = asset('front/img/products/no-image.jpg');

                            // Main image
                            $mainImage = $newproduct->main_image
                                ? asset('product-image/medium/' . $newproduct->main_image)
                                : ($newproduct->product_images->first()
                                    ? asset('product-image/medium/' . $newproduct->product_images->first()->image)
                                    : $fallbackImage);

                            // Hover image (SECOND image only)
                            $hoverImage = $newproduct->product_images->first()
                                ? asset('product-image/medium/' . $newproduct->product_images->first()->image)
                                : $mainImage;
                        @endphp
                        <div class="product-default appear-animate" data-animation-name="fadeInRightShorter">
                            <figure>
                              <a href="#">
                                    <img src="{{ $mainImage  }}"  alt="{{ $newproduct->product_name }}">

                                    {{-- Optional hover image (same image or fallback) --}}
                                    <img src="{{ $hoverImage  }}" alt="{{ $newproduct->product_name }}">
                                </a>
                                @if($newproduct['product_discount']>0)
                                <div class="label-group">
                                    <div class="product-label label-hot">HOT</div>
                                    <div class="product-label label-sale">{{ $newproduct['product_discount'] }}%</div>
                                </div>
                                @endif
                            </figure>
                            <div class="product-details">
                                <div class="category-list">
                                   <a href="#" class="product-category">
                                        {{ $newproduct->category->name ?? 'Uncategorized' }}
                                    </a>
                                </div>
                                <h3 class="product-title">
                                    <a href="#">{{ $newproduct['product_name'] }}</a>
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
                             @if($newproduct['product_discount']>0)
                                <div class="price-box">
                                    <del class="old-price">{{ formatCurrency($newproduct['product_price']) }}</del>
                                    <span class="product-price">{{ formatCurrency($newproduct['final_price']) }}</span>
                                </div>
                                @else
                                 <div class="price-box">
                                   <span class="product-price">{{ formatCurrency($newproduct['final_price']) }}</span>
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
                    <!-- End .featured-proucts -->

                    <div class="banner banner-big-sale appear-animate" data-animation-delay="200" data-animation-name="fadeInUpShorter" style="background: #2A95CB center/cover url('assets/images/demoes/demo4/banners/banner-4.jpg');">
                        <div class="banner-content row align-items-center mx-0">
                            <div class="col-md-9 col-sm-8">
                                <h2 class="text-white text-uppercase text-center text-sm-left ls-n-20 mb-md-0 px-4">
                                    <b class="d-inline-block mr-3 mb-1 mb-md-0">Big Sale</b> All new fashion brands items up to 70% off
                                    <small class="text-transform-none align-middle">Online Purchases Only</small>
                                </h2>
                            </div>
                            <div class="col-md-3 col-sm-4 text-center text-sm-right">
                                <a class="btn btn-light btn-white btn-lg" href="category.html">View Sale</a>
                            </div>
                        </div>
                    </div>

                    <h2 class="section-title categories-section-title heading-border border-0 ls-0 appear-animate" data-animation-delay="100" data-animation-name="fadeInUpShorter">Browse Our Categories
                    </h2>

                 <div class="categories-slider owl-carousel owl-theme show-nav-hover nav-outer">
                        @foreach($categories as $category)
                            @php
                                $imagePath = 'front/img/categories/' . ($category['image'] ?? '');
                                $image = (!empty($category['image']) && file_exists(public_path($imagePath)))
                                    ? asset($imagePath)
                                    : asset('front/img/categories/no-image.jpg');
                            @endphp


                            <div class="product-category appear-animate" data-animation-name="fadeInUpShorter">
                                <a href="{{ url( $category['url']) }}">
                                    <figure>
                                      <img src="{{ $image }}"
                                        alt="{{ $category['name'] }}"
                                       style="width: 100%;height: 300px; object-fit: contain;display: block;"
                                        onerror="this.src='{{ asset('front/img/categories/no-image.jpg') }}'">
                                    </figure>
                                    <div class="category-content">
                                        <h3>{{ $category['name'] }}</h3>
                                        <span>
                                            <mark class="count">{{ $category['product_count'] }}</mark> products
                                        </span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                </div>
            </section>

            <section class="feature-boxes-container">
                <div class="container appear-animate" data-animation-name="fadeInUpShorter">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="feature-box px-sm-5 feature-box-simple text-center">
                                <div class="feature-box-icon">
                                    <i class="icon-earphones-alt"></i>
                                </div>

                                <div class="feature-box-content p-0">
                                    <h3>Customer Support</h3>
                                    <h5>You Won't Be Alone</h5>

                                    <p>We really care about you and your website as much as you do. Purchasing Porto or any other theme from us you get 100% free support.</p>
                                </div>
                                <!-- End .feature-box-content -->
                            </div>
                            <!-- End .feature-box -->
                        </div>
                        <!-- End .col-md-4 -->

                        <div class="col-md-4">
                            <div class="feature-box px-sm-5 feature-box-simple text-center">
                                <div class="feature-box-icon">
                                    <i class="icon-credit-card"></i>
                                </div>

                                <div class="feature-box-content p-0">
                                    <h3>Fully Customizable</h3>
                                    <h5>Tons Of Options</h5>

                                    <p>With Porto you can customize the layout, colors and styles within only a few minutes. Start creating an amazing website right now!</p>
                                </div>
                                <!-- End .feature-box-content -->
                            </div>
                            <!-- End .feature-box -->
                        </div>
                        <!-- End .col-md-4 -->

                        <div class="col-md-4">
                            <div class="feature-box px-sm-5 feature-box-simple text-center">
                                <div class="feature-box-icon">
                                    <i class="icon-action-undo"></i>
                                </div>
                                <div class="feature-box-content p-0">
                                    <h3>Powerful Admin</h3>
                                    <h5>Made To Help You</h5>

                                    <p>Porto has very powerful admin features to help customer to build their own shop in minutes without any special skills in web development.</p>
                                </div>
                                <!-- End .feature-box-content -->
                            </div>
                            <!-- End .feature-box -->
                        </div>
                        <!-- End .col-md-4 -->
                    </div>
                    <!-- End .row -->
                </div>
                <!-- End .container-->
            </section>
            <!-- End .feature-boxes-container -->

            <section class="promo-section bg-dark" data-parallax="{'speed': 2, 'enableOnMobile': true}" data-image-src="assets/images/demoes/demo4/banners/banner-5.jpg">
                <div class="promo-banner banner container text-uppercase">
                    <div class="banner-content row align-items-center text-center">
                        <div class="col-md-4 ml-xl-auto text-md-right appear-animate" data-animation-name="fadeInRightShorter" data-animation-delay="600">
                            <h2 class="mb-md-0 text-white">Top Fashion<br>Deals</h2>
                        </div>
                        <div class="col-md-4 col-xl-3 pb-4 pb-md-0 appear-animate" data-animation-name="fadeIn" data-animation-delay="300">
                            <a href="category.html" class="btn btn-dark btn-black ls-10">View Sale</a>
                        </div>
                        <div class="col-md-4 mr-xl-auto text-md-left appear-animate" data-animation-name="fadeInLeftShorter" data-animation-delay="600">
                            <h4 class="mb-1 mt-1 font1 coupon-sale-text p-0 d-block ls-n-10 text-transform-none">
                                <b>Exclusive
									COUPON</b></h4>
                            <h5 class="mb-1 coupon-sale-text text-white ls-10 p-0"><i class="ls-0">UP TO</i><b class="text-white bg-secondary ls-n-10">$100</b> OFF</h5>
                        </div>
                    </div>
                </div>
            </section>

            <section class="blog-section pb-0">
                <div class="container">
                    <h2 class="section-title heading-border border-0 appear-animate" data-animation-name="fadeInUp">
                        Latest News</h2>

                    <div class="owl-carousel owl-theme appear-animate" data-animation-name="fadeIn" data-owl-options="{
						'loop': false,
						'margin': 20,
						'autoHeight': true,
						'autoplay': false,
						'dots': false,
						'items': 2,
						'responsive': {
							'0': {
								'items': 1
							},
							'480': {
								'items': 2
							},
							'576': {
								'items': 3
							},
							'768': {
								'items': 4
							}
						}
					}">
                        <article class="post">
                            <div class="post-media">
                                <a href="single.html">
                                    <img src="assets/images/blog/home/post-1.jpg" alt="Post" width="225" height="280">
                                </a>
                                <div class="post-date">
                                    <span class="day">26</span>
                                    <span class="month">Feb</span>
                                </div>
                            </div>
                            <!-- End .post-media -->

                            <div class="post-body">
                                <h2 class="post-title">
                                    <a href="single.html">Top New Collection</a>
                                </h2>
                                <div class="post-content">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras non placerat mi. Etiam non tellus sem. Aenean...</p>
                                </div>
                                <!-- End .post-content -->
                                <a href="single.html" class="post-comment">0 Comments</a>
                            </div>
                            <!-- End .post-body -->
                        </article>
                        <!-- End .post -->

                     </div>

                    <hr class="mt-0 m-b-5">
                     @if (count($homeLogoBanner)>0)

                    <div class="brands-slider owl-carousel owl-theme images-center appear-animate" data-animation-name="fadeIn" data-animation-duration="500" data-owl-options="{
					'margin': 0}">
                    @foreach ($homeLogoBanner as $logo)


                        <img src="{{ asset('front/img/banners/' .$logo['image']) }}" width="130" height="56" alt="Logo"
                         onerror="this.src='{{ asset('front/img/categories/no-image.jpg') }}'">
                    @endforeach
                    </div>
                    <!-- End .brands-slider -->
                      @endif
                    <hr class="mt-4 m-b-5">

                    <div class="product-widgets-container row pb-2">
                        <div class="col-lg-3 col-sm-6 pb-5 pb-md-0 appear-animate" data-animation-name="fadeInLeftShorter" data-animation-delay="200">
                            <h4 class="section-sub-title">Featured Products</h4>
                            <div class="product-default left-details product-widget">
                                <figure>
                                    <a href="product.html">
                                        <img src="assets/images/products/small/product-1.jpg" width="84" height="84" alt="product">
                                        <img src="assets/images/products/small/product-1-2.jpg" width="84" height="84" alt="product">
                                    </a>
                                </figure>

                                <div class="product-details">
                                    <h3 class="product-title"> <a href="product.html">Ultimate 3D Bluetooth Speaker</a>
                                    </h3>

                                    <div class="ratings-container">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:100%"></span>
                                            <!-- End .ratings -->
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div>
                                        <!-- End .product-ratings -->
                                    </div>
                                    <!-- End .product-container -->

                                    <div class="price-box">
                                        <span class="product-price">$49.00</span>
                                    </div>
                                    <!-- End .price-box -->
                                </div>
                                <!-- End .product-details -->
                            </div>

                            <div class="product-default left-details product-widget">
                                <figure>
                                    <a href="product.html">
                                        <img src="assets/images/products/small/product-2.jpg" width="84" height="84" alt="product">
                                        <img src="assets/images/products/small/product-2-2.jpg" width="84" height="84" alt="product">
                                    </a>
                                </figure>

                                <div class="product-details">
                                    <h3 class="product-title"> <a href="product.html">Brown Women Casual HandBag</a>
                                    </h3>

                                    <div class="ratings-container">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:100%"></span>
                                            <!-- End .ratings -->
                                            <span class="tooltiptext tooltip-top">5.00</span>
                                        </div>
                                        <!-- End .product-ratings -->
                                    </div>
                                    <!-- End .product-container -->

                                    <div class="price-box">
                                        <span class="product-price">$49.00</span>
                                    </div>
                                    <!-- End .price-box -->
                                </div>
                                <!-- End .product-details -->
                            </div>

                            <div class="product-default left-details product-widget">
                                <figure>
                                    <a href="product.html">
                                        <img src="assets/images/products/small/product-3.jpg" width="84" height="84" alt="product">
                                        <img src="assets/images/products/small/product-3-2.jpg" width="84" height="84" alt="product">
                                    </a>
                                </figure>

                                <div class="product-details">
                                    <h3 class="product-title"> <a href="product.html">Circled Ultimate 3D Speaker</a>
                                    </h3>

                                    <div class="ratings-container">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:100%"></span>
                                            <!-- End .ratings -->
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div>
                                        <!-- End .product-ratings -->
                                    </div>
                                    <!-- End .product-container -->

                                    <div class="price-box">
                                        <span class="product-price">$49.00</span>
                                    </div>
                                    <!-- End .price-box -->
                                </div>
                                <!-- End .product-details -->
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 pb-5 pb-md-0 appear-animate" data-animation-name="fadeInLeftShorter" data-animation-delay="500">
                            <h4 class="section-sub-title">Best Selling Products</h4>
                            <div class="product-default left-details product-widget">
                                <figure>
                                    <a href="product.html">
                                        <img src="assets/images/products/small/product-4.jpg" width="84" height="84" alt="product">
                                        <img src="assets/images/products/small/product-4-2.jpg" width="84" height="84" alt="product">
                                    </a>
                                </figure>

                                <div class="product-details">
                                    <h3 class="product-title"> <a href="product.html">Blue Backpack for the Young -
											S</a> </h3>

                                    <div class="ratings-container">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:100%"></span>
                                            <!-- End .ratings -->
                                            <span class="tooltiptext tooltip-top">5.00</span>
                                        </div>
                                        <!-- End .product-ratings -->
                                    </div>
                                    <!-- End .product-container -->

                                    <div class="price-box">
                                        <span class="product-price">$49.00</span>
                                    </div>
                                    <!-- End .price-box -->
                                </div>
                                <!-- End .product-details -->
                            </div>

                            <div class="product-default left-details product-widget">
                                <figure>
                                    <a href="product.html">
                                        <img src="assets/images/products/small/product-5.jpg" width="84" height="84" alt="product">
                                        <img src="assets/images/products/small/product-5-2.jpg" width="84" height="84" alt="product">
                                    </a>
                                </figure>

                                <div class="product-details">
                                    <h3 class="product-title"> <a href="product.html">Casual Spring Blue Shoes</a> </h3>

                                    <div class="ratings-container">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:100%"></span>
                                            <!-- End .ratings -->
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div>
                                        <!-- End .product-ratings -->
                                    </div>
                                    <!-- End .product-container -->

                                    <div class="price-box">
                                        <span class="product-price">$49.00</span>
                                    </div>
                                    <!-- End .price-box -->
                                </div>
                                <!-- End .product-details -->
                            </div>

                            <div class="product-default left-details product-widget">
                                <figure>
                                    <a href="product.html">
                                        <img src="assets/images/products/small/product-6.jpg" width="84" height="84" alt="product">
                                        <img src="assets/images/products/small/product-6-2.jpg" width="84" height="84" alt="product">
                                    </a>
                                </figure>

                                <div class="product-details">
                                    <h3 class="product-title"> <a href="product.html">Men Black Gentle Belt</a> </h3>

                                    <div class="ratings-container">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:100%"></span>
                                            <!-- End .ratings -->
                                            <span class="tooltiptext tooltip-top">5.00</span>
                                        </div>
                                        <!-- End .product-ratings -->
                                    </div>
                                    <!-- End .product-container -->

                                    <div class="price-box">
                                        <span class="product-price">$49.00</span>
                                    </div>
                                    <!-- End .price-box -->
                                </div>
                                <!-- End .product-details -->
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 pb-5 pb-md-0 appear-animate" data-animation-name="fadeInLeftShorter" data-animation-delay="800">
                            <h4 class="section-sub-title">Latest Products</h4>
                            <div class="product-default left-details product-widget">
                                <figure>
                                    <a href="product.html">
                                        <img src="assets/images/products/small/product-7.jpg" width="84" height="84" alt="product">
                                        <img src="assets/images/products/small/product-7-2.jpg" width="84" height="84" alt="product">
                                    </a>
                                </figure>

                                <div class="product-details">
                                    <h3 class="product-title"> <a href="product.html">Brown-Black Men Casual Glasses</a>
                                    </h3>

                                    <div class="ratings-container">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:100%"></span>
                                            <!-- End .ratings -->
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div>
                                        <!-- End .product-ratings -->
                                    </div>
                                    <!-- End .product-container -->

                                    <div class="price-box">
                                        <span class="product-price">$49.00</span>
                                    </div>
                                    <!-- End .price-box -->
                                </div>
                                <!-- End .product-details -->
                            </div>

                            <div class="product-default left-details product-widget">
                                <figure>
                                    <a href="product.html">
                                        <img src="assets/images/products/small/product-8.jpg" width="84" height="84" alt="product">
                                        <img src="assets/images/products/small/product-8-2.jpg" width="84" height="84" alt="product">
                                    </a>
                                </figure>

                                <div class="product-details">
                                    <h3 class="product-title"> <a href="product.html">Brown-Black Men Casual Glasses</a>
                                    </h3>

                                    <div class="ratings-container">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:100%"></span>
                                            <!-- End .ratings -->
                                            <span class="tooltiptext tooltip-top">5.00</span>
                                        </div>
                                        <!-- End .product-ratings -->
                                    </div>
                                    <!-- End .product-container -->

                                    <div class="price-box">
                                        <span class="product-price">$49.00</span>
                                    </div>
                                    <!-- End .price-box -->
                                </div>
                                <!-- End .product-details -->
                            </div>

                            <div class="product-default left-details product-widget">
                                <figure>
                                    <a href="product.html">
                                        <img src="assets/images/products/small/product-9.jpg" width="84" height="84" alt="product">
                                        <img src="assets/images/products/small/product-9-2.jpg" width="84" height="84" alt="product">
                                    </a>
                                </figure>

                                <div class="product-details">
                                    <h3 class="product-title"> <a href="product.html">Black Men Casual Glasses</a> </h3>

                                    <div class="ratings-container">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:100%"></span>
                                            <!-- End .ratings -->
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div>
                                        <!-- End .product-ratings -->
                                    </div>
                                    <!-- End .product-container -->

                                    <div class="price-box">
                                        <span class="product-price">$49.00</span>
                                    </div>
                                    <!-- End .price-box -->
                                </div>
                                <!-- End .product-details -->
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 pb-5 pb-md-0 appear-animate" data-animation-name="fadeInLeftShorter" data-animation-delay="1100">
                            <h4 class="section-sub-title">Top Rated Products</h4>
                            <div class="product-default left-details product-widget">
                                <figure>
                                    <a href="product.html">
                                        <img src="assets/images/products/small/product-10.jpg" width="84" height="84" alt="product">
                                        <img src="assets/images/products/small/product-10-2.jpg" width="84" height="84" alt="product">
                                    </a>
                                </figure>

                                <div class="product-details">
                                    <h3 class="product-title"> <a href="product.html">Basketball Sports Blue Shoes</a>
                                    </h3>

                                    <div class="ratings-container">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:100%"></span>
                                            <!-- End .ratings -->
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div>
                                        <!-- End .product-ratings -->
                                    </div>
                                    <!-- End .product-container -->

                                    <div class="price-box">
                                        <span class="product-price">$49.00</span>
                                    </div>
                                    <!-- End .price-box -->
                                </div>
                                <!-- End .product-details -->
                            </div>

                            <div class="product-default left-details product-widget">
                                <figure>
                                    <a href="product.html">
                                        <img src="assets/images/products/small/product-11.jpg" width="84" height="84" alt="product">
                                        <img src="assets/images/products/small/product-11-2.jpg" width="84" height="84" alt="product">
                                    </a>
                                </figure>

                                <div class="product-details">
                                    <h3 class="product-title"> <a href="product.html">Men Sports Travel Bag</a> </h3>

                                    <div class="ratings-container">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:100%"></span>
                                            <!-- End .ratings -->
                                            <span class="tooltiptext tooltip-top">5.00</span>
                                        </div>
                                        <!-- End .product-ratings -->
                                    </div>
                                    <!-- End .product-container -->

                                    <div class="price-box">
                                        <span class="product-price">$49.00</span>
                                    </div>
                                    <!-- End .price-box -->
                                </div>
                                <!-- End .product-details -->
                            </div>

                            <div class="product-default left-details product-widget">
                                <figure>
                                    <a href="product.html">
                                        <img src="assets/images/products/small/product-12.jpg" width="84" height="84" alt="product">
                                        <img src="assets/images/products/small/product-12-2.jpg" width="84" height="84" alt="product">
                                    </a>
                                </figure>

                                <div class="product-details">
                                    <h3 class="product-title"> <a href="product.html">Brown HandBag</a> </h3>

                                    <div class="ratings-container">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:100%"></span>
                                            <!-- End .ratings -->
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div>
                                        <!-- End .product-ratings -->
                                    </div>
                                    <!-- End .product-container -->

                                    <div class="price-box">
                                        <span class="product-price">$49.00</span>
                                    </div>
                                    <!-- End .price-box -->
                                </div>
                                <!-- End .product-details -->
                            </div>
                        </div>
                    </div>
                    <!-- End .row -->
                </div>
            </section>
        </main>
@endsection
