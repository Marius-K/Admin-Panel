@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Companies</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p>
                        <a href="{{ route('companies.create') }}">
                            <button type="button" class="btn btn-success">Create new company</button>
                        </a>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center" style="width: 20%">Logo</th>
                                    <th scope="col" class="text-center" style="width: 25%">Name</th>
                                    <th scope="col" class="text-center" style="width: 20%">Email</th>
                                    <th scope="col" class="text-center" style="width: 20%">Website</th>
                                    <th scope="col" class="text-center" style="width: 15%">Action</th>
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
                                                <button type="button" class="btn btn-primary btn-sm mb-1">Edit</button>
                                            </a>

                                            <form action="{{ url('/companies/'.$company->id) }}" method="POST">
                                                @method("DELETE")
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    
                                @empty
                                    <tr>
                                        <td colspan="5"><p class="text-center">There are no companies.</p></td>
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
