<?php

namespace Database\Seeders;

use App\Models\KategoriBarang;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'id' => intval((microtime(true) * 10000)),
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'role' => '1',
            'status' => '1',
        ]);
        
        User::create([
            'id' => intval((microtime(true) * 10000)),
            'name' => 'Kasir',
            'email' => 'karyawan@gmail.com',
            'username' => 'karyawan',
            'password' => bcrypt('123'),
            'role' => '2',
            'status' => '1',
        ]);
        
        User::create([
            'id' => intval((microtime(true) * 10000)),
            'name' => 'Customer',
            'email' => 'customer@gmail.com',
            'username' => 'customer',
            'password' => bcrypt('123'),
            'role' => '3',
            'status' => '1',
        ]);

        KategoriBarang::create([
            'id' => Str::uuid()->toString(),
            'kategori' => 'pakan',
            'nama_kategori' => 'Makanan kering',
            'keterangan_kategori' => 'Makanan kering',
        ]);

        KategoriBarang::create([
            'id' => Str::uuid()->toString(),
            'kategori' => 'pakan',
            'nama_kategori' => 'Makanan basah',
            'keterangan_kategori' => 'Makanan basah',
        ]);
        
        KategoriBarang::create([
            'id' => Str::uuid()->toString(),
            'kategori' => 'pakan',
            'nama_kategori' => 'Makanan ringan',
            'keterangan_kategori' => 'Makanan ringan',
        ]);
        
        KategoriBarang::create([
            'id' => Str::uuid()->toString(),
            'kategori' => 'alat',
            'nama_kategori' => 'tempat makan',
            'keterangan_kategori' => 'tempat makan',
        ]);

        KategoriBarang::create([
            'id' => Str::uuid()->toString(),
            'kategori' => 'alat',
            'nama_kategori' => 'Kandang hewan',
            'keterangan_kategori' => 'Kandang hewan',
        ]);
        
        KategoriBarang::create([
            'id' => Str::uuid()->toString(),
            'kategori' => 'alat',
            'nama_kategori' => 'mainan',
            'keterangan_kategori' => 'mainan',
        ]);
    }
}
