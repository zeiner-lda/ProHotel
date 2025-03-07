<x-layout.app>

<div wire:ignore>
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item nav-profile">
        <a href="#" class="nav-link">
          <div class="nav-profile-image">
            <img src="{{ asset('/dashboard/assets/images/faces/face1.jpg') }}" alt="profile" />
            <span class="login-status online"></span>
            <!--change to offline or busy as needed-->
          </div>
          <div class="nav-profile-text d-flex flex-column">
            <span class="font-weight-bold mb-2">{{  isset(auth()->user()->username) ?  auth()->user()->username : ''}}</span>
          </div>
          <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
        </a>
      </li>

      <li class="nav-item {{Route::current()->getName() == "admin.home" ? "bg-primary  rounded" : ""}}">
        <a  class=" nav-link" href="{{ route("admin.home") }}">
          <span class="{{ Route::current()->getName() == "admin.home" ? 'text-white' : '' }} menu-title">Dashboard</span>
          <i class="{{ Route::current()->getName() == "admin.home" ? 'text-white' : '' }} fa fa-solid fa-home menu-icon"></i>
        </a>
      </li>

        <li class="nav-item {{Route::current()->getName() == "admin.users" ? "bg-primary rounded" : ""}}">
        <a class=" nav-link" href="{{ route("admin.users") }}">
          <span class=" {{ Route::current()->getName() == "admin.users" ? 'text-white' : '' }} menu-title">Utilizadores</span>
            <i class=" {{ Route::current()->getName() == "admin.users" ? 'text-white' : '' }} fa fa-solid fa-user-group menu-icon"></i>
          </a>
      </li>



    </ul>
  </nav>

</div>
</x-layout.app>

