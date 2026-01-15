@extends('admin.layout.layout')

@section('content')
<main class="app-main">

    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Brands Management</h3>
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
                        <form id="brandForm" method="POST" enctype="multipart/form-data"
                                action="{{ isset($brand->id) ? route('brands.update', $brand->id) : route('brands.store') }}">
                                @csrf
                                @if(isset($brand->id))
                                    @method('PUT')
                                @endif

                            <div class="card-body">

                                {{-- Category Level
                                <div class="mb-3">
                                    <label class="form-label">Category Level*</label>
                                  <select name="parent_id" class="form-control">

                                <option value="">Select</option>

                                <option value="0" {{ isset($category) && $category->parent_id == 0 ? 'selected' : '' }}>
                                    Main Category
                                </option>

                                @foreach ($getCategories as $cat)
                                    <option value="{{ $cat['id'] }}"
                                        {{ isset($category) && $category->parent_id == $cat['id'] ? 'selected' : '' }}>
                                        {{ $cat['name'] }}
                                    </option>


                                    @if (!empty($cat['subcategories']))
                                        @foreach ($cat['subcategories'] as $subcat)
                                            <option value="{{ $subcat['id'] }}"
                                                {{ isset($category) && $category->parent_id == $subcat['id'] ? 'selected' : '' }}>
                                                &nbsp;&nbsp;» {{ $subcat['name'] }}
                                            </option>


                                            @if (!empty($subcat['subcategories']))
                                                @foreach ($subcat['subcategories'] as $subsubcat)
                                                    <option value="{{ $subsubcat['id'] }}"
                                                        {{ isset($category) && $category->parent_id == $subsubcat['id'] ? 'selected' : '' }}>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;»» {{ $subsubcat['name'] }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach

                            </select>

                                </div>--}}

                                {{-- Category Name --}}
                                <div class="mb-3">
                                    <label class="form-label">Brand Name*</label>
                                    <input type="text" class="form-control"
                                           name="name" id="name"
                                           value="{{ old('name', $brand->name ?? '') }}">
                                </div>

                                {{-- Brand Image --}}
                                <div class="mb-3">
                                    <label class="form-label">Brand Image</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">

                                    @if (!empty($brand->image))
                                        <div class="mt-2" id="brandImageBlock">
                                            <img src="{{ asset('front/img/brands/' . $brand->image) }}" width="50">
                                           <a href="javascript:void(0);"
                                                    id="deleteBrandImage" class="text-danger"
                                                  data-brand-id="{{ $brand->id }}">
                                                    Delete
                                                    </a>



                                        </div>
                                    @endif
                                </div>

                                {{-- Brand Logo --}}
                                <div class="mb-3">
                                    <label class="form-label">Brand Logo</label>
                                    <input type="file" class="form-control" name="logo" id="logo" accept="image/*">

                                    @if (!empty($brand->logo))
                                        <div class="mt-2" id="logoImageBlock">
                                            <img src="{{ asset('front/img/logos/' . $brand->logo) }}" width="50">
                                        </div>
                                        <a href="javascript:void(0);"
                                                    id="deleteLogoImage" class="text-danger"
                                                  data-logo-id="{{ $brand->id }}">
                                                    Delete
                                                    </a>
                                    @endif
                                </div>

                                {{-- Brand Discount --}}
                                <div class="mb-3">
                                    <label class="form-label">Brand Discount</label>
                                    <input type="text" class="form-control"
                                           name="brand_discount"
                                           value="{{ old('brand_discount', $brand->discount ?? '') }}">
                                </div>

                                {{-- Brand URL --}}
                                <div class="mb-3">
                                    <label class="form-label">Brand URL*</label>
                                    <input type="text" class="form-control"
                                           name="url" id="url"
                                           value="{{ old('url', $brand->url ?? '') }}">
                                </div>

                                {{-- Description --}}
                                <div class="mb-3">
                                    <label class="form-label">Brand Description</label>
                                    <textarea rows="3" class="form-control" id="description" name="description">{{ old('description', $brand->description ?? '') }}</textarea>
                                </div>

                                {{-- Meta Title --}}
                                <div class="mb-3">
                                    <label class="form-label">Meta Title</label>
                                    <input type="text" class="form-control"
                                           name="meta_title" id="meta_title"
                                           value="{{ old('meta_title', $brand->meta_title ?? '') }}">
                                </div>

                                {{-- Meta Description --}}
                                <div class="mb-3">
                                    <label class="form-label">Meta Description</label>
                                    <textarea rows="3" class="form-control" id="meta_description"
                                    name="meta_description">{{ old('meta_description', $brand->meta_description ?? '') }}</textarea>
                                </div>

                                {{-- Meta Keywords --}}
                                <div class="mb-3">
                                    <label class="form-label">Meta Keywords</label>
                                    <input type="text" class="form-control" id="meta_keywords"
                                           name="meta_keywords"
                                           value="{{ old('meta_keywords', $brands->meta_keywords ?? '') }}">
                                </div>

                                {{-- Menu Status --}}
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" name="menu_status" value="1"
                                           @checked(!empty($brand->menu_status))>
                                    <label class="form-check-label">Show on Header Menu</label>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>

</main>
@endsection
