@extends('layout.master')


@section('konten')


<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">datastatistik</h1>
<button class="btn btn-primary" data-toggle="modal" data-target="#tambahsiswa">Tambah datastatistik</button>
@if (session()->has('success'))
<div class="alert alert-success mt-2" role="alert">
    {{session('success')}}
</div>
@endif

@error('jenis')
<div class="alert alert-danger mt-2" role="alert">
    {{$message}}
</div>
@enderror

@error('jumlah')
<div class="alert alert-danger mt-2" role="alert">
    {{$message}}
</div>
@enderror



<!-- Tambah Modal-->
<div class="modal fade" id="tambahsiswa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah datastatistik?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/tambah_datastatistik_desa" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="province_id" value="{{auth()->user()->province_id}}">
                    <input type="hidden" name="regencie_id" value="{{auth()->user()->regencie_id}}">
                    <input type="hidden" name="district_id" value="{{auth()->user()->district_id}}">
                    <input type="hidden" name="village_id" value="{{auth()->user()->village_id}}">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Jenis:</label>
                        <input type="text" class="form-control" id="jenis" required name="jenis" value="{{old('jenis')}}">
                    </div>

                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Jumlah:</label>
                        <input type="text" class="form-control" id="jumlah" required name="jumlah" value="{{old('jumlah')}}">
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
        <h6 class="m-0 font-weight-bold text-primary">Data datastatistik</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>jenis</th>
                        <th>jumlah</th>
                        <th>Kecamatan</th>
                        <th>Desa</th>
                        <th class="align-middle text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datastatistik as $data)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$data->jenis}}</td>
                        <td>{{$data->jumlah}}</td>
                        <td>{{auth()->user()->kecamatan->name}}</td>
                        <td>{{auth()->user()->desa->name}}</td>
                       
                        <td class="align-middle text-center">
                            <div class="d-flex justify-content-sm-center mt-2">

                                <form action="/hapusdatastatistik_admin" method="post">
                                    @csrf
                                    <input type="hidden" name="foto" value="{{$data->foto}}" id="foto">
                                    <input type="hidden" name="id" value="{{$data->id}}" id="id">
                                    <button class="btn btn-danger ml-2" onclick="return confirm('Apakah anda akan menghapus data ?')">Hapus</button>
                                </form>
                                <button type="button" data-toggle="modal" data-target="#editdatastatistik{{$data->id}}"  class="btn btn-warning ml-2">Edit</button>
                                <!-- Edit Modal-->
                                <div class="modal fade" id="editdatastatistik{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Update datastatistik?</h5>
                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="/update_datastatistik_admin" method="POST" enctype="multipart/form-data">
                                                    @csrf                                                    
                                                    <input type="hidden" name="id" value="{{$data->id}}">
                                                    <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">Jenis:</label>
                                                        <input type="text" class="form-control" id="jenis" required name="jenis" value="{{old('jenis',$data->jenis)}}">
                                                    </div>

                                                     <div class="mb-3">
                                                        <label for="recipient-name" class="col-form-label">Jumlah:</label>
                                                        <input type="text" class="form-control" id="jumlah" required name="jumlah" value="{{old('jumlah',$data->jumlah)}}">
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