<div wire:ignore.self >
    <x-site.modal-make-reservation />
        <!-- Room Start -->

        <style>
            @media (max-width: 730px) {
                #rooms-div {
                  display:flex;
                  flex-direction: column;
                }

                .col-xl-3 {
                    width: 100% !important;
                }

    }
        </style>
        <div  id="quartos" class="col-md-12 py-5">
            <div class="container-fluid">
                <div class="text-center " >
                    <h6 class="section-title text-center text-primary text-uppercase">Quartos</h6>
                    <h1 class="mb-5">Quartos <span class="text-primary">Disponíveis</span></h1>
                </div>

                <div class="mt-2 mb-4">
                    <div>
                        <select wire:model.live='searcher' class='form-select'>
                            <option value=''>Selecionar</option>
                            <option value='single'>Solteiro</option>
                            <option value='double'>Casal</option>
                            <option value='suite'>Suite</option>
                        </select>

                      </div>
                </div>

                <div id='rooms-div' class="col-xl-12 d-flex  justify-content-center flex-wrap  align-items-start gap-2" >
                   @if (isset($allrooms) and count($allrooms) > 0)
                   @foreach($allrooms as $room)
                    <div  class="col-xl-3 rounded">
                        <div  id='rooms-div' class="room-item shadow rounded overflow-hidden">
                            <div class="position-relative">
                                <img  style="height: 180px !important; border-radius: 10px !important;"  class="img-fluid w-100" src="{{ asset('/storage/img/'.$room->photo) }}" alt="" />
                                <small class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded text-uppercase fw-bold py-1 px-3 ms-4">{{ number_format($room->price_pernight, 2, ',', ',') }} Kz/Noite</small>
                            </div>
                            <div class="p-4 mt-2">
                                <div class="d-flex justify-content-between mb-3">
                                    @if ($room->room_type == 'single')
                                    <h5 class="mb-0 text-capitalize">Solteiro</h5>
                                    @elseif ($room->room_type == 'double')
                                    <h5 class="mb-0 text-capitalize">Casal</h5>
                                    @elseif ($room->room_type == 'suite')
                                    <h5 class="mb-0 text-capitalize">Suite</h5>
                                    @endif
                                    <div class="ps-2">
                                        <small class="fa fa-star text-primary"></small>
                                        <small class="fa fa-star text-primary"></small>
                                        <small class="fa fa-star text-primary"></small>
                                        <small class="fa fa-star text-primary"></small>
                                        <small class="fa fa-star text-primary"></small>
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <small class="border-end me-3 pe-3"><i class="fa fa-bed text-primary me-2"></i>{{ $room->bed_quantity }} {{ $room->bed_quantity > 1 ? 'Camas' : 'Cama' }}</small>
                                    <small class="border-end me-3 pe-3"><i class="fa fa-bath text-primary me-2"></i>{{ $room->bath_quantity }} {{ $room->bath_quantity > 1 ? 'Banheiros' : 'Banheiro' }}</small>
                                    <small><i class="fa fa-wifi text-primary me-2"></i>Wifi</small>
                                </div>
                                <h6>Quarto Nº: {{ $room->room_number }}</h6>
                                @if ($room->status == 'available')
                                <h6 class="fw-bold text-success">Status: Disponível</h6>
                                @elseif ($room->status == 'occupied')
                                <h6 class="fw-bold text-danger">Status: Reservado</h6>
                                @endif

                                <div>
                                        <p class="text-body mb-3">{{ $room->description }}</p>
                                        <div class="d-flex justify-content-between">

                                            @if (!auth()->check())
                                                <button
                                                    wire:click='signIn'
                                                    class="btn  btn-sm btn-dark rounded py-2 px-4"
                                                    style='width:100% !important; border-radius: 10px !important;'
                                                    {{auth()->check() ? "data-bs-target=#make-reservation data-bs-toggle=modal" : ''}} >
                                                    Reservar
                                                </button>
                                            @else
                                                <button
                                                    wire:click='bookingRoom({{$room->id}})'
                                                    class=" btn  btn-sm btn-dark rounded py-2 px-4"
                                                    style='width:100% !important; border-radius: 10px !important;'
                                                    {{auth()->check() ? "data-bs-target=#make-reservation data-bs-toggle=modal" : ''}} >
                                                    Reservar
                                                </button>
                                            @endif


                                        </div>
                                </div>
                        </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                        <div class='w-100 alert alert-warning text-center'><span>Nenhum registo encontrado!</span> </div>
                  @endif
                </div>
                <div class='my-2'> {{ isset($allrooms) ? $allrooms->links("pagination::bootstrap-4") : '' }}</div>
                </div>

        </div>

         </div>
</div>
