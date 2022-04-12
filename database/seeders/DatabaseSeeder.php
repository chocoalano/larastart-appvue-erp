<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete'
         ];
    
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
 
         $user = User::create([
             'name' => 'Administrator', 
             'email' => 'admin@example.com',
             'password' => bcrypt('123456')
         ]);
         $role = Role::create(['name' => 'Administrator']);
         $permissions = Permission::pluck('id','id')->all();
         $role->syncPermissions($permissions);
         $user->assignRole([$role->id]);
    }
}
