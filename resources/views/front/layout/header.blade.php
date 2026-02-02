<?php
use App\Models\Category;
use App\Models\Currency;

// Get Categories and their Sub Categories
$categories = Category::getCategories('Front');
$totalCartItems = totalCartItems();

// Get current currency and all active currencies
$currentCurrency = getCurrencyCurrency();
$currencies = Currency::where('status', 1)->orderBy('is_base', 'desc')->orderBy('code')->get();
?>
<div class="top-notice bg-primary text-white">
    <div class="container text-center">
        <h5 class="d-inline-block">Get Up to <b>40% OFF</b> New-Season Styles</h5>
        <a href="category.html" class="category">MEN</a>
        <a href="category.html" class="category ml-2 mr-3">WOMEN</a>
        <small>* Limited time only.</small>
        <button title="Close (Esc)" type="button" class="mfp-close">×</button>
    </div>
</div>

<header class="header">
    <div class="header-top">
        <div class="container">
            <div class="header-left d-none d-sm-block">
                <p class="top-message text-uppercase">FREE Returns. Standard Shipping Orders $99+</p>
            </div>

            <div class="header-right header-dropdowns ml-0 ml-sm-auto w-sm-100">
                <div class="header-dropdown dropdown-expanded d-none d-lg-block">
                    <a href="#">Links</a>
                    <div class="header-menu">
                        <ul>
                            @auth
                                <li><a href="{{ url('/user/dashboard') }}">My Account ({{ auth()->user()->name }})</a></li>
                                <li><a href="{{ url('/user/orders') }}">My Orders</a></li>
                                <li><a href="{{ url('/user/wishlist') }}">My Wishlist</a></li>
                                <li><a href="{{ route('cart.index') }}">Cart</a></li>
                                <li><a href="about.html">About Us</a></li>
                                <li><a href="blog.html">Blog</a></li>
                                <li>
                                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Log Out
                                    </a>
                                    <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            @else
                                <li><a href="about.html">About Us</a></li>
                                <li><a href="blog.html">Blog</a></li>
                                <li><a href="{{ route('cart.index') }}">Cart</a></li>
                                <li><a href="{{ route('user.login') }}">Log In</a></li>
                                <li><a href="{{ route('user.register') }}">Register</a></li>
                            @endauth
                        </ul>
                    </div>
                </div>

                <span class="separator"></span>

                <div class="header-dropdown">
                    <a href="#"><i class="flag-us flag"></i>ENG</a>
                    <div class="header-menu">
                        <ul>
                            <li><a href="#"><i class="flag-us flag mr-2"></i>ENG</a></li>
                            <li><a href="#"><i class="flag-fr flag mr-2"></i>FRA</a></li>
                        </ul>
                    </div>
                </div>

                {{-- Currency Switcher --}}
                <div class="header-dropdown mr-auto mr-sm-3 mr-md-0">
                    <a href="#" id="current-currency-btn">
                        @if($currentCurrency && $currentCurrency->flag)
                            <img src="{{ asset('front/img/flags/' . $currentCurrency->flag) }}"
                                 alt="{{ $currentCurrency->code }}"
                                 style="width: 16px; height: 12px; margin-right: 5px; vertical-align: middle;">
                        @endif
                        {{ $currentCurrency->code ?? 'USD' }}
                    </a>
                    <div class="header-menu" id="currency-list">
                        <ul>
                            @foreach($currencies as $currency)
                                <li>
                                    <a href="#"
                                       class="currency-item"
                                       data-code="{{ $currency->code }}"
                                       style="display: flex; align-items: center;">
                                        @if($currency->flag)
                                            <img src="{{ asset('front/img/flags/' . $currency->flag) }}"
                                                 alt="{{ $currency->code }}"
                                                 style="width: 16px; height: 12px; margin-right: 8px;">
                                        @endif
                                        <span>{{ $currency->code }} - {{ $currency->name }}</span>
                                        @if($currency->is_base)
                                            <small class="text-muted ml-1">(Base)</small>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <span class="separator"></span>

                <div class="social-icons">
                    <a href="#" class="social-icon social-facebook icon-facebook" target="_blank"></a>
                    <a href="#" class="social-icon social-twitter icon-twitter" target="_blank"></a>
                    <a href="#" class="social-icon social-instagram icon-instagram" target="_blank"></a>
                </div>
            </div>
        </div>
    </div>

    <div class="header-middle sticky-header" data-sticky-options="{'mobile': true}">
        <div class="container">
            <div class="header-left col-lg-2 w-auto pl-0">
                <button class="mobile-menu-toggler text-primary mr-2" type="button">
                    <i class="fas fa-bars"></i>
                </button>
                <a href="{{ url('/') }}" class="logo">
                    <img src="{{ asset('front/img/logo.png') }}" width="111" height="44" alt="Porto Logo">
                </a>
            </div>

            <div class="header-right w-lg-max">
                <div class="header-icon header-search header-search-inline header-search-category w-lg-max text-right mt-0">
                    <a href="#" class="search-toggle" role="button"><i class="icon-search-3"></i></a>
                    <form action="javascript:void(0);">
                        <div class="header-search-wrapper">
                            <input type="search" class="form-control" name="q" id="search_input" placeholder="Search for products">
                            <div class="select-custom"></div>
                            <button class="btn icon-magnifier p-0" title="search" type="submit"></button>
                        </div>
                    </form>
                    <div id="search_result" style="position:absolute;top:100%;left:0;right:0;background:#fff;border:1px solid #ddd;border-top:none;z-index:999;"></div>
                </div>

                <div class="header-contact d-none d-lg-flex pl-4 pr-4">
                    <img alt="phone" src="{{ asset('front/img/phone.png') }}" width="30" height="30" class="pb-1">
                    <h6><span>Call us now</span><a href="tel:#" class="text-dark font1">+123 5678 890</a></h6>
                </div>

                <a href="login.html" class="header-icon" title="login"><i class="icon-user-2"></i></a>
                <a href="wishlist.html" class="header-icon" title="wishlist"><i class="icon-wishlist-2"></i></a>

                <div class="dropdown cart-dropdown">
                    <a href="{{ route('cart.index') }}" title="Cart" class="btn btn-sm">
                        <i class="minicart-icon"></i>
                        <span class="cart-count badge-circle totalCartItems">{{ $totalCartItems }}</span>
                    </a>
                    <div class="cart-overlay"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="header-bottom sticky-header d-none d-lg-block" data-sticky-options="{'mobile': false}">
        <div class="container">
            <nav class="main-nav w-100">
                <ul class="menu">
                    <li class="active">
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li>
                        <a href="#">Categories</a>
                        <ul>
                            @foreach ($categories as $category)
                                @if ($category['menu_status'] == 1)
                                    <li>
                                        <a href="{{ url($category['url']) }}">{{ $category['name'] }}</a>
                                        @if (!empty($category['subcategories']))
                                            <ul>
                                                @foreach ($category['subcategories'] as $subcategory)
                                                    @if ($subcategory['menu_status'] == 1)
                                                        <li>
                                                            <a href="{{ url($subcategory['url']) }}">{{ $subcategory['name'] }}</a>
                                                            @if (!empty($subcategory['subcategories']))
                                                                <ul>
                                                                    @foreach ($subcategory['subcategories'] as $subsubcategory)
                                                                        @if ($subsubcategory['menu_status'] == 1)
                                                                            <li>
                                                                                <a href="{{ url($subsubcategory['url']) }}">{{ $subsubcategory['name'] }}</a>
                                                                            </li>
                                                                        @endif
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                    <li><a href="blog.html">Blog</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>

{{-- Pass currency switch URL to JavaScript --}}
<script>
    window.appConfig = window.appConfig || {};
    window.appConfig.currencySwitchUrl = '{{ route('currency.switch') }}';
</script>
