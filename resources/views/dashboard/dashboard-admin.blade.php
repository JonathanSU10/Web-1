<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-xl-6">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card tryal-gradient">
                            <div class="card-body tryal row">
                                <div class="col-xl-7 col-sm-6">
                                    <h2>Selamat Datang, @auth
                                            {{ auth()->user()->name }}
                                        @endauth
                                    </h2>
                                    <span>Pantau kegiatan penerimaan jamaah haji baru
                                        </span>
                                    <a href="{{ route('data-registration') }}"
                                        class="btn btn-rounded  fs-18 font-w500">Lihat
                                        pendaftaran</a>
                                </div>
                                <div class="col-xl-5 col-sm-6">
                                    <img src="{{ asset('sipenmaru/images/chart.png') }}" alt=""
                                        class="sd-shape">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-6 col-sm-6">
                                        <div class="items">
                                            <h4 class="fs-20 font-w700 mb-4">Data Progress <br> Penerimaan Calon Jamaah Haji
                                                </h4>
                                            <span class="fs-14 font-w400">Data yang baru masuk dan telah
                                                diverifikasi oleh admin</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 redial col-sm-6">

                                        @php
                                            $aa = 0;
                                            $bb = 0;
                                        @endphp
                                        @foreach ($viewTotal as $x)
                                            @if (!$x->status_pendaftaran)
                                                @php
                                                    $aa = $x->jumlah;
                                                @endphp
                                            @elseif ($x->status_pendaftaran)
                                                @php
                                                    $bb = $x->jumlah;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @php
                                            $hsl = $aa + $bb;
                                            //$hslpersenanbaru = ($hsl * 100) / $jmlpendaftar;
                                            if (($hsl == null) | ($hsl == 0)) {
                                                $hslpersenanbaru = 0;
                                            } else {
                                                $hslpersenanbaru = ($hsl * 100) / $jmlpendaftar;
                                            }

                                        @endphp

                                        <div id="redial"></div>
                                        <span class="text-center d-block fs-18 font-w600">Sedang berlangsung
                                            <small class="text-orange"><span
                                                    id="progressnya">{{ $hslpersenanbaru }}</span>
                                                %</small></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="row">
                        <div class="col-xl-6 col-sm-6">
                                <div class="card">
                                    <div class="card-body d-flex px-4  justify-content-between">
                                        <div>
                                            <div class="">
                                                <h4 class="fs-32 font-w700">{{ $jmluser }}</h4>
                                                <span class="fs-18 font-w500 d-block">Total
                                                    Pengguna</span>
                                            </div>
                                        </div>
                                        <div id="NewCustomers"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-sm-6">
                                <div class="card">
                                    <div class="card-body d-flex px-4 pb-0 justify-content-between">
                                        <div>
                                            <h4 class="fs-18 font-w600 mb-4 text-nowrap">Paket
                                            </h4>
                                            <div class="d-flex align-items-center">
                                                <h2 class="fs-32 font-w700 mb-0">{{ $jmlpaket }}</h2>
                                                {{-- <span class="d-block ms-4">
                                                            <svg width="21" height="11" viewbox="0 0 21 11" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M1.49217 11C0.590508 11 0.149368 9.9006 0.800944 9.27736L9.80878 0.66117C10.1954 0.29136 10.8046 0.291359 11.1912 0.661169L20.1991 9.27736C20.8506 9.9006 20.4095 11 19.5078 11H1.49217Z"
                                                                    fill="#09BD3C"></path>
                                                            </svg>
                                                            <small
                                                                class="d-block fs-16 font-w400 text-success">+0,5%</small>
                                                        </span> --}}
                                            </div>

                                            <span class="fs-16 font-w400">Jumlah Paket</span>
                                        </div>
                                        @php
                                            $no = 1;
                                        @endphp
                                        <div id="NewCustomers3">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                            
                            

                            
                            <div class="col-xl-6 col-sm-6">
                                <div class="card">
                                    <div class="card-body d-flex px-4 pb-0 justify-content-between">
                                        <div>
                                            <h4 class="fs-18 font-w600 mb-4 text-nowrap">Pendaftar
                                            </h4>
                                            <div class="d-flex align-items-center">
                                                <h2 class="fs-32 font-w700 mb-0">{{ $jmlpendaftar }}</h2>
                                                {{-- <span class="d-block ms-4">
                                                            <svg width="21" height="11" viewbox="0 0 21 11" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M1.49217 11C0.590508 11 0.149368 9.9006 0.800944 9.27736L9.80878 0.66117C10.1954 0.29136 10.8046 0.291359 11.1912 0.661169L20.1991 9.27736C20.8506 9.9006 20.4095 11 19.5078 11H1.49217Z"
                                                                    fill="#09BD3C"></path>
                                                            </svg>
                                                            <small
                                                                class="d-block fs-16 font-w400 text-success">+0,5%</small>
                                                        </span> --}}
                                            </div>

                                            <span class="fs-16 font-w400">Pendaftar saat ini </span>
                                        </div>
                                        @php
                                            $no = 1;
                                        @endphp
                                        <div id="NewCustomers2">
                                            @foreach ($jmlpendaftarpaket as $x)
                                                <span id="paket{{ $no }}" style="color:transparent"
                                                    aria-disabled>{{ $x->jmldaftarpaket }}</span>
                                                @php
                                                    $no++;
                                                @endphp
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-sm-6">
                                <div class="card">
                                    <div class="card-body d-flex px-4  justify-content-between">
                                        <div>
                                            <div class="">
                                                <p style="margin: 0%"><b>Rp</b></p>
                                                <h5 class="fs-22 font-w700">
                                                    {{ number_format($jmlbayar) }}</h5>
                                                <span class="fs-18 font-w500 d-block">Jumlah Pembayaran</span>
                                            </div>
                                        </div>
                                        <div id="NewCustomers1"></div>
                                    </div>
                                </div>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
