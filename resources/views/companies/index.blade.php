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
                    <p>
                        <button type="button" class="btn btn-success" @click="$refs.modal.showCreateModal()">{{ trans('main.companies.add') }}</button>
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
                                        <td class="align-middle"><img src="{{ $company->logo }}" class="img-thumbnail"></td>
                                        <td class="align-middle">{{ $company->name }}</td>
                                        <td class="align-middle">{{ $company->email }}</td>
                                        <td class="align-middle"><a href="{{ $company->website }}">{{ $company->website }}</a></td>
                                        <td class="text-center align-middle">
                                            <button type="button" class="btn btn-primary btn-sm mb-1" @click="$refs.modal.showEditModal({{ $company->id }})">{{ trans('main.buttons.edit') }}</button>

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
<company-modal ref="modal" csrf="{{ csrf_token() }}"></company-modal>
@endsection
