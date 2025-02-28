
<div>
    @section("title" , "Pedidos")
        <div class="container-scroller">

            <livewire:admin.top-bar-component />

          <div class="container-fluid page-body-wrapper">

            <x-kitchen.side-bar />

            <div class="main-panel">
              <div class="content-wrapper">

                <div class="container-fluid">

                     <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title text-muted text-uppercase">Pedidos</h5>
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
                                    <th>Data de pedido</th>
                                 <th>Foto</th>
                                  <th>Item</th>
                                  <th>Preço</th>
                                  <th class='text-center'>Quarto</th>
                                  <th class="text-center">Opções</th>
                                </tr>
                              </thead>
                              <tbody>
                                @if (isset($orders) and count($orders) > 0)
                                @foreach ($orders as $order)
                                    <tr>
                                      <td>{{ $order->created_at }}</td>
                                      <td> <img class='rounded' src="{{asset('/storage/img/'.$order->order_photo)}}" /> </td>
                                      <td>{{ $order->order_name }}</td>
                                       <td>{{ $order->order_price }}</td>
                                       <td class='text-center'>{{ $order->order_room }}</td>
                                        <td>
                                          <div class="d-flex align-items-center justify-content-center gap-1">
                                            <button class='btn btn-sm btn-dark text-uppercase'>
                                                @if ($order->order_status == "finished")
                                                <span>Finalizado</span>
                                                @endif
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
                              <span wire:ignore class='my-3'>{{isset($orders) ? $orders->links('pagination::bootstrap-4') : ''}}</span>
                          </div>

                      </div>
                    </div>
                  </div>

                </div>

                <x-admin.footer />

              </div>
    </div>
