@extends('layout.master')


@section('konten')


<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">pelatihan</h1>
<button class="btn btn-primary" data-toggle="modal" data-target="#tambahsiswa">Tambah pelatihan</button>
@if (session()->has('success'))
<div class="alert alert-success mt-2" role="alert">
    {{session('success')}}
</div>
@endif

@error('foto')
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah pelatihan?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/tambah_pelatihan" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="village_id" value="{{auth()->user()->village_id}}">

                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Judul:</label>
                        <input type="text" class="form-control" id="judul" required name="judul" value="{{old('judul')}}">
                    </div>

                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Deskripsi:</label>
                        <input type="text" class="form-control" id="deskripsi" required name="deskripsi" value="{{old('deskripsi')}}">
                    </div>

                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Nara Sumber:</label>
                        <input type="text" class="form-control" id="nara_sumber" required name="nara_sumber" value="{{old('nara_sumber')}}">
                    </div>

                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Lokasi Kegiatan:</label>
                        <input type="text" class="form-control" id="lokasi_kegiatan" required name="lokasi_kegiatan" value="{{old('lokasi_kegiatan')}}">
                    </div>

                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Tanggal:</label>
                        <input type="date" class="form-control" id="tanggal" required name="tanggal" value="{{old('tanggal')}}">
                    </div>

                    <div class="mb-3" id="foto">
                        <label for="recipient-name" class="col-form-label">foto:</label>
                        <img class="img-preview-edit img-fluid">
                        <input type="file" class="form-control" id="foto" required name="foto" value="{{old('foto')}}" onchange="previewpelatihan()">

                    </div>

                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Video:</label>
                        <select id="list_video" class="form-control">
                            <option value="">Pilih ...</option>
                            <option value="Link">Link Youtube</option>
                            <option value="Video">Upload File Local</option>

                        </select>
                    </div>

                    <div class="mb-3" id="video" style="display:none">
                        <label for="recipient-name" class="col-form-label">Video:</label>
                        <img class="img-preview-edit img-fluid">
                        <input type="file" class="form-control" id="data_video" required name="video" value="{{old('video')}}">

                    </div>

                    <div class="mb-3" id="link" style="display:none">
                        <label for="recipient-name" class="col-form-label">Link:</label>
                        <input type="text" class="form-control" id="data_link" required name="link" value="{{old('link')}}">
                    </div>

                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Kontak Person:</label>
                        <input type="text" class="form-control" id="kontak_person" required name="kontak_person" value="{{old('kontak_person')}}">
                    </div>

                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Link Pendaftaran:</label>
                        <input type="text" class="form-control" id="link_pendaftaran" required name="link_pendaftaran" value="{{old('link_pendaftaran')}}">
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
        <h6 class="m-0 font-weight-bold text-primary">Data pelatihan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Nara Sumber</th>
                        <th>Lokasi Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Foto</th>
                        <th>Video</th>
                        <th>Kontak Person</th>
                        <th>Link Pendaftaran</th>
                        <th>Desa</th>
                        <th class="align-middle text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pelatihan as $data)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$data->judul}}</td>
                        <td>{{$data->deskripsi}}</td>
                        <td>{{$data->nara_sumber}}</td>
                        <td>{{$data->lokasi_kegiatan}}</td>
                        <td>{{$data->tanggal}}</td>
                        <td>
                            <a href="/storage/{{$data->foto}}">Cek Foto</a>
                        </td>
                        @if (pathinfo($data->video, PATHINFO_EXTENSION) == 'mp4' )
                        <td><a href="/storage/{{$data->video}}">Cek Video lokal</a></td>
                        @else
                        <td><a href="{{$data->video}}">Cek Video Youtube</a></td>
                        @endif
                        <td>{{$data->kontak_person}}</td>
                        <td>{{$data->link_pendaftaran}}</td>
                        <td>{{auth()->user()->desa->name}}</td>
                        <td class="align-middle text-center">
                            <div class="d-flex justify-content-sm-center mt-2">
                                <form action="/hapus_pelatihan" method="post">
                                    @csrf
                                    <input type="hidden" name="foto" value="{{$data->foto}}" id="foto">
                                    <input type="hidden" name="video" value="{{$data->video}}" id="video">
                                    <input type="hidden" name="id" value="{{$data->id}}" id="id">
                                    <button class="btn btn-danger ml-2" onclick="return confirm('Apakah anda akan menghapus data ?')">Hapus</button>
                                </form>
                                <button type="button" data-toggle="modal" data-target="#editpelatihan{{$data->id}}" class="btn btn-warning ml-2">Edit</button>
                                <!-- Edit Modal-->
                                <div class="modal fade" id="editpelatihan{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Update pelatihan?</h5>
                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="/update_pelatihan_admin" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="oldImage" value="{{$data->foto}}">
                                                    <input type="hidden" name="oldVideo" value="{{$data->video}}">
                                                    <input type="hidden" name="id" value="{{$data->id}}">
                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">Judul:</label>
                                                        <input type="text" class="form-control" id="judul" required name="judul" value="{{old('judul',$data->judul)}}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">Deskripsi:</label>
                                                        <input type="text" class="form-control" id="deskripsi" required name="deskripsi" value="{{old('deskripsi',$data->deskripsi)}}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">Nara Sumber:</label>
                                                        <input type="text" class="form-control" id="nara_sumber" required name="nara_sumber" value="{{old('nara_sumber',$data->nara_sumber)}}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">Lokasi Kegiatan:</label>
                                                        <input type="text" class="form-control" id="lokasi_kegiatan" required name="lokasi_kegiatan" value="{{old('lokasi_kegiatan',$data->lokasi_kegiatan)}}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">Tanggal:</label>
                                                        <input type="date" class="form-control" id="tanggal" required name="tanggal" value="{{old('tanggal',$data->tanggal)}}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">foto:</label>
                                                        <br>
                                                        @if ($data->foto)
                                                        <center>
                                                            <img class="img-preview-edit img-fluid" src="{{asset('storage/'.$data->foto)}}" style="width: 200px; height:200px">
                                                        </center>
                                                        @else
                                                        <img class="img-preview-edit img-fluid">
                                                        @endif
                                                        <input type="file" class="form-control" id="editpelatihan" name="foto" onchange="pelatihanEdit()">
                                                        <script>
                                                            function pelatihanEdit() {
                                                                const image = document.querySelector('#editpelatihan');
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


                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">Video:</label>
                                                        <select id="list_video_edit" class="form-control">
                                                            <option value="">Pilih ...</option>
                                                            <option value="Link">Link Youtube</option>
                                                            <option value="Video">Upload File Local</option>

                                                        </select>
                                                    </div>

                                                    <div class="mb-3" id="video_edit" style="display:none">
                                                        <label for="recipient-name" class="col-form-label">Video:</label>
                                                        <img class="video-preview-edit img-fluid">
                                                        <input type="file" class="form-control" id="data_video" name="video_edit">

                                                    </div>
                                                    <div class="mb-3" id="video_edit" style="display:none">
                                                        <label for="recipient-name" class="col-form-label">Video:</label>
                                                        <img class="video-preview-edit img-fluid">
                                                        <input type="file" class="form-control" id="data_video" name="video_edit">

                                                    </div>

                                                       <div class="mb-3" id="link_edit" style="display:none">
                                                        <label for="recipient-name" class="col-form-label">Link:</label>
                                                        <input type="text" class="form-control" id="data_link"  name="link_edit" >
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">Kontak Person:</label>
                                                        <input type="text" class="form-control" id="kontak_person" required name="kontak_person" value="{{old('kontak_person',$data->kontak_person)}}">
                                                    </div>
                                                      
                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">Link Pendaftaran:</label>
                                                        <input type="text" class="form-control" id="link_pendaftaran" required name="link_pendaftaran" value="{{old('link_pendaftaran',$data->link_pendaftaran)}}">
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



<script>
    function previewpelatihan() {
        const image = document.querySelector('#foto');
        const imgPreviewpelatihan = document.querySelector('.img-preview-edit');

        imgPreviewpelatihan.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(foto.files[0]);

        oFReader.onload = function(oFREvent) {
            imgPreviewpelatihan.src = oFREvent.target.result;
        }

    }

    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
    })

    $(function() {

        $('#list_video').change(function() {
            let list_video = $(this).val();
            if (list_video == 'Link') {
                document.getElementById('link').style.display = "contents";
                document.getElementById('video').style.display = "none"
                $("#data_video").val("");
                $('#data_link').attr('required', true);
                $('#data_video').attr('required', false);
            } else if (list_video == 'Video') {
                document.getElementById('video').style.display = "contents";
                document.getElementById('link').style.display = "none";
                $('#data_link').attr('required', false);
                $('#data_video').attr('required', true);
                $("#data_link").val("");

            }

        });

                  $('#list_video_edit').change(function() {
            let list_video = $(this).val();
            if (list_video == 'Link') {
                document.getElementById('link_edit').style.display = "contents";
                document.getElementById('video_edit').style.display = "none"
                $("#data_video_edit").val("");
                $('#data_link_edit').attr('required', true);
                $('#data_video_edit').attr('required', false);
            } else if (list_video == 'Video') {
                document.getElementById('video_edit').style.display = "contents";
                document.getElementById('link_edit').style.display = "none";
                $('#data_link_edit').attr('required', false);
                $('#data_video_edit').attr('required', true);
                $("#data_link_edit").val("");

            }

        });

    })

    
</script>
@endsection