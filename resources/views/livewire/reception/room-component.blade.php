
<div>
    @section("title" , "Quartos")
    <x-reception.modal-form-room :status='$status' />

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
                        <h5 class="card-title text-muted text-uppercase">Quartos</h5>
                        </p>

                        <div class="col-md-12 d-flex align-items-center gap-2">
                          <button data-bs-target="#form-room" data-bs-toggle="modal" class='btn btn-primary'>Adicionar</button>
                          <input wire:model.live="searcher" placeholder='Pesquisar' class='form-control' />
                           <input title='Data inicial' type='date' wire:model.live="startdate"  class='form-control' />
                          <input  title='Data final' type='date' wire:model.live="enddate" class='form-control' />
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                              <thead>
                                <tr>
                                  <th>Data de cadastro</th>
                                  <th>Foto</th>
                                  <th>Nº do quarto</th>
                                  <th>Tipo de quarto</th>
                                  <th>Capacidade</th>
                                  <th>Quantidade de camas</th>
                                  <th>Quantidade de banheiros</th>
                                  <th>Preço por noite</th>
                                  <th>Status</th>
                                  <th class="text-center">Opções</th>
                                </tr>
                              </thead>
                              <tbody>
                                @if (isset($rooms) and count($rooms) > 0)
                                @foreach ($rooms as $room)
                                    <tr>
                                      <td>{{ $room->created_at }}</td>
                                       <td>
                                         <img  class='rounded'  src="{{ asset('/storage/img/'.$room->photo) }}" alt="" />
                                      </td>
                                        <td>{{ $room->room_number }}</td>
                                        <td>
                                          @if ($room->room_type == 'single')
                                          <span>Solteiro</span>
                                          @elseif ($room->room_type == 'double')
                                          <span>Casal</span>
                                          @elseif ($room->room_type == 'suite')
                                          <span>Suite</span>
                                          @endif
                                      </td>
                                      <td>{{ $room->capacity }}</td>
                                        <td>{{ $room->bed_quantity }}</td>
                                        <td>{{ $room->bath_quantity }}</td>
                                        <td>{{ number_format($room->price_pernight, 2, ',', ',') }}</td>
                                        <td>
                                            @if ($room->status == 'available')
                                            <span class='text-success'>Disponível</span>
                                            @else
                                            <span class='text-danger'>Reservado</span>
                                            @endif
                                        </td>

                                        <td>
                                          <div class="d-flex align-items-center justify-content-center gap-1">
                                              <button wire:click="edit({{$room->id }})" data-bs-target="#form-room" data-bs-toggle="modal" class='btn btn-sm btn-info'>
                                                <span>Editar</span>
                                                <i class='fa fa-solid fa-edit'></i>
                                              </button>
                                              <button wire:click='delete({{$room->id }})' class='btn btn-sm btn-danger'>
                                                <span>Remover</span>
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
                          <span class='my-3'>{{isset($rooms) ? $rooms->links('pagination::bootstrap-4') : ''}}</span>
                         </div>

                      </div>
                    </div>
                  </div>
                </div>

                <x-admin.footer />
              </div>

    </div>

    @push("reception-room")
    <script>
        document.addEventListener("livewire:load", () => {
            Livewire.on("resetFileInput", () => {
                document.getElementById("file").value = null;
            });
        });
    </script>
    @endpush
