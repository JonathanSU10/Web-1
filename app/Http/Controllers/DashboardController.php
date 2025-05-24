<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProgramUmroh;
use App\Models\Pendaftaran;
use App\Models\Pembayaran;
use App\Models\Timeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use File;
use Alert;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (session('success')) {
                Alert::success(session('success'));
            }

            if (session('error')) {
                Alert::error(session('error'));
            }

            return $next($request);
        });
    }
    public function dashboard()
    {
        $data = Pendaftaran::select('status_pendaftaran', DB::raw('count(*) as jumlah'),)
            ->groupBy('status_pendaftaran')->get();
        $pendaftar = Pendaftaran::all();
        $jmlpendaftar = Pendaftaran::all()->count();
        $jmlpaket = ProgramUmroh::all()->count();
        $dataUser = User::all();
        $timeline = Timeline::all()->sortBy('desc');
        $jmluser = User::all()->count();
        $jmlbayar = Pembayaran::where('status', 'Dibayar')->sum('total_bayar');
        $jmlpendaftarperpaket =  Pendaftaran::select('pil1',  DB::raw('count(*) as jmldaftarpaket'),)
            ->groupBy('pil1')->get();
        $paket = ProgramUmroh::limit(4)->get();
        return view('dashboard', ['jmlpaket' => $jmlpaket, 'timeline' => $timeline, 'viewDataUser' => $dataUser, 'viewTotal' => $data, 'pendaftar' => $pendaftar, 'jmlpendaftar' => $jmlpendaftar, 'jmlpendaftarpaket' => $jmlpendaftarperpaket, 'jmluser' => $jmluser, 'paket' => $paket, 'jmlbayar' => $jmlbayar]);
    }
}
