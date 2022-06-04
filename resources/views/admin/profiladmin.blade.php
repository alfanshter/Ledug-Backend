@extends('layout.master')

@section('konten')
<h2>Profil</h2>

@error('name')
<div class="alert alert-danger mt-2" role="alert">
    {{$message}}  
</div>                        
@enderror
@error('email')
<div class="alert alert-danger mt-2" role="alert">
    {{$message}}  
</div>                        
@enderror

 @if (session()->has('success'))
                        <div class="alert alert-success mt-2" role="alert">
                            {{session('success')}}  
                        </div>
                    @endif
  <form action="/edit_profil_admin" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="oldImage" value="{{$profil->foto}}">
      <input type="hidden" name="id" id="id" value="{{$profil->id}}">
     
      <div class="mb-3">
      <label for="recipient-name" class="col-form-label">Nama:</label>
      <input type="text" class="form-control" id="name" required name="name" value="{{old('name',$profil->name)}}">
      </div>

      <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Email:</label>
        <input type="text" class="form-control" id="email" required name="email" value="{{old('email',$profil->email)}}">
        </div>

         <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Password:</label>
        <input type="password" class="form-control" id="password"  name="password">
        </div>


      <div class="modal-footer">
      <button type="submit" class="btn btn-primary">Edit</button>

      </div>
  </form>

@endsection
