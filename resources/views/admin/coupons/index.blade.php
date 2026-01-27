@extends('admin.layout.layout')
@section('content')
<main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Coupons Management</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Coupons</li>
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
                  <div class="card-header"><h3 class="card-title">Coupons</h3>
                    @if ($couponsModule['edit_access']==1 || $couponsModule['full_access']==1)
                <a style="max-width:150px;float:right;display: inline-block;"
                href="{{ url('admin/coupons/create') }}" class="btn btn-primary">Add Coupon</a>
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
                    <table class="table table-bordered" id="coupons">
                      <thead>
                        <tr>
                          <th>Code</th>
                          <th>Coupon Type</th>
                          <th>Amount</th>
                           <th>Expiry Date</th>
                           <th>Status</th>
                            <th>Action</th>

                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($coupons as $coupon)
                           <tr>
                          <td>{{ $coupon->coupon_code }}</td>
                          <td> {{ ucfirst($coupon->coupon_type) }}</td>
                         <td>{{ $coupon->amount }}
                            @if($coupon->amount_type === 'percentage')
                            %
                            @else
                            INR
                            @endif

                         </td>
                          <td>@if ($coupon->expiry_date)
                            {{ $coupon->expiry_date->format('F j, Y') }}
                              @else
                              -
                          @endif</td>

                                    <td>

                        @if ($couponsModule['edit_access']==1 || $couponsModule['full_access']==1)
                         @if ($coupon->status == 1)
                    <a class="updateCouponStatus" data-coupon_id="{{ $coupon->id }}" href="javascript:void(0)">
                        <i class="fas fa-toggle-on" style="color:#3f6ed3" data-status="Active"></i>
                    </a>
                @else
                    <a class="updateCouponStatus" data-coupon_id="{{ $coupon->id }}" href="javascript:void(0)">
                        <i class="fas fa-toggle-off" style="color:grey" data-status="Inactive"></i>
                    </a>
                @endif
                @endif
                                    </td>
                <td>
                    @if ($couponsModule['edit_access']==1 || $couponsModule['full_access']==1)
                     <a href="{{ url('admin/coupons/'.$coupon->id.'/edit') }}"><i class="fas fa-edit"></i></a>
                     @endif
                @if ($couponsModule['full_access']==1)
               <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" style="display:inline-block;">@csrf
                @method('DELETE')
                <button class="confirmDelete" name="Coupon" type="button"  style="border:none; background:none;color:#3f6ed3"
                 title="Delete Coupon" href="javascript:void(0)" data-module="coupon" data-id="{{ $coupon->id }}">
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
