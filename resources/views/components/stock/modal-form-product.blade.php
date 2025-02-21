<x-layout.app>

  <div wire:ignore.self class="modal fade" id="form-product" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content bg-white">
        <div class="modal-header">
          <h4 class="modal-title fs-5 text-uppercase">Produto</h4>
          <button wire:click='closeModal' type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form wire:submit.prevent="{{ $status == true ? "update" : "save" }}">
              <div class='form-group'>
                  <label class='form-label'>Poduto:</label>
                  <input  wire:model='product' type='text' class='form-control rounded' />
                  @error("product") <span class='text-danger'>{{ $message }}</span> @enderror
              </div>

            <div class='form-group'>
                <label class='form-label'>Categoria:</label>
                <select wire:model='category' class='form-select text-dark'>
                    <option value="">Selecionar</option>
                    @if (isset($categories) and $categories->count() > 0)
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category }}</option>
                    @endforeach
                    @endif
                </select>
                @error("category") <span class='text-danger'>{{ $message }}</span> @enderror
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
