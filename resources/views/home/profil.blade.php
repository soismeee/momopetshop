@extends('layout.main')

@section('container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="col-xl-8">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                             <h5 class="font-size-16 mb-3">Profil pengguna</h5>
                             <div class="mt-3">
                                 <p class="font-size-15 mb-1">Username : {{ auth()->user()->username }}</p>
                                 <p class="font-size-15">Nama : {{ auth()->user()->name }}</p>
                                    <hr />
                                 <h4>Ubah data pengguna</h4>
                                 @if (session()->has('warning'))
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <i class="mdi mdi-alert-outline me-2"></i>
                                        {{ session('warning') }}!
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                                <form action="{{ route('chusr') }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama pengguna</label>
                                        <input type="hidden" name="id" id="id" value="{{ auth()->user()->id }}">
                                        <input type="text" class="form-control" placeholder="Nama pengguna" name="name" id="name" value="{{ auth()->user()->name }}">
                                    </div>

                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Username</label>
                                                <input type="text" class="form-control" placeholder="Username" name="username" id="username" value="{{ auth()->user()->username }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" class="form-control" placeholder="Kosongkan jika tidak ingin merubah Password" name="password" id="password">
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary w-md">Simpan profil</button>
                                    </div>
                                </form>
                             </div>
                        </div>
                     </div>
                </div>
            </div>
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
@endsection