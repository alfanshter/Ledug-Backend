@extends('layout.master')


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