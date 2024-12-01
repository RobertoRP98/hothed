<?php

namespace Database\Seeders;

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
         $roleKarlaS = Role::firstOrCreate(['name' => 'AdministracionKarla']);
         $roleDeveloper = Role::firstOrCreate(['name' => 'Developer']);
         $roleDirOperaciones = Role::firstOrCreate(['name' => 'DirOperaciones']);
         $roleGerOperaciones = Role::firstOrCreate(['name' => 'GerOperaciones']);
         $roleVerCobranza = Role::firstOrCreate(['name' => 'VerCobranza']);




         // Crear permisos
         $permisoAlmacen = Permission::firstOrCreate(['name' => 'manage_almacen']);
         $permisoCobranza = Permission::firstOrCreate(['name'=> 'manage_cobranza']);
         $permisoKarlaS = Permission::firstOrCreate(['name'=> 'manage_administracionkarla']);
         $permisoDeveloper = Permission::firstOrCreate(['name'=> 'developer']);
         $permisoDirOperaciones = Permission::firstOrCreate(['name'=> 'diroperaciones']);
         $permisoGerOperaciones = Permission::firstOrCreate(['name'=> 'geroperaciones']);
         $permisoVerCobranza = Permission::firstOrCreate(['name'=> 'vercobranza']);





         // Asignar permisos al rol
         $roleAlmacen->givePermissionTo($permisoAlmacen);
         $roleCobranza->givePermissionTo($permisoCobranza);
         $roleKarlaS->givePermissionTo($permisoKarlaS);
         $roleDeveloper->givePermissionTo($permisoDeveloper);
         $roleDirOperaciones->givePermissionTo($permisoGerOperaciones);
         $roleGerOperaciones->givePermissionTo($permisoDirOperaciones);
         $roleVerCobranza->givePermissionTo($permisoVerCobranza);




         // Asignar el rol a un usuario específico
         $user = User::find(3); // Cambia el ID de usuario según sea necesario
         if ($user) {
             $user->assignRole('Almacen');
         }

         $user = User::find(4); // Cambia el ID de usuario según sea necesario
         if ($user) {
             $user->assignRole('Cobranza');
         }

         $user = User::find(5); // Cambia el ID de usuario según sea necesario
         if ($user) {
             $user->assignRole('AdministracionKarla');
         }

         $user = User::find(2); // Cambia el ID de usuario según sea necesario
         if ($user) {
             $user->assignRole('Developer');
         }

         $user = User::find(6); // Cambia el ID de usuario según sea necesario
         if ($user) {
             $user->assignRole('VerCobranza');
         }

         $user = User::find(7); // Cambia el ID de usuario según sea necesario
         if ($user) {
             $user->assignRole('VerCobranza');
         }

         //AUX COBRANZA PARA BIANCA Y PERLA


        //  $user = User::find(6); // Cambia el ID de usuario según sea necesario
        //  if ($user) {
        //      $user->assignRole('DirOperaciones');
        //  }
        //  $user = User::find(7); // Cambia el ID de usuario según sea necesario
        //  if ($user) {
        //      $user->assignRole('Geroperaciones');
        //  }
     }
}
