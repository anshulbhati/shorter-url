<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\ShorterLink;


class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::factory(10)->create();
        $users = User::factory(100)->create();
        $users->each(function ($user) {
            $role = Role::whereNotIn('name', ['super_admin'])->inRandomOrder()->first();
            if ($role) {
                $user->roles()->attach($role->id);
            }
        });
        
        ShorterLink::factory(1000)->make()->each(function ($link) {
            $random_user = User::inRandomOrder()->first();
            if (! $random_user) {
                return;
            }
            $link->user_id = $random_user->id;
            $link->company_id = $random_user->company_id;
            $link->save();
        });
    }
}
