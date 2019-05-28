@extends('layouts.app')

@section('pageTitle', trans('main.buttons.edit').' '.$employee->firstname.' '.$employee->lastname)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ trans('main.buttons.edit').' '.$employee->firstname.' '.$employee->lastname }}</div>

                <div class="card-body">
                    <form action="{{ url('employees/'.$employee->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method("PATCH")
                        <div class="form-group">
                            <label for="firstname">{{ trans('main.employees.fields.firstname') }}</label>
                            <input type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" id="firstname" value="{{ $employee->firstname }}" required>
                            @error('firstname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="lastname">{{ trans('main.employees.fields.lastname') }}</label>
                            <input type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" id="lastname" value="{{ $employee->lastname }}" required>
                            @error('lastname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="company">{{ trans('main.employees.fields.company') }}</label>
                            <select class="form-control @error('company') is-invalid @enderror" name="company" id="company" required>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}" @if($company->id == $employee->company_id) selected @endif>{{ $company->name }}</option>
                                @endforeach
                            </select>
                            @error('company')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">{{ trans('main.employees.fields.email') }}</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" aria-describedby="emailHelp" value="{{ $employee->email }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phonenumber">{{ trans('main.employees.fields.phone') }}</label>
                            <input type="text" class="form-control @error('phonenumber') is-invalid @enderror" name="phonenumber" id="phonenumber" placeholder="Enter a phone number" value="{{ $employee->phonenumber }}">
                            @error('phonenumber')
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
