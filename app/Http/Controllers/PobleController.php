<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Poble;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Municipi;
use Illuminate\Support\Facades\DB;


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

    public function obtenirPobles()
    {
        // Ruta completa al fitxer CSV (ajusta aquesta ruta segons el teu entorn)
        $path = 'C:\\Users\\fran1\\Desktop\\Poble_De_Catalunya\\public\\build\\assets\\mpiscatalunya.csv';

        // Comprovar si el fitxer existeix
        if (!file_exists($path)) {
            return response()->json(['error' => 'Fitxer no trobat'], 404);
        }

        // Llegir el fitxer CSV
        $csv = file_get_contents($path);

        // Convertir les dades CSV a un array de línies
        $linies = explode("\n", $csv);

        // Array per emmagatzemar els pobles
        $pobles = [];

        // Recórrer les línies i processar les dades
        foreach ($linies as $linea) {
            // Separar per ; cada línia
            $partes = explode(';', $linea);

            // Comprovar que la línia té el format esperat (4 valors)
            if (count($partes) >= 4) {
                // Obtenir els primers dos dígits del codi de municipi per determinar la província
                $codiMunicipi = substr($partes[0], 0, 2); // Els primers 2 dígits del codi

                // Assignar la província segons el codi
                switch ($codiMunicipi) {
                    case '08':
                        $provincia = 'Barcelona';
                        break;
                    case '17':
                        $provincia = 'Girona';
                        break;
                    case '25':
                        $provincia = 'Lleida';
                        break;
                    case '43':
                        $provincia = 'Tarragona';
                        break;
                    default:
                        $provincia = 'Desconeguda'; // Per a codi desconegut
                        break;
                }

                // Afegir el poble a l'array
                $pobles[] = [
                    'codi' => $partes[0],
                    'nom' => $partes[1],
                    'codiComarca' => $partes[2],
                    'comarca' => $partes[3],
                    'provincia' => $provincia, // Assigna la província
                    'descripcio' => '', // Descripció del poble, si la tens
                    'foto' => '', // Foto del poble, si la tens
                    'latitud' => null, // Assigna la latitud si la tens
                    'longitud' => null, // Assigna la longitud si la tens
                    'altitud' => null, // Assigna l'altitud si la tens
                    'superficie' => null, // Assigna la superfície si la tens
                    'poblacio' => null, // Assigna la població si la tens
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Convertir a JSON (si necessites fer-ho per algun motiu)
        $json = json_encode($pobles);

        // Opcional: Guarda el JSON en un fitxer
        // file_put_contents('path_on_server.json', $json);

        // Inserir els pobles a la base de dades (taula 'pobles')
        DB::table('pobles')->insert($pobles);

        return response()->json(['missatge' => 'Pobles guardats correctament']);
    }

    public function actualizarDatosMunicipios()
    {
        // Obtenir tots els municipis de la base de dades
        $pobles = Poble::all();

        foreach ($pobles as $poble) {
            // Obtenir el nom del municipi
            $municipio = $poble->nom;

            // URL de l'endpoint de l'API de Wikipedia per obtenir la imatge principal i el contingut complet del municipi
            $url = 'https://ca.wikipedia.org/w/api.php?action=query&titles=' . urlencode($municipio) . '&prop=pageimages|extracts&explaintext=true&format=json&pithumbsize=1000';

            // Realitzar la sol·licitud GET a l'API
            $response = Http::get($url);
            $data = $response->json();

            // Verificar si la resposta conté dades de la pàgina
            if (isset($data['query']['pages']) && !empty($data['query']['pages'])) {
                $page = reset($data['query']['pages']);

                // Obtenir la URL de la imatge si està disponible
                $imageUrl = $page['thumbnail']['source'] ?? null;

                // Obtenir el contingut complet de la pàgina si està disponible
                $extract = $page['extract'] ?? null;

                // Actualitzar els camps a la base de dades si s'han obtingut dades
                if ($imageUrl || $extract) {
                    if ($imageUrl) {
                        $poble->foto = $imageUrl;
                    }
                    if ($extract) {
                        $poble->descripcio = $extract;
                    }
                    $poble->save();
                } else {
                    // Gestionar el cas en què no s'han trobat dades adequades
                    // Pots registrar l'error o realitzar alguna acció addicional
                }
            } else {
                // Gestionar el cas en què no s'ha trobat la pàgina del municipi a Wikipedia
                // Pots registrar l'error o realitzar alguna acció addicional
            }
        }

        return response()->json(['message' => 'Dades dels municipis actualitzades a la base de dades.']);
    }
}
