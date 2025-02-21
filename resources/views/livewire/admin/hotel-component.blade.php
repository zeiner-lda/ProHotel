
<div>
    @section("title" , "Lista de hoteis")
        <div class="container-scroller">
         <x-admin.modal-form-hotel :status='$status' />
         <livewire:admin.top-bar-component />
          <div class="container-fluid page-body-wrapper">
         <x-admin.side-bar />
            <div class="main-panel">
              <div class="content-wrapper">

                <div class="container-fluid">
                     <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title text-muted text-uppercase">Lista de Hoteis cadastrados em Angola</h5>
                        </p>

                        <div class="col-md-12 d-flex align-items-center gap-2">
                            <button data-bs-target="#form-company" data-bs-toggle="modal" class='btn btn-primary'>Adicionar</button>
                            <input wire:model.live="searcher" placeholder='Pesquisar' class='form-control' />
                            <input title='Data inicial' type='date' wire:model.live="startdate"  class='form-control' />
                            <input  title='Data final' type='date' wire:model.live="enddate" class='form-control' />
                        </div>

                      <div class='table-responsive'>
                        <table class="table table-striped table-hover">
                          <thead>
                            <tr>
                              <th>Data de cadastro</th>
                              <th>Foto</th>
                              <th>Nome Da Empresa</th>
                              <th>Província</th>
                              <th>Município</th>
                              <th class='text-center'>Email</th>
                              <th>Telefone</th>
                              <th>Opções</th>
                            </tr>
                          </thead>

                          <tbody>
                            @if (isset($companies) and count($companies) > 0)
                            @foreach ($companies as $company)
                            <tr>
                              <td>{{ $company->created_at }}</</td>
                              <td><img  class='rounded' src='{{asset("/storage/img/".$company->company_cover_photo)}}' /></td>
                              <td>{{ $company->companyname }}</</td>
                              <td>{{ $company->province }}</td>
                              <td>{{ $company->municipality }}</td>
                              <td>{{ $company->email }}</td>
                              <td>{{ $company->phone }}</td>
                              <td>
                                <button data-bs-target="#form-company" data-bs-toggle="modal" wire:click="editHotel({{$company->id}})" class='btn btn-info btn-sm'>
                                  <i class='fa fa-solid fa-edit'></i>
                                    <span>Editar</span>
                                </button>
                                <button wire:click.prevent="deleteHotel({{$company->id}})" class='btn btn-danger btn-sm'>
                                   <span>Remover</span>
                                    <i class='fa fa-solid fa-trash-alt'></i>
                                </button>
                              </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan='10'> <div class='alert alert-warning text-center'>Nenhum resultado encontrado!</div> </td>
                            </tr>
                            @endif
                          </tbody>

                        </table>
                       </div>
                       <div class='d-flex'>
                        <span wire:ignore class='my-3'>{{isset($companies) ? $companies->links('pagination::bootstrap-4') : ''}}</span>
                       </div>

                      </div>
                    </div>
                  </div>

                </div>

                <x-admin.footer />

              </div>


    </div>

    @push("admin-hotel")
    <script>
        document.addEventListener("livewire:load", () => {
            Livewire.on("resetFileInput", () => {
                document.getElementById("file").value = null;
            });
        });
    </script>
    @endpush
