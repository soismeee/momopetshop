<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $primaryKey = 'id';
    public $incrementing = false;

    public function kategori_barang()
    {
        return $this->belongsTo('App\Models\KategoriBarang', 'kb_id');
    }
}
