<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        DB::table('users')->insert([
           [
            'username' => 'nopal',
            'email' => 'leader@gmail.com',
            'password' => Hash::make('nopal123'),
            'hak_akses' => 'pimpinan',
            'alamat' => 'jalan jalan ',
            'no_telp' => '86876'],
           [
            'username' => 'nopal1',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('nopal123'),
            'hak_akses' => 'admin',
            'alamat' => 'ahsfhads',
            'no_telp' => '9222'],
           [
            'username' => 'nopal2',
            'email' => 'nopal@gmail.com',
            'password' => Hash::make('nopal123'),
            'hak_akses' => 'member',
            'alamat' => 'Jl nopal',
            'no_telp' => '08123456'],
           [
            'username' => 'nopal3',
            'email' => 'kasir@gmail.com',
            'password' => Hash::make('nopal123'),
            'hak_akses' => 'kasir',
            'alamat' => 'disini',
            'no_telp' => '00000'],
        ]);

        DB::table('kategoris')->insert([
           [
            'nama_kategori' => 'Injection'
        ],
           [
            'nama_kategori' => 'Pill'
        ],
           [
            'nama_kategori' => 'Tablet'
        ],
           [
            'nama_kategori' => 'Drops'
        ],
        ]);

        DB::table('barangs')->insert([
            [
                'id_kategori' => 1,
                'nama_barang' => 'Testosterone Enanthate',
                'detail_barang' => 'Steroid anabolik ',
                'berat' => 10.5,
                'harga_jual' => 300000,
                'harga_beli' => 250000,
                'foto' => 'enanhate.jpg',
                'stok' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kategori' => 3,
                'nama_barang' => 'Dianabol',
                'detail_barang' => 'Steroid oral',
                'berat' => 5.2,
                'harga_jual' => 150000,
                'harga_beli' => 100000,
                'foto' => 'dbol.jpg',
                'stok' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kategori' => 1,
                'nama_barang' => 'Trenbolone Acetate',
                'detail_barang' => 'Steroid kuat ',
                'berat' => 8.3,
                'harga_jual' => 400000,
                'harga_beli' => 350000,
                'foto' => 'trenbolone.jpg',
                'stok' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kategori' => 4,
                'nama_barang' => 'Deca-Durabolin',
                'detail_barang' => 'Steroid dengan efek samping rendah',
                'berat' => 12.0,
                'harga_jual' => 280000,
                'harga_beli' => 230000,
                'foto' => 'deca.jpg',
                'stok' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kategori' => 2,
                'nama_barang' => 'Anavar',
                'detail_barang' => 'Steroid ringan',
                'berat' => 4.7,
                'harga_jual' => 350000,
                'harga_beli' => 300000,
                'foto' => 'Anavar.jpg',
                'stok' => 25,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('suppliers')->insert([
            [
                'nama_supplier' => 'Dyfan Xavier',
                'alamat_supplier' => 'Jl Supplier 1',
                'no_telp' => '081234567890',
            ],
            [
                'nama_supplier' => 'Rich Piana',
                'alamat_supplier' => 'California',
                'no_telp' => '911',
            ],
        ]);
    }
}
