@extends('layouts.app')
@section('title', 'Shorter URL List')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-6">
                        All Shorter Urls 
                    </div>
                    <div class="col-4 text-end">
                        <form action="{{ route('shorter.url.list') }}" method="GET">
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
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($ShorterUrls->count() > 0)
                            @foreach ($ShorterUrls as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
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
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div>
                    {{ $ShorterUrls->links('pagination::bootstrap-5')}}
                </div>
            </div>
        </div>
    </div>
@endsection