<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Sistem Pendukung Keputusan Cerdas BLT-DD' }}</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
      :root {
        --brand:#1e90ff;
        --brand-dark:#166ac9;
        --bg:#f4f8ff;
      }

      body {
        background: var(--bg);
        min-height: 100vh;
      }

      .btn-brand {
        background: var(--brand);
        color:#fff;
        transition: all .2s;
      }
      .btn-brand:hover {
        background: var(--brand-dark);
        color:#fff;
      }

      /* Sidebar */
      .sidebar {
        background: #fff;
        border-right: 1px solid #e3e9f5;
        height: calc(100vh - 56px);
        position: fixed;
        top: 56px;
        left: 0;
        width: 240px;
        padding-top: 1rem;
        overflow-y: auto;
        transition: all .3s ease;
        z-index: 1030;
      }

      .sidebar.collapsed {
        width: 70px;
      }

      .sidebar .nav-link {
        color: #444;
        font-weight: 500;
        border-radius: 8px;
        margin: 4px 8px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all .2s;
      }

      .sidebar .nav-link:hover {
        background: #e9f2ff;
        color: var(--brand);
      }

      .sidebar .nav-link.active {
        background: var(--brand);
        color: white !important;
      }

      .sidebar .nav-link i {
        font-size: 1.2rem;
      }

      /* Content */
      .content {
        margin-left: 240px;
        padding: 80px 1.5rem 5rem;
        transition: all .3s ease;
        min-height: 100vh;
      }

      .collapsed ~ .content {
        margin-left: 70px;
      }

      /* Responsif */
      @media (max-width: 992px) {
        .sidebar {
          left: -240px;
          position: fixed;
        }

        .sidebar.show {
          left: 0;
        }

        .content {
          margin-left: 0 !important;
        }

        .navbar .navbar-collapse {
          background: #fff;
          border-top: 1px solid #eaeaea;
          padding: .75rem 1rem;
        }

        .navbar-nav .nav-item {
          margin-bottom: .5rem;
        }
      }
    </style>
  </head>

  <body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
      <div class="container-fluid">
        {{-- Tombol Toggle Sidebar (mobile) --}}
        <button id="sidebarToggle" class="btn btn-light border me-2 d-lg-none">
          <i class="bi bi-list"></i>
        </button>

        {{-- Brand --}}
        <a class="navbar-brand fw-semibold text-primary" href="{{ url('/') }}">
          <i class="bi bi-house-fill me-1"></i> Sistem Pendukung Keputusan Cerdas BLT-DD
        </a>

        {{-- Tombol Toggle Navbar (mobile) --}}
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <i class="bi bi-three-dots-vertical fs-5"></i>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
          <ul class="navbar-nav align-items-center">
            @auth
              <li class="nav-item me-lg-3 mb-2 mb-lg-0">
                <span class="fw-medium text-dark">
                  👋 Hi, <strong>{{ auth()->user()->full_name }}</strong>
                </span>
              </li>
              <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button class="btn btn-sm btn-outline-primary w-100 w-lg-auto">
                    <i class="bi bi-box-arrow-right me-1"></i> Keluar
                  </button>
                </form>
              </li>
            @else
              <li class="nav-item">
                <a href="{{ route('login.form') }}" class="btn btn-sm btn-brand w-100 w-lg-auto">
                  <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                </a>
              </li>
            @endauth
          </ul>
        </div>
      </div>
    </nav>

    {{-- Sidebar --}}
    @auth
      <div id="sidebar" class="sidebar shadow-sm">
        <div class="px-3 mb-3">
          <h6 class="text-muted small mb-2">MENU {{ strtoupper(auth()->user()->role) }}</h6>
        </div>
        <nav class="nav flex-column">
          @if(auth()->user()->role==='admin')
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
              <i class="bi bi-speedometer2"></i><span>Dashboard</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.alternatif.*') ? 'active' : '' }}" href="{{ route('admin.alternatif.index') }}">
              <i class="bi bi-people"></i><span>Alternatif</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.kriteria.*') ? 'active' : '' }}" href="{{ route('admin.kriteria.index') }}">
              <i class="bi bi-diagram-3"></i><span>Kriteria & Bobot</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.sub-kriteria.*') ? 'active' : '' }}" href="{{ route('admin.sub-kriteria.index') }}">
              <i class="bi bi-list-check"></i><span>Sub Kriteria</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.proses*') ? 'active' : '' }}" href="{{ route('admin.proses') }}">
              <i class="bi bi-cpu"></i><span>Proses</span>
            </a>
            <a class="nav-link {{ request()->routeIs('admin.hasil*') ? 'active' : '' }}" href="{{ route('admin.hasil') }}">
              <i class="bi bi-bar-chart"></i><span>Hasil</span>
            </a>
            <a class="nav-link {{ request()->routeIs('pesan*') ? 'active' : '' }}" href="{{ route('pesan.index') }}">
              <i class="bi bi-envelope"></i><span>Pesan</span>
            </a>
            <a class="nav-link {{ request()->routeIs('profile*') ? 'active' : '' }}" href="{{ route('profile.index') }}">
              <i class="bi bi-person-circle"></i><span>Profile</span>
            </a>
          @elseif(auth()->user()->role==='kepala_desa')
            <a class="nav-link {{ request()->routeIs('kades.dashboard') ? 'active' : '' }}" href="{{ route('kades.dashboard') }}">
              <i class="bi bi-speedometer2"></i><span>Dashboard</span>
            </a>
            <a class="nav-link {{ request()->routeIs('kades.alternatif') ? 'active' : '' }}" href="{{ route('kades.alternatif') }}">
              <i class="bi bi-people"></i><span>Data Alternatif</span>
            </a>
            <a class="nav-link {{ request()->routeIs('kades.hasil') ? 'active' : '' }}" href="{{ route('kades.hasil') }}">
              <i class="bi bi-graph-up"></i><span>Hasil</span>
            </a>
            <a class="nav-link {{ request()->routeIs('pesan*') ? 'active' : '' }}" href="{{ route('pesan.index') }}">
              <i class="bi bi-envelope"></i><span>Pesan</span>
            </a>
            <a class="nav-link {{ request()->routeIs('profile*') ? 'active' : '' }}" href="{{ route('profile.index') }}">
              <i class="bi bi-person-circle"></i><span>Profile</span>
            </a>
          @endif
        </nav>
      </div>
    @endauth

    {{-- Content --}}
    <div id="mainContent" class="content">
      @yield('content')
    </div>

    {{-- Footer --}}
    <footer class="py-2 border-top bg-white text-center text-muted small fixed-bottom">
      <span>&copy; {{ date('Y') }} Sistem Pendukung Keputusan Cerdas BLT-DD — Hybrid Fuzzy–SAW</span>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      const sidebar = document.getElementById('sidebar');
      const toggle = document.getElementById('sidebarToggle');

      // Toggle Sidebar
      if(toggle){
        toggle.addEventListener('click', () => {
          if(window.innerWidth < 992){
            sidebar.classList.toggle('show');
          }else{
            sidebar.classList.toggle('collapsed');
          }
        });
      }

      // Tutup sidebar jika klik luar (mobile)
      document.addEventListener('click', (e) => {
        if(window.innerWidth < 992 && sidebar.classList.contains('show')){
          if(!sidebar.contains(e.target) && !toggle.contains(e.target)){
            sidebar.classList.remove('show');
          }
        }
      });
    </script>
  </body>
</html>
