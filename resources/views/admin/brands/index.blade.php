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
                  <li class="breadcrumb-item active" aria-current="page">Brands</li>
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
                  <div class="card-header"><h3 class="card-title">Brands</h3>
                    @if ($brandsModule['edit_access']==1 || $brandsModule['full_access']==1)
                <a style="max-width:150px;float:right;display: inline-block;"
                href="{{ url('admin/brands/create') }}" class="btn btn-primary">Add Brand</a>
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
                    <table class="table table-bordered" id="brands">
                      <thead>
                        <tr>
                          <th>#ID</th>
                          <th>Name</th>
                          <th>Url</th>
                           <th>Created On</th>
                            <th>Action</th>

                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($brands as $brand)
                           <tr>
                          <td>{{ $brand->id }}</td>
                          <td>{{ $brand->name }}</td>
                         <td>{{ $brand->url }}</td>
                          <td>{{ $brand->created_at->format('F j, Y, g:i a') }}</td>
                                    <td>

                        @if ($brandsModule['edit_access']==1 || $brandsModule['full_access']==1)
                         @if ($brand->status == 1)
                    <a class="updateBrandStatus" data-brand_id="{{ $brand->id }}" href="javascript:void(0)">
                        <i class="fas fa-toggle-on" style="color:#3f6ed3" data-status="Active"></i>
                    </a>
                @else
                    <a class="updateBrandStatus" data-brand_id="{{ $brand->id }}" href="javascript:void(0)">
                        <i class="fas fa-toggle-off" style="color:grey" data-status="Inactive"></i>
                    </a>
                @endif
                 <a href="{{ url('admin/brands/'.$brand->id.'/edit') }}"><i class="fas fa-edit"></i></a>
                 @endif
                @if ($brandsModule['full_access']==1)
               <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" style="display:inline-block;">@csrf
                @method('DELETE')
                <button class="confirmDelete" name="Brand" type="button"  style="border:none; background:none;color:#3f6ed3"
                 title="Delete Category" href="javascript:void(0)" data-module="brands" data-id="{{ $brand->id }}">
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
