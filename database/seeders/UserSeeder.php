<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = ['admin','petugas-rm','petugas-peminjam'];
        $name = ['administrator','Petugas RM','Petugas Peminjam'];
        for ($i=0; $i < count($role) ; $i++) {
            $user = new User;
            $user->name = $name[$i];
            $user->email = $role[$i].'@mail.com';
            $user->password = Hash::make('password');
            $user->role = $role[$i];
            $user->save();
        }
    }
}
