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

         //ROLES COMPRAS ESTRUCTURADO CON ORGANIGRAMA - LOS ROLES SE TOMAN EN CUENTA DE LA FECHA 28-01-2025

         $roleAuxconta = Role::firstOrCreate(['name' => 'Auxconta']);

         $roleAuxlogmanto = Role::firstOrCreate(['name' => 'Auxlogmanto']); //NO HAY PERSONAL
         $roleCoordalm = Role::firstOrCreate(['name' => 'Coordalm']); // ES EDUARDO
         $roleAuxopeventas = Role::firstOrCreate(['name' => 'Auxopeventas']);

         
         $roleCoordhse = Role::firstOrCreate(['name' => 'Coordhse']);//NO HAY PERSONAL
         
         $roleRespsgi = Role::firstOrCreate(['name' => 'Respsgi']);
         $roleAuxti = Role::firstOrCreate(['name' => 'Auxti']);
         $roleCoordrh = Role::firstOrCreate(['name' => 'Coordrh']);
         $roleRespcomp = Role::firstOrCreate(['name' => 'Respcomp']);
         $roleCoordcontratos = Role::firstOrCreate(['name' => 'Coordcontratos']);
         $roleCoordconta = Role::firstOrCreate(['name' => 'Coordconta']);
         $roleDiradmin = Role::firstOrCreate(['name' => 'Diradmin']);

         $roleSubgerope = Role::firstOrCreate(['name' => 'Subgerope']);
         $roleVentas = Role::firstOrCreate(['name' => 'Ventas']); //NO HAY PERSONAL
         $roleGerope = Role::firstOrCreate(['name' => 'Gerope']);

         $roleAuxcontratos = Role::firstOrCreate(['name' => 'Auxcontratos']);

         $roleDirope = Role::firstOrCreate(['name' => 'Dirope']);


         //FIN ROLES COMPRAS ESTRUCTURADO CON ORGANIGRAMA

         // Crear permisos
         $permisoAlmacen = Permission::firstOrCreate(['name' => 'manage_almacen']);
         $permisoCobranza = Permission::firstOrCreate(['name'=> 'manage_cobranza']);
         $permisoKarlaS = Permission::firstOrCreate(['name'=> 'manage_administracionkarla']);
         $permisoDeveloper = Permission::firstOrCreate(['name'=> 'developer']);
         $permisoDirOperaciones = Permission::firstOrCreate(['name'=> 'diroperaciones']);
         $permisoGerOperaciones = Permission::firstOrCreate(['name'=> 'geroperaciones']);
         $permisoVerCobranza = Permission::firstOrCreate(['name'=> 'vercobranza']);
         $permisoCompras = Permission::firstOrCreate(['name'=> 'Compras']);

         //PERMISOS COMPRAS ESTRUCTURADO CON ORGANIGRAMA
         $permisoAuxconta = Permission::firstOrCreate(['name' => 'Auxconta']);

         $permisoAuxlogmanto = Permission::firstOrCreate(['name' => 'Auxlogmanto']);
         $permisoCoordalm = Permission::firstOrCreate(['name' => 'Coordalm']);
         $permisoAuxopeventas = Permission::firstOrCreate(['name' => 'Auxopeventas']);

         $permisoCoordhse = Permission::firstOrCreate(['name' => 'Coordhse']);

         $permisoRespsgi = Permission::firstOrCreate(['name' => 'Respsgi']);
         $permisoAuxti = Permission::firstOrCreate(['name' => 'Auxti']);
         $permisoCoordrh = Permission::firstOrCreate(['name' => 'Coordrh']);
         $permisoRespcomp = Permission::firstOrCreate(['name' => 'Respcomp']);
         $permisoCoordcontratos = Permission::firstOrCreate(['name' => 'Coordcontratos']);
         $permisoCoordconta = Permission::firstOrCreate(['name' => 'Coordconta']);
         $permisoDiradmin = Permission::firstOrCreate(['name' => 'Diradmin']);

         $permisoSubgerope = Permission::firstOrCreate(['name' => 'Subgerope']);
         $permisoVentas = Permission::firstOrCreate(['name' => 'Ventas']);
         $permisoGerope = Permission::firstOrCreate(['name' => 'Gerope']);

         $permisoAuxcontratos = Permission::firstOrCreate(['name' => 'Auxcontratos']);

         $permisoDirope = Permission::firstOrCreate(['name' => 'Dirope']);

         // FIN PERMISOS COMPRAS ESTRUCTURADO CON ORGANIGRAMA

         // Asignar permisos al rol
         $roleAlmacen->givePermissionTo($permisoAlmacen);
         $roleCobranza->givePermissionTo($permisoCobranza);
         $roleKarlaS->givePermissionTo($permisoKarlaS);
         $roleDeveloper->givePermissionTo($permisoDeveloper);
         $roleDirOperaciones->givePermissionTo($permisoGerOperaciones);
         $roleGerOperaciones->givePermissionTo($permisoDirOperaciones);
         $roleVerCobranza->givePermissionTo($permisoVerCobranza);
         $roleCompras->givePermissionTo($permisoCompras);

         //PERMISOS COMPRAS ESTRUCTURADO CON ORGANIGRAMA
         $roleAuxconta->givePermissionTo($permisoAuxconta);

         $roleAuxlogmanto->givePermissionTo($permisoAuxlogmanto);
         $roleCoordalm->givePermissionTo($permisoCoordalm);
         $roleAuxopeventas->givePermissionTo($permisoAuxopeventas);

         $roleCoordhse->givePermissionTo($permisoCoordhse);

         $roleRespsgi->givePermissionTo($permisoRespsgi);
         $roleAuxti->givePermissionTo($permisoAuxti);
         $roleCoordrh->givePermissionTo($permisoCoordrh);
         $roleRespcomp->givePermissionTo($permisoRespcomp);
         $roleCoordcontratos->givePermissionTo($permisoCoordcontratos);
         $roleCoordconta->givePermissionTo($permisoCoordconta);
         $roleDiradmin->givePermissionTo($permisoDiradmin);

         $roleSubgerope->givePermissionTo($permisoSubgerope);
         $roleVentas->givePermissionTo($permisoVentas);
         $roleGerope->givePermissionTo($permisoGerope);

         $roleAuxcontratos->givePermissionTo($permisoAuxcontratos);
         
         $roleDirope->givePermissionTo($permisoDirope);

         //FIN PERMISOS COMPRAS ESTRUCTURADO CON ORGANIGRAMA


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
       

         $user = User::find(22); // Cambia el ID de usuario según sea necesario
         if ($user) {
             $user->assignRole('Auxconta');
         }

         $user = User::find(20);
         if ($user) {
             $user->assignRole('Coordalm');
         }

         
         $user = User::find(17);
         if ($user) {
             $user->assignRole('Auxopeventas');
         }
         $user = User::find(16);
         if ($user) {
             $user->assignRole('Respsgi');
         }
         $user = User::find(2);
         if ($user) {
             $user->assignRole('Auxti');
         }
         $user = User::find(19);
         if ($user) {
             $user->assignRole('Coordrh');
         }
         $user = User::find(13);
         if ($user) {
             $user->assignRole('Respcomp');
         }
         $user = User::find(4);
         if ($user) {
             $user->assignRole('Coordcontratos');
         }
         $user = User::find(7);
         if ($user) {
             $user->assignRole('Coordconta');
         }
         $user = User::find(5);
         if ($user) {
             $user->assignRole('Diradmin');
         }
         $user = User::find(23);
         if ($user) {
             $user->assignRole('Subgerope');
         }
         $user = User::find(10);
         if ($user) {
             $user->assignRole('Gerope');
         }
         $user = User::find(13);
         if ($user) {
             $user->assignRole('Auxcontratos');
         }
         $user = User::find(9);
         if ($user) {
             $user->assignRole('Dirope');
         }

         //FIN COMPRAS

        
     }
}
