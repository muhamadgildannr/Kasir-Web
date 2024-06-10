<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //
        User::create([
            "name"=>"Admin",
            "email"=>"admin@gmail.com",
            "password"=>bcrypt("4dm1n"),
            "role"=>"admin"
        ]);
        User::create([
            "name"=>"Gildan NR",
            "email"=>"gildannr@gmail.com",
            "password"=>bcrypt("gildn"),
            "role"=>"petugas"
        ]);

       
    }
}
