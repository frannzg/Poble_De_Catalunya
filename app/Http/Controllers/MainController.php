<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Poble;

class MainController extends Controller
{
    public function index()
    {

        $pobles = DB::table('pobles')->get()->toArray();

        return view("main", compact("pobles"));
    }

    public function obtenirById(Request $request)
    {
        $id = $request->input('id');
        $poble = Poble::find($id);

        if (!$poble) {
            return response()->json(['message' => 'pobleo no encontrado'], 404);
        }

        return response()->json([
            'poble' => $poble // Asegúrate de que esta estructura coincida con la que usas en el AJAX
        ]);
    }
}
