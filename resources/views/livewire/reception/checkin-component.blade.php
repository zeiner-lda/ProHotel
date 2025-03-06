
<div>
    @section("title" , "Checkins")
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
                        <h5 class="card-title text-muted text-uppercase">Checkins</h5>
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
                                  <th>Data de checkin</th>
                                  <th>Quantidade dias</th>
                                  <th>OBS</th>
                                  <th>Cliente</th>
                                  <th>Número do BI</th>
                                  <th>Telefone</th>
                                  <th>Morada</th>
                                  <th class='text-center'>Status</th>
                                  <th>Método pagamento</th>
                                  <th>Total</th>
                                  <th class="text-center">Opções</th>
                                </tr>
                              </thead>
                              <tbody>
                                @if (isset($data) and count($data) > 0)
                                @foreach ($data as $checkin)
                                    <tr>
                                       <td>{{ $checkin->checkinDate }}</td>
                                        <td class='text-center'>{{ $checkin->quantity_days }}</td>
                                        <td>{{ $checkin->notes ?? 'N/D' }}</td>
                                         <td>{{ $checkin->firstname.' '.$checkin->lastname ?? 'N/D' }}</td>
                                        <td>{{ $checkin->binumber ?? 'N/D' }}</td>
                                        <td>{{ $checkin->phone ?? 'N/D' }}</td>
                                        <td>{{ $checkin->address ?? 'N/D' }}</td>
                                        <td>
                                            <span class=' badge badge-{{ $checkin->status  ? 'success' : 'secondary' }}'>{{ $checkin->status ? 'Checkein confirmado' : 'Checkein pendente' }}</span>
                                        </td>
                                        <td>
                                            @if ($checkin->payment_method == 'cash')
                                                <span>Cash</span>
                                            @elseif ($checkin->payment_method == 'credit_card')
                                                <span>Cartão de crédito</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($checkin->total_amount, 2, ',', ',') ?? 'N/D' }}</td>

                                        <td>
                                          <div class="d-flex align-items-center justify-content-center gap-1">
                                              <button wire:click='makeCheckout({{ $checkin->checkinId }})' class='{{ $checkin->status  ? 'disabled' : '' }} btn btn-sm btn-info'>
                                              <i class='fa fa-solid fa-edit'></i>
                                                <span>Fazer check-out</span>
                                            </button>

                                            <button wire:click='deleteCheckin({{ $checkin->checkinId }})' class='btn btn-sm btn-danger'>
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
                              <span wire:ignore class='my-3'>{{isset($data) ? $data->links('pagination::bootstrap-4') : ''}}</span>
                          </div>

                      </div>
                    </div>
                  </div>

                </div>

                <x-admin.footer />

              </div>
    </div>
