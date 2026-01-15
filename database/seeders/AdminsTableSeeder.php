<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('123456');
        $admin = new Admin();
        $admin->name = 'pappie pappie';
        $admin->role = 'admin';
        $admin->mobile = '+23470986378';
        $admin->email = 'admin@gmail.com';
        $admin->password = $password;
        $admin->status = 1;
        $admin->save();

        //  $password = Hash::make('123456');
        // $admin = new Admin();
        // $admin->name = 'daniel exclusive';
        // $admin->role = 'subadmin';
        // $admin->mobile = '0908765784';
        // $admin->email = 'daniel@gmail.com';
        // $admin->password = $password;
        // $admin->status = 1;
        // $admin->save();

        // $admin = new Admin();
        // $admin->name = 'paps paps';
        // $admin->role = 'subadmin';
        // $admin->mobile = '080678345673';
        // $admin->email = 'paps@gmail.com';
        // $admin->password = $password;
        // $admin->status = 1;
        // $admin->save();

    }
}
