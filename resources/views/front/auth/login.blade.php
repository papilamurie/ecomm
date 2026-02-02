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

    <div class="container login-container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="row">
                    <div class="col-md-12">
                        <div class="heading mb-1">
                            <h2 class="title">Login</h2>
                            <div id="loginSuccess"></div>
                        </div>

                        <form name="loginForm" id="loginForm" novalidate>
                            @csrf
                            <label for="loginEmail">
                                Email address
                                <span class="required">*</span>
                            </label>
                            <input type="email" class="form-input form-wide" name="email" id="loginEmail" required />
                            <p class="help-block text-danger" data-error="email"></p>

                            <label for="loginPassword">
                                Password
                                <span class="required">*</span>
                            </label>
                            <input type="password" class="form-input form-wide" name="password" id="loginPassword" required />
                            <p class="help-block text-danger" data-error="password"></p>

                            <div class="form-footer">
                                <div class="mb-0">
                                    <label class="form-control-label mb-0">Login As:</label>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="user_type" id="loginCustomer" class="form-check-input" value="Customer" checked>
                                        <label class="form-check-label" for="loginCustomer">Customer</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="user_type" id="loginVendor" class="form-check-input" value="Vendor">
                                        <label class="form-check-label" for="loginVendor">Vendor</label>
                                    </div>
                                    <p class="help-block text-danger" data-error="user_type"></p>
                                </div>

                                <a href="#" class="forget-password text-dark form-footer-right">
                                    Forgot Password?
                                </a>
                            </div>
                            <button type="submit" class="btn btn-dark btn-md w-100" id="loginButton">
                                LOGIN
                            </button>
                        </form>
                        <p class="mt-3">Don't Have an Account? <a href="{{ route('user.register') }}">Register Here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main><!-- End .main -->
@endsection
