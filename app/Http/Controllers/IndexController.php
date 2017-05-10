<?php

namespace App\Http\Controllers;

use Storage;
use Illuminate\Http\Request;

class IndexController extends Controller
{
  /**
   * Set middleware to quard controller.
   *
   * @return void
   */
    public function __construct()
    {
        $this->middleware('sentinel.guest');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		Storage::disk('public')->makeDirectory('pero');
				
        return view('index');
    }
}
