@extends('master.master-admin')

@section('title', 'PT SAKO UTAMA WISATA')

@section('header')
@endsection

@section('navbar')
    @parent
@endsection

@section('menunya', 'Kartu Pendaftaran')

@section('menu')
@auth
<ul class="metismenu" id="menu">
    <li>
        <a href="{{ route('dashboard') }}">
            <i class="fas fa-home"></i>
            <span class="nav-text">Beranda</span>
        </a>
    </li>
    @if (auth()->user()->role === 'Administrator')
        <li>
            <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                <i class="fa fa-book"></i>
                <span class="nav-text">Data Utama</span>
            </a>
            <ul aria-expanded="false">
                <li><a href="{{ route('data-user') }}">Pengguna</a></li>
                <li><a href="{{ route('data-paket') }}">Paket</a></li>
            </ul>
        </li>
        <li>
            <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                <i class="fa fa-database"></i>
                <span class="nav-text">Data Riwayat</span>
            </a>
            <ul aria-expanded="false">
                <li><a href="{{ route('data-registration') }}">Pendaftaran</a></li>
                <li><a href="{{ route('data-pembayaran') }}">Pembayaran</a></li>
            </ul>
        </li>
    @else
        <li class="mm-active">
            <a href="{{ route('data-registration') }}" aria-expanded="false">
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
        @csrf
        <div class="col-xl-12">
            <div class="card card-body" id="cetak" style="margin-bottom: -1rem">
                {{-- Header Kartu --}}
                <div class="p-4">
                    <div class="d-flex">
                        <div class="col-lg-3 text-center mx-3">
                            <img width="110px" src="{{ asset('sipenmaru/images/logo.jpg') }}" alt="">
                        </div>
                        <div class="col-lg-6 text-center">
                            <h4 class="form-label"><strong>KARTU PESERTA</strong></h4>
                            <h4><strong>PENERIMAAN CALON JAMAAH HAJI</strong></h4>
                            <h3><strong>PT SAKO UTAMA WISATA</strong></h3>
                            <p><strong>Jln. Kampar Raya, No.4 A, Kota Palembang, Sumatera Selatan, 40151, Indonesia</strong></p>
                        </div>
                    </div>
                </div>

                {{-- Isi Kartu --}}
                <div class="card-body pt-4" style="margin-bottom: -4rem; border-top: 2px solid black;">
                    <div class="d-flex">
                        <div class="col-lg-4 text-center me-3">
                            <img src="{{ asset($viewData->pas_foto) }}" width="250px" height="300" alt="">
                        </div>
                        <div class="col-lg-6">
                            <h4><strong>DATA PESERTA</strong></h4><br>
                            <div class="row mb-2">
                                @php
                                    $fields = [
                                        'NOMOR PESERTA' => $viewData->id_pendaftaran,
                                        'NIK' => $viewData->nik,
                                        'NAMA PESERTA' => $viewData->nama,
                                        'JENIS KELAMIN' => $viewData->jenis_kelamin,
                                        'TEMPAT LAHIR' => $viewData->tempat_lahir,
                                        'TANGGAL LAHIR' => $viewData->tanggal_lahir,
                                        'ALAMAT' => $viewData->alamat,
                                        'EMAIL' => $viewData->email,
                                        'NO HP/WhatsApp' => $viewData->hp,
                                    ];
                                @endphp
                                @foreach($fields as $label => $value)
                                    <div class="col-sm-6 col-6"><h5 class="f-w-400">{{ $label }}</h5></div>
                                    <div class="col-sm-6 col-6"><h5 class="f-w-500">: {{ $value }}</h5></div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="d-flex mt-4">
                        <div class="col-lg-6">
                            <strong>PAKET PILIHAN</strong>
                            <h5><strong>{{ $viewData->pilihan1->nama_paket }}</strong></h5>
                        </div>
                    </div>

                    {{-- Pernyataan --}}
                    <div class="mt-4">
                        <h4><strong>PERNYATAAN</strong></h4>
                        <h5 style="text-indent: 0.5in; text-align: justify;">
                            Saya yang menyatakan bahwa data yang saya isikan dalam formulir pendaftaran penerimaan calon jamaah haji PT Sako Utama Wisata adalah benar dan saya bersedia menerima ketentuan yang berlaku. Saya bersedia menerima sanksi pembatalan apabila melanggar pernyataan ini.
                        </h5>
                    </div>

                    <div class="d-flex mt-4">
                        <div class="col-lg-6"></div>
                        <div class="col-lg-6 text-center">
                            <h5><strong>...................................................</strong></h5>
                            <br><br><br>
                            <h5><strong>{{ $viewData->nama }}</strong></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol Cetak --}}
        <div class="row my-4">
            <div class="col text-end">
                <button class="btn btn-success me-1" onclick="printDiv('cetak')">
                    <i class="fa fa-print"></i> Cetak Kartu
                </button>
                <button type="button" class="btn btn-primary" onclick="printDiv('nametag')">
                    <i class="fa fa-id-card"></i> Cetak Nametag
                </button>
            </div>
        </div>
    </form>
</div>

{{-- Nametag --}}
<div id="nametag" style="display:none; width:9cm; height:13cm; padding:1cm; border:1px solid #000; font-family:'Arial', sans-serif; position:relative;">
    {{-- Header Bendera dan Judul --}}
    <div style="text-align:center; margin-bottom:8px;">
        <img src="{{ asset('sipenmaru/images/indonesia-flag.png') }}" style="height:20px;"><br>
        <h4 style="margin:5px 0; font-size:14px;"><strong>KARTU KESEHATAN</strong></h4>
        <h5 style="margin:5px 0; font-size:13px;"><strong>JEMAAH HAJI INDONESIA</strong></h5>
        <p style="font-size:10px; margin:0;">بطاقة صحية لحجاج اندونيسيا</p>
    </div>

    <div class="text-center mt-3">
        <div style="border:1px solid #000; padding:2px; display:inline-block;">
            <img src="{{ asset($viewData->pas_foto) }}" style="width:100px; height:120px; object-fit:cover;">
        </div>
    </div>

    {{-- Data Jamaah --}}
    <div style="text-align:center; margin-top:15px;">
        <h4 style="margin:3px 0;"><strong>{{ $viewData->nama }}</strong></h4>
        <p style="margin:3px 0; font-size:12px;">
            {{ strtoupper($viewData->kabupaten ?? 'KAB. '.$viewData->alamat) }}
        </p>
        <h4 style="margin:3px 0;"><strong>{{ $viewData->nik }}</strong></h4>
    </div>

  
</div>

@endsection

@section('footer')
<script>
    function printDiv(divId) {
        var printContents = document.getElementById(divId).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }
</script>
@endsection
