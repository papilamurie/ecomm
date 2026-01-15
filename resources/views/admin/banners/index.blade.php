@extends('admin.layout.layout')
@section('content')
<main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Admin Management</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Banners</li>
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-md-12">
                <div class="card mb-4">
                  <div class="card-header"><h3 class="card-title">Banners</h3>
                    @if ($bannersModule['edit_access']==1 || $bannersModule['full_access']==1)
                <a style="max-width:150px;float:right;display: inline-block;"
                href="{{ url('admin/banners/create') }}" class="btn btn-primary">Add Banner</a>
                @endif
                </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                       @if (Session::has('success_message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
               <strong>Success:</strong>{{ Session::get('success_message') }}
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
               </button>
              </div>
          @endif
                    <table class="table table-bordered" id="banners">
                      <thead>
                        <tr>
                          <th>#ID</th>
                          <th>Image</th>
                          <th>Type</th>
                           <th>Link</th>
                           <th>Alt</th>
                           <th>Sort</th>
                           <th>Status</th>
                            <th>Action</th>

                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($banners as $banner)
                           <tr>
                          <td>{{ $banner->id }}</td>
                          <td> <img src="{{ asset('front/img/banners/' . $banner->image) }}" width="50"></td>
                         <td>{{ $banner->type }}</td>
                          <td>{{ $banner->link }}</td>
                          <td>{{ $banner->alt }}</td>
                          <td>{{ $banner->sort }}</td>
                          <td>{{ $banner->status }}</td>
                                    <td>

                        @if ($bannersModule['edit_access']==1 || $bannersModule['full_access']==1)
                         @if ($banner->status == 1)
                    <a class="updateBannerStatus" data-banner_id="{{ $banner->id }}" href="javascript:void(0)">
                        <i class="fas fa-toggle-on" style="color:#3f6ed3" data-status="Active"></i>
                    </a>
                @else
                    <a class="updateBannerStatus" data-banner_id="{{ $banner->id }}" href="javascript:void(0)">
                        <i class="fas fa-toggle-off" style="color:grey" data-status="Inactive"></i>
                    </a>
                @endif
                 <a href="{{ url('admin/banners/'.$banner->id.'/edit') }}"><i class="fas fa-edit"></i></a>
                 @endif
                @if ($bannersModule['full_access']==1)
               <form action="{{ route('banners.destroy', $banner->id) }}" method="POST" style="display:inline-block;">@csrf
                @method('DELETE')
                <button class="confirmDelete" name="Banner" type="button"  style="border:none; background:none;color:#3f6ed3"
                 title="Delete Banner" href="javascript:void(0)" data-module="banners" data-id="{{ $banner->id }}">
                    <i class="fas fa-trash"></i>
                </button>
                </form>
                @endif
            </td>

                        </tr>
                        @endforeach


                      </tbody>
                    </table>
                  </div>


              </div>
              <!-- /.col -->

              <!-- /.col -->
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>
@endsection
