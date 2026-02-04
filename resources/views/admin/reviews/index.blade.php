@extends('admin.layout.layout')
@section('content')
<main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Reviews Management</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Reviews</li>
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
                  <div class="card-header"><h3 class="card-title">Reviews</h3>
                    @if ($reviewsModule['edit_access']==1 || $reviewsModule['full_access']==1)
                <a style="max-width:150px;float:right;display: inline-block;"
                href="{{ url('admin/reviews/create') }}" class="btn btn-primary">Add Review</a>
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
                    <table class="table table-bordered" id="reviews">
                      <thead>
                        <tr>
                          <th>Product</th>
                          <th>User</th>
                          <th>Rating</th>
                           <th>Review</th>
                           <th>Status</th>
                           <th>Actions</th>

                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($reviews as $review)
                           <tr>
                          <td>{{ $review->product->product_name }}</td>
                          <td>
                           {{ $review->user->name ?? 'Guest' }}
                          </td>
                         <td>{{ $review->rating }} </td>
                          <td>{{ $review->review }} </td>


                          <td>
                              @if ($reviewsModule['edit_access']==1 || $reviewsModule['full_access']==1)
                         @if ($review->status == 1)
                    <a class="updateReviewStatus" data-review_id="{{ $review->id }}" href="javascript:void(0)">
                        <i class="fas fa-toggle-on" style="color:#3f6ed3" data-status="Active"></i>
                    </a>
                @else
                    <a class="updateReviewStatus" data-review_id="{{ $review->id }}" href="javascript:void(0)">
                        <i class="fas fa-toggle-off" style="color:grey" data-status="Inactive"></i>
                    </a>
                @endif
                @endif
                          </td>

                                    <td>


                      @if ($reviewsModule['edit_access']==1 || $reviewsModule['full_access']==1)

                     <a href="{{ url('admin/reviews/'.$review->id.'/edit') }}"><i class="fas fa-edit"></i></a>


                @if ($reviewsModule['full_access']==1)
               <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" style="display:inline-block;">@csrf
                @method('DELETE')
                <button class="confirmDelete" name="Review" type="button"  style="border:none; background:none;color:#3f6ed3"
                 title="Delete Review" href="javascript:void(0)" data-module="review" data-id="{{ $review->id }}">
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
