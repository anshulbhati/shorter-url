<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $data = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('12345678'),
            'company_id' => null,
        ]);
        $superAdminRoleId = Role::where('name', 'super_admin')->value('id');
        DB::table('user_role')->insert([
            'user_id' => $data->id,
            'role_id' => $superAdminRoleId,
        ]);
    }
}
