<x-layout.app>

<div wire:ignore.self class="modal fade" id="form-room" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content bg-white">
        <div class="modal-header">
          <h1 class="modal-title fs-5 text-uppercase"> {{$status ? 'Editar' : 'Adicionar'}} Quarto</h1>
          <button wire:click='closeModal' type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form wire:submit.prevent="{{ $status ? "update" : "save" }}">
            <div class="gap-1">

                      <div class='form-group'>
                        <label class='form-label'>Nº do quarto</label>
                        <input required wire:model='roomnumber' type='number' class='form-control rounded' />
                        @error("roomnumber") <span class='text-danger'>{{ $message }}</span> @enderror
                      </div>

                    <div class='form-group'>
                        <label class='form-label'>Tipo:</label>
                      <select required wire:model="roomtype" class='form-select text-dark'>
                        <option value=''>Selecionar</option>
                        <option value="single">Solteiro</option>
                        <option value="double">Casal</option>
                        <option value="suite">Suite</option>
                      </select>
                        @error("roomtype") <span class='text-danger'>{{ $message }}</span> @enderror
                    </div>

                    <div class='form-group'>
                      <label class='form-label'>Estado:</label>
                      <select required wire:model='roomstatus' class='form-select text-dark'>
                        <option>Selecionar</option>
                        <option value='available'>Disponível</option>
                        <option  value='occupied'>Reservado</option>
                      </select>
                    </div>

                    <div class='form-group'>
                      <label class='form-label'>Capacidade</label>
                      <input required wire:model='roomcapacity' min="1" type='number' class='form-control rounded' />
                      @error("roomcapacity") <span class='text-danger'>{{ $message }}</span> @enderror
                    </div>

                    <div class='form-group'>
                      <label class='form-label'>Quantidade de camas</label>
                      <input required wire:model='bedquantity' min="1" type='number' class='form-control rounded' />
                      @error("bedquantity") <span class='text-danger'>{{ $message }}</span> @enderror
                    </div>

                    <div class='form-group'>
                      <label class='form-label'>Quantidade de banheiros</label>
                      <input required wire:model='bathquantity' min="1" type='number' class='form-control rounded' />
                      @error("bathquantity") <span class='text-danger'>{{ $message }}</span> @enderror
                    </div>

                    <div class='form-group'>
                        <label class='form-label'>Preço por noite</label>
                        <input required wire:model='price' min="1" type='number' class='form-control rounded' />
                        @error("price") <span class='text-danger'>{{ $message }}</span> @enderror
                    </div>

                    <div class='form-group'>
                      <label class='form-label'>Descrição</label>
                      <textarea required wire:model="description" class='form-control' cols="30" rows="10"></textarea>
                      @error("description") <span class='text-danger'>{{ $message }}</span> @enderror
                  </div>


                    <div class='form-group'>
                        <label class='form-label'>Foto</label>
                        <input id="file" wire:model="photo" type='file' class='form-control rounded' />
                        @error("photo") <span class='text-danger'>{{ $message }}</span> @enderror
                    </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary text-uppercase btn-sm">Salvar</button>
          <button type="button" class="btn btn-secondary text-uppercase btn-sm" data-bs-dismiss="modal">Cancelar</button>
        </div>
         </form>
      </div>
    </div>
  </div>

</x-layout.app>
