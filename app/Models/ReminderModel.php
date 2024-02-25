<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReminderModel extends Model
{
    use HasFactory;
    protected $table = 'reminder';
    protected $fillable = [
        'user_id',
        'keterangan_reminder',
    ];
}
