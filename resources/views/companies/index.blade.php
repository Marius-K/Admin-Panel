@extends('layouts.app')

@section('pageTitle', trans('main.companies.title'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ trans('main.companies.title') }}</div>

                <div class="card-body">
                    <alert ref="alert"></alert>
                    <company ref="modal" csrf="{{ csrf_token() }}"></company>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
