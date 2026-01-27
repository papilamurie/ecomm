@extends('admin.layout.layout')

@section('content')
<main class="app-main">

    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Coupon Management</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--end::App Content Header-->

    <div class="app-content">
        <div class="container-fluid">
            <div class="row g-4">
                <div class="col-md-12">

                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <div class="card-title">{{ $title }}</div>
                        </div>

                        {{-- Alerts --}}
                        @if (Session::has('error_message'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                <strong>Error:</strong> {{ Session::get('error_message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (Session::has('success_message'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <strong>Success:</strong> {{ Session::get('success_message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible fade show">
                                <strong>Error:</strong> {!! $error !!}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endforeach

                        {{-- Form --}}
                        <form id="couponForm" method="POST"
                                action="{{ isset($coupon->id) ? route('coupons.update', $coupon->id) : route('coupons.store') }}">
                                @csrf
                                @if(isset($coupon->id))
                                    @method('PUT')
                                @endif

                            <div class="card-body">

                                {{-- Coupon Code && Option --}}
                                <div class="row mb-3">
                                   <div class="col-md-6">
                                    <div class="form-group">
                                     <label>Coupon Option</label><br>
                                     <div class="form-check form-check-inline">
                                        <input id="couponOptionAutomatic" class="form-check-input"
                                        type="radio" name="coupon_option" value="Automatic"
                                        {{ old('coupon_option', $coupon->coupon_option ?? 'Automatic')==='Automatic' ? 'checked' : '' }}>
                                     <label class="form-check-label" for="couponOptionAutomatic">Automatic </label>
                                     </div>
                                 <div class="form-check form-check-inline">
                                   <input id="couponOptionManual" class="form-check-input" type="radio" name="coupon_option" value="Manual"
                                    {{ old('coupon_option', $coupon->coupon_option ?? 'Manual')==='Manual' ? 'checked' : '' }}>
                                   <label class="form-check-label" for="couponOptionManual">Manual </label>
                                 </div>
                                    </div>
                                   </div>

                                   <div class="col-md-6" id="couponCodeWrapper">
                                    <div class="form-group">
                                     <label for="coupon_code">Coupon Code</label>
                                     <div class="input-group">
                                        <input type="text" name="coupon_code" id="coupon_code" class="form-control"
                                        value="{{ old('coupon_code', $coupon->coupon_code ?? '') }}" placeholder="Enter Coupon code">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" id="regenCoupon" type="button" title="Regenerate">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </div>
                                     </div>
                                     <small class="form-text text-muted">Automatic will generate a code - you may customize it here.</small>
                                    </div>
                                   </div>
                                </div>

                                  {{-- Coupon Type && Amount Type --}}
                                <div class="row mb-3">
                                   <div class="col-md-6">
                                    <div class="form-group">
                                     <label>Coupon Type</label><br>
                                     <div class="form-check form-check-inline">
                                        <input id="couponTypeMultiple" class="form-check-input"
                                        type="radio" name="coupon_type"  value="Multiple"
                                        {{ old('coupon_type', $coupon->coupon_type ?? 'Multiple')==='Multiple' ? 'checked' : '' }}>
                                     <label class="form-check-label" for="couponTypeMultiple">Multiple Times</label>
                                     </div>
                                 <div class="form-check form-check-inline">
                                   <input id="couponTypeSingle" class="form-check-input" type="radio" name="coupon_type" value="Single"
                                    {{ old('coupon_type', $coupon->coupon_type ?? 'Single')==='Single' ? 'checked' : '' }}>
                                   <label class="form-check-label" for="couponTypeSingle">Single Time</label>
                                 </div>
                                    </div>
                                   </div>

                                   <div class="col-md-6">
                                    <div class="form-group">
                                     <label for="amount_type">Amount Type</label><br>
                                    <div class="form-check form-check-inline">
                                        <input id="amountTypePercentage" class="form-check-input"
                                        type="radio" name="amount_type"  value="percentage"
                                        {{ old('amount_type', $coupon->amount_type ?? 'percentage')==='percentage' ? 'checked' : '' }}>
                                     <label class="form-check-label" for="amountTypePercentage">Percentage(%)</label>
                                     </div>
                                   <div class="form-check form-check-inline">
                                        <input id="amountTypeFixed" class="form-check-input"
                                        type="radio" name="amount_type"  value="fixed"
                                        {{ old('amount_type', $coupon->amount_type ?? 'fixed')==='fixed' ? 'checked' : '' }}>
                                     <label class="form-check-label" for="amountTypeFixed">Fixed($)</label>
                                     </div>
                                    </div>
                                   </div>
                                </div>

                             {{-- Amount, min. max qty & expiry --}}
                                <div class="row mb-3">
                                  <div class="col-md-3">
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="number" step="0.01" min="0" class="form-control"
                                           name="amount" id="amount"
                                           value="{{ old('amount', $coupon->amount ?? '') }}" required>
                                </div>
                                </div>

                                <div class="col-md-3">
                                <div class="form-group">
                                    <label for="min_qty">Min Quantity</label>
                                  <select name="min_qty" id="min_qty" class="form-control">
                                    <option value="">Select Min Quantity</option>
                                    @for($i=1; $i<=10; $i++)
                                    <option value="{{ $i }}" {{ old('min_qty', $coupon->min_qty ?? '')==$i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                    @endfor
                                  </select>
                                </div>
                                </div>

                               <div class="col-md-3">
                                <div class="form-group">
                                    <label for="max_qty">Max Quantity</label>
                                  <select name="max_qty" id="max_qty" class="form-control">
                                    <option value="">Select Max Quantity</option>
                                    @for($i=1; $i<=100; $i++)
                                    <option value="{{ $i }}" {{ old('max_qty', $coupon->max_qty ?? '')==$i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                    @endfor
                                  </select>
                                </div>
                                </div>

                              <div class="col-md-3">
                                <div class="form-group">
                                    <label for="expiry_date">Expiry Date</label>
                                    <input type="date"  class="form-control"
                                           name="expiry_date" id="expiry_date"
                                           value="{{ old('expiry_date', isset($coupon->expiry_date) ?
                                           date('Y-m-d', strtotime($coupon->expiry_date)) : '') }}">
                                </div>
                                </div>
                                </div>

                                {{-- Price Range --}}
                                <div class="row mb-3">
                                  <div class="col-md-6">
                                <div class="form-group">
                                    <label for="min_cart_value">Min Price Range</label>
                                    <input type="number" step="0.01" class="form-control"
                                           name="min_cart_value" id="min_cart_value"
                                           value="{{ old('min_cart_value', $coupon->min_cart_value ?? '') }}">
                                </div>
                                </div>

                                 <div class="col-md-6">
                                <div class="form-group">
                                    <label for="max_cart_value">Max Price Range</label>
                                    <input type="number" step="0.01" class="form-control"
                                           name="max_cart_value" id="max_cart_value"
                                           value="{{ old('max_cart_value', $coupon->max_cart_value ?? '') }}">
                                </div>
                                </div>
                                </div>

                                {{-- Usage Limits --}}
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="total_usage_limit">Total Usage Limit</label>
                                            <input type="number" min="0" class="form-control"
                                                   name="total_usage_limit" id="total_usage_limit"
                                                   value="{{ old('total_usage_limit', $coupon->total_usage_limit ?? '') }}"
                                                   placeholder="Leave empty for unlimited">
                                            <small class="text-muted">Maximum times this coupon can be used overall</small>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="usage_limit_per_user">Usage Limit Per User</label>
                                            <input type="number" min="0" class="form-control"
                                                   name="usage_limit_per_user" id="usage_limit_per_user"
                                                   value="{{ old('usage_limit_per_user', $coupon->usage_limit_per_user ?? '') }}"
                                                   placeholder="Leave empty for unlimited">
                                            <small class="text-muted">Maximum times one user can use this coupon</small>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="max_discount">Max Discount Amount</label>
                                            <input type="number" step="0.01" min="0" class="form-control"
                                                   name="max_discount" id="max_discount"
                                                   value="{{ old('max_discount', $coupon->max_discount ?? '') }}"
                                                   placeholder="Leave empty for no limit">
                                            <small class="text-muted">Maximum discount for percentage coupons</small>
                                        </div>
                                    </div>
                                </div>

                                {{-- Select Categories & brand --}}
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                     <div class="form-group">
                                        <label for="categoriesSelect">Categories</label>
                                        <select name="categories[]" id="categoriesSelect" class="form-control select2"
                                        multiple style="color:#000;" data-actions-box="true">
                                        @foreach ($categories as $category )
                                            <option value="{{ $category['id'] }}"
                                            @if(in_array($category['id'],$selCats)) selected @endif>
                                            {{ $category['name'] ?? $category['category_name'] ?? '' }}
                                            </option>
                                            @foreach ($category['subcategories'] ?? [] as $subcategory )
                                            <option value="{{ $subcategory['id'] }}"
                                            @if(in_array($subcategory['id'],$selCats)) selected @endif>
                                            &nbsp;&nbsp;--{{ $subcategory['name'] ?? $subcategory['category_name'] ?? '' }}
                                            </option>
                                            @foreach ($subcategory['subcategories'] ?? [] as $subsubcategory )
                                            <option value="{{ $subsubcategory['id'] }}"
                                            @if(in_array($subsubcategory['id'],$selCats)) selected @endif>
                                            &nbsp;&nbsp;&nbsp;&nbsp;--{{ $subsubcategory['name'] ?? $subsubcategory['category_name'] ?? '' }}
                                            </option>

                                            @endforeach

                                            @endforeach

                                        @endforeach

                                    </select>
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-sm btn-success select-all"
                                         data-target="#categoriesSelect">Select All</button>
                                          <button type="button" class="btn btn-sm btn-danger deselect-all"
                                         data-target="#categoriesSelect">Deselect All</button>
                                    </div>
                                     </div>
                                    </div>


                                <div class="col-md-6">
                                     <div class="form-group">
                                        <label for="brandsSelect">Brands</label>
                                        <select name="brands[]" id="brandsSelect" class="form-control select2"
                                        multiple>
                                        @foreach ($brands as $id =>$name )
                                            <option value="{{ $id }}" {{ in_array($id, old('brands', $selBrands ?? [])) ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                        </select>
                                        <div class="mt-2">
                                        <button type="button" class="btn btn-sm btn-success select-all"
                                         data-target="#brandsSelect">Select All</button>
                                          <button type="button" class="btn btn-sm btn-danger deselect-all"
                                         data-target="#brandsSelect">Deselect All</button>
                                    </div>
                                     </div>
                                </div>
                                </div>

                                {{-- User-Multi Select --}}
                                <div class="row mb-3">
                                <div class="col-md-6">
                                     <div class="form-group">
                                        <label for="usersSelect">Users</label>
                                        <select name="users[]" id="usersSelect" class="form-control select2-tags"
                                        multiple>
                                        @foreach ($users as $user )
                                            <option value="{{ $user['email'] }}"
                                            @if(in_array($user['email'],$selUsers)) selected @endif>
                                                {{ $user['email'] }}
                                            </option>
                                        @endforeach
                                        </select>
                                        <div class="mt-2">
                                        <button type="button" class="btn btn-sm btn-success select-all"
                                         data-target="#usersSelect">Select All</button>
                                          <button type="button" class="btn btn-sm btn-danger deselect-all"
                                         data-target="#usersSelect">Deselect All</button>
                                    </div>
                                     </div>
                                </div>
                                </div>

                                {{-- Status --}}
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Status</label><br>
                                            <div class="form-check form-check-inline">
                                                <input id="statusActive" class="form-check-input"
                                                    type="radio" name="status" value="1"
                                                    {{ old('status', $coupon->status ?? 1)==1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="statusActive">Active</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input id="statusInactive" class="form-check-input"
                                                    type="radio" name="status" value="0"
                                                    {{ old('status', $coupon->status ?? 0)==0 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="statusInactive">Inactive</label>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Visibility check box --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Visibility</label><br>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="visible" id="visible" value="1"
                                                       {{ old('visible', $coupon->visible ?? 0)==1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="visible">Visible in Cart</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ isset($coupon->id) ? 'Update Coupon' : 'Add Coupon' }}</button>
                                <a href="{{ route('coupons.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>

</main>
@endsection
