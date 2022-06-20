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

<script>
    $(document).ready(function() {
        navigator.geolocation.getCurrentPosition(function(position) {
            tampilLokasi(position);
        }, function(e) {
            alert('Geolocation Tidak Mendukung Pada Browser Anda');
        }, {
            enableHighAccuracy: true
        });
    });


    //tampilkan lokasi
      //tampilkan lokasi
    function tampilLokasi(posisi) {
        //console.log(posisi);
        var latitude = posisi.coords.latitude;
        var longitude = posisi.coords.longitude;

        //tampilkan map
        var map = L.map('map').setView([latitude, longitude], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var theMarker = {};
        map.on('click', function(e) {

            document.getElementById("latitude").value = e.latlng.lat;
            document.getElementById("longitude").value = e.latlng.lng;

            if (theMarker != undefined) {
                map.removeLayer(theMarker);
            };

            //Add a marker to show where you clicked.
            theMarker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);

        });


        L.Control.geocoder().addTo(map);
        var searchControl = new L.Control.Search({
            layer: theMarker,
            propertyName: 'Name',
            circleLocation: true
        });
        searchControl.on('search_locationfound', function(e) {
            e.layer.openPopup().openOn(map);
            map.setZoom(16);
        });
        map.addControl(searchControl);
        circle.bindPopup("I am a circle.");
        polygon.bindPopup("I am a polygon.");


    }
</script>
@endpush

@section('konten')


<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">budaya lokal</h1>
<button class="btn btn-primary" data-toggle="modal" data-target="#tambahsiswa">Tambah budaya lokal</button>
@if (session()->has('success'))
<div class="alert alert-success mt-2" role="alert">
    {{session('success')}}
</div>
@endif

@error('judul')
<div class="alert alert-danger mt-2" role="alert">
    {{$message}}
</div>
@enderror

@error('foto')
<div class="alert alert-danger mt-2" role="alert">
    {{$message}}
</div>
@enderror

@error('narasi')
<div class="alert alert-danger mt-2" role="alert">
    {{$message}}
</div>
@enderror
<x:notify-messages />


<!-- Tambah Modal-->
<div class="modal fade" id="tambahsiswa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah budaya lokal?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/tambah_kegiatandesa" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="village_id" value="{{auth()->user()->village_id}}">

                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Kegiatan Desa:</label>
                        <input type="text" class="form-control" id="kegiatan_desa" required name="kegiatan_desa" value="{{old('kegiatan_desa')}}">
                    </div>

                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Nama Kegiatan:</label>
                        <input type="text" class="form-control" id="nama_kegiatan" required name="nama_kegiatan" value="{{old('nama_kegiatan')}}">
                    </div>

                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Tanggal:</label>
                        <input type="date" class="form-control" id="tanggal" required name="tanggal" value="{{old('tanggal')}}">
                    </div>

                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Jam:</label>
                        <input type="time" class="form-control" id="jam" required name="jam" value="{{old('jam')}}">
                    </div>

                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Alamat:</label>
                        <input type="text" class="form-control" id="alamat" required name="alamat" value="{{old('alamat')}}">
                    </div>

 <div class="form-group">
        <input type="text" name="" id="textsearch" placeholder="search place here..." class="form-control">
    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Tekan lokasi tujuan:</label>
                        <div id="map" style="height: 300px"></div>
                    </div>

                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Latitude:</label>
                        <input type="text" class="form-control" id="latitude" required name="latitude" readonly value="{{old('latitude')}}">
                    </div>

                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Longitude:</label>
                        <input type="text" class="form-control" id="longitude" required name="longitude" readonly value="{{old('longitude')}}">
                    </div>



                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>

                    </div>
                </form>
            </div>


        </div>
    </div>
</div>
<!-- DataTales Example -->
<div class="card shadow mb-4 mt-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data kegiatandesa</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kegiatan Desa</th>
                        <th>Nama Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Alamat</th>
                        <th>Cek Maps</th>
                        <th class="align-middle text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kegiatandesa as $data)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$data->kegiatan_desa}}</td>
                        <td>{{$data->nama_kegiatan}}</td>
                        <td>{{$data->tanggal}}</td>
                        <td>{{$data->jam}}</td>
                        <td>{{$data->alamat}}</td>
                        <td>
                            <form id="myForm/{{$data->id}}" action="/cek_lokasi" method="post">
                                @csrf
                                <input type="hidden" name="latitude" value="{{$data->latitude}}" />
                                <input type="hidden" name="longitude" value="{{$data->longitude}}" />
                                <a href="#" onclick="document.getElementById('myForm/{{$data->id}}').submit();">Cek Lokasi</a>
                            </form>
                        </td>
                        <td class="align-middle text-center">
                            <div class="d-flex justify-content-sm-center mt-2">

                                <form action="/delete_kegiatandesa" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$data->id}}" id="id">
                                    <button class="btn btn-danger ml-2" onclick="return confirm('Apakah anda akan menghapus data ?')">Hapus</button>
                                </form>
                                <button type="button" data-toggle="modal" data-target="#editkegiatandesa{{$data->id}}" class="btn btn-warning ml-2">Edit</button>
                                <!-- Edit Modal-->
                                <div class="modal fade" id="editkegiatandesa{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Update kegiatandesa?</h5>
                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="/update_kegiatandesa" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$data->id}}">
                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">Kegiatan Desa:</label>
                                                        <input type="text" class="form-control" id="kegiatan_desa" required name="kegiatan_desa" value="{{old('kegiatan_desa',$data->kegiatan_desa)}}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">Nama Kegiatan:</label>
                                                        <input type="text" class="form-control" id="nama_kegiatan" required name="nama_kegiatan" value="{{old('nama_kegiatan',$data->nama_kegiatan)}}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">Tanggal:</label>
                                                        <input type="date" class="form-control" id="tanggal" required name="tanggal" value="{{old('tanggal',$data->tanggal)}}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">Jam:</label>
                                                        <input type="time" class="form-control" id="jam" required name="jam" value="{{old('jam',$data->jam)}}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">Alamat:</label>
                                                        <input type="text" class="form-control" id="alamat" required name="alamat" value="{{old('alamat',$data->alamat)}}">
                                                    </div>


                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">Tekan lokasi tujuan:</label>
                                                        <div id="pilih_lokasi{{$data->id}}" style="height: 300px"></div>
                                                        <script>

                                                            
                                                            $(document).ready(function() {
                                                                navigator.geolocation.getCurrentPosition(function(position) {
                                                                    pilih_lokasi(position,{{$data->id}});
                                                                }, function(e) {
                                                                    alert('Geolocation Tidak Mendukung Pada Browser Anda');
                                                                }, {
                                                                    enableHighAccuracy: true
                                                                });


                                                            });

                                                            function pilih_lokasi(posisi, id) {
                                                                var latitude = posisi.coords.latitude;
                                                                var longitude = posisi.coords.longitude;
                                                                var datalokasi = 'pilih_lokasi' + id;
                                                                console.log(datalokasi);
                                                                //pilih lokasi
                                                                var pilih_lokasi = L.map(datalokasi).setView([latitude, longitude], 15);

                                                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                                                    maxZoom: 19,
                                                                    attribution: '© OpenStreetMap'
                                                                }).addTo(pilih_lokasi);
                                                                //end pilih lokasi
                                                                var theMarker2 = {};


                                                                pilih_lokasi.on('click', function(e) {

                                                                    document.getElementById("latitude_edit").value = e.latlng.lat;
                                                                    document.getElementById("longitude_edit").value = e.latlng.lng;

                                                                    if (theMarker2 != undefined) {
                                                                        pilih_lokasi.removeLayer(theMarker2);
                                                                    };

                                                                    //Add a marker to show where you clicked.
                                                                    theMarker2 = L.marker([e.latlng.lat, e.latlng.lng]).addTo(pilih_lokasi);

                                                                });



                                                                    L.Control.geocoder().addTo(pilih_lokasi);
                                                                    var searchControl = new L.Control.Search({
                                                                        layer: theMarker2,
                                                                        propertyName: 'Name',
                                                                        circleLocation: true
                                                                    });
                                                                    searchControl.on('search_locationfound', function(e) {
                                                                        e.layer.openPopup().openOn(pilih_lokasi);
                                                                        pilih_lokasi.setZoom(16);
                                                                    });
                                                                    pilih_lokasi.addControl(searchControl);
                                                            }
                                                        </script>
                                                    </div>

                                                         <div class="mb-3">
                                                            <label for="recipient-name" class="col-form-label">Latitude:</label>
                                                            <input type="text" class="form-control" id="latitude_edit" required name="latitude" readonly value="{{$data->latitude}}">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="recipient-name" class="col-form-label">Longitude:</label>
                                                            <input type="text" class="form-control" id="longitude_edit" required name="longitude" readonly value="{{$data->longitude}}">
                                                        </div>



                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>

                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection