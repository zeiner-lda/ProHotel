
<x-layout.app>

<div class="col-md-6 stretch-card grid-margin">
    <div class="card bg-gradient-info card-img-holder text-white">
      <div class="card-body">
        <img src="{{ asset('/dashboard/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
        <h4 class="font-weight-normal mb-3 text-uppercase">Utilizadores<i class="mdi mdi-bookmark-outline mdi-24px float-end"></i>
        </h4>
        <h2 class="mb-5">{{ !is_null($userCounter) ? $userCounter : 0 }}</h2>

      </div>
    </div>
  </div>

</x-layout.app>


