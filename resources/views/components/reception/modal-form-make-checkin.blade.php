<x-layout.app>

<div wire:ignore.self class="modal fade" id="form-checkin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content bg-white">
        <div class="modal-header">
          <h1 class="modal-title fs-5 text-uppercase">Check-in</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form wire:submit.prevent="finishCheckin">
            <div class="gap-1">

                      <div class='form-group'>
                        <label class='form-label'>Quantidade de dias</label>
                        <select required  wire:change='chooseQuantityOfDays' wire:model='quantityOfDays' class="form-select text-dark" id="">
                            <option value='0'>Selecionar</option>
                            @for ($i=1; $i<=15; $i++)
                            <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                      </div>

                      <div class='form-group'>
                        <label class='form-label'>Valor a pagar</label>
                        <input wire:model='price' min="1" type='number' class='form-control rounded' />
                        @error("price") <span class='text-danger'>{{ $message }}</span> @enderror
                    </div>

                    <div class='form-group'>
                      <label class='form-label'>Método de pagamento</label>
                      <select  required wire:model='payment_method' class="form-select text-dark">
                        <option value="">Selecionar</option>
                        <option value="cash">Cash</option>
                        <option value="credit_card">Cartão de crédito</option>
                      </select>
                  </div>


                    <div class='form-group'>
                      <label class='form-label'>Nota</label>
                      <textarea wire:model='notes' class='form-control' cols="30" rows="10"></textarea>
                      @error("price") <span class='text-danger'>{{ $message }}</span> @enderror
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

