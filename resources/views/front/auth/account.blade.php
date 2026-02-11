@extends('front.layout.layout')
@section('content')
<main class="main">
			<div class="page-header">
				<div class="container d-flex flex-column align-items-center">
					<nav aria-label="breadcrumb" class="breadcrumb-nav">
						<div class="container">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">
									My Account
								</li>
							</ol>
						</div>
					</nav>

					<h1>My Account</h1>
				</div>
			</div>

			<div class="container account-container custom-account-container">
				<div class="row">
					<div class="sidebar widget widget-dashboard mb-lg-0 mb-3 col-lg-3 order-0">
						<h2 class="text-uppercase">My Account</h2>
						<ul class="nav nav-tabs list flex-column mb-0" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="dashboard-tab" data-toggle="tab" href="#dashboard"
									role="tab" aria-controls="dashboard" aria-selected="true">Dashboard</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" id="order-tab" data-toggle="tab" href="#order" role="tab"
									aria-controls="order" aria-selected="true">Orders</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" id="download-tab" data-toggle="tab" href="#download" role="tab"
									aria-controls="download" aria-selected="false">Downloads</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" id="address-tab" data-toggle="tab" href="#address" role="tab"
									aria-controls="address" aria-selected="false">Addresses</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" id="edit-tab" data-toggle="tab" href="#edit" role="tab"
									aria-controls="edit" aria-selected="false">Account
									details</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="shop-address-tab" data-toggle="tab" href="#password" role="tab"
									aria-controls="edit" aria-selected="false">Change Password</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="wishlist.html">Wishlist</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="login.html">Logout</a>
							</li>
						</ul>
					</div>
					<div class="col-lg-9 order-lg-last order-1 tab-content">
						<div class="tab-pane fade show active" id="dashboard" role="tabpanel">
							<div class="dashboard-content">
								<p>
									Hello <strong class="text-dark">Editor</strong> (not
									<strong class="text-dark">Editor</strong>?
									<a href="login.html" class="btn btn-link ">Log out</a>)
								</p>

								<p>
									From your account dashboard you can view your
									<a class="btn btn-link link-to-tab" href="#order">recent orders</a>,
									manage your
									<a class="btn btn-link link-to-tab" href="#address">shipping and billing
										addresses</a>, and
									<a class="btn btn-link link-to-tab" href="#edit">edit your password and account
										details.</a>
								</p>

								<div class="mb-4"></div>

								<div class="row row-lg">
									<div class="col-6 col-md-4">
										<div class="feature-box text-center pb-4">
											<a href="#order" class="link-to-tab"><i
													class="sicon-social-dropbox"></i></a>
											<div class="feature-box-content">
												<h3>ORDERS</h3>
											</div>
										</div>
									</div>

									<div class="col-6 col-md-4">
										<div class="feature-box text-center pb-4">
											<a href="#download" class="link-to-tab"><i
													class="sicon-cloud-download"></i></a>
											<div class=" feature-box-content">
												<h3>DOWNLOADS</h3>
											</div>
										</div>
									</div>

									<div class="col-6 col-md-4">
										<div class="feature-box text-center pb-4">
											<a href="#address" class="link-to-tab"><i
													class="sicon-location-pin"></i></a>
											<div class="feature-box-content">
												<h3>ADDRESSES</h3>
											</div>
										</div>
									</div>

									<div class="col-6 col-md-4">
										<div class="feature-box text-center pb-4">
											<a href="#edit" class="link-to-tab"><i class="icon-user-2"></i></a>
											<div class="feature-box-content p-0">
												<h3>ACCOUNT DETAILS</h3>
											</div>
										</div>
									</div>

									<div class="col-6 col-md-4">
										<div class="feature-box text-center pb-4">
											<a href="wishlist.html"><i class="sicon-heart"></i></a>
											<div class="feature-box-content">
												<h3>WISHLIST</h3>
											</div>
										</div>
									</div>

									<div class="col-6 col-md-4">
										<div class="feature-box text-center pb-4">
											<a href="login.html"><i class="sicon-logout"></i></a>
											<div class="feature-box-content">
												<h3>LOGOUT</h3>
											</div>
										</div>
									</div>
								</div><!-- End .row -->
							</div>
						</div><!-- End .tab-pane -->

						<div class="tab-pane fade" id="order" role="tabpanel">
							<div class="order-content">
								<h3 class="account-sub-title d-none d-md-block"><i
										class="sicon-social-dropbox align-middle mr-3"></i>Orders</h3>
								<div class="order-table-container text-center">
									<table class="table table-order text-left">
										<thead>
											<tr>
												<th class="order-id">ORDER</th>
												<th class="order-date">DATE</th>
												<th class="order-status">STATUS</th>
												<th class="order-price">TOTAL</th>
												<th class="order-action">ACTIONS</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="text-center p-0" colspan="5">
													<p class="mb-5 mt-5">
														No Order has been made yet.
													</p>
												</td>
											</tr>
										</tbody>
									</table>
									<hr class="mt-0 mb-3 pb-2" />

									<a href="category.html" class="btn btn-dark">Go Shop</a>
								</div>
							</div>
						</div><!-- End .tab-pane -->

						<div class="tab-pane fade" id="download" role="tabpanel">
							<div class="download-content">
								<h3 class="account-sub-title d-none d-md-block"><i
										class="sicon-cloud-download align-middle mr-3"></i>Downloads</h3>
								<div class="download-table-container">
									<p>No downloads available yet.</p> <a href="category.html"
										class="btn btn-primary text-transform-none mb-2">GO SHOP</a>
								</div>
							</div>
						</div><!-- End .tab-pane -->

						<div class="tab-pane fade" id="address" role="tabpanel">
							<h3 class="account-sub-title d-none d-md-block mb-1"><i
									class="sicon-location-pin align-middle mr-3"></i>Addresses</h3>
							<div class="addresses-content">
								<p class="mb-4">
									The following addresses will be used on the checkout page by
									default.
								</p>

								<div class="row">
									<div class="address col-md-6">
										<div class="heading d-flex">
											<h4 class="text-dark mb-0">Billing address</h4>
										</div>

										<div class="address-box">
											You have not set up this type of address yet.
										</div>

										<a href="#billing" class="btn btn-default address-action link-to-tab">Add
											Address</a>
									</div>


								</div>
							</div>
						</div><!-- End .tab-pane -->

						<div class="tab-pane fade" id="edit" role="tabpanel">
							<h3 class="account-sub-title d-none d-md-block mt-0 pt-1 ml-1"><i
									class="icon-user-2 align-middle mr-3 pr-1"></i>Account Details</h3>
							<div class="account-content">
                                <div id="accountSuccess"></div>
								<form id="accountForm" name="accountForm" novalidate>
                                    @csrf
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="acc-name">Full Name <span class="required">*</span></label>
												<input type="text" class="form-control" placeholder="Full Name"
													id="name" name="name" value="{{ old('name',$user->name) }}" required />
                                                <p class="help-block text-danger" data-error-for="name"></p>
											</div>
										</div>


									</div>

									<div class="form-group mb-4">
										<label for="email">Email address <span class="required">*</span></label>
										<input type="email" class="form-control" id="email" name="email"
										 value="{{ old('email', $user->email) }}" 	placeholder="editor@gmail.com" readonly />
                                         <p class="small text-muted mb-0">Email cannot be edited here</p>
                                         <p class="help-block text-danger" data-error-for="email"></p>
									</div>

                                    <div class="form-group mb-4">
										<label for="company">Company </label>
										<input type="text" name="company" id="company" class="form-control" placeholder="Company"
                                         value="{{ old('company', $user->company) }}">
                                          <p class="help-block text-danger" data-error-for="company"></p>
									</div>

                                    <div class="form-group mb-4">
										<label for="phone">Phone</label>
										<input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ old('phone', $user->phone) }}" />
                                         <p class="help-block text-danger" data-error-for="phone"></p>
									</div>

                                      <div class="form-group mb-4">
										<label for="address_line1">Address Line 1</label>
										<input type="text" class="form-control" id="address_line1" name="address_line1"
                                        value="{{ old('address_line1', $user->address_line1) }}" />
                                         <p class="help-block text-danger" data-error-for="address_line1"></p>
									</div>

                                      <div class="form-group mb-3=4">
										<label for="phone">Address Line 2</label>
										<input type="text" class="form-control" id="address_line2" name="address_line2"
                                        value="{{ old('address_line2', $user->address_line2) }}" />
                                         <p class="help-block text-danger" data-error-for="address_line2"></p>
									</div>

                                      <div class="form-group mb-3=4">
										<label for="phone">City</label>
										<input type="text" class="form-control" id="city" name="city"
                                        value="{{ old('city', $user->city) }}" />
                                         <p class="help-block text-danger" data-error-for="city"></p>
									</div>
                                    <style>
                                        @keyframes spin {
                                            0% { transform: rotate(0deg); }
                                            100% { transform: rotate(360deg); }
                                        }
                                    </style>

                                    <div class="select-custom mb-3">
                                        <label>Country / Region <span class="required">*</span></label>
                                        <select name="country" id="country" class="form-control" required>
                                            @foreach($countries as $c)
                                            <option value="{{ $c->name }}" {{ old('country', $user->country ?? 'United Kingdom') === $c->name ? 'selected' : '' }}>
                                                {{ $c->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <p class="help-block text-danger" data-error-for="country"></p>
                                    </div>

                                    <!-- UK County Select (shown when country = UK) -->
                                    <div class="control-group mb-3" id="county_select_wrapper">
                                        <label for="county_select">County / State</label>
                                        <select id="county_select" name="county" class="form-control">
                                            <option value="">--Select County--</option>
                                            @foreach ($ukStates as $s)
                                                <option value="{{ $s->name }}" {{ old('county', $user->county) === $s->name ? 'selected' : '' }}>
                                                    {{ $s->name }}
                                                </option>
                                            @endforeach
                                            <option value="Other">Other (enter manually)</option>
                                        </select>
                                        <p class="help-block text-danger" data-error-for="county"></p>
                                    </div>

                                    <!-- County Text Input (shown when country != UK OR county = "Other") -->
                                    <div class="control-group mb-3" id="county_text_wrapper" style="display:none;">
                                        <label for="county_text">County / State / Province</label>
                                        <input type="text" id="county_text" name="county_text" class="form-control"
                                            placeholder="Enter your county/state"
                                            value="{{ old('county_text', '') }}">
                                        <p class="help-block text-danger" data-error-for="county_text"></p>
                                    </div>

                                    <div class="control-group mb-4">
                                        <label for="postcode">Postcode / ZIP</label>
                                        <div class="input-group">
                                            <input id="postcode" type="text" name="postcode" class="form-control"
                                                placeholder="Postcode/ZIP (UK: eg L1 8JQ)" value="{{ old('postcode', $user->postcode) }}">
                                            <div class="input-group-append">
                                                <span id="postcodeLoader" class="input-group-text" style="display:none;background:white;border-left:0;">
                                                    <span class="postcode-spinner" style="display:inline-block;width:16px;height:16px;border:2px solid rgba(0,0,0,0.12);
                                                    border-top-color:#333;border-radius:50%;animation:spin .8s linear infinite;"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <p class="help-block text-danger" data-error-for="postcode"></p>
                                    </div>


									<div class="form-footer mt-3 mb-0">
										<button type="submit" class="btn btn-dark mr-0" id="accountSaveBtn">
											Save changes
										</button>
									</div>
								</form>
							</div>
						</div><!-- End .tab-pane -->

						<div class="tab-pane fade" id="billing" role="tabpanel">
							<div class="address account-content mt-0 pt-2">
								<h4 class="title">Billing address</h4>

								<form class="mb-2" action="#">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>First name <span class="required">*</span></label>
												<input type="text" class="form-control" required />
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label>Last name <span class="required">*</span></label>
												<input type="text" class="form-control" required />
											</div>
										</div>
									</div>

									<div class="form-group">
										<label>Company </label>
										<input type="text" class="form-control">
									</div>

									<div class="select-custom">
										<label>Country / Region <span class="required">*</span></label>
										<select name="orderby" class="form-control">
											<option value="" selected="selected">British Indian Ocean Territory
											</option>
											<option value="1">Brunei</option>
											<option value="2">Bulgaria</option>
											<option value="3">Burkina Faso</option>
											<option value="4">Burundi</option>
											<option value="5">Cameroon</option>
										</select>
									</div>

									<div class="form-group">
										<label>Street address <span class="required">*</span></label>
										<input type="text" class="form-control"
											placeholder="House number and street name" required />
										<input type="text" class="form-control"
											placeholder="Apartment, suite, unit, etc. (optional)" required />
									</div>

									<div class="form-group">
										<label>Town / City <span class="required">*</span></label>
										<input type="text" class="form-control" required />
									</div>

									<div class="form-group">
										<label>State / Country <span class="required">*</span></label>
										<input type="text" class="form-control" required />
									</div>

									<div class="form-group">
										<label>Postcode / ZIP <span class="required">*</span></label>
										<input type="text" class="form-control" required />
									</div>

									<div class="form-group mb-3">
										<label>Phone <span class="required">*</span></label>
										<input type="number" class="form-control" required />
									</div>


									<div class="form-group mb-3">
										<label>Email address <span class="required">*</span></label>
										<input type="email" class="form-control" placeholder="editor@gmail.com"
											required />
									</div>

									<div class="form-footer mb-0">
										<div class="form-footer-right">
											<button type="submit" class="btn btn-dark py-4">
												Save Address
											</button>
										</div>
									</div>
								</form>
							</div>
						</div><!-- End .tab-pane -->

						<div class="tab-pane fade" id="password" role="tabpanel">
							<div class="address account-content mt-0 pt-2">
								<h4 class="title mb-3">Change Password</h4>
                                <div id="changePasswordSuccess"></div>
                                @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
								<form class="mb-2" id="changePasswordForm" novalidate>
                                    @csrf

										 <div class="change-password">
										<h3 class="text-uppercase mb-2">Password Change</h3>

										<div class="form-group">
											<label for="acc-password">Current Password (leave blank to leave
												unchanged)</label>
											<input type="password" class="form-control" id="current_password"
												name="current_password" />
                                                <p class="help-block text-danger" data-error-for="current_password"></p>
										</div>

										<div class="form-group">
											<label for="acc-password">New Password (leave blank to leave
												unchanged)</label>
											<input type="password" class="form-control" id="new_password"
												name="password" />
                                             <small class="text-muted d-block">Minimum 8 chars, mixed case, letters, numbers, and symbols</small>
                                               <p class="help-block text-danger" data-error-for="password"></p>
										</div>

										<div class="form-group">
											<label for="acc-password">Confirm New Password</label>
											<input type="password" class="form-control" id="password_confirmation"
												name="password_confirmation" />
                                             <p class="help-block text-danger" data-error-for="password_confirmation"></p>
										</div>
									</div>


                               <div class="form-footer mb-0">
										<div class="form-footer-right">
											<button type="submit" class="btn btn-dark py-4" id="changePasswordBtn">
												Change Password
											</button>
										</div>
									</div>
								</form>
							</div>
						</div><!-- End .tab-pane -->
					</div><!-- End .tab-content -->
				</div><!-- End .row -->
			</div><!-- End .container -->

			<div class="mb-5"></div><!-- margin -->
		</main><!-- End .main -->
@endsection
