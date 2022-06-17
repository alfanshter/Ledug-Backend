@extends('layout.master')


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
                <form action="/tambah_budaya_lokal" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="village_id" value="{{auth()->user()->village_id}}">

                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Cagar Budaya:</label>
                        <input type="text" class="form-control" id="cagar_budaya" required name="cagar_budaya" value="{{old('cagar_budaya')}}">
                    </div>

                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">judul:</label>
                        <input type="text" class="form-control" id="judul" required name="judul" value="{{old('judul')}}">
                    </div>

                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Tanggal Terbit:</label>
                        <input type="date" class="form-control" id="tanggal_terbit" required name="tanggal_terbit" value="{{old('tanggal_terbit')}}">
                    </div>

                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Uraian:</label>
                        <input type="text" class="form-control" id="uraian" required name="uraian" value="{{old('uraian')}}">
                    </div>

                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">foto:</label>
                        <img class="img-preview img-fluid">
                        <input type="file" class="form-control" id="fotobudaya_lokal" required name="foto" value="{{old('foto')}}" onchange="previewImage()">
                        <script>
                            function previewImage() {
                                const image = document.querySelector('#fotobudaya_lokal');
                                const imgPreview = document.querySelector('.img-preview');

                                imgPreview.style.display = 'block';

                                const oFReader = new FileReader();
                                oFReader.readAsDataURL(fotobudaya_lokal.files[0]);

                                oFReader.onload = function(oFREvent) {
                                    imgPreview.src = oFREvent.target.result;
                                }

                            }
                        </script>
                    </div>

                    <div class="mb-3"  id="video" >
                                        <label for="recipient-name" class="col-form-label">Video:</label>
                                        <img class="img-preview-edit img-fluid">
                                        <input type="file" class="form-control" id="video" required name="video" value="{{old('video')}}">
                                       
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
        <h6 class="m-0 font-weight-bold text-primary">Data budaya_lokal</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Cagar Budaya</th>
                        <th>Judul</th>
                        <th>Uraian</th>
                        <th>Foto</th>
                        <th>Video</th>
                        <th>Tanggal Terbit</th>
                        <th>Tanggal Buat</th>
                        <th class="align-middle text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($budaya_lokal as $data)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$data->cagar_budaya}}</td>
                        <td>{{$data->judul}}</td>
                        <td>{{$data->uraian}}</td>
                        <td>
                            <div>
                                <img style="height: 200px; width:200px" src="{{asset('storage/'. $data->foto)}}" alt="">
                            </div>
                        </td>
                         @if (pathinfo($data->video, PATHINFO_EXTENSION) == 'mp4' )
                                            <td><a href="/storage/{{$data->video}}">Cek Video lokal</a></td>    
                                            @else
                                            <td><a href="{{$data->video}}">Cek Video Youtube</a></td>                                            
                        @endif
                        <td>{{$data->tanggal_terbit}}</td>
                        <td>{{\Carbon\Carbon::parse($data->created_at)->format('d-m-Y'); }}</td>
                        <td class="align-middle text-center">
                            <div class="d-flex justify-content-sm-center mt-2">

                                <form action="/delete_budaya_lokal" method="post">
                                    @csrf
                                    <input type="hidden" name="foto" value="{{$data->foto}}" id="foto">
                                    <input type="hidden" name="id" value="{{$data->id}}" id="id">
                                    <button class="btn btn-danger ml-2" onclick="return confirm('Apakah anda akan menghapus data ?')">Hapus</button>
                                </form>
                                <button type="button" data-toggle="modal" data-target="#editbudaya_lokal{{$data->id}}"  class="btn btn-warning ml-2">Edit</button>
                                <!-- Edit Modal-->
                                <div class="modal fade" id="editbudaya_lokal{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Update budaya_lokal?</h5>
                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="/update_budaya_lokal_admin" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="oldImage" value="{{$data->foto}}">
                                                    <input type="hidden" name="id" value="{{$data->id}}">
                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">judul:</label>
                                                        <input type="text" class="form-control" id="judul" required name="judul" value="{{old('judul',$data->judul)}}">
                                                    </div>

                                                     <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">Deskripsi:</label>
                                                        <input type="text" class="form-control" id="deskripsi" required name="deskripsi" value="{{old('deskripsi',$data->deskripsi)}}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">Link:</label>
                                                        <input type="text" class="form-control" id="link" required name="link" value="{{old('link',$data->link)}}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">foto:</label>
                                                        <br>
                                                        @if ($data->foto)
                                                            <img class="img-preview-edit img-fluid" src="{{asset('storage/'.$data->foto)}}" style="width: 200px; height:200px">
                                                            @else
                                                            <img class="img-preview-edit img-fluid">            
                                                            @endif
                                                        <input type="file" class="form-control" id="editbudaya_lokal"  name="foto" value="{{old('foto')}}" onchange="budaya_lokalEdit()">
                                                        <script>
                                                            function budaya_lokalEdit(){
                                                                const  image = document.querySelector('#editbudaya_lokal');
                                                                const imgPreviewEdit = document.querySelector('.img-preview-edit');

                                                                imgPreviewEdit.style.display = 'block';

                                                                const oFReader = new FileReader();
                                                                oFReader.readAsDataURL(image.files[0]);

                                                                oFReader.onload = function(oFREvent) {
                                                                    imgPreviewEdit.src = oFREvent.target.result;            
                                                                }

                                                            }

                                                        </script>
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