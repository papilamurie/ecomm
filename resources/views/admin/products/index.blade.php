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
                  <li class="breadcrumb-item active" aria-current="page">Products</li>
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
                  <div class="card-header"><h3 class="card-title">Products</h3>
                    @if ($productsModule['edit_access']==1 || $productsModule['full_access']==1)
                <a style="max-width:150px;float:right;display: inline-block;"
                href="{{ url('admin/products/create') }}" class="btn btn-primary">Add Product</a>
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
                    <table class="table table-bordered" id="products">
                      <thead>
                        <tr>
                          <th>#ID</th>
                          <th>Product Name</th>
                          <th>Product Code</th>
                           <th>Product Color</th>
                           <th>Product's Category</th>
                           <th>Parent Category</th>
                           <th>Actions</th>


                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($products as $product)
                           <tr>
                          <td>{{ $product->id }}</td>
                          <td>{{ $product->product_name }}</td>
                          <td>{{ $product->product_code }}</td>
                          <td>{{ $product->product_color }}</td>
                          <td>{{ $product['category']['name'] }}</td>
                          <td>@if (isset($product['category']['parentcategory']['name']))
                            {{ $product['category']['parentcategory']['name'] }}
                            @else
                            ROOT

                          @endif</td>

                        <td>
                        @if ($productsModule['edit_access']==1 || $productsModule['full_access']==1)
                         @if ($product->status == 1)
                    <a class="updateProductStatus" data-product_id="{{ $product->id }}" href="javascript:void(0)">
                        <i class="fas fa-toggle-on" style="color:#3f6ed3" data-status="Active"></i>
                    </a>
                @else
                    <a class="updateProductStatus" data-product_id="{{ $product->id }}" href="javascript:void(0)">
                        <i class="fas fa-toggle-off" style="color:grey" data-status="Inactive"></i>
                    </a>
                @endif
                 <a href="{{ url('admin/products/'.$product->id.'/edit') }}"><i class="fas fa-edit"></i></a>
                 @endif
                @if ($productsModule['full_access']==1)
               <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">@csrf
                @method('DELETE')
                <button class="confirmDelete" name="product" type="button"  style="border:none; background:none;color:#3f6ed3"
                 title="Delete product" href="javascript:void(0)" data-module="product" data-id="{{ $product->id }}">
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
