
<div>
    @section("title" , "Dashboard | Recepção")
        <div class="container-scroller">
         <livewire:admin.top-bar-component />
          <div class="container-fluid page-body-wrapper">
            <x-reception.side-bar />
            <div class="main-panel">
              <div class="content-wrapper">
                <x-reception.stats :availableRooms='$availableRooms' :occupiedRooms='$occupiedRooms' :reservationsCounter='$reservationsCounter' :roomsCounter='$roomsCounter' :testimonialsCounter='$testimonialsCounter' />
                <x-admin.footer />
              </div>
            </div>
          </div>
