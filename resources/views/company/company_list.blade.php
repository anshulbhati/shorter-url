@extends('layouts.app')
@section('title', 'Company List')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-6">
                        Companies 
                    </div>
                    <div class="col-6">
                        <a href="{{ route('create.company.page') }}" class="btn btn-primary text-end">Add Company</a> 
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Users</th>
                            <th>Generated Urls</th>
                            <th>Total Hits</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($Companies->count() > 0)
                            @foreach ($Companies as $key => $company)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $company->name }}</td>
                                    <td>{{ $company->email }}</td>
                                    <td>{{ $company->users->count() }}</td>
                                    <td>{{ $company->shorterUrls->count() }}</td>
                                    <td>{{ $company->shorterUrls->sum('hits') }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div>
                    {{ $Companies->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection