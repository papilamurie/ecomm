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
  content: "";
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
                        //Approved reviews count and average
                        $approvedReviewQuery = $product->reviews()->where('status',1);
                        $approvedCount = $approvedReviewQuery->count();
                        $averageRating = $approvedCount ?
                        round($approvedReviewQuery->avg('rating'),1) : 0;
                    @endphp

                    @if($product->product_discount > 0)
                        <div class="label-group">
                            <div class="product-label label-hot">HOT</div>
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
                                style="width:100%; height:100%; object-fit:cover; display:block;"
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
                        <div class="product-stars text-primary mr-2">
                            @for($i=1;$i<=5;$i++)
                                @if($i<=floor($averageRating))
                                    <small class="fas fa-star"></small>
                                @elseif($i==ceil($averageRating) && $averageRating - floor($averageRating)>=0.5)
                                    <small class="fas fa-star-half-alt"></small>
                                @else
                                    <small class="far fa-star"></small>
                                @endif
                            @endfor
                        </div>
                        <small class="pt-1">({{ $approvedCount }} Reviews)</small>
                    </div>
                    <!-- End .ratings-container -->

                    <hr class="short-divider">

                    <div class="price-box getAttributePrice">
                        @if($pricing['has_discount'])
                            <span class="old-price">{{ formatCurrency($pricing['base_price']) }}</span>
                            <span class="new-price">{{ formatCurrency($pricing['final_price']) }}</span>
                        @else
                            <span class="new-price">{{ formatCurrency($pricing['final_price']) }}</span>
                        @endif
                    </div>
                    <!-- End .price-box -->

                    @if(!empty($product->description))
                        <div class="product-desc">
                            <p>{{ $product->description }}</p>
                        </div>
                    @endif
                    <!-- End .product-desc -->

                    <ul class="single-info-list">
                        <li>
                            SKU: <strong class="skuText">{{ optional($product->attributes->first())->sku ?? 'N/A' }}</strong>
                        </li>
                        <li>
                            CATEGORY: <strong><a href="#" class="product-category">{{ $product->category->name }}</a></strong>
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
                                                style="background-color: {{ strtolower($gp->family_color) }}; @if(strtolower($gp->family_color) == 'white') border:1px solid #ccc; @endif"
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
                            <p class="text-danger">This Product is not Available for Purchase</p>
                        @endif

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

                        <a href="wishlist.html" class="btn-icon-wish add-wishlist" title="Add to Wishlist">
                            <i class="icon-wishlist-2"></i><span>Add to Wishlist</span>
                        </a>
                    </div>
                    <!-- End .product single-share -->
                </form>
            </div>
            <!-- End .product-single-details -->
        </div>
        <!-- End .row -->
    </div>
    <!-- End .container -->

     <div class="product-single-tabs">
        <div class="container">
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
                    <a class="nav-link" id="product-tab-reviews" data-toggle="tab" href="#product-reviews-content" role="tab" aria-controls="product-reviews-content" aria-selected="false">Reviews ({{ $approvedCount }})</a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="product-desc-content" role="tabpanel" aria-labelledby="product-tab-desc">
                    <div class="product-desc-content">
                        <p>{{ $product->description }}</p>
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
                        <p>{{ $product->wash_care }}</p>
                    </div>
                    <!-- End .product-desc-content -->
                </div>
                <!-- End .tab-pane -->

                <div class="tab-pane fade" id="product-reviews-content" role="tabpanel" aria-labelledby="product-tab-reviews">
                    <div class="product-reviews-content">
                        <h3 class="reviews-title">{{ $approvedCount }} review(s) for "{{ $product->product_name }}"</h3>

                        <div class="comment-list-wrapper" style="max-height: 500px; overflow-y: auto; padding-right: 10px;">
    @forelse($product->reviews()->where('status',1)->latest()->get() as $review)
        <div class="comments mb-3 pb-3" style="border-bottom: 1px solid #eee;">
            <div class="d-flex flex-column flex-sm-row">
                @if(!empty($review->user->avatar))
                    <figure class="img-thumbnail mb-3 mb-sm-0" style="flex-shrink: 0;">
                        <img src="{{ $review->user && $review->user->avatar ? asset('storage/'.$review->user->avatar) : asset('front/img/default-user.jpg') }}" alt="author" width="80" height="80" style="border-radius: 50%;">
                    </figure>
                @endif

                <div class="comment-block flex-grow-1 ml-sm-3">
                    <div class="comment-header mb-2">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start">
                            <span class="comment-by mb-2 mb-sm-0">
                                <strong>{{ $review->user->name ?? 'Guest' }}</strong>
                                <small class="text-muted d-block d-sm-inline ml-sm-2">{{ $review->created_at->format('d M Y') }}</small>
                            </span>

                                <div class="ratings-container">
                                    <div class="product-body">
                                        @for($i=1;$i<=5;$i++)
                                            @if($i<=$review->rating)
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="comment-content">
                            <p class="mb-0" style="word-wrap: break-word; overflow-wrap: break-word; line-height: 1.6; color: #666;">
                                {{ $review->review }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="comment-content text-center py-4">
                <i class="far fa-comment-dots fa-3x text-muted mb-3"></i>
                <p class="text-muted">No Reviews yet. Be the first to review this product.</p>
            </div>
        @endforelse
    </div>

    <style>
    /* Custom Scrollbar */
    .comment-list-wrapper::-webkit-scrollbar {
        width: 8px;
    }

    .comment-list-wrapper::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .comment-list-wrapper::-webkit-scrollbar-thumb {
        background: #08C;
        border-radius: 10px;
    }

    .comment-list-wrapper::-webkit-scrollbar-thumb:hover {
        background: #0056b3;
    }

    /* Firefox */
    .comment-list-wrapper {
        scrollbar-width: thin;
        scrollbar-color: #08C #f1f1f1;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .comment-list-wrapper {
            max-height: 400px;
        }

        .comment-block {
            margin-left: 0 !important;
        }

        .img-thumbnail {
            margin: 0 auto;
            display: block;
        }
    }

    @media (max-width: 576px) {
        .comment-list-wrapper {
            max-height: 350px;
            padding-right: 5px;
        }

        .img-thumbnail img {
            width: 60px;
            height: 60px;
        }
    }

    /* Smooth scroll behavior */
    .comment-list-wrapper {
        scroll-behavior: smooth;
    }

    /* Comment hover effect */
    .comments:hover {
        background-color: #f9f9f9;
        transition: background-color 0.3s ease;
    }
    </style>

                        <div class="divider"></div>

                        <div class="add-product-review">
                            <h3 class="review-title">Add a review</h3>

                            @if(session('success_message'))
                                <div class="alert alert-success mt-3">{{ session('success_message') }}</div>
                            @endif
                            @if(session('error_message'))
                                <div class="alert alert-danger mt-3">{{ session('error_message') }}</div>
                            @endif

                            @auth
                                @php
                                    $hasReviewed = $product->reviews()->where('user_id', auth()->id())->exists();
                                @endphp

                                @if($hasReviewed)
                                    <div class="alert alert-info mt-3">You have already submitted a review for this product. Thank you.</div>
                                @else
                                    <div class="d-flex my-3">
                                        <p class="mb-0 mr-2">Your Rating *:</p>
                                        <div id="star-rating" class="text-primary" style="font-size:20px; cursor: pointer;">
                                            <i class="far fa-star" data-value="1"></i>
                                            <i class="far fa-star" data-value="2"></i>
                                            <i class="far fa-star" data-value="3"></i>
                                            <i class="far fa-star" data-value="4"></i>
                                            <i class="far fa-star" data-value="5"></i>
                                        </div>
                                    </div>

                                    <form id="reviewForm" method="POST" action="{{ route('product.review.store') }}" class="comment-form m-0">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="rating" id="ratingInput" value="0">

                                        <div class="form-group">
                                            <label for="review-message">Your review <span class="required">*</span></label>
                                            <textarea cols="5" rows="6" class="form-control form-control-sm" id="review-message" name="review"></textarea>
                                        </div>
                                        <!-- End .form-group -->

                                        <div class="row">
                                            <div class="col-md-6 col-xl-12">
                                                <div class="form-group">
                                                    <label for="review-name">Name <span class="required">*</span></label>
                                                    <input type="text" id="review-name" class="form-control form-control-sm" value="{{ auth()->user()->name }}" readonly>
                                                </div>
                                                <!-- End .form-group -->
                                            </div>

                                            <div class="col-md-6 col-xl-12">
                                                <div class="form-group">
                                                    <label for="review-email">Email <span class="required">*</span></label>
                                                    <input type="text" class="form-control form-control-sm" id="review-email" value="{{ auth()->user()->email }}" readonly>
                                                </div>
                                                <!-- End .form-group -->
                                            </div>
                                        </div>

                                        <input type="submit" class="btn btn-primary" value="Leave Your Review">
                                    </form>
                                @endif
                            @else
                                <div class="alert alert-warning mt-3">
                                    <p> Please <a href="{{ route('user.login') }}"> Login </a> to submit a review </p>
                                </div>
                            @endauth
                        </div>
                        <!-- End .add-product-review -->
                    </div>
                    <!-- End .product-reviews-content -->
                </div>
                <!-- End .tab-pane -->
            </div>
            <!-- End .tab-content -->
        </div>
        <!-- End .container -->
    </div>
    <!-- End .product-single-tabs -->

    <div class="container">
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
                        $hoverImage = $images->count() > 1
                            ? asset('product-image/medium/' . $images->get(0)->image)
                            : $fallbackImage;
                    @endphp

                    <div class="product-default">
                        <figure>
                            <a href="{{ url($similar['product_url']) }}">
                                <img src="{{ $mainImage }}" alt="{{ $similar->product_name }}" onerror="this.src='{{ $fallbackImage }}'">
                                <img src="{{ $hoverImage }}" alt="{{ $similar->product_name }}" onerror="this.src='{{ $fallbackImage }}'">
                            </a>
                            @if($similar['product_discount']>0)
                                <div class="label-group">
                                    <div class="product-label label-hot">HOT</div>
                                    <div class="product-label label-sale">{{ $similar['product_discount']}}%</div>
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
                                    <del class="old-price">{{ formatCurrency($similar['product_price']) }}</del>
                                    <span class="product-price">{{ formatCurrency($similar['final_price']) }}</span>
                                </div>
                            @else
                                <div class="price-box">
                                    <span class="product-price">{{ formatCurrency($similar['final_price']) }}</span>
                                </div>
                            @endif
                            <!-- End .price-box -->
                            <div class="product-action">
                                <a href="#" class="btn-icon btn-add-cart"><i class="fa fa-arrow-right"></i><span>Add to Cart</span></a>
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
    </div>
    <!-- End .container -->
</main>
<!-- End .main -->

@endsection
