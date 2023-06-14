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

    public function detail()
    {
        return $this->hasMany(RABDetails::class, 'no_rab', 'no_rab');
    }

    public function getManager()
    {
        return $this->belongsTo(User::class, 'id_penyusun', 'id');
    }
}
