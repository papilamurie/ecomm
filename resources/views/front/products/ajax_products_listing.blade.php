  <div class="col-lg-9 main-content">
                       @include('front.products.filters')
                        <div class="row">
                            @if($categoryProducts->isEmpty())
    <p>No products found</p>
@endif

                          @foreach($categoryProducts as $product)
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

                            <div class="col-6 col-sm-4">
                                <div class="product-default">
                                    <figure>
                              <a href="{{ url($product['product_url']) }}">
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
                                        <div class="category-wrap">
                                            <div class="category-list">
                                               <a href="{{ url($product['product_url']) }}" class="product-category">
                                        {{ $product->category->name ?? 'Uncategorized' }}
                                    </a>
                                            </div>
                                        </div>

                                        <h3 class="product-title">  <a href="{{ url($product['product_url']) }}">{{ $product['product_name'] }}</a> </h3>

                                        <div class="ratings-container">
                                            <div class="product-ratings">
                                                <span class="ratings" style="width:100%"></span>
                                                <!-- End .ratings -->
                                                <span class="tooltiptext tooltip-top"></span>
                                            </div>
                                            <!-- End .product-ratings -->
                                        </div>
                                        <!-- End .product-container -->

                                         @if($product['product_discount']>0)
                                <div class="price-box">
                                    <del class="old-price">${{ $product['product_price'] }}</del>
                                    <span class="product-price">${{ $product['final_price'] }}</span>
                                </div>
                                @else
                                 <div class="price-box">
                                   <span class="product-price">${{ $product['final_price'] }}</span>
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
                            </div>
                            <!-- End .col-sm-4 -->
                             @endforeach




                        </div>
                        <!-- End .row -->

                       <nav class="toolbox toolbox-pagination">
                            <div class="toolbox-item toolbox-show">
                                @php
                                    if(!isset($_GET['price'])){
                                        $_GET['price'] = "";
                                    }
                                @endphp
                                        {{ $categoryProducts->appends([
                                            'sort' => $_GET['sort'] ?? '',
                                            'color' => $_GET['color'] ?? '',
                                            'size' => $_GET['size'] ?? '',
                                            'brand' => $_GET['brand'] ?? '',
                                            'price' => $_GET['price'] ?? ''
                                        ])->links('pagination::bootstrap-5') }}
                                <!-- End .select-custom -->
                            </div>
                            <!-- End .toolbox-item -->
                        </nav>

                    </div>
                    <!-- End .col-lg-9 -->

                    <div class="sidebar-overlay"></div>
                    <aside class="sidebar-shop col-lg-3 order-lg-first mobile-sidebar">
                        <div class="sidebar-wrapper">
                                            {{-- Categories --}}
                        @if(!empty($categoryDetails) && $categoryDetails->subcategories->count() > 0)
                            <div class="widget">
                                <h3 class="widget-title">
                                    <a data-bs-toggle="collapse" href="#widget-body-2" role="button" aria-expanded="true">Filter By Categories</a>
                                </h3>
                                <div class="collapse show" id="widget-body-2">
                                    <div class="widget-body pb-0 d-flex flex-column gap-2">
                                     <div class="config-size-list" style="display: flex; flex-direction: column; flex-wrap: wrap; gap: 8px; max-width: 100%;">
                                        @php $selectedCategories = request()->has('category') ? explode('~', request()->get('category')) : []; @endphp
                                        @foreach($categoryDetails->subcategories as $subcategory)
                                            <label class="size-option d-flex align-items-center gap-2" for="category{{ $subcategory->id }}"
                                                 style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                                <input type="checkbox" name="category" id="category{{ $subcategory->id }}"
                                                    value="{{ $subcategory->id }}" class="filterAjax"
                                                    {{ in_array($subcategory->id, $selectedCategories) ? 'checked' : '' }}>
                                                <span class="px-2 py-1 border rounded"
                                                 style="display: inline-block; padding: 6px 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; user-select: none; white-space: nowrap;">
                                                 {{ ucwords($subcategory->name) }}</span>
                                            </label>
                                        @endforeach
                                     </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                            <div class="widget">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-body-3" role="button" aria-expanded="true" aria-controls="widget-body-3">Price</a>
                                </h3>
                                @php

                                    $prices = ['0-1000','1000-2000','2000-5000','5000-10000','10000-100000'];
                                    $selectedPrices = [];
                                    if(request()->has('price')){
                                        $selectedPrices = explode('~', request()->get('price'));
                                    }
                                @endphp
                                <div class="collapse show" id="widget-body-3">
                                    <div class="widget-body pb-0">
                                        <div class="config-size-list" style="display: flex; flex-direction: column; flex-wrap: wrap; gap: 8px; max-width: 100%;">
                                            @foreach($prices as $key => $price)
                                                <label class="size-option" for="price{{ $key }}" style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                                    <input type="checkbox" name="price" id="price{{ $key }}"
                                                        value="{{ $price }}" class="filterAjax" {{ in_array($price, $selectedPrices) ? 'checked' : '' }} style="flex-shrink: 0;">
                                                    <span style="display: inline-block; padding: 6px 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; user-select: none; white-space: nowrap;">
                                                        ${{ $price }}
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- End .widget-body -->
                                </div>
                                <!-- End .collapse -->
                            </div>
                            <!-- End .widget -->

                            <div class="widget widget-color" style="background: #666;">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-body-4" role="button" aria-expanded="true" aria-controls="widget-body-4" class="text-white">Color</a>
                                </h3>
                                <?php
                                use App\Models\ProductsFilter;

                                $getColors = ProductsFilter::getColors($catIds);
                                $selectedColors = [];
                                if(request()->has('color')){
                                    $selectedColors = explode('~', request()->get('color'));
                                }
                                ?>
                                <div class="collapse show" id="widget-body-4">
                                        <div class="widget-body pb-0 d-flex flex-wrap align-items-center gap-2">
                                            @foreach($getColors as $key => $color)
                                                <label class="color-label m-1" for="color{{ $key }}">
                                                    <input type="checkbox"
                                                        id="color{{ $key }}"
                                                        value="{{ $color }}"
                                                        name="color"
                                                        class="filterAjax"
                                                        {{ in_array($color, $selectedColors) ? 'checked' : '' }}>

                                                    <span class="color-box"
                                                        style="background:{{ $color }}; width:20px; height:20px; display:inline-block;"></span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>



                                <!-- End .collapse -->
                            </div>
                            <!-- End .widget -->

                            <div class="widget widget-size">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-body-5" role="button" aria-expanded="true" aria-controls="widget-body-5">Sizes</a>
                                </h3>
                                @php
                                    $getSizes = \App\Models\ProductsFilter::getSizes($catIds);
                                    $selectedSizes = request()->has('size')
                                        ? explode('~', request('size'))
                                        : [];
                                @endphp

                                <div class="collapse show" id="widget-body-5">
                                    <div class="widget-body pb-0">
                                           <div class="config-size-list" style="display: flex; flex-wrap: wrap; gap: 8px;">
                                                @foreach($getSizes as $key => $size)
                                                    <label class="size-option" style="cursor: pointer;" for="size{{ $key }}">
                                                        <input type="checkbox" name="size" id="size{{ $key }}"
                                                            value="{{ $size }}" class="filterAjax" {{ in_array($size, $selectedSizes) ? 'checked' : '' }}>
                                                        <span style="display: inline-block; padding: 6px 12px; border: 1px solid #ccc;
                                                                    border-radius: 4px; font-size: 14px; user-select: none;">
                                                            {{ strtoupper($size) }}
                                                        </span>
                                                    </label>
                                                @endforeach
                                            </div>

                                        </div>
                                    <!-- End .widget-body -->
                                </div>
                                <!-- End .collapse -->
                            </div>
                            <!-- End .widget -->

                            <div class="widget widget-featured">
                                <h3 class="widget-title">Brands</h3>
                                  @php
                                    $getBrands = \App\Models\ProductsFilter::getBrands($catIds);
                                    $selectedBrands = request()->has('brand')
                                        ? explode('~', request('brand'))
                                        : [];
                                @endphp
                               <div class="widget-body pb-0">
                                           <div class="config-size-list" style="display: flex; flex-wrap: wrap; gap: 8px;">
                                                @foreach($getBrands as $key => $brand)
                                                    <label class="size-option" style="cursor: pointer;" for="brand{{ $key }}">
                                                        <input type="checkbox" name="brand" id="brand{{ $key }}"
                                                            value="{{ $brand['name'] }}" class="filterAjax" {{ in_array($brand['name'], $selectedBrands) ? 'checked' : '' }}>
                                                        <span style="display: inline-block; padding: 6px 12px; border: 1px solid #ccc;
                                                                    border-radius: 4px; font-size: 14px; user-select: none;">
                                                            {{ ucFirst($brand['name']) }}
                                                        </span>
                                                    </label>
                                                @endforeach
                                            </div>

                                        </div>
                                <!-- End .widget-body -->
                            </div>
                            <!-- End .widget -->
                            @foreach ($filters as $filter )
                            @php
                                 $filterValues = $filter->values
                                            ->where('status', 1)
                                            ->filter(function ($value) use ($catIds) {
                                                return $value->products()
                                                    ->whereIn('category_id', $catIds)
                                                    ->exists();
                                            })->pluck('value')
                                              ->toArray();

                                if(empty($filterValues)) continue;
                                $selectedValues = request()->has($filter->filter_name) ? explode('~', request()->get($filter->filter_name))
                                : [];
                            @endphp
                          <div class="widget widget-featured">
                                <h3 class="widget-title">Filter By: {{ ucwords($filter->filter_name) }}</h3>

                               <div class="widget-body pb-0">
                                           <div class="config-size-list" style="display: flex; flex-wrap: wrap; gap: 8px;">
                                                @foreach($filterValues  as $key => $value)
                                                    <label class="size-option" style="cursor: pointer;" for="{{ $filter->filter_name }}{{ $key }}">
                                                        <input type="checkbox" name="{{ $filter->filter_name }}" id="{{ $filter->filter_name }}{{ $key }}"
                                                            value="{{ $value }}" class="filterAjax" {{ in_array($value, $selectedValues) ? 'checked' : '' }}>
                                                        <span style="display: inline-block; padding: 6px 12px; border: 1px solid #ccc;
                                                                    border-radius: 4px; font-size: 14px; user-select: none;">
                                                            {{ ucFirst($value) }}
                                                        </span>
                                                    </label>
                                                @endforeach
                                            </div>

                                        </div>
                                <!-- End .widget-body -->
                            </div>
                        @endforeach
                            <!-- End .widget -->
                        </div>
                        <!-- End .sidebar-wrapper -->
                    </aside>
                    <!-- End .col-lg-3 -->
