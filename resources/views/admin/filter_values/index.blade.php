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
                  <li class="breadcrumb-item active" aria-current="page">Manage - {{ $filter->filter_name }}</li>
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
                  <div class="card-header"><h3 class="card-title">Filter Values</h3>
                    @if($filterValuesModule['edit_access'] ?? false || $filterValuesModule['full_access'] ?? false)
                <a style="max-width:150px;float:right;display: inline-block;"
                href="{{ route('filter_values.create', $filter->id) }}" class="btn btn-primary float-end">Add Filter Value</a>
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
                    <table class="table table-bordered" id="filter_values">
                      <thead>
                        <tr>
                          <th>#ID</th>
                          <th>Value</th>
                          <th>Sort</th>
                           <th>Status</th>
                     @if($filterValuesModule['edit_access'] ?? false || $filterValuesModule['full_access'] ?? false)
                          <th>Action</th>
                        @endif
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($filterValues as $value)
                           <tr>
                          <td>{{ $value->id }}</td>
                          <td>{{ $value->value }}</td>
                          <td>{{ $value->sort }}</td>
                          <td>
                           @if ($value->status==1)
                               <span class="badge bg-success">Active</span>
                           @else
                               <span class="badge bg-danger">Inactive</span>
                           @endif

                          </td>
                        @if($filterValuesModule['edit_access'] ?? false || $filterValuesModule['full_access'] ?? false)
                          <td>
                            {{-- Edit --}}
                            @if($filterValuesModule['edit_access'] ?? false || $filterValuesModule['full_access'] ?? false)
                          <a href="{{ route('filter_values.edit', ['filter' => $filter->id, $value->id]) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i></a>
                            @endif

                            {{-- Delete --}}
                            @if($filterValuesModule['full_access'] ?? false)
                            <form action="{{ route('filter_values.destroy', [$filter->id, $value->id]) }}"
                                 method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger confirmDelete" name="Filter Value">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif


                          </td>
                        @endif


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
