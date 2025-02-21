
<div>
    @section("title" , "Cozinha | Produtos")
        <div class="container-scroller">
        {{-- @include("livewire.kitchen.modal.form-request-item") --}}
        <livewire:admin.top-bar-component />
          <div class="container-fluid page-body-wrapper">

            <x-kitchen.side-bar />

            <div class="main-panel">
              <div class="content-wrapper">

                <div class="container-fluid">

                     <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title text-muted text-uppercase">Itens Disponíves no Economato</h5>
                        </p>

                        <div class="col-md-12 d-flex align-items-center gap-2">
                          <input wire:model.live="searcher" placeholder='Pesquisar' class='form-control' />
                          <input wire:model.live='startdate' class='form-control' type="date" title='Data de inicial' />
                          <input wire:model.live='enddate' class='form-control' type="date" title='Data final' />
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                              <thead>
                                <tr>
                                  <th>Item</th>
                                  <th>Quantidade</th>
                                  <th>Data de registo</th>
                                  <th class="text-center">Opções</th>
                                </tr>
                              </thead>
                              <tbody>
                                @if (isset($avaliableItems) and count($avaliableItems) > 0)
                                @foreach ($avaliableItems as $item)
                                    <tr>
                                        <td>{{ $item->item }}</td>
                                        <td>{{ $item->quantity ?? '' }}</td>
                                        <td>{{ $item->created_at ?? '' }}</td>
                                        <td>
                                          <div class="d-flex align-items-center justify-content-center gap-1">
                                              <button wire:click='requestItem({{ $item->id }})' data-bs-target="#form-request-item" data-bs-toggle="modal"  data-bs-target="#form-item" data-bs-toggle="modal"  class=' btn btn-sm btn-primary'>
                                                <span>Solicitar</span>
                                              </button>

                                              <button wire:click='restoreItem({{ $item->id }})' data-bs-target="#form-request-item" data-bs-toggle="modal"  data-bs-target="#form-item" data-bs-toggle="modal"  class=' btn btn-sm btn-info'>
                                                <span>Repor</span>
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

                            <div class='my-2'>
                                {{ isset($items) ? $items->links("pagination::bootstrap-4") : '' }}
                            </div>
                        </div>

                      </div>
                    </div>
                  </div>

                </div>

                <x-admin.footer />

              </div>
    </div>
