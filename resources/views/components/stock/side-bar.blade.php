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

          <li class="nav-item {{Route::current()->getName() == "stock.management.index" ? "bg-primary  rounded" : ""}}">
            <a  class=" nav-link" href="{{ route("stock.management.index") }}">
              <span class="{{ Route::current()->getName() == "stock.management.index" ? 'text-white' : '' }} menu-title">Dashboard</span>
              <i class="{{ Route::current()->getName() == "stock.management.index" ? 'text-white' : '' }} mdi mdi-home menu-icon"></i>
            </a>
          </li>

          <li class="nav-item {{Route::current()->getName() == "stock.management.stockroom" ? "bg-primary  rounded" : ""}} ">
            <a class=" nav-link" href="{{ route('stock.management.stockroom') }}">
              <span class="{{ Route::current()->getName() == "stock.management.stockroom" ? 'text-white' : '' }} menu-title">Economato</span>
                <i class="{{ Route::current()->getName() == "stock.management.stockroom" ? 'text-white' : '' }} fa fa-box-open menu-icon"></i>
              </a>
          </li>


           <li class="nav-item {{ Route::current()->getName() == "stock.management.categories" ? "bg-primary rounded" : "" }}">
            <a class=" nav-link" href="{{ route("stock.management.categories") }}">
              <span class=" {{ Route::current()->getName() == "stock.management.categories" ? 'text-white' : '' }} menu-title">Categorias</span>
            <i class=" {{ Route::current()->getName() == "stock.management.categories" ? 'text-white' : '' }} mdi mdi-format-list-bulleted menu-icon"></i>
              </a>
          </li>

          <li class="nav-item {{ Route::current()->getName() == "stock.management.products" ? "bg-primary rounded" : "" }}">
            <a class=" nav-link" href="{{ route('stock.management.products') }}">
              <span class=" {{ Route::current()->getName() == "stock.management.products" ? 'text-white' : '' }} menu-title">Produtos</span>
                <i class="bi bi-clipboard-minus {{ Route::current()->getName() == "stock.management.products" ? 'text-white' : '' }}  menu-icon"></i>
            </a>
          </li>


        </ul>
      </nav>

    </div>

</x-layout.app>
