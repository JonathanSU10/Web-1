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
Detail Pendaftaran
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
                        <li class="mm-active"><a href="{{route('data-registration')}}">Pendaftaran</a></li>
                        <li><a href="{{route('data-pembayaran')}}">Pembayaran</a></li>
                    </ul>
                </li>
            @else
                <li class="mm-active"><a href="{{route('data-registration')}}" aria-expanded="false">
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
        {{ csrf_field() }}
        <div class="col-xl-12">
            <div class="custom-accordion">
                @if (auth()->user()->role == 'Administrator')
                <div class="row my-4">
                    <div class="col">
                        <div class="text-end mt-2 mt-sm-0">
                            <a href="../../data-registration"><button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Tutup </button></a>
                            @if ($viewData->status_pendaftaran =='Belum Terverifikasi')
                            <a href="../../verified-registration/{{$viewData->id_pendaftaran}}"><button type="button" class="btn btn-primary">Verifikasi</button></a>
                            @endif
                            <a href="../../card-registration/{{$viewData->id}}"><button type="button" class="btn btn-primary">Lihat Kartu </button></a>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row-->
                @elseif(auth()->user()->role == 'Calon Peserta')
                @if ($viewData->status_pendaftaran=="Belum Terverifikasi")
                <div class="alert alert-success alert-dismissible fade show">
                    <svg viewbox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                    <strong>Sukses!</strong> Data pendaftaranmu terkirim. Sebelum melakukan pembayaran, tunggu administrator memverifikasi datamu ya.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                    </button>
                </div>
                @elseif ($viewData->status_pendaftaran=="Terverifikasi" && $viewDataPembayaran->status !="Gratis" && $viewDataPembayaran->status !="Dibayar")
                <div class="alert alert-info alert-dismissible fade show">
                    <svg viewbox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                    <strong>Informasi!</strong> Segera lakukan pembayaran.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                    </button>
                </div>
                @endif
                <div class="text-end">
                    <a href="../../card-registration/{{$viewData->id}}"><button type="button" class="btn btn-primary">Lihat Kartu Pendaftaran </button></a>
                </div>
                @endif

                <div class="card card-body">
                    <div class="card-header">
                        <h4 class="card-title">Data Pendaftaran</h4>
                        <!-- center modal -->
                        <div>
                            @if ($viewData->status_pendaftaran == "Belum Terverifikasi")
                            <button class="btn btn-warning mb-4" style="margin-bottom: 1rem;" disabled>Belum Terverifikasi</button>
                            @elseif ($viewData->status_pendaftaran == "Terverifikasi")
                                @if ($viewDataPembayaran->status !="Gratis" && $viewDataPembayaran->status !="Dibayar")
                                <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target=".upload"
                                style="margin-bottom: 1rem;"><i class="mdi mdi-plus me-1"></i>Upload Pembayaran  </button>
                                @endif

                            <button class="btn btn-success mb-4" style="margin-bottom: 1rem;" disabled>Terverifikasi</button>
                            @elseif ($viewData->status_pendaftaran == "Selesai")
                            <button class="btn btn-primary mb-4" style="margin-bottom: 1rem;" disabled>Selesai</button>
                            @else
                            <span class="badge badge-danger">Data Batal</span>
                            @endif
                        </div>
                    </div>
                    <div class="modal fade upload" tabindex="-1" role="dialog"
                        aria-labelledby="mySmallModalLabel" aria-hidden="true">

                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Kirim bukti pembayaran</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('upload-payment')}}" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="userid" value="{{ auth()->user()->id}}">
                                        <div class="form-group">
                                            <input type="hidden" name="id_pendaftaran" id="nama" class="form-control"
                                            value="{{ $viewData->id_pendaftaran }}">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <label for="iduser">Pilih Dokumen</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">Upload</span>
                                                        <div class="form-file">
                                                                        <input type="file" class="form-file-input form-control" name="pem" accept="image/png, image/jpg, image/jpeg">

                                                                    <input type="hidden" class="form-file-input form-control"
                                                                        name="pathnya">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top-0 d-flex">
                                            <button type="button" class="btn btn-danger light"
                                                data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" name="add"
                                                class="btn btn-primary">Perbaharui
                                                Data</button>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row mb-2">
                                    <div class="pt-4 border-bottom-1 pb-3">
                                        <h4 class="text-primary"><b>PROFIL JAMAAH</b></h4>
                                    </div>
                                    <div class="col-sm-4 col-5">
                                        <h5 class="f-w-400">ID Pendaftaran</h5>
                                    </div>
                                    <div class="col-sm-8 col-7">
                                        <h5 class="f-w-500">: {{ $viewData->id_pendaftaran }}</h5>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4 col-6">
                                        <h5 class="f-w-400">Nama</h5>
                                    </div>
                                    <div class="col-sm-8 col-6">
                                        <h5 class="f-w-500">: {{ $viewData->nama }}</h5>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4 col-6">
                                        <h5 class="f-w-400">Jenis Kelamin</h5>
                                    </div>
                                    <div class="col-sm-8 col-6">
                                        <h5 class="f-w-500">: {{ $viewData->jenis_kelamin }}</h5>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4 col-6">
                                        <h5 class="f-w-400">TTL</h5>
                                    </div>
                                    <div class="col-sm-8 col-6">
                                        <h5 class="f-w-500">: {{ $viewData->tempat_lahir }}, {{ $viewData->tanggal_lahir }}</h5>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4 col-6">
                                        <h5 class="f-w-400">NIK</h5>
                                    </div>
                                    <div class="col-sm-8 col-6">
                                        <h5 class="f-w-500">: {{ $viewData->nik }}</h5>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4 col-6">
                                        <h5 class="f-w-400">Alamat</h5>
                                    </div>
                                    <div class="col-sm-8 col-6">
                                        <h5 class="f-w-500">: {{ $viewData->alamat }}</h5>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4 col-6">
                                        <h5 class="f-w-400">Email</h5>
                                    </div>
                                    <div class="col-sm-8 col-6">
                                        <h5 class="f-w-500">: {{ $viewData->email }}</h5>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4 col-6">
                                        <h5 class="f-w-400">Telepon/What'sApp</h5>
                                    </div>
                                    <div class="col-sm-8 col-6">
                                        <h5 class="f-w-500">: {{ $viewData->hp }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="pt-4 border-bottom-1 pb-3">
                                    <img src="{{ asset($viewData->pas_foto) }}" width="250px" height="300" alt="">
                                </div>
                            </div>
                        </div>

                            <div class="pt-4 border-bottom-1 pb-3">
                                <h4 class="text-primary"><b>PAKET PILIHAN</b></h4>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 col-4">
                                    <div class="col-sm-9 col-7">
                                        <h5 class="f-w-500">{{ $viewData->pilihan1->nama_paket }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-4 border-bottom-1 pb-3">
                                <h4 class="text-primary"><b>DOKUMEN</b></h4>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6 col-6">
                                    <h5 class="f-w-400">Pasport</small></h5>
                                    <div class="col-sm-9 col-7">
                                        <a href="{{ asset($viewData->passport) }}"> <i class="fa fa-file-pdf" style="font-size:48px;color:red"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6 col-6">
                                    <h5 class="f-w-400">KK</small></h5>
                                    <div class="col-sm-9 col-7">
                                        <a href="{{ asset($viewData->kk) }}"> <i class="fa fa-file-pdf" style="font-size:48px;color:red"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6 col-6">
                                    <h5 class="f-w-400">KTP</small></h5>
                                    <div class="col-sm-9 col-7">
                                        <a href="{{ asset($viewData->ktp) }}"> <i class="fa fa-file-pdf" style="font-size:48px;color:red"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6 col-6">
                                    <h5 class="f-w-400">Akta</small></h5>
                                    <div class="col-sm-9 col-7">
                                        <a href="{{ asset($viewData->akta) }}"> <i class="fa fa-file-pdf" style="font-size:48px;color:red"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- end row-->
            </div>
        </div>
        <!-- end row -->
    @endsection

    @section('footer')
    @endsection
