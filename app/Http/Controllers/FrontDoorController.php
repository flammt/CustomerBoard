<?php


namespace App\Http\Controllers;

use Illuminate\View\View;

class FrontDoorController extends Controller
{
    /**
     * @return void
     */
    public function __construct ()
    {
//        $this->middleware('auth');
    }


    /**
     * @return View
     */
    public function index () {
        return view('index');
    }

}
