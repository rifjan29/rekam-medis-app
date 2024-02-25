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
        'user_id',
        'id_rm',
    ];

    function pasien() {
        return $this->belongsTo(RekamMedisModel::class,'id_rm','id');
    }
    function user() {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
