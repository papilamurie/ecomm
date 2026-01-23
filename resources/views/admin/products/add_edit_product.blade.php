@extends('admin.layout.layout')

@section('content')
<main class="app-main">

    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Products Management</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--end::App Content Header-->

    <div class="app-content">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-md-12">

                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <div class="card-title">{{ $title }}</div>
                        </div>

                        {{-- Alerts --}}
                        @if (Session::has('error_message'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                <strong>Error:</strong> {{ Session::get('error_message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (Session::has('success_message'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <strong>Success:</strong> {{ Session::get('success_message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible fade show">
                                <strong>Error:</strong> {!! $error !!}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endforeach

                        {{-- Form --}}
                        <form id="productForm" name="productForm" method="POST" enctype="multipart/form-data"
                                action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}">
                                @csrf
                                @if(isset($product))
                                    @method('PUT')
                                @endif

                            <div class="card-body">

                                {{-- Category Level --}}
                                <div class="mb-3">
                                    <label class="form-label">Category Level*</label>
                                  <select name="category_id" class="form-control">

                                <option value="">Select</option>

                                @foreach ($getCategories as $cat)
                                    <option value="{{ $cat['id'] }}" @if (old('category_id',$product->category_id ?? '')==$cat['id'])
                                        selected @endif>{{ $cat['name'] }}

                                    </option>

                                    {{-- Subcategories --}}
                                    @if (!empty($cat['subcategories']))
                                        @foreach ($cat['subcategories'] as $subcat)
                                            <option value="{{ $subcat['id'] }}"
                                            @if (old('category_id',$product->category_id ?? '')==$subcat['id'])
                                        selected @endif>
                                        &nbsp;&nbsp;» {{ $subcat['name'] }}

                                            </option>

                                            {{-- Sub-subcategories --}}
                                            @if (!empty($subcat['subcategories']))
                                                @foreach ($subcat['subcategories'] as $subsubcat)
                                                    <option value="{{ $subsubcat['id'] }}"
                                                     @if (old('category_id',$product->category_id ?? '')==$subsubcat['id'])
                                        selected @endif>
                                                     &nbsp;&nbsp;&nbsp;&nbsp;»» {{ $subsubcat['name'] }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach

                            </select>

                                </div>

                            {{-- Other Categories --}}

                                <div class="mb-3">
                                    <label for="other_categories">Show in Other Categories</label>

                                    <select name="other_categories[]" id="other_categories" class="form-control" multiple>
                                        @foreach($getCategories as $cat)
                                            <option value="{{ $cat['id'] }}"
                                                @if(!empty($product) &&
                                                    in_array($cat['id'], $product->categories->pluck('id')->toArray()))
                                                    selected
                                                @endif>
                                                {{ $cat['name'] }}
                                            </option>

                                            {{-- Subcategories --}}
                                            @if (!empty($cat['subcategories']))
                                                @foreach ($cat['subcategories'] as $subcat)
                                                    <option value="{{ $subcat['id'] }}"
                                                        @if(!empty($product) &&
                                                            in_array($subcat['id'], $product->categories->pluck('id')->toArray()))
                                                            selected
                                                        @endif>
                                                        &nbsp;&nbsp;» {{ $subcat['name'] }}
                                                    </option>

                                                    {{-- Sub-subcategories --}}
                                                    @if (!empty($subcat['subcategories']))
                                                        @foreach ($subcat['subcategories'] as $subsubcat)
                                                            <option value="{{ $subsubcat['id'] }}"
                                                                @if(!empty($product) &&
                                                                    in_array($subsubcat['id'], $product->categories->pluck('id')->toArray()))
                                                                    selected
                                                                @endif>
                                                                &nbsp;&nbsp;&nbsp;&nbsp;»» {{ $subsubcat['name'] }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </select>

                                    {{-- Select / Deselect --}}
                                    <div class="mt-2">
                                        <button type="button" id="selectAll" class="btn btn-sm btn-primary">
                                            Select All
                                        </button>
                                        <button type="button" id="deselectAll" class="btn btn-sm btn-secondary">
                                            Deselect All
                                        </button>
                                    </div>
                                </div>



                              {{-- Brand Name --}}
                              <div class="mb-3">
                                 <label class="form-label" for="brand_id">Select Brand*</label>
                                 <select name="brand_id" class="form-control">
                                    <option value="">Select</option>
                                    @foreach ($brands as $brand )
                                        <option value="{{ $brand['id'] }}"
                                            {{ old('brand_id', $product['brand_id'] ?? '') == $brand['id'] ? 'selected' : '' }}>
                                            {{ $brand['name'] }}
                                        </option>
                                    @endforeach
                                 </select>

                              </div>

                                {{-- Product Name --}}
                                <div class="mb-3">
                                    <label class="form-label">Product Name*</label>
                                    <input type="text" class="form-control"
                                           name="product_name" id="product_name"
                                           value="{{ old('product_name', $product->product_name ?? '') }}">
                                </div>

                                @if(!empty($product->product_url))
                                {{-- Product URL --}}
                                <div class="mb-3">
                                    <label class="form-label">Product URL*</label>
                                    <input type="text" class="form-control"
                                           name="product_url" id="product_url"
                                           value="{{ old('product_url', $product->product_url ?? '') }}">
                                </div>
                                @endif

                                {{-- Product Code --}}
                                <div class="mb-3">
                                    <label class="form-label">Product Code*</label>
                                    <input type="text" class="form-control"
                                           name="product_code" id="product_code"
                                           value="{{ old('product_code', $product->product_code ?? '') }}">
                                </div>

                                {{-- Product color --}}
                                <div class="mb-3">
                                    <label class="form-label">Product Color*</label>
                                    <input type="text" class="form-control"
                                           name="product_color" id="product_color"
                                           value="{{ old('product_color', $product->product_color ?? '') }}">
                                </div>

                                {{-- Family Color --}}
                                <?php $familyColors = \App\Models\Color::colors();?>
                                <div class="mb-3">
                                    <label class="form-label">Family Color*</label>
                                    <select name="family_color" class="form-control">
                                        <option value="">Please Select</option>
                                        @foreach ($familyColors as $color)

                                        <option value="{{ $color->name }}"
                                            @if(isset($product['family_color'])&& $product['family_color']==$color->name) selected @endif>
                                                {{ $color->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Group Code --}}
                                <div class="mb-3">
                                    <label class="form-label">Group Code</label>
                                    <input type="text" class="form-control"
                                           name="group_code" id="group_code"
                                           value="{{ old('group_code', $product->group_code ?? '') }}">
                                </div>

                                  {{-- Product Image --}}
                                <div class="mb-3">
                                    <label class="form-label">Product Image (500kb)</label>

                                    <div class="dropzone" id="mainImageDropzone"></div>

                                     {{-- hidden input to send image --}}
                                           <input type="hidden" name="main_image" id="main_image_hidden">

                                    @if (!empty($product['main_image']))
                                    <a target="_blank" href="{{ url('front/img/products/'.$product['main_image']) }}">

                                            <img style="margin:10px;"
                                             src="{{ url('product-image/thumbnail/' . $product['main_image']) }}">
                                          </a><a href="javascript:void(0);"
                                                    class="deleteProductImage"
                                                    data-url="{{ url('admin/delete-product-main-image/'.$product->id) }}">
                                                    <i class="fas fa-trash"></i>
                                                    </a>

                                          @endif
                                </div>
                                <div id="mainImageDropzoneError" style="color:red;display:none;"></div>

                                 {{-- Multi Product Image --}}
                                <div class="mb-3">
                                    <label class="form-label">Alternate Product Image (Multiple uploads allowed Max 500kb each)</label>

                                    <div class="dropzone" id="productImagesDropzone"></div>

                                     {{-- hidden input to send image --}}
                                           <input type="hidden" name="product_images" id="product_images_hidden">
                                    @if (isset($product->product_images)&& $product->product_images->count()>0)
                                    @if ($product->product_images->count()>1)
                                           <p class="drag-instruction">
                                            <i class="fas fa-arrows-alt"></i> Drag & Drop Images Below
                                           </p>
                                           @endif

                                    <div id="sortable-images" class="sortable-wrapper d-flex gap-2 overflow-auto">
                                        @foreach ($product->product_images as $img)
                                          <div class="sortable-item" data-id="{{ $img->id }}">
                                    <a target="_blank" href="{{ url('front/img/products/'.$img->image) }}">

                                            <img style="width:50px; margin:10px;"
                                             src="{{ url('product-image/thumbnail/' . $img->image) }}">
                                          </a>
                                           <a href="javascript:void(0);"
                                                    class="deleteProductImages"
                                                    data-url="{{ url('admin/delete-product-images/'.$img->id) }}">
                                                    <i class="fas fa-trash"></i>
                                                    </a>
                                          </div>
                                        @endforeach
                                    </div>

                                          @endif
                                </div>

                                 {{-- Product Video --}}
                                <div class="mb-3">
                                    <label class="form-label">Product Video (2mb)</label>

                                    <div class="dropzone" id="productVideoDropzone"></div>

                                      {{-- //hidden input to send video --}}
                                           <input type="hidden" name="product_video" id="product_video_hidden">

                                    @if (!empty($product['product_video']))
                                    <a target="_blank" href="{{ url('front/videos/products/'.$product['product_video']) }}">

                                            <img style="width:50px; margin:10px;"
                                             src="{{ asset('front/videos/products/' . $product['product_video']) }}">View Video
                                          </a> | <a href="javascript:void(0);"
                                                    title="Delete Product Video" class="deleteProductVideo"
                                                    data-url="{{ url('admin/delete-product-video/'.$product->id) }}">
                                                    Delete Video
                                                    </a>
                                          @endif
                                </div>

                                {{-- Product Price --}}
                                <div class="mb-3">
                                    <label class="form-label">Product Price*</label>
                                    <input type="text" class="form-control"
                                           name="product_price" id="product_price"
                                           value="{{ old('product_price', $product->product_price ?? '') }}">
                                </div>

                                {{-- Product Name --}}
                                <div class="mb-3">
                                    <label class="form-label">Product Discount(%)</label>
                                    <input type="number" step="0.01" class="form-control"
                                           name="product_discount" id="product_discount"
                                           value="{{ old('product_discount', $product->product_discount ?? '') }}">
                                </div>

                                {{-- Product Weight --}}
                                <div class="mb-3">
                                    <label class="form-label">Product Weight(kg)</label>
                                    <input type="number" step="0.01" class="form-control"
                                           name="product_weight" id="product_weight"
                                           value="{{ old('product_weight', $product->product_weight ?? '') }}">
                                </div>

                                 <div class="mb-3">
                                    <label class="form-label mb-1">Product Attributes</label>
                                    <div class="d-none d-md-flex fw-semibold bg light border rounded px-2 py-1 mb-2">
                                            <div class="flex-fill col-2 ms-2">Size</div>
                                            <div class="flex-fill col-2 ms-2">SKU</div>
                                            <div class="flex-fill col-2 ms-2">Price</div>
                                            <div class="flex-fill col-2 ms-2">Stock</div>
                                            <div class="flex-fill col-2 ms-2">Sort</div>
                                            <div style="width: 60px;"></div>
                                    </div>

                                    <div class="field_wrapper">
                                        <div class="d-flex align-items-center gap-2 mb-2 attribute-row">
                                            <input name="size[]" class="form-control flex-fill col-2" placeholder="Size">
                                            <input name="sku[]" class="form-control flex-fill col-2" placeholder="SKU">
                                            <input name="price[]" class="form-control flex-fill col-2" placeholder="Price">
                                            <input name="stock[]" class="form-control flex-fill col-2" placeholder="Stock">
                                            <input name="sort[]" class="form-control flex-fill col-2" placeholder="Sort">

                                            <a href="javascript:void(0);" class="btn btn-sm btn-success add_button" title="Add Row">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @if (isset($product['attributes']) && count($product['attributes']) > 0)
                                <div class="mb-3">
                                    <label class="form-label mb-1">Existing Product Attributes</label>

                                    <div class="table-responsive">
                                        <table class="table table-bordered align-middle mb-0">
                                            <thead class="table-light text-center">
                                                <tr>
                                                    <th style="width:15%">Size</th>
                                                    <th style="width:15%">SKU</th>
                                                    <th style="width:15%">Price</th>
                                                    <th style="width:15%">Stock</th>
                                                    <th style="width:15%">Sort</th>
                                                    <th style="width:15%">Actions</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($product['attributes'] as $attribute )
                                                <input type="hidden" name="attrId[]" value="{{ $attribute['id'] }}">
                                                <tr class="text-cneter">
                                                    <td>{{ $attribute['size'] }}</td>
                                                    <td>{{ $attribute['sku'] }}</td>
                                                    <td><input type="number" name="update_price[]"
                                                        value="{{ $attribute['price'] }}" class="form-control text-center" required></td>
                                                    <td><input type="number" name="update_stock[]"
                                                        value="{{ $attribute['stock'] }}" class="form-control text-center" required></td>
                                                    <td><input type="number" name="update_sort[]"
                                                        value="{{ $attribute['sort'] }}" class="form-control text-center" required></td>
                                                   <td>
                                                    @if($attribute['status'] == 1)
                                                    <a class="updateAttributeStatus text-primary me-2"
                                                    data-attribute_id="{{ $attribute->id }}" style="color:#3f6ed3;"
                                                    href="javascript:void(0)"><i class="fas fa-toggle-on"
                                                    data-status="Active"></i></a>
                                                    @else
                                                     <a class="updateAttributeStatus text-primary me-2" data-attribute_id="{{ $attribute->id }}"
                                                         style="color:grey;"  href="javascript:void(0)"><i class="fas fa-toggle-off"
                                                    data-status="Inactive"></i></a>
                                                        @endif
                                                        <a title="Delete Attribute" href="javascript:void(0)" class="deleteProductAttribute text-danger"
                                                        data-module="attribute" data-id="{{ $attribute['id'] }}"
                                                         data-url="{{ url('admin/delete-product-attribute/'.$attribute->id) }}"><i class="fas fa-trash"></i></a>
                                                   </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                @endif





                                 {{-- Description --}}
                                <div class="mb-3">
                                    <label class="form-label">Wash Care</label>
                                    <textarea rows="3" class="form-control" name="wash_care">
                                        {{ old('wash_care', $product->wash_care ?? '') }}</textarea>
                                </div>

                                 {{-- Product Description --}}
                                <div class="mb-3">
                                    <label class="form-label">Product Description</label>
                                    <textarea rows="3" class="form-control" name="description">
                                        {{ old('description', $product->description ?? '') }}</textarea>
                                </div>

                                 {{-- Search Keywords --}}
                                <div class="mb-3">
                                    <label class="form-label">Search Keywords</label>
                                    <textarea rows="3" class="form-control" name="search_keywords">
                                        {{ old('search_keywords', $product->search_keywords ?? '') }}</textarea>
                                </div>

                                @php
                                    $filters = \App\Models\Filter::with(['values' => function($q){
                                        $q->where('status',1)->orderBy('sort','asc');
                                    }])->where('status',1)->orderBy('sort','asc')->get();

                                    $selectedValues = isset($product)
                                            ? $product->filterValues->pluck('id')->toArray()
                                            : [];

                                @endphp

                                @foreach ($filters as $filter )
                                    <div class="mb-3">
                                        <label class="form-label">{{ ucwords($filter->filter_name) }}</label>
                                        <select name="filter_values[{{ $filter->id }}]" class="form-control">
                                            <option value="">-- Select {{ ucwords($filter->filter_name) }} --</option>
                                            @foreach ($filter->values as $value )
                                                <option value="{{ $value->id }}"
                                                    {{ in_array($value->id, $selectedValues) ? 'selected' : '' }}>
                                                    {{ ucfirst($value->value) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                @endforeach

                                {{-- Meta Title --}}
                                <div class="mb-3">
                                    <label class="form-label">Meta Title</label>
                                    <input type="text" class="form-control"
                                           name="meta_title" id="meta_title"
                                           value="{{ old('meta_title', $product->meta_title ?? '') }}">
                                </div>

                                {{-- Meta Description --}}
                                <div class="mb-3">
                                    <label class="form-label">Meta Description</label>
                                    <input type="text" class="form-control"
                                           name="meta_description" id="meta_description"
                                           value="{{ old('meta_description', $product->meta_description ?? '') }}">
                                </div>

                                {{-- Meta Keywords --}}
                                <div class="mb-3">
                                    <label class="form-label">Meta Keywords</label>
                                    <input type="text" class="form-control"
                                           name="meta_keywords" id="meta_keywords"
                                           value="{{ old('meta_keywords', $product->meta_keywords ?? '') }}">
                                </div>

                                {{-- is Featured --}}
                                <div class="mb-3">
                                    <label class="form-label">Is Featured?</label>
                                    <select name="is_featured" class="form-select">
                                        <option value="No" {{ old('is_featured', $product->is_featured ?? '')=='No' ? 'selected' : '' }}>
                                            No</option>
                                        <option value="Yes" {{ old('is_featured', $product->is_featured ?? '')=='Yes' ? 'selected' : '' }}>
                                            Yes</option>
                                    </select>
                                </div>




                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary"> Submit</button>
                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>

</main>
@endsection
