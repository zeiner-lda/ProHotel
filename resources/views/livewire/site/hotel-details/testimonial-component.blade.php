<div id='container-xxl'  class="container-xxl py-5">
    <style>
        @media (max-width: 800px) {
            #testimonials-box {
                display: flex !important;
                flex-direction: column !important;
                justify-content: center !important;
            }

            .col-md-3 {

            }

        }

        #container-xxl{
            margin-bottom: 15rem !important;
        }
    </style>
    <div class="container-fluid">
        <div class="text-center " >
            <h6 class="section-title text-center text-primary text-uppercase">Depoimentos</h6>
            <h6 class="mb-5">Depoimentos <span class="text-primary">de Clientes</span></h6>
        </div>


        <div id='testimonials-box' class='d-flex align-items-start justify-content-center flex-wrap gap-2 col-md-12'>
            @if (isset($allTestimonials) and count($allTestimonials) > 0)
                @foreach ($allTestimonials as $testimonial)
                    <div class='col-md-4'>
                        <div class="card text-bg-primary" >
                            <div class="card-header border-0 bg-white"></div>
                            <div class="card-body">
                            <p class="card-text">{{ $testimonial->text }}</p>

                            <div class='d-flex justify-content-end gap-2 align-items-start'>
                                <h6 class='text-uppercase'></h6>
                                @for ($i = 1; $i <= $testimonial->star_quantity; $i++)
                                    <i class="fa fa-star fa-1 text-primary "></i>
                                @endfor
                            </div>

                            </div>
                        </div>

                    </div>
                @endforeach
                @else
                    <div class='w-100 col-md-12 alert alert-warning text-center'>Nenhum registo encontrado!</div>
            @endif

        </div>

    </div>

 </div>









 <!--

 <div  wire:ignore.self class=" testimonial my-5 py-5 bg-dark">
  <x-site.modal-form-add-testimonial :allAvailableHotelsInAngola="$allAvailableHotelsInAngola" />

  <div style='height:15rem !important;' class="container">
        <style>
            .stars:hover
             {
                color: #FEA116 !important;
                cursor: pointer !important;
            }

            #testimonial-div {
                display: flex !important;
                margin-bottom: 10rem !important;
            }
          </style>



             <div class='col-md-10 d-flex align-iems-center  justify-content-start'>
                @if (auth()->check() and auth()->user()->profile == 'guest')
                    <button  class='btn btn-primary d-flex text-capitalize align-items-center' data-bs-target='#form-add-testimonial' data-bs-toggle='modal'>
                        <i class="fa-solid fa-plus"></i>
                        <span>Adicionrar depoimento</span>
                    </button>
                @endif
            </div>

            <div id='testimonial-div' class="col-md-12 bg-danger flex-wrap justify-content-start  d-flex align-items-center gap-3 py-5">

                    @if (isset($allTestimonials) and count($allTestimonials) > 0)
                        @foreach ($allTestimonials as $testimonial)
                            <div class="card p-2  col-md-3 rounded bg-white rounded ">
                                <p class='fw-bold'>{{ $testimonial->text ?? '' }}</p>
                                <div class="d-flex align-items-center">
                                    <img class="img-fluid flex-shrink-0 rounded-pill" src="{{ ('/site/img/user-without-photo.png') }}" style="width: 45px; height: 45px;" />
                                    <div class="ps-3">
                                        {{-- <h6 class="fw-bold mb-1">{{ $testimonial->user->personaldata->firstname ?? ''.' '.$testimonial->user->personaldata->lastname ?? '' }}</h6> --}}
                                        <small></small>
                                    </div>
                                </div>

                                <div class='d-flex justify-content-end gap-2 align-items-start'>
                                    <h6 class='text-uppercase'>{{ $testimonial->hotel->companyname ?? '' }}:</h6>
                                    @for ($i = 1; $i <= $testimonial->star_quantity; $i++)
                                        <i class="fa fa-star fa-1 text-primary "></i>
                                    @endfor
                                </div>

                            </div>
                        @endforeach
                    @endif


            </div>

    </div>
</div>

-->
