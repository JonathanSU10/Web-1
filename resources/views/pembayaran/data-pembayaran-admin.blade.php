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
    Pembayaran
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
                @php
                    $no = 1;
                @endphp
                @foreach ($viewDataUser as $x)
                    @if ($no == 1)
                            <li><a href="data-registration" aria-expanded="false">
                                    <i class="fa fa-database"></i>
                                    <span class="nav-text">Pendaftaran</span>
                                </a>
                            </li>
                    @endif
                    @php
                        $no++;
                    @endphp
                @endforeach
            @endif
        </ul>
    @endauth
@endsection

@section('content')
    <div class="row" style="margin-bottom: 15rem">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Data Pembayaran</h4>

                    <div>
                            <select id="filterWaktu" class="form-control mb-3" onchange="filterData()">
                            <option value="1minggu">1 Minggu Terakhir</option>
                            <option value="1bulan">1 Bulan Terakhir</option>
                            <option value="1tahun">1 Tahun Terakhir</option>
                            </select>
                            
                                <a href="{{ route('pembayaran.print') }}" target="_blank" class="btn btn-info mb-4">
                                <i class="fa fa-print"></i>
                                </a>
                            
                    </div>
                    <!-- center modal -->
                    

                    <div class="modal fade modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Pembayaran </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="save-payment" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="userid" value="{{ auth()->user()->id}}">
                                        <div class="form-group">
                                            <div class="row">
                                                <input type="hidden" name="pathid" value="{{auth()->user()->name}}">
                                                <div class="col-xl-4">
                                                    <label for="iduser">ID Pendaftaran</label>
                                                    <select class="form-control wide" title="id pendaftaran"
                                                        name="id_pendaftaran" required>
                                                        <option value="-">Pilih ID</option>
                                                        @foreach ($viewIdPendaftaran as $z)
                                                            <option value="{{ $z->id_pendaftaran }}">
                                                                {{ $z->id_pendaftaran }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-xl-8">
                                                    <label for="iduser">Status</label>
                                                    <select class="default-select form-control wide" title="status"
                                                        name="status" required>
                                                        <option value="-">Pilih Status</option>
                                                        <option value="Dibayar">Dibayar</option>
                                                                        <option value="Belum Bayar">Belum Bayar</option>
                                                                        <option value="Gratis">Gratis</option>
                                                                        <option value="Batal">Batal</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="iduser">Bukti Pembayaran</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Upload</span>
                                                <div class="form-file">
                                                    <input type="file" class="form-file-input form-control" name="bukti"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top-0 d-flex">
                                            <button type="button" class="btn btn-danger light"
                                                data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" name="add" class="btn btn-primary">Tambahkan</button>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </div>
                <div class="card-body" id="cetak">
                    <div class="table-responsive">
                        {{ csrf_field() }}
                        <table id="example3" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pendaftar</th>
                                    <th>Paket</th>
                                    <th>Biaya Pendaftaran</th>
                                    <th>Tanggal Pembayaran</th>
                                    <th>Status</th>
                                    <th class="text-center">Bukti Pembayaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($viewData as $x)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td><a href="detail-registration/{{ $x->pendaftaran->id_pendaftaran }}">{{ $x->pendaftaran->nama }}</a></td>
                                        <td>{{ $x->pendaftaran->pilihan1->nama_paket }}</td>
                                        <td>{{ $x->pendaftaran->pilihan1->harga_paket }}</td>
                                        <td>{{ $x->tgl_pembayaran }}</td>
                                        <td>{{ $x->status }}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-7">
                                                    @if ($x->status == 'Dibayar')
                                                        <span class="badge badge-success">Dibayar<span
                                                                class="ms-1 fa fa-check"></span>
                                                        @elseif($x->status =='Belum Bayar')
                                                            <span class="badge badge-warning">Belum Dibayar<span
                                                                    class="ms-1 fas fa-stream"></span>
                                                            @elseif($x->status =='Batal')
                                                                <span class="badge badge-danger">Batal<span
                                                                        class="ms-1 fa fa-ban"></span>
                                                                        @elseif ($x->status == 'Gratis')
                                                                        <span class="badge badge-success">Gratis<span
                                                                                class="ms-1 fa fa-check"></span>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="dropdown text-sans-serif"><button
                                                            class="btn btn-primary tp-btn-light sharp" type="button"
                                                            id="order-dropdown-7" data-bs-toggle="dropdown"
                                                            data-boundary="viewport" aria-haspopup="true"
                                                            aria-expanded="false"><span><svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="18px"
                                                                    height="18px" viewbox="0 0 24 24" version="1.1">
                                                                    <g stroke="none" stroke-width="1" fill="none"
                                                                        fill-rule="evenodd">
                                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                                        <circle fill="#000000" cx="5" cy="12" r="2">
                                                                        </circle>
                                                                        <circle fill="#000000" cx="12" cy="12" r="2">
                                                                        </circle>
                                                                        <circle fill="#000000" cx="19" cy="12" r="2">
                                                                        </circle>
                                                                    </g>
                                                                </svg></span></button>
                                                        <div class="dropdown-menu dropdown-menu-end border py-0"
                                                            aria-labelledby="order-dropdown-7">
                                                            <div class="py-2"><a class="dropdown-item"
                                                                    href="/paid-payment/{{ $x->id_pembayaran }}">Bayar</a><a
                                                                    class="dropdown-item"
                                                                    href="/unpaid-payment/{{ $x->id_pembayaran }}">Belum Bayar</a>
                                                                <div class="dropdown-divider"></div><a
                                                                    class="dropdown-item text-danger"
                                                                    href="/invalid-payment/{{ $x->id_pembayaran }}">Batal</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if ($x->bukti_pembayaran != null)
                                                <a class="btn btn-light shadow btn-xs sharp me-1" title="Proof of Payment"
                                                    href="{{ $x->bukti_pembayaran }}" download><i
                                                        class="fa fa-file-alt"></i></a>
                                            @else
                                                @if ($x->status == "Gratis")
                                                Gratis Biaya Pendaftaran
                                                @else
                                                Tidak tersedia
                                                @endif
                                            @endif
                                        </td>
                                        <td>
    <div class="d-flex">
        {{-- Tombol Edit --}}
        <a class="btn btn-primary shadow btn-xs sharp me-1" title="Edit"
           data-bs-toggle="modal"
           data-bs-target=".edit{{ $x->id_pembayaran }}">
            <i class="fa fa-pencil-alt"></i>
        </a>

        {{-- Tombol Invoice --}}
        <a href="{{ route('pembayaran.invoice', $x->id_pembayaran) }}"
           class="btn btn-info shadow btn-xs sharp me-1"
           title="Lihat Invoice"
           target="_blank">
            <i class="fa fa-file-invoice"></i>
        </a>

        {{-- Tombol Hapus --}}
        {{-- Aktifkan jika ingin tampilkan tombol hapus sebagai ikon langsung --}}
        {{-- 
        <a class="btn btn-danger shadow btn-xs sharp" data-bs-toggle="modal"
           data-bs-target=".delete{{ $x->id_pembayaran }}">
           <i class="fa fa-trash"></i>
        </a>
        --}}

        {{-- Modal Hapus --}}
        <div class="modal fade delete{{ $x->id_pembayaran }}" tabindex="-1"
             role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                        <i class="fa fa-trash fa-2x mb-3 text-danger"></i><br>
                        Apakah Anda yakin ingin menghapus data ini?<br>
                        <strong>{{ $x->id_pembayaran }}</strong>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary light" data-bs-dismiss="modal">Batalkan</button>
                        <a href="{{ url('delete-payment/'.$x->id_pembayaran) }}">
                            <button type="submit" class="btn btn-danger shadow">Ya, Hapus Data!</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</td>

                                    </tr>

                                    <div class="modal fade edit{{ $x->id_pembayaran }}" tabindex="-1" role="dialog"
                                        aria-labelledby="mySmallModalLabel" aria-hidden="true">

                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Sunting Pembayaran</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="update-payment/{{ $x->id_pembayaran }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="userid" value="{{ auth()->user()->id}}">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-xl-12">
                                                                    <label for="iduser"> ID Pembayaran</label>
                                                                    <input type="text" class="form-control" id="nama"
                                                                        value="{{ $x->id_pembayaran }}" name="id" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-xl-4">
                                                                    <label for="iduser"> ID Pendaftaran </label>
                                                                    <select class="form-control wide" title="id pendaftaran"
                                                                        name="id_pendaftaran" required>
                                                                        <option value="{{ $x->id_pendaftaran }}" selected>
                                                                            {{ $x->pendaftaran->id_pendaftaran }} || {{ $x->pendaftaran->nama }}</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-xl-8">
                                                                    <label for="iduser">Status</label>
                                                                    <select class="default-select form-control wide"
                                                                        title="status" name="status" required>
                                                                        <option value="{{ $x->status }}" selected>
                                                                            {{ $x->status }}</option>
                                                                        <option value="Dibayar">Dibayar</option>
                                                                        <option value="Belum Bayar">Belum Bayar</option>
                                                                        <option value="Batal">Batal</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="iduser">Bukti Pembayaran</label>
                                                            <div class="input-group">
                                                                <div class="form-file">
                                                                        <input type="file" class="form-file-input form-control" name="bukti" accept="image/png, image/jpg, image/jpeg">

                                                                    <input type="hidden" class="form-file-input form-control"
                                                                        name="pathnya" value="{{ $x->bukti_pembayaran }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-top-0 d-flex">
                                                            <button type="button" class="btn btn-danger light"
                                                                data-bs-dismiss="modal">Tutup</button>
                                                            <button type="submit" name="add"
                                                                class="btn btn-primary">Perbaharui Data</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
@endsection
