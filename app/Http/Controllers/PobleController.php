<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Poble;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PobleController extends Controller
{

    public function index(Request $request)
    {
        $provincia = $request->query('provincia');
        if ($provincia) {
            $pobles = Poble::where('provincia', $provincia)->get();
        } else {
            $pobles = Poble::all();
        }
        return response()->json($pobles);
    }

    public function show($id)
    {
        $poble = Poble::findOrFail($id);
        return response()->json($poble);
    }

    public function obtenirMunicipis()
    {
        try {
            // 1. Obtener las provincias
            $provinciasResponse = Http::get('https://api.idescat.cat/emex/v1/nodes.json', [
                'tipus' => 'prov'
            ]);

            if ($provinciasResponse->failed()) {
                return response()->json(['error' => 'Error al obtener provincias'], 500);
            }

            dd($provinciasResponse->json()["fitxes"]);
            $provincias = $provinciasResponse->json()['nodes'];
            $resultado = [];

            foreach ($provincias as $provincia) {
                $provinciaId = $provincia['id'];
                $provinciaNombre = $provincia['name'];

                // 2. Obtener las comarcas relacionadas con la provincia
                $comarcasResponse = Http::get('https://api.idescat.cat/emex/v1/nodes.json', [
                    'tipus' => 'com',
                    'parent' => $provinciaId
                ]);

                if ($comarcasResponse->failed()) {
                    continue; // Si falla, pasa a la siguiente provincia
                }

                $comarcas = $comarcasResponse->json()['nodes'];
                $comarcasData = [];

                foreach ($comarcas as $comarca) {
                    $comarcaId = $comarca['id'];
                    $comarcaNombre = $comarca['name'];

                    // 3. Obtener los municipios relacionados con la comarca
                    $municipiosResponse = Http::get('https://api.idescat.cat/emex/v1/nodes.json', [
                        'tipus' => 'mun',
                        'parent' => $comarcaId
                    ]);

                    if ($municipiosResponse->failed()) {
                        continue; // Si falla, pasa a la siguiente comarca
                    }

                    $municipios = $municipiosResponse->json()['nodes'];
                    $municipiosNombres = array_column($municipios, 'name'); // Obtener solo los nombres

                    // Construir el array de la comarca
                    $comarcasData[] = [
                        'comarca' => $comarcaNombre,
                        'municipios' => $municipiosNombres
                    ];
                }

                // Construir el array de la provincia
                $resultado[] = [
                    'provincia' => $provinciaNombre,
                    'comarcas' => $comarcasData
                ];
            }

            return response()->json($resultado, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
