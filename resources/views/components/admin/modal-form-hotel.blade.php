<x-layout.app>

<div wire:ignore.self class="modal fade" id="form-company" data-bs-backdrop="static" data-bs-keyboard="false"
  tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-scrollable">
    <div class="modal-content bg-white">
      <div class="modal-header">
        <h1 class="modal-title fs-5 text-uppercase">{{$status ? 'Editar' : 'Adicionar'}}  Hotel</h1>
        <button wire:click='closeModal' type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form wire:submit.prevent="{{$status ? 'update' : 'save'}}">
          <div class='form-group'>
            <label class='form-label'>Nome do hotel:</label>
            <input required wire:model='companyname' type='text' class='form-control rounded' />
            @error("companyname") <span class='text-danger'>{{ $message }}</span> @enderror
          </div>

          <div class='form-group'>
            <label class='form-label'>Província:</label>
            <select required  wire:model='province' class='form-select text-dark'>
              <option>Selecionar</option>
              <option value="Bengo">Bengo</option>
              <option value="Benguela">Benguela</option>
              <option value="Bié">Bié</option>
              <option value="Cabinda">Cabinda</option>
              <option value="Cuanza Norte">Cuanza Norte</option>
              <option value="Cuanza Sul">Cuanza Sul</option>
              <option value="Cunene">Cunene</option>
              <option value="Huambo">Huambo</option>
              <option value="Huíla">Huíla</option>
              <option value="Luanda">Luanda</option>
              <option value="Lunda Norte">Lunda Norte</option>
              <option value="Lunda Sul">Lunda Sul</option>
              <option value="Malanje">Malanje</option>
              <option value="Moxico">Moxico</option>
              <option value="Namibe">Namibe</option>
              <option value="Uíge">Uíge</option>
              <option value="Zaire">Zaire</option>
              <option value="Cuando Cubango">Cuando Cubango</option>
            </select>
            @error("province") <span class='text-danger'>{{ $message }}</span> @enderror
          </div>

          <div class='form-group'>
            <label class='form-label'>Município:</label>
            <input required wire:model='municipality' type='text' class='form-control rounded' />
            @error("municipality") <span class='text-danger'>{{ $message }}</span> @enderror
          </div>

          <div class='form-group'>
            <label class='form-label'>Email:</label>
            <input required wire:model='email' type='email' class='form-control rounded' />
            @error("email") <span class='text-danger'>{{ $message }}</span> @enderror
          </div>

          <div class='form-group'>
            <label class='form-label'>Telefone:</label>
            <input required wire:model='phone' type='tel' class='form-control rounded' />
            @error("phone") <span class='text-danger'>{{ $message }}</span> @enderror
          </div>

          <div class='form-group'>
            <label class='form-label'>Foto:</label>
            <input id="file" {{$status ? '' : 'required'}}  wire:model='photo' type='file'  class='form-control rounded' />
             @error("photo") <span class='text-danger'>{{ $message }}</span> @enderror
          </div>

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary text-uppercase btn-sm">
          Salvar
        </button>
        <button type="button" class="btn btn-secondary text-uppercase btn-sm" data-bs-dismiss="modal">
          Cancelar
        </button>
      </div>
      </form>
    </div>
  </div>
</div>

</x-layout.app>
