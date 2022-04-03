@extends('layout.master')


@section('konten')

    
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Admin</h1>
                    @if (auth()->user()->role ==0)
                    <button class="btn btn-primary"  data-toggle="modal" data-target="#tambahsiswa">Tambah Admin</button>                        
                    @endif
                    @if (session()->has('success'))
                        <div class="alert alert-success mt-2" role="alert">
                            {{session('success')}}  
                        </div>
                    @endif

                    @error('username')
                    <div class="alert alert-danger mt-2" role="alert">
                        {{$message}}  
                    </div>                        
                    @enderror

                    @error('name')
                    <div class="alert alert-danger mt-2" role="alert">
                        {{$message}}  
                    </div>                        
                    @enderror

                    @error('nim')
                    <div class="alert alert-danger mt-2" role="alert">
                        {{$message}}  
                    </div>                        
                    @enderror

                    @error('alamat')
                    <div class="alert alert-danger mt-2" role="alert">
                        {{$message}}  
                    </div>                        
                    @enderror

                    @error('nohp')
                    <div class="alert alert-danger mt-2" role="alert">
                        {{$message}}  
                    </div>                        
                    @enderror

                    @error('password')
                    <div class="alert alert-danger mt-2" role="alert">
                        {{$message}}  
                    </div>                        
                    @enderror
                    
                      <!-- Logout Modal-->
                    <div class="modal fade" id="tambahsiswa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Admin?</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="/admin" method="POST">
                                        @csrf

                                      <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Name:</label>
                                        <input type="text" class="form-control" id="name" required name="name" value="{{old('name')}}">
                                      </div>

                                      <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">email:</label>
                                        <input type="text" class="form-control" id="email" required name="email" value="{{old('email')}}">
                                      </div>

                                      <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Desa:</label>
                                        <input type="text" class="form-control" id="email" required name="email" value="{{old('email')}}">
                                      </div>
                                      <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Password:</label>
                                        <input type="text" class="form-control" id="nim" required name="nim" value="{{old('nim')}}">
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
                            <h6 class="m-0 font-weight-bold text-primary">Data Admin</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Username</th>
                                            <th class="align-middle text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataadmin as $data)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$data->name}}</td>
                                            <td>{{$data->email}}</td>
                                            <td class="align-middle text-center">
                                                <div class="d-flex justify-content-sm-center mt-2">
                                                    
                                                    <form action="/admin/hapusadmin/{{$data->id}}" method="post">
                                                        @method('delete')
                                                        @csrf
                                                        <button class="btn btn-danger ml-2" onclick="return confirm('Apakah anda akan menghapus data ?')">Hapus</button>
                                                    </form>
                                                    <a href="admin/editadmin/{{$data->id}}" class="btn btn-warning ml-2">Edit</a>
                                         

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