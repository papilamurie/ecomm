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
            <div class="row">
              <div class="col-md-12">
                <div class="card mb-4">
                  <div class="card-header"><h3 class="card-title">{{ $title }}</h3>
                    @if($filtersModule['edit_access']==1 || $filtersModule['full_access']==1)
                <a style="max-width:150px;float:right;display: inline-block;"
                href="{{ route('filters.create') }}" class="btn btn-primary float-end">Add Filter</a>
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
                    <table class="table table-bordered" id="filters">
                      <thead>
                        <tr>
                          <th>#ID</th>
                          <th>Filter Name</th>
                          <th>Category</th>
                           <th>Status</th>
                          <th>Action</th>

                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($filters as $filter)
                           <tr>
                          <td>{{ $filter->id }}</td>
                          <td>{{ $filter->filter_name }}</td>
                          <td>
                            @if ($filter->categories->count()>0)
                                 {{ $filter->categories->pluck('name')->join(', ') }}
                            @else
                                N/A
                            @endif


                          </td>
                          <td>
                          @if($filtersModule['edit_access']==1 || $filtersModule['full_access']==1)
                            @if ($filter->status==1)
                                <a class="updateFilterStatus" data-filter_id="{{ $filter->id }}" style="color:#3f6ed3"
                                     href="javascript:void(0)">
                                    <i class="fas fa-toggle-on"  data-status="Active"></i>
                                </a>
                            @else
                            <a class="updateFilterStatus" data-filter_id="{{ $filter->id }}" style="color:grey"
                                     href="javascript:void(0)">
                                    <i class="fas fa-toggle-off"  data-status="Inactive"></i>
                                </a>
                            @endif
                            @else
                            {{ $filter->status == 1 ? 'Active' : 'Inactive' }}
                            @endif
                          </td>

                                    <td>
                       @if($filtersModule['edit_access']==1 || $filtersModule['full_access']==1)

                       <a href="{{ route('filters.edit', $filter->id) }}"><i class="fas fa-edit"></i></a>
                       &nbsp;&nbsp;
                        @endif
                        @if($filtersModule['full_access']==1)
                       <form method="POST" action="{{ route('filters.destroy', $filter->id) }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="confirmDelete" data-module="filter" data-id="{{ $filter->id }}"
                             style="border:none; background:none;color:red" title="Delete Filter">
                            <i class="fas fa-trash"></i>
                        </button>
                          </form>
                          &nbsp;
                            @endif
                       @if($filtersModule['view_access']==1 || $filtersModule['edit_access']==1 || $filtersModule['full_access']==1)
                         <a href="{{ route('filter_values.index', $filter->id) }}" class="btn btn-sm btn-secondary">
                            Manage Values
                         </a>
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
