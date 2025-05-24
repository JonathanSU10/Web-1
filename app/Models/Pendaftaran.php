<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
Use Illuminate\Support\Carbon;

class Pendaftaran extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;

    protected $table = 'pendaftaran';
    protected $primaryKey = "id";
    protected $fillable = [
        'id_pendaftaran',
        'user_id',
        'nik',
        'nama',
        'jenis_kelamin',
        'pas_foto',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',

        'email',
        'hp',

        'alamat',

        'pil1',
        'pil2',

        'passport',
        'kk',
        'ktp',
        'akta',

        'status_pendaftaran',
        'tgl_pendaftaran',
        'created_at'
    ];


    public static function id()
{
    $data = DB::table('pendaftaran')->orderBy('id_pendaftaran', 'DESC')->first();

    if (!$data) {
        $kodeBaru = now()->format('Y') . now()->format('m') . '0001';
    } else {
        $kodeakhir5 = substr($data->id_pendaftaran, -4);
        $kodeku = (int)$kodeakhir5;
        $kode = $kodeku + 1;
        $addNol = str_pad('', 4 - strlen($kode), '0');
        $kodeBaru = now()->format('Y') . now()->format('m') . $addNol . $kode;
    }

    return $kodeBaru;
}

    public function user()
    {
         return $this->belongsTo(User::class, 'user_id');
    }

     public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function pengumuman()
    {
        return $this->hasMany(pengumuman::class);
    }

    public function jadwal(){
        return $this->belongsTo(JadwalKegiatan::class,'gelombang');
    }

    public function pilihan1(){
        return $this->belongsTo(ProgramUmroh::class,'pil1');
    }

    public function pilihan2(){
        return $this->belongsTo(ProgramUmroh::class,'pil2');
    }
}
