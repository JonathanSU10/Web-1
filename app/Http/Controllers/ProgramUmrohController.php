<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProgramUmroh;
use Alert;

class ProgramUmrohController extends Controller
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


    public function datapaket(){
        $viewData = ProgramUmroh::all();
        return view ('paket.data-programUmroh-admin',compact('viewData'));
    }

    public function simpanpaket(Request $a)
    {
        try{

            $kode=ProgramUmroh::id();

            $fileft = $a->file('foto');
            if(file_exists($fileft)){
                $nama_fileft = "paket".time() . "-" . $fileft->getClientOriginalName();
                $namaFolderft = 'foto paket';
                $fileft->move($namaFolderft,$nama_fileft);
                $path = $namaFolderft."/".$nama_fileft;
            } else {
                $path = null;
            }

            ProgramUmroh::create([
                'id_paket' => $kode,
                'nama_paket' => $a->nama,
                'foto_paket' => $path,
                'jam' => $a->jam,
                'hari' => $a->hari,
                'harga_paket' => $a->harga_paket,
        ]);
            return redirect('/data-paket')->with('success', 'Data Tersimpan!!');
        } catch (\Exception $e){
            echo $e;
        }
    }

    public function updatepaket(Request $a, $id_paket){
        try{
            $fileft = $a->file('foto');
            if(file_exists($fileft)){
                $nama_fileft = "paket".time() . "-" . $fileft->getClientOriginalName();
                $namaFolderft = 'foto paket';
                $fileft->move($namaFolderft,$nama_fileft);
                $path = $namaFolderft."/".$nama_fileft;
            } else {
                $path = $a->pathnya;
            }
            ProgramUmroh::where("id", $id_paket)->update([
                'nama_paket' => $a->nama,
                'foto_paket' => $path,
                'jam' => $a->jam,
                'hari' => $a->hari,
                'harga_paket' => $a->harga_paket,
        ]);
            return redirect('/data-paket')->with('success', 'Data Terubah!!');
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Data Tidak Berhasil Diubah!');
        }
    }

    public function hapuspaket($id_paket){
        try{
            $data = ProgramUmroh::find($id_paket);
            $data->delete();
            return redirect('/data-paket')->with('success', 'Data Terhapus!!');
        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Data Tidak Berhasil Dihapus!');
        }
    }
}
