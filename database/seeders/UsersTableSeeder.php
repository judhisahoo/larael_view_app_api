<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users=\App\Models\User::factory()->count(5)->make()->toArray();
        foreach($users AS $k){
            $userObj= new User();
            $userObj->name=$k['name'];
            $userObj->email=$k['email'];
            $userObj->phone=$k['phone'];
            $userObj->password='$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
            $userObj->remember_token=Str::random(20);
            $userObj->save();
        }
    }
}
