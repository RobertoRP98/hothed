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
         $roleCompras = Role::firstOrCreate(['name' => 'Compras']);
         
         $roleClientCompras = Role::firstOrCreate(['name' => 'ClientCompras']);
         $roleAdmCompras = Role::firstOrCreate(['name' => 'AdmCompras']);
         $roleOpeCompras = Role::firstOrCreate(['name' => 'OpeCompras']);
         $roleRespCompras = Role::firstOrCreate(['name' => 'RespCompras']);


         // Crear permisos
         $permisoAlmacen = Permission::firstOrCreate(['name' => 'manage_almacen']);
         $permisoCobranza = Permission::firstOrCreate(['name'=> 'manage_cobranza']);
         $permisoKarlaS = Permission::firstOrCreate(['name'=> 'manage_administracionkarla']);
         $permisoDeveloper = Permission::firstOrCreate(['name'=> 'developer']);
         $permisoDirOperaciones = Permission::firstOrCreate(['name'=> 'diroperaciones']);
         $permisoGerOperaciones = Permission::firstOrCreate(['name'=> 'geroperaciones']);
         $permisoVerCobranza = Permission::firstOrCreate(['name'=> 'vercobranza']);
         $permisoCompras = Permission::firstOrCreate(['name'=> 'Compras']);

         $permisoClientCompras = Permission::firstOrCreate(['name' => 'ClientCompras']);
         $permisoAdmCompras = Permission::firstOrCreate(['name' => 'AdmCompras']);
         $permisoOpeCompras = Permission::firstOrCreate(['name' => 'OpeCompras']);
         $permisoRespCompras = Permission::firstOrCreate(['name' => 'RespCompras']);






         // Asignar permisos al rol
         $roleAlmacen->givePermissionTo($permisoAlmacen);
         $roleCobranza->givePermissionTo($permisoCobranza);
         $roleKarlaS->givePermissionTo($permisoKarlaS);
         $roleDeveloper->givePermissionTo($permisoDeveloper);
         $roleDirOperaciones->givePermissionTo($permisoGerOperaciones);
         $roleGerOperaciones->givePermissionTo($permisoDirOperaciones);
         $roleVerCobranza->givePermissionTo($permisoVerCobranza);
         $roleCompras->givePermissionTo($permisoCompras);


         $roleClientCompras->givePermissionTo($permisoClientCompras);
         $roleAdmCompras->givePermissionTo($permisoAdmCompras);
         $roleOpeCompras->givePermissionTo($permisoOpeCompras);
         $roleRespCompras->givePermissionTo($permisoRespCompras);


         // Asignar el rol a un usuario específico

        // ALMACEN

         $user = User::find(3); // Cambia el ID de usuario según sea necesario
         if ($user) {
             $user->assignRole('Almacen');
         }
         // FIN ALMACEN

         //COBRANZA

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

         
         $user = User::find(8); // Cambia el ID de usuario según sea necesario
         if ($user) {
             $user->assignRole('VerCobranza');
         }

         $user = User::find(9); // Cambia el ID de usuario según sea necesario
         if ($user) {
             $user->assignRole('VerCobranza');
         }

         $user = User::find(10); // Cambia el ID de usuario según sea necesario
         if ($user) {
             $user->assignRole('VerCobranza');
         }

          //AUX COBRANZA PARA BIANCA Y PERLA
          $user = User::find(13); // Bianca
          if ($user) {
              $user->assignRole('Cobranza');
          }
          $user = User::find(15); // Perla
          if ($user) {
              $user->assignRole('Cobranza');
          }
          // FIN COBRANZA


          //COMPRAS
         $user = User::find(11); // Cambia el ID de usuario según sea necesario
         if ($user) {
             $user->assignRole('Compras'); // PERFIL DE JESSI
         }

         $user = User::find(13); // Cambia el ID de usuario según sea necesario
         if ($user) {
             $user->assignRole('RespCompras');
         }

         $user = User::find(5); // Cambia el ID de usuario según sea necesario
         if ($user) {
             $user->assignRole('AdmCompras');
         }

         $user = User::find(9); // Cambia el ID de usuario según sea necesario
         if ($user) {
             $user->assignRole('OpeCompras');
         }

         $user = User::find(10); // Cambia el ID de usuario según sea necesario
         if ($user) {
             $user->assignRole('OpeCompras');
         }

         $user = User::find(16); // Cambia el ID de usuario según sea necesario
         if ($user) {
             $user->assignRole('ClientCompras');
         }

         $user = User::find(4); // Cambia el ID de usuario según sea necesario
         if ($user) {
             $user->assignRole('ClientCompras');
         }

         $user = User::find(17); // Cambia el ID de usuario según sea necesario
         if ($user) {
             $user->assignRole('ClientCompras');
         }

         $user = User::find(18); // Cambia el ID de usuario según sea necesario
         if ($user) {
             $user->assignRole('ClientCompras');
         }
         
         $user = User::find(19); // Cambia el ID de usuario según sea necesario
         if ($user) {
             $user->assignRole('ClientCompras');
         }

         $user = User::find(20); // Cambia el ID de usuario según sea necesario
         if ($user) {
             $user->assignRole('ClientCompras');
         }

         $user = User::find(21); // Cambia el ID de usuario según sea necesario
         if ($user) {
             $user->assignRole('ClientCompras');
         }




         //FIN COMPRAS

        
     }
}
