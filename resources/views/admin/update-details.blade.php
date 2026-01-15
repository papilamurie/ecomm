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
                  <li class="breadcrumb-item active" aria-current="page">Update Details</li>
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
            <div class="row g-4">

              <!--begin::Col-->
              <div class="col-md-12">
                <!--begin::Quick Example-->
                <div class="card card-primary card-outline mb-4">
                  <!--begin::Header-->
                  <div class="card-header"><div class="card-title">Update Details</div></div>
                  <!--end::Header-->
                  <!--begin::Form-->
                   @if (Session::has('error_message'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
               <strong>Error:</strong>{{ Session::get('error_message') }}
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
               </button>
              </div>
          @endif
                     @if (Session::has('success_message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
               <strong>success:</strong>{{ Session::get('success_message') }}
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
               </button>
              </div>
          @endif
                     @foreach ($errors->all() as $error)
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
               <strong>Error!:</strong>{!! $error !!}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
               </button>
              </div>
          @endforeach
                  <form method="post" enctype="multipart/form-data" action="{{ route('admin.update-details.request') }}">@csrf
                    <!--begin::Body-->
                    <div class="card-body">
                      <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input
                          type="email"
                          class="form-control"
                          id="exampleInputEmail1"
                          aria-describedby="emailHelp"
                          value = "{{ Auth::guard('admin')->user()->email }}"
                          readonly
                        />
                       </div>
                      <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value = "{{ Auth::guard('admin')->user()->name }}" />

                      </div>
                      <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile</label>
                        <input type="text" class="form-control" id="mobile" name="mobile" value = "{{ Auth::guard('admin')->user()->mobile }}"/>
                      </div>
                     <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*"/>
                        @if (!empty(Auth::guard('admin')->user()->image))
                        <div id="profileImageBlock">
                            <a target="_blank" href="{{ url('admin/img/photos/'.Auth::guard('admin')->user()->image) }}">View</a>
                            <input type="hidden" name="current_image" value="{{ Auth::guard('admin')->user()->image }}">
                           <a href="javascript:void(0);" id="deleteProfileImage"
                           data-admin-id="{{ Auth::guard('admin')->user()->id }}" class="text-danger">Delete</a>

                        </div>

                        @endif
                      </div>
                     </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    <!--end::Footer-->
                  </form>
                  <!--end::Form-->
                </div>
                <!--end::Quick Example-->


              </div>
              <!--end::Col-->



              <!--end::Col-->
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>
@endsection
