<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    //
    protected $table = 'layanan';
    protected $primaryKey = 'id_layanan';
    protected $fillable = [
        'nama', 
        'deskripsi', 
        'harga'
    ];
     public $timestamps = false;
}
