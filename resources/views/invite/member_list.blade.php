@extends('layouts.app')
@section('title', 'Member List')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-6">
                        Members 
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Generated Urls</th>
                            <th>Total Hits</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($members->count() > 0)
                            @foreach ($members as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->roles()->value('name') }}</td>
                                    <td>{{ $item->shorterUrls->count() }}</td>
                                    <td>{{ $item->shorterUrls->sum('hits') }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div>
                    {{ $members->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection