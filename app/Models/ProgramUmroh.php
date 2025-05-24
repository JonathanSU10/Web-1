<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProgramUmroh extends Model
{
    use HasFactory;
    protected $table = "program_umroh";
    protected $primaryKey= "id";
    protected $fillable = ["id_paket","nama_paket","foto_paket","jam","hari","harga_paket"];
    public $timestamps = false;
    public $incrementing = false;

    public static function id()
    {
    	$kode = DB::table('program_umroh')->max('id');
    	$addNol = '';
    	$kode = str_replace("PU", "", $kode);
    	$kode = (int) $kode + 1;
        $incrementKode = $kode;

    	if (strlen($kode) == 1) {
    		$addNol = "00";
    	} elseif (strlen($kode) == 2) {
    		$addNol = "0";
        }
    	$kodeBaru = "PU".$addNol.$incrementKode;
    	return $kodeBaru;
    }

    public function pengumuman()
    {
    return $this->belongsTo(Pengumuman::class);
    }

    public function pendaftaran(){
        return $this->hasMany(Pendaftaran::class);
    }
}
