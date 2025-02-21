<div >
    <x-site.modal-see-client-orders :orderedItems="$orderedItems" />
    <div  class="row">
        <div  class='section'>
            <div class='container text-center'>
                <h5 id='menu' class='text-uppercase'>Menu do Hotel<h5>

                <div class="d-flex gap-1 justify-content-center align-items-center">

                    <button {{-- wire:click='buttonGetAllDrinksAndDishesFromCurrentHotel' --}}
                        class='btn btn-sm {{$menuHotelDishesAndDrinksStatus ? 'btn-dark' : 'btn-primary'}} '>
                        <i class="fa fa-solid fa-cookie-bite"></i>
                        <span>Todos</span>
                    </button>

                    <button {{-- wire:click='buttonGetDishesFromHotel' --}}
                     class='btn btn-sm {{$menuHotelDishesStatus ? 'btn-dark' : 'btn-primary'}}'>
                        <i class='fa fa solid fa-utensils menu-icon'></i>
                        <span>Pratos</span>
                    </button>

                    <buttone {{-- wire:click='buttonGetDrinksFromHotel' --}} class='btn btn-sm {{$menuHotelDrinksStatus ? 'btn-dark' : 'btn-primary'}} '>
                        <i class='fa fa solid fa-champagne-glasses'></i>
                        <span>Bebidas</span>
                    </button>

                </div>
            </div>

            <div class="col-md-12 d-flex flex-wrap justify-content-center my-4 gap-2 align-items-center">
               @if (isset($drinksAndDishes) && $drinksAndDishes->count() > 0)
                @foreach ($drinksAndDishes as $item)
                <div style="width: 15rem important!; height:20rem;" class=" card text-center mb-2 col-md-2">
                    <div class="card-body">
                        <div class='mb-3'>
                            <img style='width: 150px !important;' class='img-fluid' src='{{url('/storage/img/'.$item->photo)}}' />
                        </div>

                        <div class='position-relative d-flex flex-column align-items-center'>
                            <div>
                                <h6 class="text-uppercase fw-bold">{{$item->name}}</h6>
                                <span class="fw-bold text-danger">{{number_format($item->price, 2, ',', ',') ?? 0}} Kz</span>
                            </div>

                            <div class='position-absolute top-50 mt-5 d-flex gap-1 align-items-center '>
                               @if (auth()->check())
                                    <button wire:click='orderItem({{$item->id}})'
                                        title='Pedir item' class='d-flex align-items-center gap-1 btn  btn-sm btn-dark'>
                                        Pedir
                                        {{-- <i class="fa fa-solid fa-heart"></i> --}}
                                    </button>
                               @else
                                    <button wire:click='login'
                                        title='Pedir item' class='d-flex align-items-center gap-1 btn  btn-sm btn-dark'>
                                        Pedir
                                        {{-- <i class="fa fa-solid fa-heart"></i> --}}
                                    </button>
                               @endif

                                 <button data-bs-target='#ordered-items' data-bs-toggle='modal' title='Ver itens pedidos' class='btn btn-sm btn-dark d-flex align-items-center gap-1'>
                                    Consultar
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
                @endforeach
                @else
                <div class='col-md-10 alert alert-warning text-center'>Nenhum resultado encontrado!</div>
                @endif
            </div>
        </div>

    </div>
</div>
