

    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <a class="navbar-brand brand-logo-mini"><img src="{{ asset('/dashboard/assets/images/logo-mini.svg') }}" alt="logo" /></a>
        <h5 class='navbar-brand brand-logo text-primary'>PROHOTEL</h5>
        {{-- <a class="navbar-brand brand-logo"><img src="{{ asset('/dashboard/assets/images/logo.svg') }}" alt="logo" /></a> --}}
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <div class="search-field d-none d-md-block">
            <form class="d-flex align-items-center h-100" action="#">
            <div class="input-group">
                <div class="input-group-prepend bg-transparent">
                <i class="input-group-text border-0 mdi mdi-magnify"></i>
                </div>
                <input type="text" class="form-control bg-transparent border-0" placeholder="Search projects">
            </div>
            </form>
        </div>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="nav-profile-img">
                <img src="{{ asset('/dashboard/assets/images/faces/face1.jpg') }}" alt="image">
                <span class="availability-status online"></span>
                </div>
                <div class="nav-profile-text">
                <p class="mb-1 text-black">{{  isset(auth()->user()->username) ?  auth()->user()->username : ''}}</p>
                </div>
            </a>
            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                <a href='{{ route('admin.profile') }}' class="dropdown-item">
                <i class="fa fa-solid fa-user me-2 text-success"></i>Meu perfil
                </a>
                <div class="dropdown-divider"></div>
                <a wire:click='logout' class="dropdown-item" >
                <i class="mdi mdi-logout me-2 text-primary"></i> Terminar sessão
                </a>

            </div>
            </li>

        <!-- Notifications-->
        @if (auth()->user()->profile == "reception")
        <li class="nav-item dropdown">
            <button wire:click.live='changeStatusAboutSeenNotifications' data-bs-toggle="dropdown"  class="btn btn-primary btn-sm position-relative">
                <i class="mdi mdi-bell-outline"></i>
                <span class="position-absolute top-0
                 start-100 translate-middle badge
                  rounded-pill bg-danger">
                  {{isset($notificationsCounter) ? $notificationsCounter : 0 }}
                </span>
            </button>

            <div wire:ignore.self class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <div class='d-flex align-items-center '>
                  <h6 class="p-3 mb-0">Notificações</h6>
                      <span class='badge text-bg-secondary'>{{isset($notificationsCounter) ? $notificationsCounter : 0 }}</span>
              </div>

                <div class="dropdown-divider"></div>
                @if (isset($allreservedNotifications) && $allreservedNotifications->count() > 0)
                    @foreach($allreservedNotifications as $notification)
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-dark">
                                    <i class="mdi mdi-bell-outline"></i>
                                </div>
                            </div>
                            <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                                <h6 class="preview-subject font-weight-normal mb-1">{{$notification->notification_title}}</h6>
                                <div class="text-gray   mb-0">
                                    {{$notification->notification}}
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                <div class='d-flex align-items-center justify-content-center'>
                    <i class="fa fa-2x fa-bell-slash"></i>
                </div>
                @endif
                <div class="dropdown-divider"></div>
                <a href='{{route('reception.notifications')}}'>
                    <h6 class="p-3 mb-0 text-center">Ver todas as notificações</h6>
                </a>
            </div>
        </li>

        @elseif(auth()->user()->profile == "kitchen_manager")

        <li class="nav-item dropdown">
            <button wire:click.live='changeStatusAboutSeenNotificationsOfOrders' data-bs-toggle="dropdown"  class="btn btn-primary btn-sm position-relative">
                <i class="mdi mdi-bell-outline"></i>
                <span class="position-absolute top-0
                 start-100 translate-middle badge
                  rounded-pill bg-danger">
                  {{isset($orderNotificationCounter) ? $orderNotificationCounter : 0 }}
                </span>
            </button>

            <div wire:ignore.self class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <div class='d-flex align-items-center '>
                  <h6 class="p-3 mb-0">Notificações</h6>
                      <span class='badge text-bg-secondary'>{{isset($orderNotificationCounter) ? $orderNotificationCounter : 0 }}</span>
              </div>

                <div class="dropdown-divider"></div>
                @if (isset($allOrderClientNotifications) && $allOrderClientNotifications->count() > 0)
                    @foreach($allOrderClientNotifications as $orderNotification)
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-dark">
                                    <i class="mdi mdi-bell-outline"></i>
                                </div>
                            </div>
                            <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                                <h6 class="preview-subject font-weight-normal mb-1">{{$orderNotification->notification_title}}</h6>
                                <div class="text-gray   mb-0">
                                    {{$orderNotification->notification}}
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                <div class='d-flex align-items-center justify-content-center'>
                    <i class="fa fa-2x fa-bell-slash"></i>
                </div>
                @endif
                <div class="dropdown-divider"></div>
                {{-- <a href='{{route('reception.notifications')}}'>
                    <h6 class="p-3 mb-0 text-center">Ver todas as notificações</h6>
                </a> --}}
            </div>
        </li>

        @endif

        <li class="nav-item nav-settings d-none d-lg-block">
            <a class="nav-link" href="#">
                <i class="mdi mdi-format-line-spacing"></i>
            </a>
        </li>

        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
        </div>
    </nav>


