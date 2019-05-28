@extends('layouts.app')

@section('pageTitle', trans('main.companies.title'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ trans('main.companies.title') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p>
                        <a href="{{ route('companies.create') }}">
                            <button type="button" class="btn btn-success">{{ trans('main.companies.add') }}</button>
                        </a>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center" style="width: 20%">{{ trans('main.companies.fields.logo') }}</th>
                                    <th scope="col" class="text-center" style="width: 25%">{{ trans('main.companies.fields.name') }}</th>
                                    <th scope="col" class="text-center" style="width: 20%">{{ trans('main.companies.fields.email') }}</th>
                                    <th scope="col" class="text-center" style="width: 20%">{{ trans('main.companies.fields.website') }}</th>
                                    <th scope="col" class="text-center" style="width: 15%">{{ trans('main.companies.fields.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($companies as $company)
                                    <tr>
                                        <td><img src="{{ $company->logo }}" class="img-thumbnail"></td>
                                        <td>{{ $company->name }}</td>
                                        <td>{{ $company->email }}</td>
                                        <td><a href="{{ $company->website }}">{{ $company->website }}</a></td>
                                        <td class="text-center">
                                            <a href="{{ url('/companies/'.$company->id.'/edit') }}">
                                                <button type="button" class="btn btn-primary btn-sm mb-1">{{ trans('main.buttons.edit') }}</button>
                                            </a>

                                            <form action="{{ url('/companies/'.$company->id) }}" method="POST">
                                                @method("DELETE")
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">{{ trans('main.buttons.delete') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                    
                                @empty
                                    <tr>
                                        <td colspan="5"><p class="text-center">{{ trans('main.companies.empty') }}</p></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
