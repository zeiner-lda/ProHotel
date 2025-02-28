
<div>
    @section("title" , "Reservas")
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
                        <h5 class="card-title text-muted text-uppercase">Reservas</h5>
                        </p>

                        <div class="col-md-12 d-flex align-items-center gap-2">
                          <input wire:model.live="searcher" placeholder='Pesquisar' class='form-control' />
                          <input title='Data inicial' type='date' wire:model.live="startdate"  class='form-control' />
                          <input  title='Data final' type='date' wire:model.live="enddate" class='form-control' />
                        </div>

                        <div class='table-responsive'>
                            <table class="table table-hover">
                              <thead>
                                <tr>
                                  <th>Data de reserva</th>
                                  <th>Nº quarto</th>
                                  <th>Tipo de quarto</th>
                                  <th>Preço quarto</th>
                                  <th>Hóspede</th>
                                  <th class='text-center'>Status</th>
                                  <th class="text-center">Opções</th>
                                </tr>
                              </thead>
                              <tbody>
                                @if (isset($data) and count($data) > 0)
                                @foreach ($data as $reservation)
                                    <tr>
                                        <td>{{ $reservation->reservation_date ?? '' }}</td>
                                        <td>{{ $reservation->room->room_number ?? ''}}</td>
                                        <td>
                                          @if (isset($reservation->room->room_type) and $reservation->room->room_type == 'single')
                                              <span>Solteiro</span>
                                          @elseif(isset($reservation->room->room_type) and $reservation->room->room_type == 'double')
                                              <span>Casal</span>
                                          @elseif (isset($reservation->room->room_type) and $reservation->room->room_type == 'suite')
                                              <span>Suite</span>
                                          @endif
                                        </td>
                                        <td>{{ isset($reservation->room->price_pernight) ? number_format($reservation->room->price_pernight, 2, ',', ',') : '' }}</td>
                                        <td>{{ $reservation->guest->firstname.' '.$reservation->guest->lastname }}</td>
                                        <td>
                                            <span class='fw-bold {{ $reservation->reservation_status == 'pending' ? 'text-danger' : 'text-dark' }}'>{{ $reservation->reservation_status == 'pending' ? 'Checkin Pendente' : 'Checkin Confirmado' }}</span>
                                        </td>
                                        <td>
                                          <div class="d-flex align-items-center justify-content-center gap-1">

                                              <button wire:click='makeCheckin({{ $reservation->id }})'
                                                 data-bs-target="#form-checkin" data-bs-toggle="modal"
                                                  class='{{ $reservation->reservation_status == 'confirmed' ? 'disabled' : '' }}
                                                  btn btn-sm btn-info'
                                                >
                                                <i class='fa fa-solid fa-edit'></i>
                                                <span>Fazer check-in</span>
                                              </button>

                                              <button
                                               wire:click='cancelReservation({{ $reservation->id }})'
                                               class='btn btn-sm btn-danger'
                                               >
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
                              <span  class='my-3'>{{isset($data) ? $data->links('pagination::bootstrap-4') : ''}}</span>
                       </div>

                      </div>
                    </div>
                  </div>
                </div>

                <x-reception.modal-form-make-checkin />
                <x-admin.footer />

</div>
