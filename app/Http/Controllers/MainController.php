<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function index(){

        $pobles = DB::table('pobles')->get()->toArray();

        return view("main", compact("pobles"));
    }

    
}
