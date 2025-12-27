<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">{{'Email: '. auth()->user()->email .' ||' . "Role :" . auth()->user()->roles->value('name') ?? ''}}</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse " id="navbarNav">
            <ul class="navbar-nav text-end">
                <li>
                    <a type="button" class="btn btn-outline-primary me-2" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                @can('isSuperAdmin')
                    <li class="nav-item">
                        <a type="button" class="btn btn-outline-success me-2" href="{{ route('create.company.page') }}">Create Company</a>
                    </li>
                    <li class="nav-item">
                        <a type="button" class="btn btn-outline-info me-2" href="{{ route('company.list') }}">View All Companies</a>
                    </li>
                @endcan
                @can('admin-or-member')
                    <li class="nav-item">
                        <a type="button" class="btn btn-outline-warning me-2" href="{{ route('invite.member.page') }}">Invite Member</a>
                    </li>
                    <li class="nav-item">
                        <a type="button" class="btn btn-outline-info me-2" href="{{ route('shorter.url.page') }}">Shorter URL</a>
                    </li>
                @endcan
                <li class="nav-item">
                    <a type="button" class="btn btn-outline-danger " href="{{ route('logout') }}">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

@include('partials.message')