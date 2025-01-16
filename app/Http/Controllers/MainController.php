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
            return response()->json(['message' => 'Poble no encontrado'], 404);
        }

        // Envolver en un array para que el frontend pueda manejarlo como 'poble[0]'
        return response()->json([
            'poble' => [$poble]
        ]);
    }
}
