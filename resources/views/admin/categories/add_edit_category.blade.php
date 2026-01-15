@extends('admin.layout.layout')

@section('content')
<main class="app-main">

    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Categories Management</h3>
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
                        <form id="categoryForm" method="POST" enctype="multipart/form-data"
                                action="{{ isset($category->id) ? route('categories.update', $category->id) : route('categories.store') }}">
                                @csrf
                                @if(isset($category->id))
                                    @method('PUT')
                                @endif

                            <div class="card-body">

                                {{-- Category Level --}}
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

                                    {{-- Subcategories --}}
                                    @if (!empty($cat['subcategories']))
                                        @foreach ($cat['subcategories'] as $subcat)
                                            <option value="{{ $subcat['id'] }}"
                                                {{ isset($category) && $category->parent_id == $subcat['id'] ? 'selected' : '' }}>
                                                &nbsp;&nbsp;» {{ $subcat['name'] }}
                                            </option>

                                            {{-- Sub-subcategories --}}
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

                                </div>

                                {{-- Category Name --}}
                                <div class="mb-3">
                                    <label class="form-label">Category Name*</label>
                                    <input type="text" class="form-control"
                                           name="category_name"
                                           value="{{ old('category_name', $category->name ?? '') }}">
                                </div>

                                {{-- Category Image --}}
                                <div class="mb-3">
                                    <label class="form-label">Category Image</label>
                                    <input type="file" class="form-control" name="category_image" accept="image/*">

                                    @if (!empty($category->image))
                                        <div class="mt-2" id="categoryImageBlock">
                                            <img src="{{ asset('front/img/categories/' . $category->image) }}" width="50">
                                           <a href="javascript:void(0);"
                                                    id="deleteCategoryImage" class="text-danger"
                                                  data-category-id="{{ $category->id }}">
                                                    Delete
                                                    </a>



                                        </div>
                                    @endif
                                </div>

                                {{-- Size Chart --}}
                                <div class="mb-3">
                                    <label class="form-label">Size Chart</label>
                                    <input type="file" class="form-control" name="size_chart" accept="image/*">

                                    @if (!empty($category->size_chart))
                                        <div class="mt-2" id="sizechartImageBlock">
                                            <img src="{{ asset('front/img/sizecharts/' . $category->size_chart) }}" width="50">
                                        </div>
                                        <a href="javascript:void(0);"
                                                    id="deleteSizechartImage" class="text-danger"
                                                  data-category-id="{{ $category->id }}">
                                                    Delete
                                                    </a>
                                    @endif
                                </div>

                                {{-- Category Discount --}}
                                <div class="mb-3">
                                    <label class="form-label">Category Discount</label>
                                    <input type="text" class="form-control"
                                           name="category_discount"
                                           value="{{ old('category_discount', $category->discount ?? '') }}">
                                </div>

                                {{-- Category URL --}}
                                <div class="mb-3">
                                    <label class="form-label">Category URL*</label>
                                    <input type="text" class="form-control"
                                           name="url"
                                           value="{{ old('url', $category->url ?? '') }}">
                                </div>

                                {{-- Description --}}
                                <div class="mb-3">
                                    <label class="form-label">Category Description</label>
                                    <textarea rows="3" class="form-control" name="description">{{ old('description', $category->description ?? '') }}</textarea>
                                </div>

                                {{-- Meta Title --}}
                                <div class="mb-3">
                                    <label class="form-label">Meta Title</label>
                                    <input type="text" class="form-control"
                                           name="meta_title"
                                           value="{{ old('meta_title', $category->meta_title ?? '') }}">
                                </div>

                                {{-- Meta Description --}}
                                <div class="mb-3">
                                    <label class="form-label">Meta Description</label>
                                    <textarea rows="3" class="form-control" name="meta_description">{{ old('meta_description', $category->meta_description ?? '') }}</textarea>
                                </div>

                                {{-- Meta Keywords --}}
                                <div class="mb-3">
                                    <label class="form-label">Meta Keywords</label>
                                    <input type="text" class="form-control"
                                           name="meta_keywords"
                                           value="{{ old('meta_keywords', $category->meta_keywords ?? '') }}">
                                </div>

                                {{-- Menu Status --}}
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" name="menu_status" value="1"
                                           @checked(!empty($category->menu_status))>
                                    <label class="form-check-label">Show on Header Menu</label>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ isset($category->id) ? 'Update' : 'Create' }} Category</button>
                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>

</main>
@endsection
