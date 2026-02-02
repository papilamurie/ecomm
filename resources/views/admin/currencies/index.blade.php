@extends('admin.layout.layout')
@section('content')
<main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Currency Management</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Currencies</li>
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
                  <div class="card-header"><h3 class="card-title">Currencies</h3>
                    @if ($currenciesModule['edit_access']==1 || $currenciesModule['full_access']==1)
                <a style="max-width:150px;float:right;display: inline-block;"
                href="{{ url('admin/currencies/create') }}" class="btn btn-primary">Add Currency</a>
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
                    <table class="table table-bordered" id="currencies">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Flag</th>
                          <th>Name</th>
                           <th>Code</th>
                           <th>Symbol</th>
                           <th>Rate</th>
                           <th>Base</th>
                           <th>Created On</th>
                            <th>Actions</th>

                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($currencies as $currency)
                           <tr id="id="current-row-{{ $currency->id }}"">
                          <td>{{ $currency->id }}</td>
                          <td>
                            @if ($currency->flag)
                                <img src="{{ asset('front/img/flags/' .$currency->flag) }}"
                                alt="{{ $currency->code }}" style="height:16px">
                                @else
                                <span class="text-muted">----</span>

                            @endif
                          </td>
                         <td>{{ $currency->name }} </td>
                          <td>{{ $currency->code }} </td>
                          <td>{{ $currency->symbol }}</td>
                          <td>{{ $currency->rate }}</td>
                          <td>
                            @if ($currency->is_base)
                                <span class="badge bg-success text-white">Base</span>
                            @endif
                          </td>
                          <td>{{ optional($currency->created_at)->format('F j, g:i a') }}</td>

                                    <td>

                        @if ($currenciesModule['edit_access']==1 || $currenciesModule['full_access']==1)
                         @if ($currency->status == 1)
                    <a class="updateCurrencyStatus" data-currency_id="{{ $currency->id }}" href="javascript:void(0)">
                        <i class="fas fa-toggle-on" style="color:#3f6ed3" data-status="Active"></i>
                    </a>
                @else
                    <a class="updateCurrencyStatus" data-currency_id="{{ $currency->id }}" href="javascript:void(0)">
                        <i class="fas fa-toggle-off" style="color:grey" data-status="Inactive"></i>
                    </a>
                @endif

                     &nbsp;&nbsp;

                     <a href="{{ url('admin/currencies/'.$currency->id.'/edit') }}"><i class="fas fa-edit"></i></a>


                @if ($currenciesModule['full_access']==1)
               <form action="{{ route('currencies.destroy', $currency->id) }}" method="POST" style="display:inline-block;">@csrf
                @method('DELETE')
                <button class="confirmDelete" name="Currency" type="button"  style="border:none; background:none;color:#3f6ed3"
                 title="Delete Currency" href="javascript:void(0)" data-module="currency" data-id="{{ $currency->id }}">
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
