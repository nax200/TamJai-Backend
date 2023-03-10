<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'aungpor.napat@gmail.com')->first();
        if (!$user) {
            $user = new User;
            $user->name = "aungpor";
            $user->role = 'USER';
            $user->email = 'aungpor.napat@gmail.com';
            $user->password = Hash::make('userpass');
            $user->phone_number = "0811234445";
            $user->save();
        }

        $user = User::where('email', 'Irisia@gmail.com')->first();
        if (!$user) {
            $user = new User;
            $user->name = "Ton";
            $user->role = 'USER';
            $user->email = 'Irisia@gmail.com';
            $user->password = Hash::make('userpass');
            $user->phone_number = "0822387846";
            $user->save();
        }

        $user = User::where('email', 'a@a.com')->first();
        if (!$user) {
            $user = new User;
            $user->name = "a";
            $user->role = 'USER';
            $user->email = 'a@a.com';
            $user->password = Hash::make('userpass');
            $user->phone_number = "0812345678";
            $user->save();
        }
    }
}
