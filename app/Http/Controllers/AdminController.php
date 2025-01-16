<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Poble;

class AdminController extends Controller
{
    //Obtenir tots els pobles de la BD
    public function index()
    {
        $pobles = DB::table('pobles')->get()->toArray();

        $provinciaTotal = DB::table('pobles')
                ->select('provincia', DB::raw('COUNT(*) as total'))
                ->groupBy('provincia')
                ->get();

        $comarcatotal = DB::table('pobles')
                ->select('comarca', DB::raw('COUNT(*) as total'))
                ->groupBy('comarca')
                ->get();
        return view("components.welcome", compact("pobles","provinciaTotal","comarcatotal"));
    }

    //Obtenir el ID del municipi
    public function obtenirById(Request $request)
    {
        $id = $request->input('id');
        $poble = Poble::select('*')->where('codi', $id)->get()->toArray();

        if (!$poble) {
            return response()->json(['message' => 'pobleo no encontrado'], 404);
        }

        return response()->json(['poble' => $poble], 200);
    }

    //Crear un municpi
    public function crear(Request $request)
    {
        dd($request);
    }

    //Editar un municipi
    public function editar(Request $request) {}

    //Eliminar municipi
    public function eliminar(Request $request)
    {
        $id = $request->input('id');

        DB::table('pobles')->where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Municipi eliminat existosament.',
        ], 200);
    }
}
