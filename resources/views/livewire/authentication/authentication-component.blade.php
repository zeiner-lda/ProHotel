<div>
    @section("title" , "Login")
    <livewire:site.home.navbar-component />
    <style>

    </style>

    <main class="form-signin container col-md-4 m-auto" style="margin-top: 25vh !important">
        <form wire:submit.prevent="authenticate">
          <h1 class="h1 mb-3 fw-normal text-center"> Login</h1>
          @if (session()->has('success'))
          <div class="alert alert-success text-center">
            <span>{{ session('success') }}</span>
          </div>
          @endif

          <div class="form-floating mb-2">
            <input wire:model="email" type="email" class="form-control" id="floatingInput" />
            <label for="floatingInput">Email:</label>
            @error('email') <span class='text-danger'>{{ $message }}</span> @enderror
          </div>

          <div class="form-floating">
            <input wire:model="password" type="password" class="form-control" id="floatingPassword" />
            <label for="floatingPassword">Senha:</label>
            @error('password') <span class='text-danger'>{{ $message }}</span> @enderror
          </div>

          @guest
                <div class='text-center d-flex gap-1 align-items-center justify-content-center'>
                <span>Ainda não tem uma conta? </span><a href="{{-- route('client.create.account') --}}" style="color:#0d6efd !important" >clique aqui para registar</a>
                </div>
        @endguest


          <div>
              <button class="btn btn-primary w-100 py-2 my-2" type="submit">
                Entrar
              </button>
          </div>
        </form>
      </main>


</div>

@push("login-script")
    <script>
      $(".back-to-top").remove();
        $(document).ready( () => {
        setInterval( () => {
        $('.alert').remove();
        }, 60000); // 1min de duração do alert!
        });
    </script>
@endpush

