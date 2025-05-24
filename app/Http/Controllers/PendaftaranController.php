<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfileUsers;
use App\Models\User;
use App\Models\ProgramUmroh;
use App\Models\Pendaftaran;
use App\Models\Pembayaran;
use App\Models\Timeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Support\Facades\Hash;
Use Illuminate\Support\Carbon;
use File;
use Alert;

class PendaftaranController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request,$next){
            if (session('success')) {
                Alert::success(session('success'));
            }

            if (session('error')) {
                Alert::error(session('error'));
            }

            if (session('warning')) {
                Alert::warning(session('warning'));
            }
            return $next($request);
        });
    }

    public function index(Request $request)
{
    $query = Pendaftaran::query();

    if ($request->has('filter')) {
        $range = $request->input('filter');
        $startDate = now();

        switch ($range) {
            case 'week':
                $startDate = now()->subWeek();
                break;
            case 'month':
                $startDate = now()->subMonth();
                break;
            case 'year':
                $startDate = now()->subYear();
                break;
        }

        $query->whereDate('tanggal_daftar', '>=', $startDate);
    }

    $data = $query->get();

    return view('pendaftaran.data-pendaftaran-admin', compact('data'));
}

public function print()
{
    $viewData = Pendaftaran::with('pilihan1')->get();
    return view('pendaftaran.print', compact('viewData'));
}


    public function datapendaftaran(){
        $dataUser = ProfileUsers::all();
        $data = Pendaftaran::all();
        $datapembayaran = Pembayaran::all();
        return view ('pendaftaran.data-pendaftaran-admin',['viewDataPembayaran' => $datapembayaran, 'viewDataUser' => $dataUser,'viewData' => $data]);
    }

    public function inputpendaftaran(){
        $dataprod = ProgramUmroh::all();
        $datenow = date('Y-m-d');
        return view ('pendaftaran.data-pendaftaran-input-admin',['viewpaket' => $dataprod]);
    }

    public function simpanpendaftaran(Request $a)
    {
        try{

        $kodependaftaran = Pendaftaran::id();
        

        
        
        $fileftpasfoto = $a->file('ftpasfoto');
        $nama_fileftpasfoto = "Pasfoto".time() . "-" . $fileftpasfoto->getClientOriginalName();
        $namaFolderftpasfoto = 'data pendaftar/'.$kodependaftaran;
        $fileftpasfoto->move($namaFolderftpasfoto,$nama_fileftpasfoto);
        $pathPasfoto = $namaFolderftpasfoto."/".$nama_fileftpasfoto;

        $fileftpassport = $a->file('ftpassport');
        $nama_fileftpassport = "Passport".time() . "-" . $fileftpassport->getClientOriginalName();
        $namaFolderftpassport = 'data pendaftar/'.$kodependaftaran;
        $fileftpassport->move($namaFolderftpassport,$nama_fileftpassport);
        $pathPassport = $namaFolderftpassport."/".$nama_fileftpassport;

        $fileftkk = $a->file('ftkk');
        $nama_fileftkk = "KK".time() . "-" . $fileftkk->getClientOriginalName();
        $namaFolderftkk = 'data pendaftar/'.$kodependaftaran;
        $fileftkk->move($namaFolderftkk,$nama_fileftkk);
        $pathKK = $namaFolderftkk."/".$nama_fileftkk;

        $fileftktp = $a->file('ftktp');
        $nama_fileftktp = "KTP".time() . "-" . $fileftktp->getClientOriginalName();
        $namaFolderftktp = 'data pendaftar/'.$kodependaftaran;
        $fileftktp->move($namaFolderftktp,$nama_fileftktp);
        $pathKTP = $namaFolderftktp."/".$nama_fileftktp;

        $fileftakta = $a->file('ftakta');
        $nama_fileftakta = "Akta".time() . "-" . $fileftakta->getClientOriginalName();
        $namaFolderftakta = 'data pendaftar/'.$kodependaftaran;
        $fileftakta->move($namaFolderftakta,$nama_fileftakta);
        $pathAkta = $namaFolderftakta."/".$nama_fileftakta;

        Pendaftaran::create([
            'id_pendaftaran' => $kodependaftaran,
            'user_id' => Auth::user()->id,
            'nik' => $a->nik,
            'nama' => $a->nama,
            'jenis_kelamin' => $a->jk,
            'pas_foto' => $pathPasfoto,
            'tempat_lahir' => $a->tempatlahir,
            'tanggal_lahir' => $a->tanggallahir,
            'agama' => $a->agama,

            'email' => $a->email,
            'hp' => $a->nohp,

            'alamat' => $a->alamat,

            'pil1' => $a->pil1,
            'pil2' => $a->pil2,

            'passport' => $pathPassport,
            'kk' => $pathKK,
            'ktp' => $pathKTP,
            'akta' => $pathAkta,

            'status_pendaftaran' => 'Belum Terverifikasi',
            'tgl_pendaftaran' => now(),
            'created_at' => now()
        ]);
        $pendaftaranbaru = Pendaftaran::orderBy('id','DESC')->first();
        
        $id_pendaftaran = $pendaftaranbaru->id;
        $kodepembayaran = Pembayaran::id();
        $total = ProgramUmroh::find($a->pil1)?->harga_paket;
        Pembayaran::create([
            'id_pembayaran' => $kodepembayaran,
            'status'=> "Belum Bayar",
            'verifikasi'=> false,
            'jatuh_tempo'  => now()->addDays(2)->format('Y-m-d'),
            'tgl_pembayaran' => now(),
            'total_bayar'  => $total,
            'id_pendaftaran' =>$id_pendaftaran,
            'created_at' => now()
        ]);


        Timeline::create([
            'user_id' => Auth::user()->id,
            'status' => "Pendaftaran",
            'pesan' => "Melakukan pendaftaran penerimaan peserta kursus baru",
            'tgl_update' => now(),
            'created_at' => now()
        ]);

        return redirect('/data-registration')->with('success', 'Data Tersimpan!!');
        } catch (\Exception $e){
            echo $e->getMessage();
        }
    }

    public function verifikasistatuspendaftaran($id_pendaftaran){
        Pendaftaran::where("id_pendaftaran", "$id_pendaftaran")->update([
            'status_pendaftaran' => "Terverifikasi"
        ]);
        Timeline::create([
            'user_id' => Auth::user()->id,
            'status' => "Pendaftaran",
            'pesan' => "Melakukan verifikasi pendaftaran ".$id_pendaftaran,
            'tgl_update' => now(),
            'created_at' => now()
        ]);
        return redirect('/data-registration');
    }

    public function notverifikasistatuspendaftaran($id_pendaftaran){
        Pendaftaran::where("id_pendaftaran", "$id_pendaftaran")->update([
            'status_pendaftaran' => "Belum Terverifikasi"
        ]);
        Timeline::create([
            'user_id' => Auth::user()->id,
            'status' => "Pendaftaran",
            'pesan' => "Melakukan perubahan verifikasi pendaftaran ".$id_pendaftaran." (Belum Terverifikasi)",
            'tgl_update' => now(),
            'created_at' => now()
        ]);
        return redirect('/data-registration');
    }

    public function invalidstatuspendaftaran($id_pendaftaran){
        Pendaftaran::where("id_pendaftaran", "$id_pendaftaran")->update([
            'status_pendaftaran' => "Batal"
        ]);
        Timeline::create([
            'user_id' => Auth::user()->id,
            'status' => "Pendaftaran",
            'pesan' => "Melakukan perubahan verifikasi pendaftaran ".$id_pendaftaran." (Batal)",
            'tgl_update' => now(),
            'created_at' => now()
        ]);
        return redirect('/data-registration');
    }

    public function selesaistatuspendaftaran($id_pendaftaran){
        Pendaftaran::where("id_pendaftaran", "$id_pendaftaran")->update([
            'status_pendaftaran' => "Selesai"
        ]);
        Timeline::create([
            'user_id' => Auth::user()->id,
            'status' => "Pendaftaran",
            'pesan' => "Melakukan perubahan verifikasi pendaftaran ".$id_pendaftaran." (Umumkan)",
            'tgl_update' => now(),
            'created_at' => now()
        ]);
        return redirect('/data-registration');
    }


    public function editpendaftaran($id_pendaftaran)
    {
        $dataUser = ProfileUsers::all();
        $dataprod = ProgramUmroh::all();
        $datenow = date('Y-m-d');
        $data = Pendaftaran::where("id_pendaftaran",$id_pendaftaran)->first();
        return view('pendaftaran.data-pendaftaran-edit-admin', ['viewDataUser' => $dataUser,'viewData' => $data,'viewpaket' => $dataprod]);
    }

    public function updatependaftaran(Request $a, $id_pendaftaran){

        try{

        $kodependaftaran = Pendaftaran::id();
        
        $fileftpasfoto = $a->file('ftpasfoto');
        if(file_exists($fileftpasfoto)){
            $nama_fileftpasfoto = "Pasfoto".time() . "-" . $fileftpasfoto->getClientOriginalName();
            $namaFolderftpasfoto = 'data pendaftar/'.$kodependaftaran;
            $fileftpasfoto->move($namaFolderftpasfoto,$nama_fileftpasfoto);
            $pathPasfoto = $namaFolderftpasfoto."/".$nama_fileftpasfoto;
        } else {
            $pathPasfoto = $a->pathPasfoto;
        }

        $fileftpassport = $a->file('ftpassport');
        if(file_exists($fileftpassport)){
            $nama_fileftpassport = "Passport".time() . "-" . $fileftpassport->getClientOriginalName();
            $namaFolderftpassport = 'data pendaftar/'.$kodependaftaran;
            $fileftpassport->move($namaFolderftpassport,$nama_fileftpassport);
            $pathPassport = $namaFolderftpassport."/".$nama_fileftpassport;
        } else {
            $pathPassport = $a->pathPassport;
        }

        $fileftkk = $a->file('ftkk');
        if(file_exists($fileftkk)){
            $nama_fileftkk = "KK".time() . "-" . $fileftkk->getClientOriginalName();
            $namaFolderftkk = 'data pendaftar/'.$kodependaftaran;
            $fileftkk->move($namaFolderftkk,$nama_fileftkk);
            $pathKK = $namaFolderftkk."/".$nama_fileftkk;
        } else {
            $pathKK = $a->pathKK;
        }

        $fileftktp = $a->file('ftktp');
        if(file_exists($fileftktp)){
            $nama_fileftktp = "KTP".time() . "-" . $fileftktp->getClientOriginalName();
            $namaFolderftktp = 'data pendaftar/'.$kodependaftaran;
            $fileftktp->move($namaFolderftktp,$nama_fileftktp);
            $pathKTP = $namaFolderftktp."/".$nama_fileftktp;
        } else {
            $pathKTP = $a->pathKTP;
        }

        $fileftakta = $a->file('ftakta');
        if(file_exists($fileftakta)){
            $nama_fileftakta = "Akta".time() . "-" . $fileftakta->getClientOriginalName();
            $namaFolderftakta = 'data pendaftar/'.$kodependaftaran;
            $fileftakta->move($namaFolderftakta,$nama_fileftakta);
            $pathAkta = $namaFolderftakta."/".$nama_fileftakta;
        } else {
            $pathAkta = $a->pathAkta;
        }

        Pendaftaran::where("id_pendaftaran", $id_pendaftaran)->update([
            'nik' => $a->nik,
            'nama' => $a->nama,
            'jenis_kelamin' => $a->jk,
            'pas_foto' => $pathPasfoto,
            'tempat_lahir' => $a->tempatlahir,
            'tanggal_lahir' => $a->tanggallahir,
            'agama' => $a->agama,
            'alamat' => $a->alamat,
            'email' => $a->email,
            'hp' => $a->nohp,
            'pil1' => $a->pil1,
            'pil2' => $a->pil2,
            'passport' => $pathPassport,
            'kk' => $pathKK,
            'ktp' => $pathKTP,
            'akta' => $pathAkta
        ]);
        Timeline::create([
            'user_id' => Auth::user()->id,
            'status' => "Pendaftaran",
            'pesan' => "Melakukan perubahan data pendaftaran ".$id_pendaftaran,
            'tgl_update' => now(),
            'created_at' => now()
        ]);
        return redirect('/data-registration')->with('success', 'Data Terubah!!');
        } catch (\Exception $e){
            echo $e;
        }
    }

    public function hapuspendaftaran($id_pendaftaran){
        try{
            $data = Pendaftaran::find($id_pendaftaran);
            File::delete($data->pas_foto);
            File::delete($data->passport);
            File::delete($data->kk);
            File::delete($data->ktp);
            File::delete($data->akta);
            $dataPembayaran = Pembayaran::where("id_pendaftaran",$id_pendaftaran)->first();
            if ($dataPembayaran->bukti_pembayaran != null) {
                File::delete($dataPembayaran->bukti_pembayaran);
            }
            $dataPembayaran->delete();
            
            
            $data->delete();
            return redirect('/data-registration')->with('success', 'Data Terhapus!!');
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Data Tidak Berhasil Dihapus!');
        }
    }

    public function detailpendaftaran($id_pendaftaran)
    {
        $dataUser = ProfileUsers::all();
        $dataprod = ProgramUmroh::all();
        $data = Pendaftaran::where("id_pendaftaran",$id_pendaftaran)->first();
        $datPembayaran = Pembayaran::where("id_pendaftaran",$data->id)->first();
        $no=1;


        $datapembayaran = Pendaftaran::where("id_pendaftaran", $id_pendaftaran)->get();
        return view('pendaftaran.data-pendaftaran-detail', ['viewDataUser' => $dataUser,'viewDataPembayaran' => $datPembayaran,'viewData' => $data,'viewpaket' => $dataprod]);
    }

    public function kartupendaftaran($id_pendaftaran)
    {
        $dataUser = ProfileUsers::all();
        $dataprod = ProgramUmroh::all();
        $data = Pendaftaran::find($id_pendaftaran);
        return view('pendaftaran.data-pendaftaran-kartu-admin', ['viewDataUser' => $dataUser,'viewData' => $data,'viewpaket' => $dataprod]);
    }
}
