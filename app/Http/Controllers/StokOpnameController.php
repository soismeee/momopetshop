<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StokOpnameController extends Controller
{
    public function opname_alat_pakan(){
        return view('stok_opname.alat_dan_pakan', [
            'title' => 'Stok opname peralatan hewan',
        ]);
    }

    public function opname_hewan(){
        return view('stok_opname.hewan', [
            'title' => 'Stok opname pakan',
        ]);
    }
}
