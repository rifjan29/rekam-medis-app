<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoliModel extends Model
{
    use HasFactory;
    protected $table = 'poli';
    protected $fillable = [
        'poli_name'
    ];
}
