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
    
          <li class="nav-item {{Route::current()->getName() == "kitchen.index" ? "bg-primary  rounded" : ""}}">
            <a  class=" nav-link" href="{{ route("kitchen.index") }}">
              <span class="{{ Route::current()->getName() == "kitchen.index" ? 'text-white' : '' }} menu-title">Dashboard</span>
              <i class="{{ Route::current()->getName() == "kitchen.index" ? 'text-white' : '' }} fa fa-solid fa-home menu-icon"></i>
            </a>
          </li>
    
          <li class="nav-item {{ Route::current()->getName() == "kitchen.request.items" ? "bg-primary  rounded" : "" }} ">
            <a class=" nav-link" href="{{ route('kitchen.request.items') }}">
              <span class="{{ Route::current()->getName() == "kitchen.request.items" ? 'text-white' : '' }} menu-title">Solicitar itens</span>
                <i class="{{ Route::current()->getName() == "kitchen.request.items" ? 'text-white' : '' }} fa solid fa-pen-to-square menu-icon"></i>         
              </a>
          </li>  
          
          <li class="nav-item {{ Route::current()->getName() == "kitchen.dishes" ? "bg-primary  rounded" : "" }} ">
            <a class="nav-link" href="{{ route('kitchen.dishes') }}">
              <span class="{{ Route::current()->getName() == "kitchen.dishes" ? 'text-white' : '' }} menu-title">Pratos</span>
                <i class="{{ Route::current()->getName() == "kitchen.dishes" ? 'text-white' : '' }} fa solid fa-utensils menu-icon"></i>         
              </a>
          </li>  
          <li class="nav-item {{ Route::current()->getName() == "kitchen.drinks" ? "bg-primary  rounded" : "" }} ">
            <a class=" nav-link" href="{{ route('kitchen.drinks') }}">
              <span class="{{ Route::current()->getName() == "kitchen.drinks" ? 'text-white' : '' }} menu-title">Bebidas</span>   
                <i class="{{ Route::current()->getName() == "kitchen.drinks" ? 'text-white' : '' }} fa solid fa-champagne-glasses menu-icon"></i>         
              </a>
          </li>

          <li class="nav-item {{ Route::current()->getName() == "kitchen.orders" ? "bg-primary  rounded" : "" }} ">
            <a class=" nav-link" href="{{ route('kitchen.orders') }}">
              <span class="{{ Route::current()->getName() == "kitchen.orders" ? 'text-white' : '' }} menu-title">Pedidos pendentes</span>   
              <i class="{{ Route::current()->getName() == "kitchen.orders" ? 'text-white' : '' }} fa solid fa-hand menu-icon"></i>         
            </a>
          </li>

          <li class="nav-item {{ Route::current()->getName() == "kitchen.history.orders" ? "bg-primary  rounded" : "" }} ">
            <a class=" nav-link" href="{{route('kitchen.history.orders')}}">
              <span class="{{ Route::current()->getName() == "kitchen.history.orders" ? 'text-white' : '' }} menu-title">Histórico de pedidos </span>   
              <i class="{{ Route::current()->getName() == "kitchen.history.orders" ? 'text-white' : '' }} fa solid fa-trash-can-arrow-up menu-icon"></i>         
            </a>
          </li>

        </ul>
      </nav>
    
    </div>
   

</x-layout.app>