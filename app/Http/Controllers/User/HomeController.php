<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use App\Models\UsersRoot;
use Centaur\AuthManager;
use Cartalyst\Sentinel\Users\UserInterface;
use File;

class HomeController extends Controller
{
	protected $sentinel;
  /**
   * Set middleware to quard controller.
   *
   * @return void
   */
    public function __construct()
    {
        $this->middleware('sentinel.auth');
		$this->sentinel = app()->make('sentinel');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$user = $this->sentinel->check();
		$user_id = $user["attributes"]["id"];
		$users_root = new UsersRoot();
		
		$keys = array_keys($_GET);
		if($_GET){
			foreach($_GET as $key=>$value){
				if($key == 'nazivDir'){
					$this->uploadFile($_GET['nazivDir'], $user_id);
				}
				if(substr($key, 0, 6)=="delete"){
					$this->deleteFile($key);
				}
			}
		}
		$user = $this->sentinel->check();
		$user_id = $user["attributes"]["id"];
		$users_root = new UsersRoot();
		$table = $users_root->get();
		foreach($table as $key=>$file){
			if($file["attributes"]["user_id"]== $user_id){
				$files[] = $table[$key];
			}
		}
        return view('user.home', ['files' => $files] );
    }
	
	public function uploadFile($name, $user_id){
		$dirExist = Storage::disk('public')->allDirectories();	
		if(!in_array($name, $dirExist)){
			Storage::disk('public')->makeDirectory($name);
			$users_root = new UsersRoot();
			$users_root->name = $name;
			$users_root->user_id = $user_id;
			$users_root->save();
		}else{
			session()->flash('error', 'The map already exists!');
		}
	}
	
	public function deleteFile($key){
		$name = explode("_", $key)[1];
		$users_root = new UsersRoot();
		$users_root->where('name', '=', $name)->delete();
		Storage::deleteDirectory($name);
	}
	
	
}
