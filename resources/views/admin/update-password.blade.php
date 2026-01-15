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
                  <li class="breadcrumb-item active" aria-current="page">Update Password</li>
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
                  <div class="card-header"><div class="card-title">Update Password</div></div>
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
                  <form method="post" action="{{ route('admin.update-password.request') }}">@csrf
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
                        <div id="emailHelp" class="form-text">
                          We'll never share your email with anyone else.
                        </div>
                      </div>
                      <div class="mb-3">
                        <label for="current_pwd" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_pwd" name="current_pwd" />
                        <span id="verifyPwd"></span>
                      </div>
                      <div class="mb-3">
                        <label for="new_pwd" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_pwd" name="new_pwd" />
                      </div>
                     <div class="mb-3">
                        <label for="confirm_pwd" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_pwd" name="confirm_pwd" />
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
