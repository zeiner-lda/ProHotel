@section('title' , 'ProHotel')

<div class="bg-white p-0">
    <x-site.spinner-component />
    <livewire:site.home.navbar-component />
    <x-site.carousel-component />
    <livewire:site.available-hotels-in-angola.hotel-component   />
    <x-site.footer-component  />
</div>
