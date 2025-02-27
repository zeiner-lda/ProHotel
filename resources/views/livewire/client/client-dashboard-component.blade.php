<main id="main" class="main">


        <style>
            .stars:hover
             {
                color: #FEA116 !important;
                cursor: pointer !important;
            }

        </style>



        <div class="pagetitle mb-3">
            <h6 class='text-uppercase'>Dashboard</h6>
        </div>


        <section class="section dashboard">
          <div class="col-lg-12">
            <div class="row">
                <div class="col-xxl-6 col-md-6">
                  <div class="card info-card sales-card">

                    <div class="filter">
                      <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>

                    </div>

                    <div class="card-body">
                      <h5 class="card-title">Meus Pedidos</h5>

                      <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                          <i class="fa fa-solid  fa-utensils"></i>
                        </div>
                        <div class="ps-3">
                          <h6>0</h6>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>

                <div class="col-xxl-6 col-md-6">
                  <div class="card info-card sales-card">

                    <div class="filter">
                      <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>

                    </div>

                    <div class="card-body">
                      <h5 class="card-title ">Meus Depoimentos </h5>

                      <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                          <i class="bi bi-megaphone"></i>
                        </div>
                        <div class="ps-3">
                          <h6>{{ isset($testimonialCounter) ? $testimonialCounter : 0 }}</h6>

                        </div>
                      </div>
                    </div>

                  </div>
                </div>

            </div>
          </div>

            <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-12">
              <div class="row">

                  <!-- Testimonials -->
                <div class="col-12">
                  <div class="card recent-sales overflow-auto">

                    <div class="filter">
                      <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>

                    </div>

                    <div class="card-body">
                      <h5 class="card-title text-uppercase">Pedidos Solicitados</h5>
                      <div>

                      </div>
                      <div class="d-flex gap-2 mb-2">
                          <input wire:model.live='searcher' class="form-control w-100" type="text" placeholder="Pesquisar" />
                          <input wire:model.live='startdate' type="date" class='form-control' />
                          <input wire:model.live='enddate' type="date" class='form-control' />
                     </div>

                     <div class='table-responsive'>
                      <table  class="table table-striped table-borderless table-hover rounded">
                          <thead class=''>
                            <tr>
                              <th scope="col">Item</th>
                              <th scope="col">Hotel</th>
                              <th scope="col">Preço</th>
                              <th scope="col">Status</th>
                            </tr>
                          </thead>

                          <tbody>
                            @if (isset($orders) and $orders->count() > 0)
                            @foreach($orders as $order)
                            <tr>
                              <td>{{$order->order_name}}</td>
                              <td>{{$order->hotel->companyname}}</td>
                              <td>{{number_format($order->order_price, 2, ',', ',') ?? 0}}</td>
                              <td>
                                @if ($order->order_status == 'pending')
                                <span class='text-uppercase text-danger fw-bold'>Pendente</span>
                                @elseif ($order->order_status == 'in_preparation')
                                <span class='text-uppercase text-primary fw-bold'>Em Preparação</span>
                                @elseif ($order->order_status == 'finished')
                                <span class='text-success text-uppercase fw-bold'>Finalizado</span>
                                @endif
                              </td>
                            </tr>
                            @endforeach
                            @else
                            <td colspan='12'>
                              <div class='alert alert-warning text-center'>Nenhum resultado encontrado!</div>
                            </td>
                            @endif
                          </tbody>
                      </table>
                     </div>

                  </div>
                </div>
                <!-- End Testimonials -->


              </div>
            </div><!-- End Left side columns -->



          </div>
        </section>

      </main>
      <!-- End #main -->
