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
    }
}
