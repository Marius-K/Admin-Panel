@extends('layouts.app')

@section('pageTitle', trans('main.employees.title'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ trans('main.employees.title') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p>
                        <a href="{{ route('employees.create') }}">
                            <button type="button" class="btn btn-success">{{ trans('main.employees.add') }}</button>
                        </a>
                    </p>

                    <div class="table-responsive">
                        <table class="table table-striped table-sm" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">{{ trans('main.employees.fields.firstname') }}</th>
                                    <th scope="col" class="text-center">{{ trans('main.employees.fields.lastname') }}</th>
                                    <th scope="col" class="text-center">{{ trans('main.employees.fields.company') }}</th>
                                    <th scope="col" class="text-center">{{ trans('main.employees.fields.email') }}</th>
                                    <th scope="col" class="text-center">{{ trans('main.employees.fields.phone') }}</th>
                                    <th scope="col" class="text-center" style="width: 15%">{{ trans('main.employees.fields.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($employees as $employee)
                                    <tr>
                                        <td>{{ $employee->firstname }}</td>
                                        <td>{{ $employee->lastname }}</td>
                                        <td>{{ $employee->company->name }}</td>
                                        <td>{{ $employee->email }}</td>
                                        <td>{{ $employee->phonenumber }}</td>
                                        <td class="text-center">
                                            <a href="{{ url('/employees/'.$employee->id.'/edit') }}">
                                                <button type="button" class="btn btn-primary btn-sm mb-1">{{ trans('main.buttons.edit') }}</button>
                                            </a>

                                            <form action="{{ url('/employees/'.$employee->id) }}" method="POST">
                                                @method("DELETE")
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">{{ trans('main.buttons.delete') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                    
                                @empty
                                    <tr>
                                        <td colspan="6"><p class="text-center">{{ trans('main.employees.empty') }}</p></td>
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
