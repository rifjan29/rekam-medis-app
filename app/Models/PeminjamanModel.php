<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanModel extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';
    protected $fillable = [
        'kode_peminjam',
        'unit',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'status_pengembalian',
        'keperluan',
        'status_rm',
        'poli_id',
        'kamar',
        'user_id',
        'id_rm',
        'is_verifikasi',
    ];

    function pasien() {
        return $this->belongsTo(RekamMedisModel::class,'id_rm','id');
    }
    function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }
    function poli() {
        return $this->belongsTo(PoliModel::class,'poli_id','id');
    }
}
