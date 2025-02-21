
<div>
    @section("title" , "Lista de Utilizadores")   
        <div class="container-scroller">        
            <livewire:admin.top-bar-component />
          <div class="container-fluid page-body-wrapper">
            <x-admin.side-bar />
            <div class="main-panel">
              <div class="content-wrapper">

                <div class="container-fluid">
                    <div class="col-lg-12 grid-margin stretch-card">
                   <div class="card">
                     <div class="card-body">
                       <h5 class="card-title text-muted text-uppercase">Meus dados</h5>
                       </p>
                       
                       <div class='col-md-12 gap-1  d-flex align-items-center'>
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <label>Nome de usuário</label>
                                <input class='form-control' />
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <label>Nome de usuário</label>
                                <input class='form-control' />
                            </div>

                        </div>

                       </div>
                    
                   
                   </div>
                 </div>
   
               </div>
                <x-admin.footer />
            </div>
    </div>
