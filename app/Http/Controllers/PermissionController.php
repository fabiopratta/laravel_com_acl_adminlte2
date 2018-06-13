<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Spatie\Permission\Traits\RefreshesPermissionCache;
use Spatie\Permission\PermissionRegistrar;


class PermissionController extends Controller
{
	use RefreshesPermissionCache;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:permission-list');
         $this->middleware('permission:permission-create', ['only' => ['create','store']]);
         $this->middleware('permission:permission-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

	    $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
	                                 ->get();

	    $arrRolesPermissions = [];
	    foreach($rolePermissions as $key => $rp)
	    {
		    $role = Role::findById($rp->role_id);
		    $nameArr = explode("-",$rp->name);
		    $arrRolesPermissions[$rp->role_id]['permissions'][] = $rp;
		    $arrRolesPermissions[$rp->role_id]['role'] = $role;
		    $arrRolesPermissions[$rp->role_id]['resources'][$nameArr[0]] = ucfirst($nameArr[0]);
	    }

	    $retorno = [];
	    foreach ($arrRolesPermissions as $key => $permiss)
	    {

			foreach ($permiss['permissions'] as $key => $permission)
			{
				$nameResource = explode("-",$permission->name);
				$action[$permiss['role']->id]['resources'][$nameResource[0]][] = $nameResource[1];
				$action[$permiss['role']->id]['role'] = $permiss['role'];
			}
		    $retorno = $action;
		   // $retorno[$key]['roles'] = $permiss['role'];
	    }

	    $permissionsShow = ['list'=>'Listar','create'=>"Criar",'edit'=>'Editar','delete'=>'Deletar'];

        return view('permissions.index',compact('retorno','permissionsShow'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
	    $resourcesDB = Permission::get();
        $roles = Role::pluck('name', 'id');

        $resources = [];
	    foreach ($resourcesDB as $resDB)
	    {
		    $res = explode("-",$resDB->name);
		    if(!in_array($res[0],$resources)){
			    $resources[$res[0]] = ucfirst($res[0]);
		    }
	    }

	    $permissions = ['list'=>'Listar','create'=>"Criar",'edit'=>'Editar','delete'=>'Deletar'];

        return view('permissions.create',compact('resources', 'roles', 'permissions'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'role' => 'required',
            'permissions' => 'required',
            'resource' => 'required',
        ]);


        $role = Role::findById($request->input('role'));

        $resource = $request->input('resource');
        $permissions = $request->input('permissions');


        //ArrPermissoes ja existentes
	    $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
	                                 ->get();
	    $arrPermissions = [];
	    foreach ($rolePermissions as $resDB)
	    {
	    	if($resDB->role_id == $role->id){
			    $arrPermissions[] = $resDB->name;
		    }
	    }


        //Arr Novas Permissoes
	    foreach ($permissions as $permission ) {
	    	$permissionFind = $resource."-".$permission;
		    $key = array_search( $permissionFind, $arrPermissions );

		    if(!in_array($permissionFind, $arrPermissions)){
				$arrPermissions[] = Permission::findByName($permissionFind);
		    }

	    }


        $role->syncPermissions($arrPermissions);


        return redirect()->route('permissions.index')
                        ->with('success','Permissao criada com sucesso');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();


        return view('roles.show',compact('role','rolePermissions'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($params)
    {

	    $trt = explode("-",$params);

	    $role_id = $trt[0];
	    $resource = $trt[1];

	    $role = Role::findById($role_id);

		$roles[$role->id] = $role->name;

	    $permissions = ['list','create','edit','delete'];
	    foreach ($permissions as $per)
	    {
		    $resources[$resource] = ucfirst($resource);
	    }

	    //ArrPermissoes ja existentes
	    $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
	                                 ->get();

	    $arrPermissions = [];
	    $permissions = ['list'=>'Listar','create'=>"Criar",'edit'=>'Editar','delete'=>'Deletar'];
	    foreach ($rolePermissions as $resDB)
	    {
		    if($resDB->role_id == $role->id){
		    	$findArr = explode("-",$resDB->name);
			    if(in_array(ucfirst($findArr[0]), $resources)){
				    $arrPermissions[$findArr[1]] = $permissions[$findArr[1]];
			    }
		    }
	    }

	    app(PermissionRegistrar::class)->forgetCachedPermissions();

        return view('permissions.edit',compact('role','roles','resources','permissions', 'arrPermissions'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

	    $this->validate($request, [
		    'role' => 'required',
		    'resource' => 'required',
	    ]);

	    $role = Role::findById($request->input('role'));

	    $resource = $request->input('resource');
	    $permissionsSend = $request->input('permissions');


	    //aPagar permissions deste modulo
	    $permissions = ['list','create','edit','delete'];
	    foreach ($permissions as $per)
	    {
		    $findPer = $resource."-".$per;
		    $permission = Permission::findByName($findPer);
		    $ids[] = $permission->id;
	    }

	    foreach ($ids as $delP)
	    {
		    DB::table("role_has_permissions")->where('role_id',$role->id)->where('permission_id', $delP)->delete();
	    }

	    //Incluir permissoes deste modulo
	    if(count($permissionsSend) > 0){
		    foreach ( $permissionsSend as $permission ) {
			    $permissionFind = $resource."-".$permission;
			    $per = Permission::findByName($permissionFind);
			    DB::table("role_has_permissions")->insert(['role_id' => $role->id, 'permission_id' => $per->id]);

		    }
	    }

	    app(PermissionRegistrar::class)->forgetCachedPermissions();

	    return redirect()->route('permissions.index')
	                     ->with('success','Permissao criada com sucesso');

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($params)
    {

	    $trt = explode("-",$params);

	    $role_id = $trt[0];
    	$resource = $trt[1];

	    $permissions = ['list','create','edit','delete'];

	    foreach ($permissions as $per)
	    {
	    	$findPer = $resource."-".$per;
	    	$permission = Permission::findByName($findPer);
	    	$ids[] = $permission->id;
	    }

	    foreach ($ids as $delP)
	    {
		    DB::table("role_has_permissions")->where('role_id',$role_id)->where('permission_id', $delP)->delete();
	    }

	    app(PermissionRegistrar::class)->forgetCachedPermissions();
        return redirect()->route('permissions.index')
                        ->with('success','Permissaoes deletadas sucesso');
    }
}