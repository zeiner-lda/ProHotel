
<div>
    @section("title" , "Produtos")
        <div class="container-scroller">
        <x-stock.modal-form-product :categories='$categories' :status='$status' />
        <livewire:admin.top-bar-component />
          <div class="container-fluid page-body-wrapper">

            <x-stock.side-bar />

            <div class="main-panel">
              <div class="content-wrapper">

                <div class="container-fluid">

                     <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title text-muted text-uppercase">Produtos</h5>
                        </p>

                        <div class="col-md-12 d-flex align-items-center gap-2">
                            <button data-bs-target="#form-product" data-bs-toggle="modal" class='btn btn-primary'>Adicionar</button>
                          <input wire:model.live="searcher" placeholder='Pesquisar' class='form-control' />
                          <input title='Data inicial' type='date' wire:model.live="startdate"  class='form-control' />
                          <input  title='Data final' type='date' wire:model.live="enddate" class='form-control' />
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                              <thead>
                                <tr>
                                  <th>Data de cadastro</th>
                                  <th>Produto</th>
                                  <th>Categoria</th>
                                  <th class="text-center">Opções</th>
                                </tr>
                              </thead>
                              <tbody>
                                @if (isset($products) and count($products) > 0)
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $product->created_at }}</td>
                                        <td>{{ $product->product }}</td>
                                        <td>{{ $product->category->category ?? '' }}</td>
                                        <td>
                                          <div class="d-flex align-items-center justify-content-center gap-1">
                                              <button wire:click='edit({{ $product->id }})' data-bs-target="#form-product" data-bs-toggle="modal"  class=' btn btn-sm btn-info'>
                                                <i class='fa fa-solid fa-edit'></i>
                                                <span>Editar</span> 
                                            </button>
                                              <button wire:click='delete({{ $product->id }})' class=' btn btn-sm btn-danger'>
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

                            <div class='my-2'>
                                {{ isset($products) ? $products->links("pagination::bootstrap-4") : '' }}
                            </div>
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
