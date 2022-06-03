@extends('layout.master')

@section('konten')
<h2>Edit Admin</h2>

@error('name')
<div class="alert alert-danger mt-2" role="alert">
    {{$message}}  
</div>                        
@enderror
@error('username')
<div class="alert alert-danger mt-2" role="alert">
    {{$message}}  
</div>                        
@enderror
<form action="/admin/updateadmin" method="POST">
    @csrf
    <input type="hidden" name="id" id="id" value="{{$dataadmin->id}}">
  <div class="mb-3">
    <label for="recipient-name" class="col-form-label">Nama:</label>
    <input type="text" class="form-control" id="name" name="name" value="{{old('name',$dataadmin->name)}}" required>
  </div>

  <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Provinsi:</label>
                                        <select name="province_id" id="provinsi" class="form-control">
                                            <option value="{{$dataadmin->provinsi->id}}">{{$dataadmin->provinsi->name}}</option>
                                            @foreach ($provinces as $provinsi)
                                            <option value="{{$provinsi->id}}">{{$provinsi->name}}</option>                                                
                                            @endforeach

                                        </select>
                                      </div>

                                      <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Kabupaten/Kota:</label>
                                        <select name="regencie_id" id="kabupaten" class="form-control">
                                            <option value="{{$dataadmin->kabupaten->id}}">{{$dataadmin->kabupaten->name}}</option>
                                        </select>
                                      </div>

                                      <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Kecamatan:</label>
                                        <select name="district_id" id="kecamatan" class="form-control">
                                            <option value="{{$dataadmin->kecamatan->id}}">{{$dataadmin->kecamatan->name}}</option>
                                        </select>
                                      </div>

                                      <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Desa:</label>
                                        <select name="village_id" id="desa" class="form-control">
                                            <option value="{{$dataadmin->desa->id}}">{{$dataadmin->desa->name}}</option>
                                        </select>
                                      </div>
  <div class="mb-3">
    <label for="recipient-name" class="col-form-label">Password:</label>
    <input type="password" class="form-control" id="password" name="password" value="{{old('password')}}">
  </div>

  <div class="mb-3">
    <label for="recipient-name" class="col-form-label">Email:</label>
    <input type="text" class="form-control" id="email" name="email" value="{{old('email',$dataadmin->email)}}" required>
  </div>

  

  <div class="modal-footer">
    <button type="submit" class="btn btn-primary">Update</button>

</div>
</form>

     <script>
                        $(function () {
                            $.ajaxSetup({
                                headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')}
                            })
                          })
                        
                        $(function () {
                            $('#provinsi').on('change',function () {
                                let id_provinsi = $('#provinsi').val();

                                $.ajax({
                                    // type: "POST",
                                    method: 'POST',
                                    url: "{{route('getkabupaten_on')}}",
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
                                    url: "{{route('getkecamatan_on')}}",
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
                                    url: "{{route('getdesa_on')}}",
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
