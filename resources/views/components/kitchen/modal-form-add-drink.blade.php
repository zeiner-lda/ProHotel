<x-layout.app>

    <div wire:ignore.self class="modal fade" id="form-add-drink" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
          <div class="modal-content bg-white">
            <div class="modal-header">
              <h1 class="modal-title fs-5 text-uppercase">{{ $status ? 'Editar' : 'Adicionar' }} Bebida</h1>
              <button wire:click='closeModal' type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form wire:submit.prevent="{{ $status ? 'update' : 'save' }}">
                <div class="gap-1">

                          <div class='form-group'>
                            <label class='form-label'>Nome da bebida</label>
                            <input required wire:model='drinkName' type='text' class='form-control rounded' />
                            @error("drinkName") <span class='text-danger'>{{ $message }}</span> @enderror
                          </div>

                          <div class='form-group'>
                            <label class='form-label'>Categoria</label>
                          <select wire:model='category' class='form-select text-dark'>
                            <option >Selecionar</option>
                            <option value='dish'>Pratos</option>
                            <option value='drink'>Bebidas</option>
                          </select>
                            @error("category") <span class='text-danger'>{{ $message }}</span> @enderror
                          </div>

                          <div class='form-group'>
                            <label class='form-label'>Preço</label>
                            <input min='1' required wire:model='price' type='number' class='form-control rounded' />
                            @error("price") <span class='text-danger'>{{ $message }}</span> @enderror
                          </div>


                        <div class='form-group'>
                            <label class='form-label'>Foto</label>
                            <input  wire:model="photo" type='file' class='form-control rounded' />
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
