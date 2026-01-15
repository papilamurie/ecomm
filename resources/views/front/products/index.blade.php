 @extends('front.layout.layout')
 @section('content')
<main class="main">
            <div class="category-banner-container bg-gray">
                <div class="category-banner banner text-uppercase" style="background: no-repeat 60%/cover url('assets/images/banners/banner-top.jpg');">
                    <div class="container position-relative">
                        <div class="row">
                            <div class="pl-lg-5 pb-5 pb-md-0 col-sm-12 col-xl-12 col-lg-12 offset-1">
                                <h3>{{ $categoryDetails['name'] }}</h3>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                {!! $breadcrumbs ?? '' !!}

                <div class="row" id="appendProducts">
                  @include('front.products.ajax_products_listing')
                </div>
                <!-- End .row -->
            </div>
            <!-- End .container -->

            <div class="mb-4"></div>
            <!-- margin -->
        </main>

 @endsection
