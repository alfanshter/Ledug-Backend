@extends('layout.master')


@section('konten')

    
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">multidesa</h1>
                    @if (auth()->user()->role ==0)
                    <button class="btn btn-primary"  data-toggle="modal" data-target="#tambahsiswa">Tambah multidesa</button>                        
                    @endif
                    @if (session()->has('success'))
                        <div class="alert alert-success mt-2" role="alert">
                            {{session('success')}}  
                        </div>
                    @endif
                    
                    @error('provinsi_id')
                    <div class="alert alert-danger mt-2" role="alert">
                        {{$message}}  
                    </div>                        
                    @enderror

                    @error('kabupaten_id')
                    <div class="alert alert-danger mt-2" role="alert">
                        {{$message}}  
                    </div>                        
                    @enderror

                    @error('kecamatan_id')
                    <div class="alert alert-danger mt-2" role="alert">
                        {{$message}}  
                    </div>                        
                    @enderror

                    @error('desa_id')
                    <div class="alert alert-danger mt-2" role="alert">
                        {{$message}}  
                    </div>                        
                    @enderror

                    
                       <!-- Logout Modal-->
                       <div class="modal fade" id="tambahsiswa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                       aria-hidden="true">
                       <div class="modal-dialog" role="document">
                           <div class="modal-content">
                               <div class="modal-header">
                                   <h5 class="modal-title" id="exampleModalLabel">Tambah Multi Desa?</h5>
                                   <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                       <span aria-hidden="true">×</span>
                                   </button>
                               </div>
                               <div class="modal-body">
                                   <form action="/multidesa" method="POST" enctype="multipart/form-data">
                                           @csrf

                                     <div class="mb-3">
                                       <label for="recipient-name" class="col-form-label">Provinsi:</label>
                                       <select name="province_id" id="provinsi" class="form-control">
                                           <option value="">Pilih Provinsi...</option>
                                           @foreach ($provinces as $id => $name)
                                           <option value="{{ $id }}">{{ $name }}</option>
                                            @endforeach
                                       </select>
                                     </div>

                                     <div class="mb-3">
                                       <label for="recipient-name" class="col-form-label">Kabupaten/Kota:</label>
                                       <select name="kabupaten_id"  id="kabupaten" class="form-control">
                                        <option value="">Pilih Kota/Kabupaten...</option>
                                       </select>
                                     </div>

                                     <div class="mb-3">
                                       <label for="recipient-name" class="col-form-label">Kecamatan:</label>
                                       <select name="kecamatan_id" id="kecamatan" class="form-control">
                                           <option value="">Pilih Kecamatan...</option>
                                       </select>
                                     </div>

                                     <div class="mb-3">
                                       <label for="recipient-name" class="col-form-label">Desa:</label>
                                       <select name="desa_id" id="desa" class="form-control">
                                           <option value="">Pilih Desa...</option>
                                       </select>
                                     </div>

                                     <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Latitude:</label>
                                        <input type="text" class="form-control" id="latitude" required name="latitude" value="{{old('latitude')}}">
                                      </div>
 
                                        <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Longitude:</label>
                                        <input type="text" class="form-control" id="longitude" required name="longitude" value="{{old('longitude')}}">
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
                            <h6 class="m-0 font-weight-bold text-primary">Data multidesa</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Provinsi</th>
                                            <th>Kabupaten</th>
                                            <th>Kecamatan</th>
                                            <th>Desa</th>
                                            <th class="align-middle text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($multidesa as $data)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$data->provinsi}}</td>                                           
                                            <td>{{$data->kabupaten}}</td>                                           
                                            <td>{{$data->kecamatan}}</td>                                           
                                            <td>{{$data->desa}}</td>                                           
                                            <td class="align-middle text-center">
                                                <div class="d-flex justify-content-sm-center mt-2">
                                
                                                    <form action="/delete_multidesa" method="post">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$data->id}}" id="id">
                                                        <input type="hidden" name="province_id" value="{{$data->province_id}}">
                                                        <input type="hidden" name="kabupaten_id" value="{{$data->kabupaten_id}}">
                                                        <input type="hidden" name="kecamatan_id" value="{{$data->kecamatan_id}}">
                                                        <input type="hidden" name="desa_id" value="{{$data->desa_id}}">
                                                        <button class="btn btn-danger ml-2" onclick="return confirm('Apakah anda akan menghapus data ?')">Hapus</button>
                                                    </form>
                                                </div>
                                                </td>                                        

                                        </tr>
                                            
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    
                    <script>
                        $(function () {
                            $.ajaxSetup({
                                headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')}
                            })
                          })
                        
                        $(function () {
                            let datakabupaten ="";
                              $('#provinsi').on('change',function () {
                                let id_provinsi = $('#provinsi').val();

                                $.ajax({
                                    // type: "POST",
                                    method: 'POST',
                                    url: "{{route('getkabupaten')}}",
                                    data: {id_provinsi: id_provinsi},
                                    success: function (response) {
                                        $('#kabupaten').empty();
                                        $('#kabupaten').html('<option value="">Pilih Kabupaten</option>');
                                        $.each(response, function (id, name) {
                                            $('#kabupaten').append(new Option(name, id))

                                        })
                                    },
                                    error: function (data) {
                                        console.log('error',data);
                                      }
                                });
                              })
                              
                              $('#kabupaten').on('change',function () {
                                let id_kabupaten = $('#kabupaten').val();
                                $.ajax({
                                    type: "POST",
                                    url: "{{route('getkecamatan')}}",
                                    data: {id_kabupaten: id_kabupaten},
                                    success: function (response) {
                                        $('#kecamatan').empty();
                                        $('#kecamatan').html('<option value="">Pilih Kecamatan</option>');

                                        $.each(response, function (id, name) {
                                            $('#kecamatan').append(new Option(name, id))
                                        })
                                    },
                                    error: function (data) {
                                        console.log('error',data);
                                      }
                                });
                              })

                              $('#kecamatan').on('change',function () {
                                let id_kecamatan = $('#kecamatan').val();

                                $.ajax({
                                    type: "POST",
                                    url: "{{route('getdesa')}}",
                                    data: {id_kecamatan: id_kecamatan},
                                    cache: false,
                                    success: function (response) {
                                        $('#desa').empty();
                                        $('#desa').html('<option value="">Pilih Desa</option>');

                                        $.each(response, function (id, name) {
                                            $('#desa').append(new Option(name, id))
                                        })

                                    },
                                    error: function (data) {
                                        console.log('error',data);
                                      }
                                });
                              })
                          })
                    </script>
@endsection