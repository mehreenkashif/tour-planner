<div class="d-flex flex-column p-3 text-white h-100">
    <a href="{{ url('/') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <span class="fs-4"><i class="bi bi-globe"></i> Tour Planner</span>
    </a>
    <hr>
    @if(auth()->check())
    <ul class="nav nav-pills flex-column mb-auto">
        @if(auth()->user()->role == 'admin')
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link text-white">
                <i class="bi bi-plus-circle me-2"></i>Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('users.index') }}" class="nav-link text-white">
                <i class="bi bi-list-ul me-2"></i> Users
            </a>
        </li>
        @endif
        <li>
            <a href="{{ route('tours.index') }}" class="nav-link text-white">
                <i class="bi bi-list-ul me-2"></i> All Tours
            </a>
        </li>


    </ul>

    <hr>
    <div class="text-white small mb-3">
        Logged in as: {{ auth()->user()->name ?? 'Guest' }}
    </div>
    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-danger btn-sm">
            <i class="bi bi-box-arrow-right"></i> Logout
        </button>
    </form>
    @endif
</div>

{{--
<button class="btn btn-dark d-md-none mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
    <i class="bi bi-list"></i> Menu
  </button>


  <div id="sidebarMenu" class="collapse d-md-block bg-dark text-white p-3 h-100">
    <a href="{{ url('/') }}" class="d-flex align-items-center mb-3 text-white text-decoration-none">
      <span class="fs-4"><i class="bi bi-globe me-2"></i> Tour Planner</span>
    </a>
    <hr>

    @if(auth()->check())
    <ul class="nav nav-pills flex-column mb-auto">
      @if(auth()->user()->role == 'admin')
      <li class="nav-item">
        <a href="{{ route('dashboard') }}" class="nav-link text-white">
          <i class="bi bi-plus-circle me-2"></i>Dashboard
        </a>
      </li>
      <li>
        <a href="{{ route('users.index') }}" class="nav-link text-white">
          <i class="bi bi-list-ul me-2"></i> Users
        </a>
      </li>
      @endif
      <li>
        <a href="{{ route('tours.index') }}" class="nav-link text-white">
          <i class="bi bi-list-ul me-2"></i> All Tours
        </a>
      </li>
    </ul>

    <hr>
    <div class="small mb-3">Logged in as: {{ auth()->user()->name ?? 'Guest' }}</div>

    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="btn btn-danger btn-sm w-100">
        <i class="bi bi-box-arrow-right me-1"></i> Logout
      </button>
    </form>
    @endif
  </div> --}}
