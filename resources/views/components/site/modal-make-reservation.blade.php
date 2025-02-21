<x-layout.app>

    <div wire:ignore.self class="modal fade" id="make-reservation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Efectuar reserva</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
        <form wire:submit.prevent="storeReservationByClient">
            <div class="col-md-12">
                @auth
                    <div class="form-group">
                        <label>Nome</label>
                        <input disabled value='{{ auth()->user()->profile == 'guest' ? auth()->user()->personaldata->firstname.' '.auth()->user()->personaldata->lastname : auth()->user()->username}}' class='bg-white form-control' type="text" />
                        @error('dataOfReservation') <span class='text-center'>{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input disabled value='{{ auth()->user()->profile == 'guest' ? auth()->user()->email : auth()->user()->email }}'  class='form-control bg-white' type="email" />
                        @error('email') <span class='text-center'>{{ $message }}</span> @enderror
                    </div>
                @endauth

                <div class="form-group">
                    <label>Data de reserva</label>
                    <input wire:model='dateOfReservation' class='form-control' type="date" />
                    @error('dateOfReservation') <span class='text-danger'>{{ $message }}</span> @enderror
                </div>

            </div>
            </div>
            <div class="modal-footer border-0">
            <button type="button" class="btn btn-sm btn-secondary text-uppercase" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-sm btn-primary text-uppercase">Reservar</button>
            </div>

        </form>
        </div>
        </div>
    </div>
</x-layout.app>


