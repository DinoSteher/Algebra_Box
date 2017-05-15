<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sentinel;
use App\Models\UsersRoot;
use Storage;

class HomeController extends Controller
{
	
	private $user_id;
	private $user_root = false;
	
  /**
   * Set middleware to quard controller.
   *
   * @return void
   */
    public function __construct()
    {
        $this->middleware('sentinel.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$this->setUserRoot();
		
		$directories = Storage::disk('public')->directories($this->user_root);
		$files = Storage::disk('public')->files($this->user_root);
		
        return view('user.home', ['directories' => $directories, 'files' => $files]);
    }
	
	public function show($name)
	{
		$this->setUserRoot();
		$directoriesFirst = Storage::disk('public')->directories($this->user_root.'/'.$name);
		$filesFirst = Storage::disk('public')->files($this->user_root.'/'.$name);
		$directories=[];
		$files=[];
		$nameLetters = strlen($name);
		foreach($directoriesFirst as $directory){
			$directories[] = '/'.explode('/', $directory)[2];
		}
		foreach($filesFirst as $file){
			$files[] = '/'.explode('/',$file)[2];
		}	
        return view('user.home', ['directories' => $directories, 'files' => $files]);
	}
	
	public function create(Request $request)
	{
		$this->setUserRoot();
		$new_dir = $request->get('dir_name');
		Storage::disk('public')->makeDirectory($this->user_root.'/'.$new_dir);
		session()->flash('success', "You've successfully created a {$new_dir} folder");
		
		return redirect()->route('home');
	}
	
	public function deleteDir($name)
	{
		$this->setUserRoot();
		Storage::disk('public')->deleteDirectory($this->user_root.'/'.$name);
		session()->flash('success', "You've successfully deleted a {$name} folder");
		
		return redirect()->route('home');
	}
	
	private function setUserRoot()
	{
		$this->user_id = Sentinel::getUser()->id;
		$root = UsersRoot::where('user_id', $this->user_id)->first();
		
		if($root) {
			$this->user_root = $root->name;
		} else {
			session()->flash('error', 'Cannot find user root directory');
		}
	}
}
