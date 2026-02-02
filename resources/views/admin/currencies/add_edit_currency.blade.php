@extends('admin.layout.layout')

@section('content')
<main class="app-main">

    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Currency Management</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{ isset($currency) ? 'Edit Currency' : 'Add Currency' }}</li>
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
                            <div class="card-title">{{ isset($currency) ? 'Edit Currency' : 'Add Currency' }}</div>
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
                        <form id="currencyForm" method="POST" enctype="multipart/form-data"
                               @if(isset($currency))
                               action="{{ url('admin/currencies/'.$currency->id) }}"
                               @else
                               action="{{ url('admin/currencies') }}"
                               @endif
                               >
                                @csrf
                                @if(isset($currency))
                                    @method('PUT')
                                @endif

                            <div class="card-body">



                                {{-- Currency Code --}}
                                <div class="mb-3">
                                    <label class="form-label" for="code">Currency Code*</label>
                                    <input type="text" class="form-control"
                                           name="code" id="code"
                                           value="{{ old('code', $currency->code ?? '') }}"
                                           placeholder="eg GBP" required>
                                           @error('code')
                                               <span class="text-danger">{{ $message }}</span>
                                           @enderror
                                </div>

                                 {{-- Currency Symbol --}}
                                <div class="mb-3">
                                    <label class="form-label" for="symbol">Currency Symbol*</label>
                                    <input type="text" class="form-control"
                                           name="symbol" id="symbol"
                                           value="{{ old('symbol', $currency->symbol ?? '') }}"
                                           placeholder="eg $" required>
                                           @error('symbol')
                                               <span class="text-danger">{{ $message }}</span>
                                           @enderror
                                </div>

                                  {{-- Currency Name --}}
                                <div class="mb-3">
                                    <label class="form-label" for="name">Currency Name*</label>
                                    <input type="text" class="form-control"
                                           name="name" id="name"
                                           value="{{ old('name', $currency->name ?? '') }}"
                                           placeholder="eg US Dollars" required>
                                           @error('name')
                                               <span class="text-danger">{{ $message }}</span>
                                           @enderror
                                </div>

                                  {{-- Exchange Rate --}}
                                <div class="mb-3">
                                    <label class="form-label" for="rate">Rate*</label>
                                    <input type="number" step="0.00000001" class="form-control"
                                           name="rate" id="rate"
                                           value="{{ old('rate', $currency->rate ?? 1) }}"
                                           {{ isset($currency) &&$currency->is_base ? 'readonly' : '' }}>
                                           @if(isset($currency) && $currency->is_base)
                                           <small class="form-text text-muted">Base Currency always has rate = 1</small>
                                           @endif
                                            @error('rate')
                                               <span class="text-danger">{{ $message }}</span>
                                           @enderror
                                </div>

                                  {{-- Status --}}
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input"
                                           name="status" id="statusActive"
                                           value="1" {{ old('status', $currency->status ?? 1)==1 ? 'checked' : '' }}
                                           >
                                           <label class="form-check-label" for="statusActive">Active</label>

                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input"
                                           name="status" id="statusInactive"
                                           value="0" {{ old('status', $currency->status ?? 1)==0 ? 'checked' : '' }}
                                           >
                                           <label class="form-check-label" for="statusInactive">Inactive</label>

                                </div>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </div>



                          {{-- Base Currency --}}
                                <div class="mb-3">
                                    <label class="form-label">Base Currency</label>
                                    <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input"
                                           name="is_base" id="is_base" value="1"
                                           {{ old('is_base', $currency->is_base ?? 0)==1 ? 'checked' : '' }}
                                           >
                                           <label class="form-check-label" for="is_base">Mark as Base</label>

                                </div>
                                @if(isset($currency) && $currency->is_base)
                                    <small class="form-text text-muted">Base currency cannot be changed to inactive</small>
                                    @endif
                                </div>


                                {{-- Currency Flag --}}
                                <div class="mb-3">
                                    <div class="form-check form-check-inline">
                                    <label class="form-label">Flag</label>
                                    <input type="file" class="form-control" id="flag" name="flag" accept="image/*">

                                    @if (isset($currency) && $currency->flag)
                                        <div class="mt-2">
                                            <img src="{{ asset('front/img/flags/' . $currency->flag) }}"
                                             alt="flag" style="height:24px;">
                                           <small class="text-muted">{{ $currency->flag }}</small>



                                        </div>
                                    @endif
                                    @error('flag')
                                       <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>
                                </div>





                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ isset($currency) ? 'Update Currrency' : 'Add Currency'}}</button>
                                <a href="{{ url('admin/currencies') }}" class="btn btn-secondary">Cancel</a>
                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>

</main>
@endsection
