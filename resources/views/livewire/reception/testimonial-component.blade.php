
<div>
    @section("title" , "Depoimentos")
        <div class="container-scroller">

         <livewire:admin.top-bar-component />
          <div class="container-fluid page-body-wrapper">

            <x-reception.side-bar />

            <div class="main-panel">
              <div class="content-wrapper">

                <div class="container-fluid">

                     <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title text-muted text-uppercase">Depoimentos</h5>
                        </p>

                        <div class="col-md-12 d-flex align-items-center gap-2">
                          <input wire:model.live="searcher" placeholder='Pesquisar' class='form-control' />
                          <input title='Data inicial' type='date' wire:model.live="startdate"  class='form-control' />
                          <input  title='Data final' type='date' wire:model.live="enddate" class='form-control' />
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                              <thead>
                                <tr>
                                  <th>Data de depoimento</th>
                                  <th>Depoimento</th>
                                  <th>Estrelas</th>
                                  <th>Cliente</th>
                                  <th>Hotel</th>
                                  <th>Visibilidade</th>
                                  <th class="text-center">Opções</th>
                                </tr>
                              </thead>
                              <tbody>
                                @if (isset($data) and $data->count() > 0)
                                @foreach ($data as $testimonial)
                                    <tr>
                                       <td>{{ $testimonial->created_at }}</td>
                                       <td>{{ $testimonial->text }}</td>

                                        <td>
                                            <div class='d-flex align-items-center'>
                                                {{ $testimonial->testimonial_number }}
                                                @for ($i = 1; $i <= $testimonial->star_quantity; $i++)
                                                    <i class="fa fa-star fa-1 text-dark "></i>
                                                @endfor

                                            </div>
                                        </td>
                                        <td>{{ $testimonial->user->personaldata->firstname ?? ''.' '.$testimonial->user->personaldata->lastname ?? '' }}</td>
                                      <td>{{ $testimonial->hotel->companyname ?? ''}}</td>
                                        <td>
                                          @if ($testimonial->visibility == 'public')
                                          <span>Público</span>
                                          @else
                                          <span>Privado</span>
                                          @endif
                                        </td>
                                        <td>
                                          <div class="d-flex align-items-center justify-content-center gap-1">
                                              <button wire:click='changeVisibilityOfStatus({{ $testimonial->testimonialId }})' class='btn btn-sm {{ $testimonial->visibility == 'public' ? 'btn-info' : 'btn-dark' }} '>
                                              <i class='fa fa-solid {{ $testimonial->visibility == 'public' ? 'fa-eye' : 'fa-eye-slash' }}'></i>
                                              <span>{{ $testimonial->visibility == 'public' ? 'Público' : 'Privado' }}</span>
                                              </button>
                                              <button wire:click='delete({{ $testimonial->testimonialId }})' class='btn btn-sm btn-danger'>
                                                <span>Eliminar</span>  
                                                <i class='fa fa-solid fa-trash-alt'></i>
                                            </button>
                                          </div>

                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                  <tr>
                                      <td colspan="10">
                                              <div class='alert alert-warning text-center'>Nenhum resultado encontrado!</div>
                                      </td>
                                  </tr>
                                @endif

                              </tbody>
                            </table>
                        </div>
                        <div class='d-flex'>
                          <span class='my-3'>{{isset($data) ? $data->links('pagination::bootstrap-4') : ''}}</span>
                         </div>

                      </div>
                    </div>
                  </div>

                </div>




            <footer class="footer">
             <div class="d-sm-flex justify-content-center ">
             <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2024 - {{ date('Y') }} <a href="#" target="_blank">ZEINER, LDA</a>. Todos os direitos reservados.</span>
              </div>
            </footer>

              </div>

    </div>
