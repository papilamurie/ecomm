@extends('admin.layout.layout')

@section('content')
<main class="app-main">

    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Banner Management</h3>
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
                        <form id="bannerForm" method="POST" enctype="multipart/form-data"
                                action="{{ isset($banner->id) ? route('banners.update', $banner->id) : route('banners.store') }}">
                                @csrf
                                @if(isset($banner->id))
                                    @method('PUT')
                                @endif

                            <div class="card-body">

                                {{-- Banner Type --}}
                                <div class="mb-3">
                                    <label class="form-label">Banner Type*</label>
                                  <select name="type" class="form-control">

                                        <option value="">Select Type</option>
                                        <option value="Slider" {{ old('type', $banner->type ?? '')== 'Slider' ? 'selected' : '' }}>Slider</option>
                                        <option value="Fix" {{ old('type', $banner->type ?? '')=='Fix' ? 'selected' : '' }}>Fix</option>
                                        <option value="Logo" {{ old('type', $banner->type ?? '')=='Logo' ? 'selected' : '' }}>Logo</option>
                            </select>

                                </div>

                                {{-- Banner Title --}}
                                <div class="mb-3">
                                    <label class="form-label">Banner Title*</label>
                                    <input type="text" class="form-control"
                                           name="title"
                                           value="{{ old('title', $banner->title ?? '') }}">
                                </div>

                                {{-- Banner Image --}}
                                <div class="mb-3">
                                    <label class="form-label">Banner Image @if(!isset($banner->id))* @endif</label>
                                    <input type="file" class="form-control" name="image" accept="image/*">

                                    @if (!empty($banner->image))
                                        <div class="mt-2" id="bannerImageBlock">
                                            <img src="{{ asset('front/img/banners/' . $banner->image) }}" width="50">




                                        </div>
                                    @endif
                                </div>



                                {{-- Banner Alt --}}
                                <div class="mb-3">
                                    <label class="form-label">Alt Text</label>
                                    <input type="text" class="form-control"
                                           name="alt"
                                           value="{{ old('alt', $banner->alt ?? '') }}">
                                </div>

                                {{-- Bsnner Link --}}
                                <div class="mb-3">
                                    <label class="form-label">Banner Link</label>
                                    <input type="text" class="form-control"
                                           name="link"
                                           value="{{ old('link', $banner->link ?? '') }}">
                                </div>


                                {{-- Sort --}}
                                <div class="mb-3">
                                    <label class="form-label">Sort Order</label>
                                    <input type="number" class="form-control"
                                           name="sort"
                                           value="{{ old('sort', $banner->sort ?? 0) }}">
                                </div>





                                {{-- Status --}}
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" name="status" value="1"
                                          {{ (old('status', $banner->status ?? 1)==1) ? 'checked' : '' }}>Active
                                    {{-- <label class="form-check-label"></label> --}}
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
