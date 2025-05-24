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
Pendaftaran
@endsection

@section('menu')
@auth
<ul class="metismenu" id="menu">
    <li><a href="{{route('dashboard')}}">
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
            <li><a href="{{route('data-user')}}">Pengguna</a></li>
            <li><a href="{{route('data-paket')}}">Paket</a></li>
        </ul>
    </li>
    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
        <i class="fa fa-database"></i>
        <span class="nav-text">Data Riwayat</span>
        </a>
        <ul aria-expanded="false">
            <li><a href="{{route('data-registration')}}">Pendaftaran</a></li>
            <li><a href="{{route('data-pembayaran')}}">Pembayaran</a></li>
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
        <form action="/update-registration/{{ $viewData->id_pendaftaran }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="col-xl-12">
                <div class="custom-accordion">
                    <div class="card">
                        <a href="#personal-data" class="text-dark" data-bs-toggle="collapse">
                            <div class="p-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3"> <i class="uil uil-receipt text-primary h2"></i> </div>
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
                                    <div class="col-lg-4">
                                        <div class="mb-3 mb-4">
                                            <label class="form-label" for="personal-data-nik">NIK</label>
                                            <input type="text" value="{{ $viewData->nik }}" class="form-control" id="personal-data-nik" name="nik"
                                                placeholder="Enter NIK" value="{{ old('nik') }}">
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
                                            <input type="text" value="{{ $viewData->nama }}" class="form-control" id="personal-data-name" name="nama"
                                                placeholder="Enter Name" value="{{ old('nama') }}">
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
                                            <label class="form-label" for="personal-data-gender">Jenis Kelamin</label>
                                            @if ($viewData->jenis_kelamin == 'Perempuan')
                                                <select class="form-control wide" name="jk" value="{{ old('jk') }}">
                                                    <option value="{{ $viewData->jenis_kelamin }}" selected> {{ $viewData->jenis_kelamin }}</option>
                                                    <option value="Laki-Laki">Laki-Laki</option>
                                                </select>
                                            @else
                                                <select class="form-control wide" name="jk" value="{{ old('jk') }}">
                                                    <option value="{{ $viewData->jenis_kelamin }}" selected> {{ $viewData->jenis_kelamin }}</option>
                                                    <option value="Perempuan">Perempuan</option>
                                                </select>
                                            @endif
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
                                            <input type="text" value="{{ $viewData->tempat_lahir }}" class="form-control" id="basicpill" name="tempatlahir"
                                                placeholder="Masukkan Tempat Lahir" value="{{ old('tempatlahir') }}">
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
                                            <label class="form-label" for="billing-city">Tanggal Lahir</label>
                                            <input type="date" value="{{ $viewData->tanggal_lahir }}" class="form-control" id="basicpill" name="tanggallahir"
                                            placeholder="Masukkan Tanggal Lahir" value="{{ old('tanggallahir') }}">
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
                                                    <input type="file" class="form-file-input form-control" name="ftpasfoto"
                                                        value="{{ old('ftpasfoto') }}" accept="image/png, image/jpg, image/jpeg">
                                                    <input type="hidden" name="pathPasfoto" class="form-control-file"
                                                        value="{{ $viewData->pas_foto }}">
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
                                    <textarea class="form-control" id="billing-address" rows="3" name="alamat"
                                        placeholder="Masukkan Alamat">{{ $viewData->alamat }}</textarea>
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
                                            <input type="email" value="{{ $viewData->email }}" class="form-control" id="personal-data-nik" name="email"
                                                placeholder="Masukkan email" value="{{ old('email') }}">
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
                                            <label class="form-label" for="personal-data-nik">
                                                No HP/WhatsApp</label>
                                            <input type="number" value="{{ $viewData->hp }}" class="form-control" id="personal-data-nik" name="nohp"
                                                placeholder="Masukkan Nomor" value="{{ old('nohp') }}">
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
                                    <div class="flex-shrink-0 me-3"> <i class="uil uil-truck text-primary h2"></i> </div>
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
                                            <label class="form-label" for="personal-data-nik">Paket</label>
                                            <input class="form-control" value="{{ $viewData->pil1 }}" list="datalistOptionspaket" id="exampleDataList"
                                                placeholder="Cari Kursus..." name="pil1" value="{{ old('pil1') }}" autocomplete='off' >
                                            <datalist id="datalistOptionspaket">
                                                @foreach ($viewpaket as $z)
                                                    <option value="{{ $z->id_paket }}">{{ $z->nama_paket }}</option>
                                                @endforeach
                                            </datalist>
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
                                    <div class="flex-shrink-0 me-3"> <i class="uil uil-truck text-primary h2"></i> </div>
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
                                                    <input type="file" class="form-file-input form-control" name="ftpassport"
                                                        value="{{ old('ftpassport') }}" accept="application/pdf">

                                                    <input type="hidden" name="pathPassport" class="form-control-file"
                                                        value="{{ $viewData->passport }}">
                                                </div>
                                            </div>
                                            @error('ftpassport')
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
                                                    <input type="file" class="form-file-input form-control" name="ftkk"
                                                        value="{{ old('ftkk') }}" accept="application/pdf">

                                                    <input type="hidden" name="pathKK" class="form-control-file"
                                                        value="{{ $viewData->kk }}">
                                                </div>
                                            </div>
                                            @error('ftkk')
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
                                                    <input type="file" class="form-file-input form-control" name="ftktp"
                                                        value="{{ old('ftktp') }}" accept="application/pdf">

                                                    <input type="hidden" name="pathKTP" class="form-control-file"
                                                        value="{{ $viewData->ktp }}">
                                                </div>
                                            </div>
                                            @error('ftktp')
                                                <div class="alert alert-warning" role="alert">
                                                    <strong>Peringatan!</strong>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                            
                        
                                    <div class="col-lg-6">
                                        <div class="mb-3 mb-4">
                                            <label class="form-label" for="billing-address">Akta Kelahiran / Ijazah / Akta Nikah</label>
                                            <div class="input-group">
                                                <div class="form-file">
                                                    <input type="file" class="form-file-input form-control" name="ftakta"
                                                        value="{{ old('ftakta') }}" accept="application/pdf">

                                                    <input type="hidden" name="pathAkta" class="form-control-file"
                                                        value="{{ $viewData->akta }}">
                                                </div>
                                            </div>
                                            @error('ftakta')
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
                                <button type="submit" name="add" class="btn btn-primary">Perbaharui Data</button>
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
