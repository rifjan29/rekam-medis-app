<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TtdModel extends Model
{
    use HasFactory;
    protected $table = 'ttd';
    protected $guarded = ['id'];
}
