@extends('layouts.app')

@section('pageTitle', trans('main.employees.title'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ trans('main.employees.title') }}</div>

                <div class="card-body">
                    <alert ref="alert"></alert>
                    <employee ref="modal" csrf="{{ csrf_token() }}"></employee>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
