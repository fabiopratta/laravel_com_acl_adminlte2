<?php


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use \Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
           'permission-list',
           'permission-create',
           'permission-edit',
           'permission-delete',
	       'resource-list',
	       'resource-create',
	       'resource-edit',
	       'resource-delete',
	       'user-list',
	       'user-create',
	       'user-edit',
	       'user-delete'
        ];

        foreach ($permissions as $permission) {
	        $idsPermissions[] = Permission::create(['name' => $permission]);
        }

	    $role = Role::findById(1);
        foreach ($idsPermissions as $id => $permissionSave)
        {
	        DB::table("role_has_permissions")->insert(['role_id' => $role->id, 'permission_id' => $permissionSave->id]);
        }


        DB::table("model_has_roles")->insert(['role_id'=>$role->id,'model_type'=>'App\Entities\User','model_id'=>'1']);



    }
}