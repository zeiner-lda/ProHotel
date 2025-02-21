<x-layout.app>

<div wire:ignore.self class="modal fade" id="form-add-user" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content bg-white">
        <div class="modal-header">
          <h1 class="modal-title fs-5 text-uppercase">{{ $status ? 'Editar' : 'Adicionar' }} Utlizador</h1>
          <button wire:click='closeModal' type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form wire:submit.prevent="{{ $status ? 'update' : 'save' }}">
            <div class="gap-1">
  
                      <div class='form-group'>
                        <label class='form-label'>Nome do utilizador</label>
                        <input wire:model='username' type='text' class='form-control rounded' />
                        @error("username") <span class='text-danger'>{{ $message }}</span> @enderror
                      </div> 
                   
                    <div class='form-group'>
                      <label class='form-label'>Email</label>
                      <input wire:model='email'  type='text' class='form-control rounded' />
                      @error("email") <span class='text-danger'>{{ $message }}</span> @enderror
                    </div>
                    
                    <div class='form-group'>
                      <label class='form-label'>Perfil</label>
                        <select wire:model='profile' class='form-select text-dark'>
                            <option value="">Selecionar</option>
                            <option value="admin">Administrador</option>
                            <option value="kitchen_manager">Chefe de cozinha</option>
                            <option value="stockroom_manager">Gestor de economato</option>
                            <option value="reception">Recepção</option>
                        </select>
                        @error('profile') <span class='text-danger'>{{$message}}</span>@enderror                         
                       
                    </div>   
                    
                    <div class='form-group'>
                        <label class='form-label'>Senha</label>
                        <input wire:model="password" type='password' class='form-control rounded' />
                        @error("password") <span class='text-danger'>{{ $message }}</span> @enderror
                    </div>
                    
                    <div class='form-group'>
                        <label class='form-label'>Foto</label>
                        <input wire:model="photo" type='file' class='form-control rounded' />
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