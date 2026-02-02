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
                            Register
                        </li>
                    </ol>
                </div>
            </nav>

            <h1>Register</h1>
        </div>
    </div>

    <div class="container login-container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="row">
                    <div class="col-md-12">
                        <div class="heading mb-1">
                            <h2 class="title">Create Account</h2>
                            <div id="registerSuccess"></div>
                        </div>

                        <form name="registerForm" id="registerForm" novalidate>
                            @csrf
                            <label for="name">
                                Full Name

                            </label>
                            <input type="text" class="form-input form-wide" name="name" id="name" />
                            <p class="help-block text-danger" data-error="name"></p>

                            <label for="email">
                                Email address
                                <span class="required">*</span>
                            </label>
                            <input type="email" class="form-input form-wide" name="email" id="email" required />
                            <p class="help-block text-danger" data-error="email"></p>

                            <label for="password">
                                Password
                                <span class="required">*</span>
                            </label>
                            <input type="password" class="form-input form-wide" name="password" id="password" required />
                            <p class="help-block text-danger" data-error="password"></p>

                            <label for="password_confirmation">
                                Confirm Password
                                <span class="required">*</span>
                            </label>
                            <input type="password" class="form-input form-wide" name="password_confirmation" id="password_confirmation" required />
                            <p class="help-block text-danger" data-error="password_confirmation"></p>

                            <div class="form-footer">
                                <div class="mb-0">
                                    <label class="form-control-label mb-0">Register As:</label>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="user_type" id="regCustomer" class="form-check-input" value="Customer" checked>
                                        <label class="form-check-label" for="regCustomer">Customer</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="user_type" id="regVendor" class="form-check-input" value="Vendor">
                                        <label class="form-check-label" for="regVendor">Vendor</label>
                                    </div>
                                    <p class="help-block text-danger" data-error="user_type"></p>
                                </div>
                            </div>

                            <button type="submit" id="registerButton" class="btn btn-dark btn-md w-100">
                                REGISTER
                            </button>
                        </form>
                        <p class="mt-3">Already Have an Account? <a href="{{ route('user.login') }}">Login Here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main><!-- End .main -->
@endsection
