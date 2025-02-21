<x-layout.app>
    <div wire:ignore.self class="modal fade" id="form-add-item" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog  ">
          <div class="modal-content bg-white">
            <div class="modal-header">
              <h4 class="modal-title fs-5 text-uppercase ">Adicionar Item</h4>
              <button wire:click='closeModal' type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form wire:submit.prevent="{{ $status ? "update" : "save" }}">
                  <div class='form-group'>
                      <label class='form-label'>Item:</label>
                     <select wire:model='item' class='{{$selectedItem ? 'd-none' : ''}} stock-item form-select text-dark'>
                        <option>Selecionar</option>
                        @if (!$selectedItem && isset($products) && $products->count() > 0)
                        @foreach($products as $item) 
                        <option value='{{$item->product}}'>{{$item->product}}</option>
                        @endforeach
                        @else
                        <input wire:model='itemName' class='form-control' />
                        @endif
                     </select>
                      @error("item") <span class='text-danger'>{{ $message }}</span> @enderror
                  </div>
    
                  <div class='form-group'>
                    <label class='form-label'>Quantidade:</label>
                    <input wire:model='quantity' class='form-control' min="0" type="number" />
                    @error("quantity") <span class='text-danger'>{{ $message }}</span> @enderror
                </div>
    
                <div class='form-group'>
                    <label class='form-label'>Descrição:</label>
                    <textarea wire:model='description' class="form-control" cols="30" rows="10"></textarea>
                    @error("description") <span class='text-danger'>{{ $message }}</span> @enderror
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
