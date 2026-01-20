@extends('admin.layout.layout')

@section('content')
<main class="app-main">

    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Filter Value Management</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{ $title }} - {{ $filter->filter_name }}</li>
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
                        <form method="POST"
                                action="{{ isset($filterValue) ? route('filter_values.update', [$filter->id, $filterValue->id]) : route('filter_values.store', $filter->id)}}">
                                @csrf
                                @if(isset($filterValue))
                                    @method('PUT')
                                @endif

                            <div class="card-body">

                                {{-- Value --}}
                                <div class="mb-3">
                                    <label class="form-label">Value*</label>
                                    <input type="text" class="form-control"
                                           name="value" id="value"
                                           value="{{ old('value', $filterValue->value ?? '') }}">
                                </div>



                               {{-- Sort Order --}}
                                <div class="mb-3">
                                    <label class="form-label">Sort Order</label>
                                    <input type="number" class="form-control"
                                           name="sort"
                                           value="{{ old('sort', $filterValue->sort ?? '') }}">
                                </div>



                                {{-- Status --}}
                                <div class="mb-3">
                                   <label for="status" class="form-control"> Status*</label>
                                   <select name="status" class="form-select">
                                        <option value="1" {{ old('status', $filterValue->status ?? 1)==1 ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0" {{ old('status', $filterValue->status ?? 1)==0 ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                   </select>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">  Submit</button>
                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>

</main>
@endsection
