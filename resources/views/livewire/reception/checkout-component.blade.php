
<div>
    @section("title" , "Checkouts")
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
                            <h5 class="card-title text-muted text-uppercase">Checkouts</h5>
                            </p>

                            <div class="col-md-12 d-flex align-items-center gap-2">
                            <input wire:model.live="searcher" placeholder='Pesquisar' class='form-control' />
                            <input title='Data inicial' type='date' wire:model.live="startdate"  class='form-control' />
                            <input  title='Data final' type='date' wire:model.live="enddate" class='form-control' />
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                <thead>
                                    <tr>
                                    <th>Data de checkout</th>
                                    <th>Cliente</th>
                                    <th>Número do BI</th>
                                    <th>Telefone</th>
                                    <th>Morada</th>
                                    <th>Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($data) and count($data) > 0)
                                    @foreach ($data as $checkout)
                                        <tr>
                                            <td>{{ $checkout->checkoutDate }}</td>
                                            <td>{{ $checkout->reservation->guest->firstname.' '.$checkout->reservation->guest->lastname ?? 'N/D' }}</td>
                                            <td>{{ $checkout->reservation->guest->binumber ?? 'N/D' }}</td>
                                            <td>{{ $checkout->reservation->guest->phone ?? 'N/D' }}</td>
                                            <td>{{ $checkout->reservation->guest->address ?? 'N/D' }}</td>
                                            <td>
                                                <button  wire:click='deleteCheckout({{ $checkout->checkoutId }})' class='btn btn-sm btn-danger'>
                                                    <span>Eliminar</span>  
                                                    <i class='fa fa-solid fa-trash-alt'></i>
                                                </button>
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

                    <x-admin.footer />

           </div>
    </div>
