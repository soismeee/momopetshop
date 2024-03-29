<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hewan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $primaryKey = 'id';
    public $incrementing = false;

    public function kategori_hewan()
    {
        return $this->belongsTo('App\Models\KategoriHewan', 'kh_id');
    }
}
