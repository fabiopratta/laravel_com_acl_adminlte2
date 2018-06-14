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


class ResourceController extends Controller
{
	use RefreshesPermissionCache;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:resource-list');
         $this->middleware('permission:resource-create', ['only' => ['create','store']]);
         $this->middleware('permission:resource-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:resource-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
	    $resourcesDB = Permission::get();

	    $resources = [];
	    foreach ($resourcesDB as $resDB)
	    {
		    $res = explode("-",$resDB->name);
		    if(!in_array($res[0],$resources)){
			    $resources[$res[0]] = ucfirst($res[0]);
		    }
	    }

        return view('resource.index',compact('resources'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

	    $controllersAutoLoad = include base_path('vendor/composer/autoload_classmap.php');
	    $controllersAutoLoad = array_keys($controllersAutoLoad);
	    $controllersAutoLoad = array_filter($controllersAutoLoad, function ($controller) {
		    return strpos($controller, 'App\Http\Controllers') !== false;
	    });
	    $controllersAutoLoad = array_map(function ($controller) {
		    return str_replace('App\Http\Controllers\\', '', $controller);
	    }, $controllersAutoLoad);

	    $controllersAutoLoad = array_filter($controllersAutoLoad, function ($controller) {
		    return strpos($controller, '\\') == false;
	    });

	    $controllersAutoLoad = array_filter($controllersAutoLoad, function ($controller) {
		    return str_replace('Controller', '', $controller);
	    });

	   $resources = [];
	   foreach ($controllersAutoLoad as $controller)
	   {
	   	$resource = str_replace("Controller", '', $controller);
	   	$resources[strtolower($resource)] = $resource;
	   }

	   $resourcesDB = Permission::get();

	   foreach ($resourcesDB as $resDB)
	   {
			$res = explode("-",$resDB->name);
			$searchResource = ucfirst($res[0]);
		    $key = array_search($searchResource, $resources);
			if(in_array($searchResource,$resources)){
				unset($resources[$key]);
			}
	   }

 	   return view('resource.create',compact('resources'));
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
            'resource' => 'required',
        ]);

        $resource = $request->input("resource");
        
        $permissions = ['list','create','edit','delete'];


        foreach($permissions as $permission)
        {
        	$permissionArr = $resource."-".$permission;
        	$insertPermission = ['guard_name' => 'web', 'name' => $permissionArr];
        	Permission::create($insertPermission);
        }

	    app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()->route('resource.index')
                        ->with('success','Recurso criado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($resource)
    {
        DB::table("permissions")->where('name',$resource)->orWhere('name', 'like', '%' . $resource . '%')->delete();

	    app(PermissionRegistrar::class)->forgetCachedPermissions();
        return redirect()->route('resource.index')
                        ->with('success','Recurso deletado com sucesso');
    }
}