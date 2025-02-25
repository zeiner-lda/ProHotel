

<div class="container-fluid bg-dark px-0 fixed-top">

    <style>
        @media (max-width: 992px) {
            #dropdownItems{
               display:block !important;
               background-color: #ccc !important;
            }
        }
    </style>


    <div class="row gx-0">
        <div class="col-lg-3 bg-dark d-none d-lg-block">
            <a href="{{ route('site.index') }}" class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
                <h1 class="m-0 text-primary text-uppercase">ProHotel</h1>
            </a>
        </div>
        <div class="col-lg-9">

            <nav class="navbar navbar-expand-lg bg-dark navbar-dark p-3 p-lg-0">
                <a href="{{ route('site.index') }}" class="navbar-brand d-block d-lg-none">
                    <h1 class="m-0 text-primary text-uppercase">ProHotel</h1>
                </a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="/" class="nav-item nav-link active">Home</a>
                        <a href="#quartos" class="{{Route::currentRouteName() == 'prohotel.hotel.informations' ? 'd-block' : 'd-none'}} nav-item nav-link">Quartos</a>
                        <a href="#menu" class="{{Route::currentRouteName() == 'prohotel.hotel.informations' ? 'd-block' : 'd-none'}} nav-item nav-link">Menu</a>
                         <a href="#servicos" class="{{Route::currentRouteName() == 'prohotel.hotel.informations' ? 'd-block' : 'd-none'}} nav-item nav-link">Serviços</a>
                        <a href="#contactos" class="nav-item nav-link">Contactos</a>
                        @guest
                        <a href="{{ route('login') }}" class="nav-item nav-link">Login</a>
                        @endguest

                        @auth


                            <div class="nav-item dropdown">

                                <div class='d-flex gap-1 align-items-center'>
                                    @if (auth()->user()->profile == 'guest')
                                    <a data-bs-toggle="dropdown" class="nav-link dropdown-toggle">
                                        <i class='fa fa-user text-white'></i>
                                       <span>{{ auth()->user()->personaldata->firstname.' '.auth()->user()->personaldata->lastname ?? '' }}</span>
                                    </a>
                                    @else
                                    <a data-bs-toggle="dropdown"  class="nav-link dropdown-toggle">
                                        <i class='fa fa-user text-white'></i>
                                        <span>{{ auth()->user()->username ?? '' }}</span>
                                    </a>
                                    @endif
                                </div>

                                <ul id='dropdownItems' class="dropdown-menu rounded-0 m-0">
                                    <li>
                                        <a  href="{{ route('prohotel.client.panel.dashboard') }}" class="dropdown-item {{ auth()->user()->profile != 'guest' ? 'd-none' : 'd-block' }}">Meu painel</a>
                                    </li>
                                    
                                    <li>
                                        <a wire:click="logout" class="dropdown-item">Terminar sessão</a>
                                    </li>

                                </ul>
                            </div>



                        @endauth



                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>

