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

			<div class="container reset-password-container">
				<div class="row">
					<div class="col-lg-6 offset-lg-3">
						<div class="feature-box border-top-primary">
							<div class="feature-box-content">
                                <div id="resetSuccess"></div>
								<form class="mb-0" name="resetForm" id="resetForm" novalidate>
                                    @csrf
									<p>
										Please enter your
										New Password to gain access to your dashboard.
									</p>
                                    <input type="hidden" name="token" value="{{ $token }}">
									<div class="form-group mb-0">
										<label for="reset-email" class="font-weight-normal">Email</label>
										<input type="email" class="form-control" id="resetEmail" name="email"
											required />
                                            <p class="help-block text-danger" data-error-for="email"></p>
									</div>
                                    <div class="form-group mb-0">
										<label for="reset-password" class="font-weight-normal">New Password</label>
										<input type="password" class="form-control" id="resetPassword" name="password"
											required />
                                            <p class="help-block text-danger" data-error-for="password"></p>
									</div>
                                    <div class="form-group mb-0">
										<label for="confirmPassword" class="font-weight-normal">Confirm Password</label>
										<input type="password" class="form-control" id="resetConfirm" name="password_confirmation"
											required />
                                            <p class="help-block text-danger" data-error-for="password_confirmation"></p>
									</div>

									<div class="form-footer mb-0">
										<a href="{{ route('user.login') }}">Click here to login</a>

										<button type="submit" id="resetButton"
											class="btn btn-md btn-primary form-footer-right font-weight-normal text-transform-none mr-0">
											Reset Password
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main><!-- End .main -->
@endsection
