@extends('layout.master')


@section('konten')


<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">gambardesa</h1>
<button class="btn btn-primary" data-toggle="modal" data-target="#tambahsiswa">Tambah gambardesa</button>
@if (session()->has('success'))
<div class="alert alert-success mt-2" role="alert">
    {{session('success')}}
</div>
@endif

@error('nama')
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


<!-- Tambah Modal-->
<div class="modal fade" id="tambahsiswa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah gambardesa?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/tambah_gambardesa" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="province_id" value="{{auth()->user()->province_id}}">
                    <input type="hidden" name="regencie_id" value="{{auth()->user()->regencie_id}}">
                    <input type="hidden" name="district_id" value="{{auth()->user()->district_id}}">
                    <input type="hidden" name="village_id" value="{{auth()->user()->village_id}}">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">nama:</label>
                        <input type="text" class="form-control" id="nama" required name="nama" value="{{old('nama')}}">
                    </div>


                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">foto:</label>
                        <img class="img-preview img-fluid">
                        <input type="file" class="form-control" id="fotogambardesa" required name="foto" value="{{old('foto')}}" onchange="previewImage()">
                        <script>
                            function previewImage() {
                                const image = document.querySelector('#fotogambardesa');
                                const imgPreview = document.querySelector('.img-preview');

                                imgPreview.style.display = 'block';

                                const oFReader = new FileReader();
                                oFReader.readAsDataURL(fotogambardesa.files[0]);

                                oFReader.onload = function(oFREvent) {
                                    imgPreview.src = oFREvent.target.result;
                                }

                            }
                        </script>
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
        <h6 class="m-0 font-weight-bold text-primary">Data gambardesa</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>nama</th>
                        <th>Kecamatan</th>
                        <th>Desa</th>
                        <th>Foto</th>
                        <th class="align-middle text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($gambardesa as $data)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$data->nama}}</td>
                        <td>{{auth()->user()->kecamatan->name}}</td>
                        <td>{{auth()->user()->desa->name}}</td>
                        <td>
                            <div>
                                <img style="height: 200px; width:200px" src="{{asset('storage/'. $data->foto)}}" alt="">
                            </div>
                        </td>
                        <td class="align-middle text-center">
                            <div class="d-flex justify-content-sm-center mt-2">

                                <form action="/hapusgambardesa_admin" method="post">
                                    @csrf
                                    <input type="hidden" name="foto" value="{{$data->foto}}" id="foto">
                                    <input type="hidden" name="id" value="{{$data->id}}" id="id">
                                    <button class="btn btn-danger ml-2" onclick="return confirm('Apakah anda akan menghapus data ?')">Hapus</button>
                                </form>
                                <button type="button" data-toggle="modal" data-target="#editgambardesa{{$data->id}}"  class="btn btn-warning ml-2">Edit</button>
                                <!-- Edit Modal-->
                                <div class="modal fade" id="editgambardesa{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Update gambardesa?</h5>
                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="/update_gambardesa_admin" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="oldImage" value="{{$data->foto}}">
                                                    <input type="hidden" name="id" value="{{$data->id}}">
                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">nama:</label>
                                                        <input type="text" class="form-control" id="nama" required name="nama" value="{{old('nama',$data->nama)}}">
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
                                                        <input type="file" class="form-control" id="editgambardesa"  name="foto" value="{{old('foto')}}" onchange="gambardesaEdit()">
                                                        <script>
                                                            function gambardesaEdit(){
                                                                const  image = document.querySelector('#editgambardesa');
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