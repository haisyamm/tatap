<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RAB extends Model
{
    use HasFactory;
    protected $fillable = [
        'no_rab',
        'id_penyusun',
        'tgl_rab',
        'total'
    ];
}
