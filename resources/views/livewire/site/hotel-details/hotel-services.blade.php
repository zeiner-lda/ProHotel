@section('title', 'Detalhes do hotel')
<div>
<div class="bg-white p-0">
    <x-site.spinner-component />
    <x-site.welcome-prohotel :hotel='$hotel' :hotelId='$hotelId' />
    <!-- Header Start -->
    <livewire:site.home.navbar-component />
    <!-- Room component -->
    <livewire:site.hotel-details.room-component :hotelId='$hotelId' />
    <livewire:site.hotel-details.menu-hotel-component :hotelId='$hotelId' />
    <!-- Services component -->
    <livewire:site.hotel-details.service-component :hotelId='$hotelId' />
    <!-- Testimonials component -->
     <livewire:site.hotel-details.testimonial-component  :hotelId='$hotelId'  />
     <!-- Footer Start -->
    <x-site.footer-component  />

</div>
