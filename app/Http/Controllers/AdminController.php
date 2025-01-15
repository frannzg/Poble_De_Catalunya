<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(){

        $pobles = DB::table('pobles')->get()->toArray();

        return view("admin", compact("pobles"));
    }
}
