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
        return view("components.welcome", compact("pobles", "provinciaTotal", "comarcatotal"));
    }

    //Obtenir el ID del municipi
    public function obtenirById(Request $request)
    {
        $id = $request->input('id');
        $poble = Poble::select('*')->where('codi', $id)->first();
        
        if (!$poble) {
            return response()->json(['message' => 'Poble no trobat'], 404);
        }

        return response()->json([
            'codi' => $poble->codi,
            'nom' => $poble->nom,
            'comarca' => $poble->comarca,
            'provincia' => $poble->provincia,
            'descripcio' => $poble->descripcio,
            'foto' => $poble->foto,
            'latitud' => $poble->latitud,
            'longitud' => $poble->longitud,
            'altitud' => $poble->altitud,
            'superficie' => $poble->superficie,
            'poblacio' => $poble->poblacio,
            'codi' => $poble->codi,
            'codiComarca' => $poble->codiComarca
        ], 200);
    }

    //Crear un municpi
    public function crear(Request $request)
    {
        try {
            $poble = DB::table('pobles')->insert([
                'nom' => $request->input('nom'),
                'comarca' => $request->input('comarca'),
                'provincia' => $request->input('provincia'),
                'descripcio' => $request->input('descripcio'),
                'foto' => $request->input('foto'),
                'latitud' => $request->input('latitud'),
                'longitud' => $request->input('longitud'),
                'altitud' => $request->input('altitud'),
                'superficie' => $request->input('superficie'),
                'poblacio' => $request->input('poblacio'),
                'codi' => $request->input('codi'),
                'codiComarca' => $request->input('codiComarca'),
                'updated' => $request->input('updated'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            if ($poble) {
                return response()->json([
                    'success' => true,
                    'message' => 'Poble creat amb èxit.',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No s\'ha pogut crear el poble.',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ha ocorregut un error al crear el poble.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    //Editar un municipi
    public function editar(Request $request) {
        
    }

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
