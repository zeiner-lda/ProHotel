
<div>
    @section("title" , "Lista de Utilizadores")
    <x-g_admin.modal-form-user :allHotels='$allHotels' :profile='$profile' :status='$status' :username='$username' :firstname='$firstname' :lastname='$lastname' :telephone='$telephone'  />
        <div class="container-scroller">
            <livewire:admin.top-bar-component />
          <div class="container-fluid page-body-wrapper">
            <x-g_admin.side-bar />
            <div class="main-panel">
              <div class="content-wrapper">

                <div class="container-fluid">
                     <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title text-muted text-uppercase">Utilizadores Administradores Dos Hoteis</h5>
                        </p>

                        <div class="col-md-12 d-flex align-items-center gap-2">
                          <input data-bs-target='#form-add-user' data-bs-toggle='modal' class='btn  btn-primary' value='Adicionar' type="button" />
                          <input wire:model.live="searcher" placeholder='Pesquisar' class='form-control' />
                          <input title='Data inicial' type='date' wire:model.live="startdate"  class='form-control' />
                          <input  title='Data final' type='date' wire:model.live="enddate" class='form-control' />
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                              <thead>
                                <tr>
                                  <th>Data de cadastro</th>
                                  <th>Nome do utilizador</th>                                 
                                  <th>Email</th>
                                  <th>Perfil</th>
                                  <th>Hotel</th>
                                  {{-- <th>Foto</th>                                --}}
                                  <th class="text-center">Opções</th>
                                </tr>
                              </thead>
                              <tbody>
                                @if (isset($data) and count($data) > 0)
                                @foreach ($data as $user)
                                 <tr>
                                   <td>{{ $user->email ? $user->created_at : '' }}</td>
                                    <td>{{ $user->username  ? $user->username : 'Hóspede'}}</td>                                    
                                    <td>{{ $user->email ? $user->email : '' }}</td>
                                    <td><span class='text-capitalize'>
                                      @if ($user->profile == 'admin')
                                      <span>Admin</span>
                                      @elseif ($user->profile == 'stockroom_manager')
                                      <span>Gestor de economato</span>
                                      @elseif ($user->profile == 'kitchen_manager')
                                      <span>Chefe de cozinha</span>
                                      @elseif ($user->profile == 'reception')
                                      <span>Recepção</span>
                                      @elseif ($user->profile == 'guest')
                                      <span>Cliente</span>
                                      @endif
                                    </td> </span>
                                    <td>{{ isset($user->hotel->companyname)  ? $user->hotel->companyname  : 'N/D'}}</td>
                                    {{-- <td> <img src="" alt="foto" /></td>         --}}
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center gap-1">
                                            <button wire:click='edit({{ $user->id }})' data-bs-target='#form-add-user' data-bs-toggle='modal' class='btn btn-sm btn-info'>
                                                <i class='fa fa-solid fa-edit'></i>
                                                <span>Editar</span>
                                            </button>
                                            <button wire:click='delete({{ $user->id }})' class='btn btn-sm btn-danger'>
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

                            <div class='d-flex'>
                                <span wire:ignore class='my-3'>{{isset($data) ? $data->links('pagination::bootstrap-4') : ''}}</span>
                            </div>
                        </div>

                      </div>
                    </div>
                  </div>


                <x-admin.footer />

</div>
