<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Pembayaran extends Model
{
    use HasFactory;
    protected $table = "pembayaran";
    protected $fillable = ["id_pembayaran","bukti_pembayaran","status","verifikasi","tgl_pembayaran","id_pendaftaran","total_bayar"];
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey= "id";

	public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran');
 	}
     public static function id()
     {
         $data = DB::table('pembayaran')->orderBy('id_pendaftaran', 'DESC')->first();
         $kodetb = 'TAG';
         $addNol = '';
         
         if (!$data) {
             $kodeBaru = $kodetb . now()->format('y') . '0001';
         } else {
             $kodeakhir5 = substr($data->id_pendaftaran, -3);
             $kodeku = (int)$kodeakhir5;
             $kode = $kodeku + 1;
     
             if (strlen($kode) == 1) {
                 $addNol = "000";
             } elseif (strlen($kode) == 2) {
                 $addNol = "00";
             } elseif (strlen($kode) == 3) {
                 $addNol = "0";
             }
     
             $kodeBaru = $kodetb . now()->format('y') . $addNol . $kode;
         }
     
         return $kodeBaru;
     }     
}
