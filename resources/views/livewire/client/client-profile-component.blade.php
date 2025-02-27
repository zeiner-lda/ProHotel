<main id="main" class="main">

        <section class="section dashboard">
          <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
              <div class="row">

                  <!-- Testimonials -->
                <div class="col-12">
                  <div class="card recent-sales overflow-auto">

                    <div class="filter">
                      <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                          <h6>Filter</h6>
                        </li>

                        <li><a class="dropdown-item" href="#">Today</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                      </ul>
                    </div>

                    <div class="card-body">
                              <h5 class="card-title text-uppercase">Meus Dados</h5>
                            <form wire:submit.prevent='update'>
                              <div class="col-md-12 d-flex align-items-center gap-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Primeiro Nome</label>
                                        <input  type='text' wire:model='firstname' class='form-control' />
                                    </div>

                                    <div class="form-group">
                                        <label>Último Nome</label>
                                        <input type='text' wire:model='lastname' class='form-control' />
                                    </div>

                                    <div class="form-group">
                                        <label>Localização</label>
                                        <input wire:model='address' type='text' class='form-control' />
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input wire:model='email' type='email' class='form-control' />
                                    </div>

                                    <div class="form-group">
                                        <label>Telefone</label>
                                        <input wire:model='phone' type='tel' class='form-control' />
                                    </div>

                                    <div class="form-group">
                                        <label>Senha</label>
                                        <input wire:model="password" type='password' class='form-control' />
                                    </div>

                                </div>

                              </div>

                              <div class='mt-2'>
                                <button type='submit' class='btn btn-dark btn-sm text-uppercase'>Atualizar</button>
                              </div>
                            </form>

                            </div>

                          </div>
                    </div>


              </div>
            </div><!-- End Left side columns -->



          </div>
        </section>

      </main>
      <!-- End #main -->
