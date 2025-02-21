
<div>
    @section("title" , "Stock")
        <div class="container-scroller">

            <livewire:admin.top-bar-component />
          <div class="container-fluid page-body-wrapper">

            <x-stock.side-bar />

            <div class="main-panel">
              <div class="content-wrapper">
                <div class="page-header">
                  <h3 class="page-title">
                    <span class="page-title-icon bg-gradient-primary text-white me-2">
                      <i class="mdi mdi-home"></i>
                    </span> Dashboard
                  </h3>
                  <nav aria-label="breadcrumb">
                    <ul class="breadcrumb">
                      <li class="breadcrumb-item active" aria-current="page">
                        <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                      </li>
                    </ul>
                  </nav>
                </div>

                <div class="row">

                  <div class="col-md-4 stretch-card grid-margin">
                    <div class="card bg-gradient-danger card-img-holder text-white">
                      <div class="card-body">
                        <img src="{{ asset('/dashboard/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                        <h3 class="font-weight-normal mb-3 text-uppercase">Categorias <i class="mdi mdi-chart-line mdi-24px float-end"></i> </h3>
                        <h2 class="mb-5">{{ isset($categoriesCount) ? $categoriesCount : 0 }}</h2>

                      </div>
                    </div>
                  </div>

                  <div class="col-md-4 stretch-card grid-margin">
                    <div class="card bg-gradient-info card-img-holder text-white">
                      <div class="card-body">
                        <img src="{{ asset('/dashboard/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                        <h3 class="font-weight-normal mb-3 text-uppercase">Produtos <i class="mdi mdi-bookmark-outline mdi-24px float-end"></i>
                        </h3>
                        <h2 class="mb-5">{{ isset($productsCount) ? $productsCount : 0 }}</h2>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4 stretch-card grid-margin">
                    <div class="card bg-gradient-warning card-img-holder text-white">
                      <div class="card-body">
                        <img src="{{ asset('/dashboard/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                        <h3 class="font-weight-normal mb-3 text-uppercase">Economato <i class="mdi mdi-bookmark-outline mdi-24px float-end"></i>
                        </h3>
                        <h2 class="mb-5">{{ isset($stockroomCount) ? $stockroomCount : 0 }}</h2>
                      </div>
                    </div>
                  </div>

                </div>

                <div class="row">
                  <div class="col-md-7 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <div class="clearfix">
                          <h4 class="card-title float-start">Visit And Sales Statistics</h4>
                          <div id="visit-sale-chart-legend" class="rounded-legend legend-horizontal legend-top-right float-end"></div>
                        </div>
                        <canvas id="visit-sale-chart" class="mt-4"></canvas>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-5 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title">Traffic Sources</h4>
                        <div class="doughnutjs-wrapper d-flex justify-content-center">
                          <canvas id="traffic-chart"></canvas>
                        </div>
                        <div id="traffic-chart-legend" class="rounded-legend legend-vertical legend-bottom-left pt-4"></div>
                      </div>
                    </div>
                  </div>
                </div>

                <x-admin.footer />

              </div>

    </div>
