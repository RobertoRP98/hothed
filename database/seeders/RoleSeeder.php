<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; 
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Crear roles
         $roleAlmacen = Role::firstOrCreate(['name' => 'Almacen']);
         $roleCobranza = Role::firstOrCreate(['name' => 'Cobranza']);

         // Crear permisos
         $permisoAlmacen = Permission::firstOrCreate(['name' => 'manage_almacen']);
         $permisoCobranza = Permission::firstOrCreate(['name'=> 'manage_cobranza']);
 
         // Asignar permisos al rol
         $roleAlmacen->givePermissionTo($permisoAlmacen);
         $roleCobranza->givePermissionTo($permisoCobranza);
 
         // Asignar el rol a un usuario específico
         $user = User::find(3); // Cambia el ID de usuario según sea necesario
         if ($user) {
             $user->assignRole('Almacen');
         }

         $user = User::find(4); // Cambia el ID de usuario según sea necesario
         if ($user) {
             $user->assignRole('Cobranza');
         }
     }
}
