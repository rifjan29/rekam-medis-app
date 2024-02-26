<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedisModel extends Model
{
    use HasFactory;
    protected $table = 'pasien';
    protected $fillable = [
        'no_rm',
        'nama_pasien',
        'tempat_lahir',
        'tanggal_lahir',
        'no_hp',
        'alamat',
        'jenis_kelamin',
        'user_id',
    ];
}
