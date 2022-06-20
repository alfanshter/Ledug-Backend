@extends('layout.master')
@section('style')
        <!-- LEAFLET MAPS -->

    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
   integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
   crossorigin=""/>

    {{--<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
      integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
      crossorigin=""/>
      <link rel="stylesheet" href="https://labs.easyblog.it/maps/leaflet-search/src/leaflet-search.css">--}}

@endsection

@push('scripts')
     <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
   integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
   crossorigin=""></script>
@endpush


@section('konten')

    
                <div id="map" style="height: 500px"></div>
                <script>

                    $(document).ready(function() {
                        navigator.geolocation.getCurrentPosition(function (position) {
                            tampilLokasi(position);
                        }, function (e) {
                            alert('Geolocation Tidak Mendukung Pada Browser Anda');
                        }, {
                            enableHighAccuracy: true
                        });
                    });

                        
                    //tampilkan lokasi
                    function tampilLokasi(posisi) {
                        //console.log(posisi);
                        var latitude 	= posisi.coords.latitude;
                        var longitude 	= posisi.coords.longitude;

                        $('#lokasi').html(latitude);

                        //tampilkan map
                          var map = L.map('map').setView([{{$desa->latitude}}, {{$desa->longitude}}], 15);
                            var marker = L.marker([{{$desa->latitude}}, {{$desa->longitude}}]).addTo(map);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '© OpenStreetMap'
                        }).addTo(map);
                         var desa = {!! json_encode($desa->toArray()) !!};
 
                        marker.bindPopup(desa['desa']['name']).openPopup();
                        circle.bindPopup("I am a circle.");
                        polygon.bindPopup("I am a polygon.");

              
                    }
                    
                  
                </script>
@endsection