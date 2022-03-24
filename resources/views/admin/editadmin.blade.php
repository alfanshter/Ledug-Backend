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
    <label for="recipient-name" class="col-form-label">Password:</label>
    <input type="password" class="form-control" id="password" name="password" value="{{old('password')}}">
  </div>

  <div class="mb-3">
    <label for="recipient-name" class="col-form-label">Username:</label>
    <input type="text" class="form-control" id="email" name="email" value="{{old('email',$dataadmin->email)}}" required>
  </div>

  <div class="modal-footer">
    <button type="submit" class="btn btn-primary">Update</button>

</div>
</form> 
@endsection
