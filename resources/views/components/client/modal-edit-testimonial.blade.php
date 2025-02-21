<x-layout.app>

<div wire:ignore.self class="modal fade" id="form-edit-testimonial" data-bs-backdrop="static" data-bs-keyboard="false"
  tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog  ">
    <div class="modal-content bg-white">
      <div class="modal-header">
        <h1 class="modal-title fs-5 text-uppercase">Editar depoimento</h1>
        <button wire:click='closeModal' type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form wire:submit.prevent="updateTestimonial">
          <div class='form-group'>
            <label class='form-label'>Depoimento:</label>
            <textarea wire:model='testimony' class='form-control'></textarea>
            @error("testimony") <span class='text-danger'>{{ $message }}</span> @enderror
          </div>

          <div class='form-group'>
            <label class='form-label'>Hotel:</label>
            <select required  wire:model='hotelId' class='form-select text-dark'>
              <option>Selecionar</option>
              @if (isset($hotels) and $hotels->count() > 0)
              @foreach ($hotels as $hotel)
               <option value="{{ $hotel->id }}">{{ $hotel->companyname }}</option>
              @endforeach
              @endif
            </select>
            @error("hotelId") <span class='text-danger'>{{ $message }}</span> @enderror
          </div>

          <div class='form-group'>
            <label class='form-label'>Quantidade de estrelas:</label>
           <select class='form-select' wire:model='starquantity'>
            <option>Selecionar</option>
            @for ($i=1; $i <= 5; $i++)
            <option value='{{$i}}'>{{$i}}</option>
            @endfor
           </select>
            @error("starquantity") <span class='text-danger'>{{ $message }}</span> @enderror
          </div>

      </div>
      <div class="modal-footer border-0">
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
