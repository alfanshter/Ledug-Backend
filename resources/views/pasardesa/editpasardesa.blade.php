@extends('layout.master')

@section('konten')
<h2>Edit pasardesa</h2>

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
  <form action="/pasardesa/update" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="oldImage" value="{{$pasardesa->foto}}">
      <input type="hidden" name="id" id="id" value="{{$pasardesa->id}}">
      <div class="mb-3">
      <label for="recipient-name" class="col-form-label">Judul:</label>
      <input type="text" class="form-control" id="judul" required name="judul" value="{{old('judul',$pasardesa->judul)}}">
      </div>

      <div class="mb-3">
      <label for="recipient-name" class="col-form-label  d-block">foto:</label>
        @if ($pasardesa->foto)
        <img class="img-preview img-fluid" src="{{asset('storage/'.$pasardesa->foto)}}" style="width: 200px; height:200px">
        @else
        <img class="img-preview img-fluid">            
        @endif
      <input type="file" class="form-control" id="foto"  name="foto" value="{{old('foto')}}" onchange="previewImage()">
      <script>
        function previewImage(){
            const  image = document.querySelector('#foto');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(foto.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;            
            }

        }

      </script>
      </div>
      <div class="mb-3">
      <label for="recipient-name" class="col-form-label">Narasi:</label>
      <input type="text" class="form-control" id="narasi" required name="narasi" value="{{old('narasi',$pasardesa->narasi)}}">
      </div>

      <div class="mb-3">
        <label for="recipient-name" class="col-form-label">Link:</label>
        <input type="text" class="form-control" id="link" required name="link" value="{{old('link',$pasardesa->link)}}">
        </div>


      <div class="modal-footer">
      <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
      <button type="submit" class="btn btn-primary">Edit</button>

      </div>
  </form>

@endsection
