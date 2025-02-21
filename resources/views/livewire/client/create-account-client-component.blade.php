<div>
    @section("title" , "Registar nova conta")
    <livewire:site.home.navbar-component />
    <style>
        @media (max-width: 730px) {
            #title {
              display: flex;
              justify-content: center;

            }
            #container-inputs {
                display: flex;

                justify-content: center !important;
            }

            .col-md-4, .col-md-3 {
                width: 100% !important;
            }

            #buttons-store-back-login  {
                display: flex;
                flex-direction: column;
            }

            #buttons-store-back-login .btn-sm {
                width: 100% !important;
                margin-left: 0px !important;
            }
        }
    </style>

    <main class="form-signin container-fluid " style="margin-top: 20vh !important">
        <form wire:submit.prevent="storeAccount">
          <div  class='container mb-3'>
            <h4 class="h4 mb-3 fw-normal text-center text-uppercase"> Criar conta</h4>
          </div>


          <div id="container-inputs" class="container col-md-7 d-flex flex-wrap justify-content-center align-items-start  gap-2 ">

            <div class="col-md-4">
                    <div class="mb-2">
                        <label>Primeiro nome:</label>
                        <input  wire:model="firstname" type="text" class="form-control" id="floatingInput" placeholder="Digite o primeiro nome">
                        @error('firstname')<span class='text-danger'>{{$message}}</span>@enderror
                    </div>

                    <div class="form-group mb-2">
                        <label for="">Email</label>
                        <input  wire:model='email' type="text" class="form-control" placeholder="Digite o email" />
                        @error('email')<span class='text-danger'>{{$message}}</span>@enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-2">
                        <label >Último nome:</label>
                        <input  wire:model="lastname" type="text" class="form-control" id="floatingPassword" placeholder="Digite o último nome" />
                        @error('lastname')<span class='text-danger'>{{$message}}</span>@enderror
                    </div>


                    <div class="form-group mb-2">
                        <label for="">Senha</label>
                        <input  wire:model='password' type="password" class="form-control" placeholder="Digite a senha" />
                        @error('password')<span class='text-danger'>{{$message}}</span>@enderror
                    </div>


                </div>

                <div class="col-md-3">
                    <div class="mb-2">
                        <label>Telefone:</label>
                        <input  wire:model="phone" type="tel" class="form-control" id="floatingPassword" placeholder="Digite o telefone" />
                        @error('phone')<span class='text-danger'>{{$message}}</span>@enderror
                        </div>


                    <div class="form-group">
                        <label for="">Confirmar senha:</label>
                        <input  wire:model='passwordconfirmation' type="password" class="form-control" placeholder="Confirmar senha" />
                        @error('passwordconfirmation')<span class='text-danger'>{{$message}}</span>@enderror
                    </div>

                </div>

            </div>


          <div id='buttons-store-back-login'  class='col-md-6 container  d-flex flex-column align-items-center '>
              <button class="w-100 rounded btn btn-block btn-primary btn-sm py-2 my-2" type="submit">
                Salvar
              </button>
              <div class='d-flex align-items-center'>
                <a href='/' class='text-dark'>Ir para o Início</a>
                  <a  href="{{ route('login') }}" class=" py-2 my-2 ms-2">Fazer login</a>
              </div>
          </div>
        </form>
      </main>
</div>

@push("create-account-script")
<script>
    $(document).ready( () => {
    $(".back-to-top").remove();
    });
</script>
@endpush
