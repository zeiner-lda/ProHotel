<div wire:ignore.self  style='margin-bottom:10rem;' id="servicos" class="container-xxl py-5">
    <div class="container-xxl ">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title text-center text-primary text-uppercase">Serviços</h6>
            <h1 class="mb-5">Serviços <span class="text-primary">Disponíveis</span></h1>
        </div>

        <div class="mt-2 mb-4  ">
            <div class="input-group mb-3">
                <input wire:model.live='searchService' type="text" class="form-control p-2" placeholder="Pesquisar serviço"  />
                <span class="input-group-text" id="basic-addon1">
                    <i class='fa fa-solid fa-search'></i>
                </span>
            </div>
        </div>

        <div class="row g-4">
            @if (isset($services) and count($services) > 0)
            @foreach($services as $service)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="position-relative">
                            <small class="position-absolute start-0 top-100 translate-middle-y bg-primary text-white rounded text-uppercase fw-bold py-1 px-3 ms-4">{{ number_format($service->price, 2, ',', ',') }} Kz</small>
                        </div>
                        <a class="service-item rounded" href="">
                            <div class="service-icon bg-transparent border rounded p-1">
                                <div class="w-100 h-100 border rounded d-flex align-items-center justify-content-center">
                                    <i class="fa fa-store fa-solid fa-2x text-primary"></i>
                                </div>
                            </div>
                            <h5 class="mb-3">{{ $service->servicename }}</h5>
                            <p class="text-body mb-0">{{ $service->description }}</p>
                        </a>
                    </div>
              @endforeach
              @else
              <div style='margin-bottom: 5rem !important;' class='w-100 alert alert-warning container text-center'>
                  <span>Nenhum registo encontrado!</span>
              </div>
            @endif


        </div>
    </div>
</div>
