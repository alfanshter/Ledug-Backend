@extends('layout.master')
@section('style')
        <!-- LEAFLET MAPS -->

    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
   integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
   crossorigin=""/>



@endsection

@push('scripts')
 <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
   integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
   crossorigin=""></script>    


 {{--<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
          integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
          crossorigin="">
      </script>
 <script src="https://labs.easyblog.it/maps/leaflet-search/src/leaflet-search.js"></script>--}}


     <script>
                    $(document).ready(function() {
                            tampilLokasi();
                    });
                    //tampilkan lokasi
                    function tampilLokasi() {
                        //console.log(posisi);
                        var latitude 	= {{$latitude}};
                        var longitude 	= {{$longitude}};

                        //tampilkan map
                          var map = L.map('map').setView([latitude, longitude], 15);
                            var marker = L.marker([latitude, longitude]).addTo(map);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '© OpenStreetMap'
                        }).addTo(map);
 
                        marker.bindPopup('Lokasi').openPopup();
                        circle.bindPopup("I am a circle.");
                        polygon.bindPopup("I am a polygon.");

              
                    }
                    
                  
                </script>
@endpush
@section('konten')

    
                <div id="map" style="height: 500px"></div>
           
@endsection