<x-layout.app>

<div wire:ignore.self class="modal fade" id="form-add-testimonial" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-white">
        <div class="modal-header">
          <h4 class="modal-title fs-5 text-uppercase">Adicionar Depoimento</h4>
          <button  type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form wire:submit="save">
            <div class='form-group mb-3'>
                <strong class='form-label'>Selecione o hotel:</strong>
                <select wire:model='hotelId' class='hotelId form-select'>
                    <option>Selecionar</option>
                    @if ($allAvailableHotelsInAngola and $allAvailableHotelsInAngola->count() > 0)
                    @foreach ($allAvailableHotelsInAngola as $company)
                    <option value='{{$company->id}}'>{{$company->companyname}}</option>
                    @endforeach
                    @endif
                </select>
                @error("hotelId") <span class='text-danger'>{{ $message }}</span> @enderror
            </div>
              <div class='form-group'>
                  <strong class='form-label'>Adicione o seu depoimento:</strong>
                  <textarea wire:model='testimonial' class='form-control' cols="20" rows="5"></textarea>
                  @error("testimonial") <span class='text-danger'>{{ $message }}</span> @enderror
              </div>

              <div class="form-group mt-3">
                <strong class='form-label'>Classifique-nos por uma quantidade estrelas:</strong>
                  <div class='d-flex align-items-center'>
                    @for ($i=1; $i<=5; $i++)
                      <small wire:click.prevent='chooseStarQuantity({{$i}})'
                      title='Dar {{$i}} {{ $i > 1 ? 'estrelas' : 'estrela' }}'
                      wire:model='starquantity'
                      class="fs-3 fa fa-star stars">
                      </small>
                    @endfor
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


