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
                          var map = L.map('map').setView([latitude, longitude], 15);
                          //tampilkan marker
                           //get marker
                                $.ajax({
                                    type: "GET",
                                    url: "{{route('desaterdekat')}}",
                                    data: {latitude: latitude,longitude:longitude},
                                    cache: false,
                                    success: function (response) {
                                        $.each(response, function (id, lokasi) {
                                            var marker = L.marker([lokasi['latitude'], lokasi['longitude']]).addTo(map);
                                              marker.bindPopup(lokasi['desa']['name']).openPopup();
                                        })

                                    },
                                    error: function (data) {
                                        console.log('error',data);
                                      }
                                });
                            
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '© OpenStreetMap'
                        }).addTo(map);

                    }
                    
                  
                </script>
@endsection