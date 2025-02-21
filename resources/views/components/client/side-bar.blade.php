<x-layout.app>

<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="{{Route::current()->getName() === 'prohotel.client.panel.dashboard' ? 'bg-dark  text-light' : ''}} nav-link " href="{{ route('prohotel.client.panel.dashboard') }}">
          <i class="bi bi-grid {{Route::current()->getName() === 'prohotel.client.panel.dashboard' ? 'text-light' : ''}}"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="{{Route::current()->getName() === 'prohotel.client.panel.profile' ? 'bg-dark  text-light' : ''}} nav-link " href="{{ route('prohotel.client.panel.profile') }}">
          <i class="bi bi-person {{Route::current()->getName() === 'prohotel.client.panel.profile' ? 'text-light' : ''}}"></i>
          <span>Meu Perfil</span>
        </a>
      </li>
      <!-- End Dashboard Nav -->
    </ul>

  </aside>

</x-layout.app>

