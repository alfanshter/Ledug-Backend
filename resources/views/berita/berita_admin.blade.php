@extends('layout.master')


@section('konten')

    
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Berita</h1>
                    <button class="btn btn-primary"  data-toggle="modal" data-target="#tambahsiswa">Tambah Berita</button>                        
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

                    
                      <!-- Tambah Modal-->
                    <div class="modal fade" id="tambahsiswa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Berita?</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="/beritadesa" method="POST" enctype="multipart/form-data">
                                            @csrf
                                    <input type="hidden" name="province_id" value="{{auth()->user()->province_id}}">
                                    <input type="hidden" name="regencie_id" value="{{auth()->user()->regencie_id}}">
                                    <input type="hidden" name="district_id" value="{{auth()->user()->district_id}}">
                                    <input type="hidden" name="village_id" value="{{auth()->user()->village_id}}">

                                       <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Judul:</label>
                                        <input type="text" class="form-control" id="judul" required name="judul" value="{{old('judul')}}">
                                      </div>

                                      <div class="mb-3" id="foto">
                                        <label for="recipient-name" class="col-form-label">foto:</label>
                                        <img class="img-preview-edit img-fluid">
                                        <input type="file" class="form-control" id="foto" required name="foto" value="{{old('foto')}}" onchange="previewBerita()">
                                       
                                      </div>

                                       <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Video:</label>
                                        <select  id="list_video" class="form-control">
                                            <option value="">Pilih ...</option>
                                            <option value="Link">Link Youtube</option>                                                
                                            <option value="Video">Upload File Local</option>                                                

                                        </select>
                                      </div>

                                       <div class="mb-3"  id="video" style="display:none">
                                        <label for="recipient-name" class="col-form-label">Video:</label>
                                        <img class="img-preview-edit img-fluid">
                                        <input type="file" class="form-control" id="data_video" required name="video" value="{{old('video')}}">
                                       
                                      </div>

                                      <div class="mb-3" id="link" style="display:none">
                                        <label for="recipient-name" class="col-form-label">Link:</label>
                                        <input type="text" class="form-control" id="data_link" required name="link" value="{{old('link')}}">
                                      </div>

                                      <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Narasi:</label>
                                        <input type="text" class="form-control" id="narasi" required name="narasi" value="{{old('narasi')}}">
                                      </div>

                                       <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Tanggal Terbit:</label>
                                        <input type="date" class="form-control" id="tanggal_terbit" required name="tanggal_terbit" value="{{old('tanggal_terbit')}}">
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
                            <h6 class="m-0 font-weight-bold text-primary">Data Berita</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Foto</th>
                                            <th>Narasi</th>
                                            <th>Tanggal Terbit</th>
                                            <th>Video</th>

                                            <th>Desa</th>
                                            <th class="align-middle text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($berita as $data)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$data->judul}}</td>                                           
                                            <td>
                                                <div >
                                                    <img style="height: 200px; width:200px" src="{{asset('storage/'. $data->foto)}}" alt="">
                                                </div>
                                            </td>
                                            <td>{{$data->narasi}}</td>
                                                                                        <td>{{$data->tanggal_terbit}}</td>
                                            @if (pathinfo($data->video, PATHINFO_EXTENSION) == 'mp4' )
                                            <td><a href="/storage/{{$data->video}}">Cek Video lokal</a></td>    
                                            @else
                                            <td><a href="{{$data->video}}">Cek Video Youtube</a></td>                                            
                                            @endif

                                            <td>{{$data->desa}}</td>
                                            <td class="align-middle text-center">
                                                <div class="d-flex justify-content-sm-center mt-2">
                                
                                                    <form action="/beritadesa/delete" method="post">
                                                        @csrf
                                                        <input type="hidden" name="foto" value="{{$data->foto}}" id="foto">
                                                        <input type="hidden" name="id" value="{{$data->id}}" id="id">
                                                        <button class="btn btn-danger ml-2" onclick="return confirm('Apakah anda akan menghapus data ?')">Hapus</button>
                                                    </form>
                                                    <a href="/beritadesa/{{$data->id}}" class="btn btn-warning ml-2">Edit</a>
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
                        function previewBerita(){
                                                const  image = document.querySelector('#foto');
                                                const imgPreviewBerita = document.querySelector('.img-preview-edit');
                                        
                                                imgPreviewBerita.style.display = 'block';
                                        
                                                const oFReader = new FileReader();
                                                oFReader.readAsDataURL(foto.files[0]);
                                        
                                                oFReader.onload = function(oFREvent) {
                                                    imgPreviewBerita.src = oFREvent.target.result;            
                                                }
                                        
                                            }
                                            
                        $(function () {
                            $.ajaxSetup({
                                headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')}
                            })
                          })
                        
                        $(function () {

                              $('#list_video').change(function() {
                                  let list_video = $(this).val();
                                  if (list_video == 'Link') {
                                        document.getElementById('link').style.display = "contents";
                                        document.getElementById('video').style.display = "none"
                                         $("#data_video").val("");
                                         $('#data_link').attr('required', true); 
                                         $('#data_video').attr('required', false); 
                                  }else if (list_video == 'Video') {
                                        document.getElementById('video').style.display = "contents";
                                        document.getElementById('link').style.display = "none";
                                         $('#data_link').attr('required', false); 
                                         $('#data_video').attr('required', true); 
                                         $("#data_link").val("");
                                   
                                  }
                                 
                                });

                          })
                    </script>
@endsection