@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Employees</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p>
                        <a href="{{ route('employees.create') }}">
                            <button type="button" class="btn btn-success">Add an employee</button>
                        </a>
                    </p>

                    <div class="table-responsive">
                        <table class="table table-striped table-sm" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">First name</th>
                                    <th scope="col" class="text-center">Last name</th>
                                    <th scope="col" class="text-center">Company</th>
                                    <th scope="col" class="text-center">Email</th>
                                    <th scope="col" class="text-center">Phone number</th>
                                    <th scope="col" class="text-center" style="width: 15%">Action</th>
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
                                                <button type="button" class="btn btn-primary btn-sm mb-1">Edit</button>
                                            </a>

                                            <form action="{{ url('/employees/'.$employee->id) }}" method="POST">
                                                @method("DELETE")
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    
                                @empty
                                    <tr>
                                        <td colspan="6"><p class="text-center">There are no employees.</p></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex">
                        <div class="mx-auto">
                            {{ $employees->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
