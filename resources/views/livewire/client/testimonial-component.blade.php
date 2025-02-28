<main id="main" class="main">
    <x-client.modal-add-testimonial :allAvailableHotelsInAngola=$allAvailableHotelsInAngola />
    <x-client.modal-edit-testimonial  />

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
                      <h5 class="card-title text-uppercase">Meus Depoimentos</h5>
                      <div>

                      </div>
                      <div class="d-flex gap-2 mb-2">
                         <button
                         data-bs-target='#form-add-testimonial'
                         data-bs-toggle='modal'
                         class='btn btn-primary d-flex align-items-center'>
                            <i class="bi bi-plus-lg"></i>
                            Adicionar
                         </button>
                          <input wire:model.live='searcher' class="form-control w-100" type="text" placeholder="Pesquisar" />
                          <input wire:model.live='startdate' type="date" class='form-control' />
                          <input wire:model.live='enddate' type="date" class='form-control' />
                     </div>

                     <div class="table-responsive">
                        <table class="table table-striped table-borderless table-hover rounded">
                          <thead class=''>
                            <tr>
                              <th scope="col">Depoimento</th>
                              <th scope="col">Hotel</th>
                              <th scope="col">Estrelas</th>
                              <th scope="col">Visibilidade</th>
                              <th scope="col">Opções</th>
                            </tr>
                          </thead>

                          <tbody>
                          @if (isset($testimonials) and $testimonials->count() > 0)
                           @foreach ($testimonials as $data)
                              <tr>
                                  <td>{{ $data->text }}</td>
                                  <td>{{ $data->hotel->companyname }}</td>
                                  <td>
                                      @if (isset($data->star_quantity))
                                      <div class='d-flex align-items-center'>
                                          @for ($i=1; $i <= $data->star_quantity; $i++)
                                              <i class='bi bi-star-fill text-warning'></i>
                                          @endfor
                                      </div>
                                      @else
                                      <strong>Não atribuído.</strong>
                                      @endif
                                  </td>
                                  <td>
                                      @if ($data->visibility == 'public')
                                      <span >Público</span>
                                      @else
                                      <span>Privado</span>
                                      @endif
                                  </td>
                                  <td>
                                      <div class='d-flex align-items-center gap-1'>
                                              <button wire:click='editTestimonial({{ $data->id }})' data-bs-target='#form-edit-testimonial' data-bs-toggle='modal' class='btn btn-primary btn-sm d-flex gap-1 align-items-center'>
                                                  <i class="bi bi-pencil-square"></i>
                                                  <span>Editar</span>
                                              </button>
                                              <button  wire:click='deleteTestimonial({{ $data->id }})'
                                                  class='btn btn-danger btn-sm gap-1 d-flex align-items-center'>
                                                  <span>Eliminar</span>
                                                  <i class="bi bi-trash3"></i>
                                              </button>
                                  </div>
                                  </td>
                              </tr>
                          @endforeach
                          @else
                          <td colspan='10'>
                              <div class='alert alert-warning text-center'> <span>Nenhum resultado encontrado.</span> </div>
                          </td>
                          @endif
                          </tbody>
                        </table>
                        <div class='my-2'>{{isset($testimonials) ? $testimonials->links("pagination::simple-tailwind") : ''}}</div>
                       </div>
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
