@extends('layouts.app')

@section('pageTitle', trans('main.dashboard.title'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ trans('main.dashboard.title') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ trans('main.dashboard.logged') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
