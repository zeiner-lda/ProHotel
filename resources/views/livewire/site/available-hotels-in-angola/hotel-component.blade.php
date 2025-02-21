<div style="margin-bottom: 6.5rem!important;">

    <div class="container-xxl py-5 ">
            <!-- Estilizar os cards dos hoteis disponiveis -->
            <style>
                #card-hotels{
                    border-radius: 15px !important;
                }

                .card-img-top{
                    width: 100% !important;
                    height: 10rem !important;
                    border-radius: 15px !important;
                }
                </style>

                <div class="container">
                    <div class="row g-5 align-items-center">
                        <div class="col-lg-12">
                            <h6 class="section-title text-start text-primary text-uppercase">Sobre nós</h6>
                            <h1 class="mb-4">Seja bem vindo ao <span class="text-primary text-uppercase">ProHotel</span></h1>
                            <h6 class="mb-4 fw-bold"> A excelência é nossa prioridade</h6>

                            <div>
                                <div class='text-center'>
                                    <h4>Hoteis Disponíveis em <span class='text-primary'>Angola</span></h4>
                                    <div class="d-flex container  gap-1 flex-wrap justify-content-center align-items-center mb-2">

                                        <button wire:click='getAllHotels' class='btn btn-sm {{isset($filterButtonAllHotels) && $filterButtonAllHotels  ? 'btn-dark' : 'btn-primary'}}  text-capitalize'>
                                            <i class="fa fa-solid fa-hotel"></i>
                                            Todos
                                        </button>

                                        <button wire:click='getMostRequestedHotels' class='btn btn-sm {{isset($filterButtonMostRequestHotels) && $filterButtonMostRequestHotels ? 'btn-dark' : 'btn-primary'}}  text-capitalize'>
                                            <i class="fa fa-solid fa-location-dot"></i>
                                            mais solicitados
                                        </button>

                                        <button wire:click='getMostClassifiedHotels' class='btn btn-sm {{isset($filterButtonMostClassifiedHotels) && $filterButtonMostClassifiedHotels ? 'btn-dark' : 'btn-primary'}}  text-capitalize'>
                                            <small class="fa fa-solid fa-star"></small>
                                            mais classificados
                                        </button>
                                    </div>

                                </div>

                                <!-- Filtro de hoteis -->
                                <div class="col-md-12 container mb-3">
                                    <div class="">
                                        <div class="input-group mb-3">
                                            <input wire:model.live='searcher' type="text" class="form-control p-2" placeholder="Pesquisar hotel"  />
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class='fa fa-solid fa-search'></i>
                                            </span>
                                          </div>
                                    </div>


                                </div>
                                <!-- Lista de hoteis -->
                                <div class='d-flex justify-content-center col-md-12 flex-wrap align-items-center gap-3'>
                                    @if (isset($availablehotels) and count($availablehotels) > 0)
                                        @foreach ($availablehotels as $hotel)
                                            <a href='{{ route('prohotel.hotel.informations',$hotel->id ? $hotel->id : $hotel->$hotel->id) }}'>
                                                <div id='card-hotels' class="card rounded" style="width: 15rem;">
                                                        @if (isset($hotel->company_cover_photo))
                                                        <img src="{{url('/storage/img/' .$hotel->company_cover_photo)}}" class="card-img-top" alt="...">
                                                        @else
                                                        <img src="{{url('/storage/img/' .$hotel->hotel->company_cover_photo)}}" class="card-img-top" alt="...">
                                                        @endif
                                                        <div class="card-body">
                                                        <div class='d-flex flex-wrap'>
                                                            <h6 class="card-title"> {{$hotel->companyname ? $hotel->companyname : $hotel->hotel->companyname}}</h6>
                                                        </div>

                                                        <div class="d-flex gap-3">
                                                            <div>
                                                                <span>
                                                                    <i class="fa fa-solid fa-location-dot"></i> <span>{{$hotel->province ? $hotel->province : $hotel->hotel->province}}, {{$hotel->country ? $hotel->country : $hotel->hotel->country }}</span>
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <small class="fa fa-star text-primary"></small>
                                                                <small class="fa fa-star text-primary"></small>
                                                            </div>
                                                        </div>


                                                        </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    @else
                                        <div class="col-md-10 alert alert-warning text-center">Nenhum resultado encontrado!</div>
                                    @endif

                                </div>
                                <div class='d-flex justify-content-center container'>
                                    <span class='my-3'>{{isset($availablehotels) ? $availablehotels->links('pagination::bootstrap-4') : ''}}</span>
                                </div>

                            </div>

                        </div>


                    </div>
                </div>
    </div>
    </div>
