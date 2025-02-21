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

          <li class="nav-item {{Route::current()->getName() == "dashboard.reception.index" ? "bg-primary  rounded" : ""}}">
            <a  class=" nav-link" href="{{ route("dashboard.reception.index") }}">
              <span class="{{ Route::current()->getName() == "dashboard.reception.index" ? 'text-white' : '' }} menu-title">Dashboard</span>
              <i class="{{ Route::current()->getName() == "dashboard.reception.index" ? 'text-white' : '' }} mdi mdi-home menu-icon"></i>
            </a>
          </li>
          <li class="nav-item {{Route::current()->getName() == "reception.reservations" ? "bg-primary rounded" : ""}}">
            <a class=" nav-link" href="{{ route("reception.reservations") }}">
              <span class=" {{ Route::current()->getName() == "reception.reservations" ? 'text-white' : '' }} menu-title">Reservas</span>
                <i class=" {{ Route::current()->getName() == "reception.reservations" ? 'text-white' : '' }} fa fa-solid fa-people-roof menu-icon"></i>
              </a>
          </li>


          <li class="nav-item {{Route::current()->getName() == "reception.checkins" ? "bg-primary rounded" : ""}}">
            <a class="nav-link d-flex align-items-center justify-content-between" href="{{ route("reception.checkins") }}">
              <span class="{{ Route::current()->getName() == "reception.checkins" ? 'text-white' : '' }} menu-title">Checkin</span>
              <i  class="{{ Route::current()->getName() == "reception.checkins" ? 'text-white' : '' }}  fa fa-solid fa-arrow-right-long menu-icon "></i>
            </a>
          </li>

           <li class="nav-item {{Route::current()->GetName() == "reception.checkout" ? "bg-primary rounded" : ""}}">
            <a class=" nav-link" href="{{ route("reception.checkout") }}">
              <span class=" {{ Route::current()->GetName() == "reception.checkout" ? 'text-white' : '' }} menu-title">Checkout</span>
                <i class=" {{ Route::current()->GetName() == "reception.checkout" ? 'text-white' : '' }} fa fa-solid  fa-arrow-right-arrow-left menu-icon"></i>
              </a>
          </li>

          <li class="nav-item {{Route::current()->getName() == "reception.rooms" ? "bg-primary rounded" : ""}}">
            <a class=" nav-link" href="{{ route("reception.rooms") }}">
              <span class=" {{ Route::current()->getName() == "reception.rooms" ? 'text-white' : '' }} menu-title">Quartos</span>
                <i class=" {{ Route::current()->getName() == "reception.rooms" ? 'text-white' : '' }} fa fa-solid  fa-hotel menu-icon"></i>
              </a>
          </li>


          <li class="nav-item {{Route::current()->getName() == "reception.testimonials" ? "bg-primary rounded" : ""}}">
            <a class=" nav-link" href="{{ route("reception.testimonials") }}">
              <span class=" {{ Route::current()->getName() == "reception.testimonials" ? 'text-white' : '' }} menu-title">Depoimentos</span>
                <i class=" {{ Route::current()->getName() == "reception.testimonials" ? 'text-white' : '' }} fa fa-solid fa-pen-to-square menu-icon"></i>
              </a>
          </li>

          <li class="nav-item {{Route::current()->getName() == "reception.notifications" ? "bg-primary rounded" : ""}}">
            <a class=" nav-link" href="{{ route("reception.notifications") }}">
              <span class=" {{ Route::current()->getName() == "reception.notifications" ? 'text-white' : '' }} menu-title">Notificações</span>
                <i class=" {{ Route::current()->getName() == "reception.notifications" ? 'text-white' : '' }} mdi mdi-bell-outline menu-icon"></i>
            </a>
          </li>



        </ul>
      </nav>





    </div>

</x-layout.app>

