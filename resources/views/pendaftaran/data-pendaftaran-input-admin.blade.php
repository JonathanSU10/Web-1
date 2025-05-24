@extends('master.master-admin')

@section('title')
    PT SAKO UTAMA WISATA
@endsection

@section('header')
@endsection

@section('navbar')
    @parent
@endsection

@section('menunya')
    Data Pendaftaran
@endsection

@section('menu')
    @auth
        <ul class="metismenu" id="menu">
            <li><a href="{{ route('dashboard') }}">
                    <i class="fas fa-home"></i>
                    <span class="nav-text">Beranda</span>
                </a>
            </li>
            @if (auth()->user()->role == 'Administrator')
                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa fa-book"></i>
                        <span class="nav-text">Data Utama </span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('data-user') }}">Pengguna</a></li>
                        <li><a href="{{ route('data-paket') }}">Paket</a></li>
                    </ul>
                </li>
                <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
                        <i class="fa fa-database"></i>
                        <span class="nav-text">Data Riwayat</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('data-registration') }}">Pendaftaran</a></li>
                        <li><a href="{{ route('data-pembayaran') }}">Pembayaran</a></li>
                    </ul>
                </li>
            @else
                <li class="mm-active"><a href="{{ route('data-registration') }}" aria-expanded="false">
                        <i class="fa fa-database"></i>
                        <span class="nav-text">Pendaftaran</span>
                    </a>
                </li>
            @endif
        </ul>
    @endauth
@endsection

@section('content')
    <div class="row">
        <form action="/save-registration" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="userid" value="{{ auth()->user()->id }}">
            <div class="col-xl-12">
                <div class="custom-accordion">
                    <div class="card">
                        <a href="#personal-data" class="text-dark" data-bs-toggle="collapse">
                            <div class="p-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3"> <i class="uil uil-receipt text-primary h2"></i>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-16 mb-1">Data Pribadi</h5>
                                    </div>
                                    <div class="flex-shrink-0"> <i
                                            class="mdi mdi-chevron-up accor-down-icon font-size-24"></i> </div>
                                </div>
                            </div>
                        </a>
                        <div id="personal-data" class="collapse show">
                            <div class="p-4 border-top">
                                <div class="row">
                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                    <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3 mb-4">
                                            <label class="form-label" for="personal-data-nik">NIK</label>
                                            <input type="text" class="form-control" id="personal-data-nik" name="nik"
                                                placeholder="Masukkan NIK" value="{{ old('nik') }}" required>
                                            @error('nik')
                                                <div class="alert alert-warning" role="alert">
                                                    <strong>Peringatan!</strong>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3 mb-4">
                                            <label class="form-label" for="personal-data-name">Nama</label>
                                            <input type="text" class="form-control" id="personal-data-name" name="nama"
                                                placeholder="Masukkan Nama Lengkap" value="{{ old('nama') }}" required>
                                            @error('nama')
                                                <div class="alert alert-warning" role="alert">
                                                    <strong>Peringatan!</strong>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3 mb-4">
                                            <label class="form-label" for="personal-data-gender">Jenis
                                                Kelamin</label>
                                           
                                                <select class="default-select form-control wide" name="jk"
                                                    value="{{ old('jk') }}" required>
                                                    <option value="{{ old('jk') }}" disabled selected>Pilih
                                                        Jenis Kelamin </option>
                                                    <option value="Laki-Laki">Laki-Laki</option>
                                                    <option value="Perempuan">Perempuan</option>
                                                </select>
                                           

                                            @error('jk')
                                                <div class="alert alert-warning" role="alert">
                                                    <strong>Peringatan!</strong>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
</div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3 mb-4">
                                            <label class="form-label">Tempat Lahir</label>
                                            
                                                <input type="text" class="form-control" id="basicpill"
                                                    name="tempatlahir" placeholder="Masukkan Tempat Lahir"
                                                    value="{{ old('tempatlahir') }}" required>
                                           
                                            @error('tempatlahir')
                                                <div class="alert alert-warning" role="alert">
                                                    <strong>Peringatan!</strong>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3 mb-4">
                                            <label class="form-label" for="billing-city">Tanggal lahir</label>
                                        
                                                <input type="date" class="form-control" id="basicpill"
                                                    name="tanggallahir" placeholder="Masukkan Tanggal Lahir"
                                                    value="{{ old('tanggallahir') }}" required>
                                          
                                            @error('tanggallahir')
                                                <div class="alert alert-warning" role="alert">
                                                    <strong>Peringatan!</strong>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <!--<input name="tanggallahir" class="datepicker-default form-control" id="datepicker" >-->
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3 mb-4">
                                            <label class="form-label" for="zip-code">Pas Foto</label>
                                            <div class="input-group">
                                                
                                                <div class="form-file">
                                                    <input type="file" class="form-file-input form-control"
                                                        name="ftpasfoto" value="{{ old('ftpasfoto') }}" accept="image/png, image/jpg, image/jpeg" required>
                                                </div>
                                            </div>
                                            @error('ftpasfoto')
                                                <div class="alert alert-warning" role="alert">
                                                    <strong>Peringatan!</strong>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="billing-address">Alamat</label>

                                   
                                        <textarea class="form-control" id="billing-address" rows="3" name="alamat" required
                                            placeholder="Masukkan Alamat Lengkap">{{ old('alamat') }}</textarea>
                                    
                                    @error('alamat')
                                        <div class="alert alert-warning" role="alert">
                                            <strong>Peringatan!</strong>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="row">
                                <div class="col-lg-6">
                                        <div class="mb-3 mb-4">
                                            <label class="form-label" for="personal-data-nik">Email</label>
                                            <input type="email" class="form-control" id="personal-data-nik" name="email"
                                                placeholder="Masukkan Email" value="{{ old('nik') }}" required>
                                            @error('email')
                                                <div class="alert alert-warning" role="alert">
                                                    <strong>Peringatan!</strong>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3 mb-4">
                                            <label class="form-label" for="personal-data-nik">No
                                                HP/WhatsApp</label>
                                           
                                                <input type="number" class="form-control" id="basicpill" name="nohp"
                                                    placeholder="Masukkan Nomor" value="{{ old('nohp') }}" required>
                                           
                                            @error('nohp')
                                                <div class="alert alert-warning" role="alert">
                                                    <strong>Peringatan!</strong>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <a href="#registration-data" class="collapsed text-dark" data-bs-toggle="collapse">
                            <div class="p-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3"> <i class="uil uil-truck text-primary h2"></i>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-16 mb-1">Paket Pilihan</h5>
                                    </div>
                                    <div class="flex-shrink-0"> <i
                                            class="mdi mdi-chevron-up accor-down-icon font-size-24"></i> </div>
                                </div>
                            </div>
                        </a>
                        <div id="registration-data" class="collapse">
                            <div class="p-4 border-top">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3 mb-4">
                                            <label class="form-label" for="personal-data-nik">Paket
                                                </label>
                                                <select name="pil1" id=""
                                                class="form-control">
                                                    @foreach ($viewpaket as $item)
                                                        <option value="{{$item->id}}">{{$item->nama_paket}}</option>
                                                    @endforeach
                                                </select>
                                            @error('pil1')
                                                <div class="alert alert-warning" role="alert">
                                                    <strong>Peringatan!</strong>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <a href="#school-data" class="collapsed text-dark" data-bs-toggle="collapse">
                            <div class="p-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3"> <i class="uil uil-truck text-primary h2"></i>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-16 mb-1">Berkas-Berkas</h5>
                                    </div>
                                    <div class="flex-shrink-0"> <i
                                            class="mdi mdi-chevron-up accor-down-icon font-size-24"></i> </div>
                                </div>
                            </div>
                        </a>
                        <div id="school-data" class="collapse">
                            <div class="p-4 border-top">  
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3 mb-4">
                                            <label class="form-label" for="billing-address">Passport</label>
                                            <div class="input-group">
                                                <div class="form-file">
                                                    <input type="file" class="form-file-input form-control"
                                                        name="ftpassport" value="{{ old('ftpassport') }}" accept="application/pdf" required>
                                                </div>
                                            </div>
                                            @error('ftberkas')
                                                <div class="alert alert-warning" role="alert">
                                                    <strong>Peringatan!</strong>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                            
                       
                                    <div class="col-lg-6">
                                        <div class="mb-3 mb-4">
                                            <label class="form-label" for="billing-address">KK</label>
                                            <div class="input-group">
                                                <div class="form-file">
                                                    <input type="file" class="form-file-input form-control"
                                                        name="ftkk" value="{{ old('ftkk') }}" accept="application/pdf" required>
                                                </div>
                                            </div>
                                            @error('ftberkas')
                                                <div class="alert alert-warning" role="alert">
                                                    <strong>Peringatan!</strong>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3 mb-4">
                                            <label class="form-label" for="billing-address">KTP</label>
                                            <div class="input-group">
                                                <div class="form-file">
                                                    <input type="file" class="form-file-input form-control"
                                                        name="ftktp" value="{{ old('ftktp') }}" accept="application/pdf" required>
                                                </div>
                                            </div>
                                            @error('ftberkas')
                                                <div class="alert alert-warning" role="alert">
                                                    <strong>Peringatan!</strong>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                         
                       
                              
                                    <div class="col-lg-6">
                                        <div class="mb-3 mb-4">
                                            <label class="form-label" for="billing-address">Akta Kelahiran/ Ijazah/ Akta Nikah</label>
                                            <div class="input-group">
                                                <div class="form-file">
                                                    <input type="file" class="form-file-input form-control"
                                                        name="ftakta" value="{{ old('ftakta') }}" accept="application/pdf" required>
                                                </div>
                                            </div>
                                            @error('ftberkas')
                                                <div class="alert alert-warning" role="alert">
                                                    <strong>Peringatan!</strong>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
</div>
                    <div class="row my-4">
                        <div class="col">
                            <div class="text-end mt-2 mt-sm-0">
                                <button type="submit" name="add" class="btn btn-primary">Buat Pendaftaran</button>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row-->
                </div>
        </form>
    </div>
    <!-- end row -->
@endsection

@section('footer')
@endsection
