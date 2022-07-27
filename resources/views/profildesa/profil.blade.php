@extends('layout.master')

@section('konten')
<h2>Edit profil</h2>

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

                    @if (session()->has('success'))
                        <div class="alert alert-success mt-2" role="alert">
                            {{session('success')}}  
                        </div>
                    @endif

  <form action="/update_profildesa" method="POST" enctype="multipart/form-data">
      @csrf
                          <input type="hidden" name="province_id" value="{{auth()->user()->province_id}}">
                    <input type="hidden" name="regencie_id" value="{{auth()->user()->regencie_id}}">
                    <input type="hidden" name="district_id" value="{{auth()->user()->district_id}}">
                    <input type="hidden" name="village_id" value="{{auth()->user()->village_id}}">

      {{--<input type="hidden" name="id" id="id" value="{{$profil->id}}">--}}
      
      <div class="mb-3">
      <label for="recipient-name" class="col-form-label">Kecamatan:</label>
      <input type="text" class="form-control" id="kecamatan" required name="kecamatan" disabled value="{{auth()->user()->kecamatan->name}}" >
      </div>

            <div class="mb-3">
      <label for="recipient-name" class="col-form-label">Desa:</label>
      <input type="text" class="form-control" id="desa" required name="desa" disabled value="{{auth()->user()->desa->name}}" >
      </div>

      @if ($profil ==null)
        <div class="mb-3">
        <label for="recipient-name" class="col-form-label">kepala Desa:</label>
        <input type="text" class="form-control" id="kepala_desa" required name="kepala_desa" >
        </div>          
        <div class="mb-3">
        <label for="recipient-name" class="col-form-label">sekretaris_desa:</label>
        <input type="text" class="form-control" id="sekretaris_desa" required name="sekretaris_desa" >
        </div>
        <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Alamat : </label>
        <input type="text" class="form-control" id="alamat" required name="alamat" >
        </div>

         <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Deskripsi : </label>
        <input type="text" class="form-control" id="deskripsi" required name="deskripsi"  >
        </div>


      @else
        <div class="mb-3">
        <label for="recipient-name" class="col-form-label">kepala Desa:</label>
        <input type="text" class="form-control" id="kepala_desa" required name="kepala_desa" value="{{$profil->kepala_desa}}" >
        </div>          
        <div class="mb-3">
        <label for="recipient-name" class="col-form-label">sekretaris_desa:</label>
        <input type="text" class="form-control" id="sekretaris_desa" required name="sekretaris_desa" value="{{$profil->sekretaris_desa}}" >
        </div>

        <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Alamat : </label>
        <input type="text" class="form-control" id="alamat" required name="alamat" value="{{$profil->alamat}}" >
        </div>

        <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Deskripsi : </label>
        <input type="text" class="form-control" id="deskripsi" required name="deskripsi" value="{{$profil->deskripsi}}" >
        </div>

      @endif



      <div class="modal-footer">
      <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
      <button type="submit" class="btn btn-primary">Edit</button>

      </div>
  </form>

@endsection
