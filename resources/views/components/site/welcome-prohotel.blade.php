<x-layout.app>
    <div id="welcome" class="container-xxl py-5 mt-5">
        <h6 class="section-title text-start text-primary text-uppercase">Sobre nós</h6>
        <h1 class="mb-4">Seja bem vindo ao  <span class="text-primary text-uppercase"> {{$hotel->companyname ? $hotel->companyname : ''}} </span></h1>
        <h6 class="mb-4 fw-bold"> A excelência é nossa prioridade</h6>
    </div>
</x-layout.app>
