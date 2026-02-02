@extends('admin.layout.layout')
@section('content')
<main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Users Management</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Users</li>
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
                  <div class="card-header"><h3 class="card-title">Users</h3>
                    @if ($usersModule['edit_access']==1 || $usersModule['full_access']==1)
                <a style="max-width:150px;float:right;display: inline-block;"
                href="{{ url('admin/users/create') }}" class="btn btn-primary">Add User</a>
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
                    <table class="table table-bordered" id="users">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Email</th>
                           <th>City</th>
                           <th>PostCode</th>
                           <th>Country</th>
                           <th>Registered On</th>
                            <th>Actions</th>

                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($users as $user)
                           <tr>
                          <td>{{ $user->id }}</td>
                          <td> {{ ucfirst($user->name ?? '-') }}</td>
                         <td>{{ $user->email }} </td>
                          <td>{{ $user->city ?? '-' }} </td>
                          <td>{{ $user->postcode ?? '-' }}</td>
                          <td>{{ $user->country ?? '-' }}</td>
                          <td>{{ optional($user->created_at)->format('F j, g:i a') }}</td>

                                    <td>

                        @if ($usersModule['edit_access']==1 || $usersModule['full_access']==1)
                         @if ($user->status == 1)
                    <a class="updateUserStatus" data-user_id="{{ $user->id }}" href="javascript:void(0)">
                        <i class="fas fa-toggle-on" style="color:#3f6ed3" data-status="Active"></i>
                    </a>
                @else
                    <a class="updateUserStatus" data-user_id="{{ $user->id }}" href="javascript:void(0)">
                        <i class="fas fa-toggle-off" style="color:grey" data-status="Inactive"></i>
                    </a>
                @endif

                     &nbsp;&nbsp;

                     <a href="{{ url('admin/users/'.$user->id.'/edit') }}"><i class="fas fa-edit"></i></a>


                @if ($usersModule['full_access']==1)
               <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">@csrf
                @method('DELETE')
                <button class="confirmDelete" name="User" type="button"  style="border:none; background:none;color:#3f6ed3"
                 title="Delete User" href="javascript:void(0)" data-module="user" data-id="{{ $user->id }}">
                    <i class="fas fa-trash"></i>
                </button>
                </form>
                @endif
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
