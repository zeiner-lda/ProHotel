
<div>
    @section("title" , "Hóspedes")
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
                        <h5 class="card-title text-muted text-uppercase">Hóspedes</h5>
                        </p>

                        <div class="col-md-12 d-flex align-items-center gap-2">
                          <input type='text' wire:model.live="searcher" placeholder='Pesquisar' class='form-control' />
                          <input title='Data inicial' type='date' wire:model.live="startdate"  class='form-control' />
                          <input  title='Data final' type='date' wire:model.live="enddate" class='form-control' />
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                              <thead>
                                <tr>
                                  <th>Data de registo</th>
                                  <th>Quarto</th>                                 
                                  <th>Quantidade dias</th>                                 
                                  <th>Cliente</th>
                                  <th>Número do BI</th>
                                  <th>Telefone</th>
                                  <th>Morada</th>
                                  <th class='text-center'>Status</th>                                  
                                  <th class="text-center">Opções</th>
                                </tr>
                              </thead>
                              <tbody>
                                @if (isset($guests) and count($guests) > 0)
                                @foreach ($guests as $guest)
                                    <tr>
                                       <td>{{ $guest->created_at }}</td>
                                       <td>{{ $guest->reservation->room->room_number }}</td>
                                        <td class='text-center'>{{ $guest->quantity_days }}</td>                                       
                                         <td>{{ $guest->reservation->guest->firstname.' '.$guest->lastname ?? 'N/D' }}</td>
                                        <td>{{ $guest->binumber ?? 'N/D' }}</td>
                                        <td>{{ $guest->reservation->guest->phone ?? 'N/D' }}</td>
                                        <td>{{ $guest->address ?? 'N/D' }}</td>
                                        <td>
                                            <span class='badge badge-success'>{{ $guest->reservation->reservation_status  }}</span>
                                        </td>                                  
                                      
                                        <td>                                     
                                            <button class='btn btn-sm btn-danger'>
                                                <span>Eliminar</span>
                                                <i class='fa fa-solid fa-trash-alt'></i>
                                            </button>
                                          </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                  <tr>
                                      <td colspan="12">
                                              <div class='alert alert-warning text-center'>Nenhum resultado encontrado!</div>
                                      </td>
                                  </tr>
                                @endif

                              </tbody>
                            </table>
                        </div>
                          <div class='d-flex'>
                              <span wire:ignore class='my-3'>{{isset($guests) ? $guests->links('pagination::bootstrap-4') : ''}}</span>
                          </div>

                      </div>
                    </div>
                  </div>

                </div>

                <x-admin.footer />

              </div>
    </div>
