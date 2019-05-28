@extends('layouts.app')

@section('pageTitle', trans('main.buttons.edit').' '.$company->name)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ trans('main.buttons.edit').' '.$company->name }}</div>

                <div class="card-body">
                    <form action="{{ url('/companies/'.$company->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method("PATCH")
                        <div class="form-group">
                                <label for="name">{{ trans('main.companies.fields.name') }}</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ $company->name }}" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">{{ trans('main.companies.fields.email') }}</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" aria-describedby="emailHelp" value="{{ $company->email }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="logo">{{ trans('main.companies.fields.logo') }}</label>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="logo" name="logo">
                                        <label class="custom-file-label" for="logo">{{ trans('main.companies.fields.choose') }}</label>
                                    </div>
                                </div>
                                @error('logo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="website">{{ trans('main.companies.fields.website') }}</label>
                                <input type="text" class="form-control @error('website') is-invalid @enderror" name="website" id="website" value="{{ $company->website }}">
                                @error('website')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">{{ trans('main.buttons.submit') }}</button>
                        </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
