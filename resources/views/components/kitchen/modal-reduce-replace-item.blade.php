<!-- Button trigger modal -->

<x-layout.app>
  <!-- Modal -->
  <div wire:ignore.self class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content bg-white">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Solicitar de Itens</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body ">
          <form wire:submit.prevent='{{ $status ? "saveRequestItem" : "saveRestoreItem" }}'>

            <div class="form-group">
                <label>Item</label>
                <input wire:model='itemRequested' type="text" class="form-control" />
            </div>

            <div class="form-group">
                <label>Quantidade</label>
                <input wire:model='quantity' min="1" class="form-control" type="number" />
            </div>



        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary text-uppercase" data-bs-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-sm btn-info text-uppercase">Salvar</button>
        </div>
    </form>
      </div>
    </div>
  </div>

</x-layout.app>
