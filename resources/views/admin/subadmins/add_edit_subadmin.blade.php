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
                  <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
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
                  <div class="card-header"><div class="card-title">{{ $title }}</div></div>
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
                  <form name="subadminForm" id="subadminForm" method="post" enctype="multipart/form-data"
                   action="{{ route('admin.add-edit-subadmin.request') }}">@csrf
                  @if (!empty($subadmindata->id))
                    <input type="hidden" name="id" value="{{ $subadmindata->id }}">
                    @endif

                    <!--begin::Body-->
                    <div class="card-body">
                      <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input
                          type="email"
                          class="form-control"
                          id="email"
                          name="email"
                         @if (!empty($subadmindata->email))
                            value="{{ $subadmindata->email }}" readonly
                            @endif

                        />
                       </div>
                      <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input
                          type="password"
                          class="form-control"
                          id="password"
                          name="password"
                          placeholder="Enter Password"
                        />
                       </div>
                      <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input
                          type="text"
                          class="form-control"
                          id="name"
                          name="name"
                          placeholder="Enter Name"
                          @if (!empty($subadmindata->name))
                            value="{{ $subadmindata->name }}"
                            @endif

                        />
                       </div>
                       <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile</label>
                        <input
                          type="text"
                          class="form-control"
                          id="mobile"
                          name="mobile"
                          placeholder="Enter Mobile"
                        @if (!empty($subadmindata->mobile))
                                value="{{ $subadmindata->mobile }}"
                                @endif

                        />
                       </div>
                     <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*"/>
                        @if (!empty($subadmindata->image))
                        <a target="_blank" href="{{ url('admin/img/photos/'.$subadmindata->image) }}">View</a>
                        <input type="hidden" name="current_image" value="{{ $subadmindata->image }}">
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
