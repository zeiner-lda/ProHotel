
<div>
    @section("title" , "Notificações")
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
                        <h5 class="card-title text-muted text-uppercase">notifications</h5>
                        </p>

                        <div class="col-md-12 d-flex align-items-center gap-2">
                          <input type='text' wire:model.live="searcher" placeholder='Pesquisar' class='form-control' />
                          <input title='Data inicial' type='date' wire:model.live="startdate"  class='form-control' />
                          <input  title='Data final' type='date' wire:model.live="enddate" class='form-control' />
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                              <thead class='text-center'>
                                <tr>
                                  <th>Titulo</th>
                                  <th>Notificação</th>                                 
                                  <th>Status</th>  
                                  <th>Opções</th>
                                </tr>
                              </thead>
                              <tbody>
                                @if (isset($notifications) and count($notifications) > 0)
                                @foreach ($notifications as $notification)
                                    <tr>
                                        <td class='text-center'>{{ $notification->notification_title }}</td>                                       
                                        <td class='text-center'>{{ $notification->notification }}</td>                                                             
                                        <td class='text-center'>{{ $notification->status ? 'vista' : 'pendente' }}</td>                                                             
                                        <td>
                                          <div class="d-flex align-items-center justify-content-center gap-1">
                                           
                                            <button wire:click='delete({{ $notification->id }})' class='btn btn-sm btn-danger'>
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
                            <span class='my-3'>{{isset($notifications) ? $notifications->links('pagination::bootstrap-4') : ''}}</span>
                        </div>

                      </div>
                    </div>
                  </div>

                </div>

                <x-admin.footer />

              </div>
    </div>
