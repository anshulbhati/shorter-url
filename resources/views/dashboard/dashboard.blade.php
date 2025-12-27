@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="container mt-5">
        <div class="row">
            @can('isSuperAdmin')
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
                                    <td>{{ $company->shorterUrls->sum('click_count') }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    </table>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            {{ $Companies->links('pagination::bootstrap-5') }}
                        </div>
                        <a href="{{ route('company.list') }}" class="btn btn-primary text-end">View All Companies</a>
                    </div>
                </div>
            @endcan
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                
                <div class="row">
                    <div class="col-3">
                        All Shorter Urls 
                    </div>
                    @cannot('isSuperAdmin')
                     <div class="col-3">
                        <a href="{{ route('shorter.url.page') }}" class="btn btn-primary text-end">Create Shorter URL</a> 
                    </div>
                    @endcannot
                    <div class="col-4 text-end">
                        <form action="{{ route('dashboard') }}" method="GET">
                            <select name="filter" class="form-control" onchange="this.form.submit()">
                                <option value="">All</option>
                                <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>Today</option>
                                <option value="last_week" {{ request('filter') == 'last_week' ? 'selected' : '' }}>Last Week</option>
                                <option value="last_month" {{ request('filter') == 'last_month' ? 'selected' : '' }}>Last Month</option>
                            </select>
                        </form>
                        
                    </div>
                    <div class="col-2 text-end">
                        <a href="{{ url('shorter-url-list-download',request('filter')) }}" class="btn btn-primary">Download</a>
                    </div>
                </div>
                
               <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Original URL</th>
                            <th>Short Code</th>
                            <th>Click Count</th>
                            @can('isSuperAdmin')
                                <th>Company</th>
                            @endcan
                            @cannot('isSuperAdmin')
                                <th>Member Name</th>
                            @endcannot
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($ShorterUrls->count() > 0)
                            @foreach ($ShorterUrls as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}</td>

                                    <div>
                                        <td>{{ $value->original_url }}</td>
                                        <script>
                                            (function(){
                                                var td = document.currentScript.previousElementSibling;
                                                if(td && td.tagName === 'TD'){
                                                    var full = td.textContent.trim();
                                                    var max = 60;
                                                    var disp = full.length > max ? full.slice(0, max) + '…' : full;
                                                    td.innerHTML = '<a href="'+full+'" target="_blank" rel="noopener noreferrer">'+disp+'</a>';
                                                    td.title = full;
                                                }
                                            })();
                                        </script>
                                        <td><a href="{{ url('/s/'.$value->short_url) }}" target="_blank" rel="noopener noreferrer">{{ url('/s/'.$value->short_url) }}</a></td>
                                        <td>{{ $value->click_count }}</td>
                                        @can('isSuperAdmin')
                                            <td>{{ $value->company->name }}</td>
                                        @endcan
                                        @cannot('isSuperAdmin')
                                            <td>{{ $value->user->name }}</td>
                                        @endcannot
                                        <td>{{ $value->created_at->format('d-M-Y') }}</td>
                                    </div>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
               <div class="d-flex justify-content-between align-items-center">
                        <div>
                            {{ $ShorterUrls->links('pagination::bootstrap-5') }}
                        </div>
                    <a href="{{ route('shorter.url.list') }}" class="btn btn-primary text-end">view all urls</a>
                </div>
            </div>
        </div>
    </div>
    @cannot('isSuperAdmin')
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12">
                    
                    <div class="row">
                        <div class="col-6">
                            All Members 
                        </div>
                        <div class="col-6">
                            <a href="{{ route('invite.member.page') }}" class="btn btn-primary text-end">Invite Member</a> 
                        </div>
                    </div>
                <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Total Generated URLs</th>
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
                                        <td>{{ $item->shorterUrls->sum('click_count') }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            {{ $members->links('pagination::bootstrap-5') }}
                        </div>
                        <div>
                            <a href="{{ route('member.list') }}" class="btn btn-primary">view all members</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endcan
@endsection