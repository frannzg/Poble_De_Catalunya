<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Poble;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Municipi;
use Exception;
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
        try {
            // Ruta completa al fitxer CSV (ajusta aquesta ruta segons el teu entorn)
            $path = 'C:\\Users\\Usuario.DESKTOP-F8NFSKL\\Desktop\\Poble_De_Catalunya\\public\\build\\assets\\mpiscatalunya.csv';

            Log::info("Definida la ruta del fichero: {$path}");

            // Comprovar si el fitxer existeix
            if (!file_exists($path)) {
                return response()->json(['error' => 'Fitxer no trobat'], 404);
                Log::error("El fichero con ruta: {$path} no existe");
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
                    // Obtenir el nom original del municipi
                    $nomOriginal = trim($partes[1]);

                    // Verificar si el nom conté una coma
                    if (strpos($nomOriginal, ',') !== false) {
                        // Separar el nom en dues parts: abans i després de la coma
                        list($nom, $article) = array_map('trim', explode(',', $nomOriginal));

                        // Reconstruir el nom amb l'article al davant i en majúscula inicial
                        if (str_contains($article, "'")) {
                            $nom = ucfirst($article) . '' . $nom;
                        } else {
                            $nom = ucfirst($article) . ' ' . $nom;
                        }
                    } else {
                        // Si no hi ha coma, mantenir el nom original
                        $nom = $nomOriginal;
                    }

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
                        'nom' => $nom,
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

            // Inserir els pobles a la base de dades (taula 'pobles')
            DB::table('pobles')->insert($pobles);
            Log::info("Añadidos los pueblos a la BBDD");
        } catch (Exception $e) {
            Log::error("Error al realizar el proceso: {$e->getMessage()}");
        }

        try{
            $this->afegirDadesRestants();
        } catch(Exception $z){
            Log::error("Error al ejecutar la función afegirDadesRestants, error body: {$z->getMessage()}");
        }

        return response()->json(['missatge' => 'Pobles guardats correctament']);
    }

    public function afegirDadesRestants()
    {
        // Obtenir tots els municipis de la base de dades
        $pobles = Poble::all();

        foreach ($pobles as $poble) {
            // Obtenir el nom del municipi i tractar noms amb coma
            $municipi = $poble->nom;
            if (strpos($municipi, ',') !== false) {
                $parts = explode(',', $municipi);
                $municipi = trim($parts[1]) . ' ' . trim($parts[0]);
            }

            // Tractar noms que comencen amb apòstrof
            if (strpos($municipi, "'") === 0) {
                $municipi = substr($municipi, 1);
            }

            // URL de l'API de Wikipedia per obtenir la imatge principal i el contingut complet del municipi
            $wikiUrl = 'https://ca.wikipedia.org/w/api.php?action=query&titles=' . urlencode($municipi) . '&prop=pageimages|extracts|coordinates|pageprops&explaintext=true&format=json&pithumbsize=1000';
            // Realitzar la sol·licitud GET a l'API de Wikipedia
            $wikiResponse = Http::get($wikiUrl);
            $wikiData = $wikiResponse->json();

            $wikiImg = "https://commons.wikimedia.org/w/api.php?action=query&list=search&srsearch={$municipi}&srnamespace=6&format=json";
            $wikiImgResponse = Http::get($wikiImg);
            $wikiImgData = $wikiImgResponse->json();


            $imagenFileName = "";
            $imagenes = "";

            foreach ($wikiImgData["query"]["search"] as $key => $curr) {

                if (str_contains($curr['title'], '.png') || str_contains($curr['title'], '.jpg') || str_contains($curr['title'], '.jpeg' || str_contains($curr['title'], '.svg'))) {
                        $imagenFileName = $curr['title'];
                        $imagenPageId = $curr['pageid'];
                        $wikiUrlImg = "https://commons.wikimedia.org/w/api.php?action=query&titles={$imagenFileName}&prop=imageinfo&iiprop=url&format=json";
                        $wikiImgUrlResponse = Http::get($wikiUrlImg);
                        $wikiImgUrlData = $wikiImgUrlResponse->json();
                        if($key == 0){
                            $imagenes = $wikiImgUrlData["query"]["pages"][$imagenPageId]["imageinfo"][0]["url"];
                        } else {
                            $imagenes .= "####" . $wikiImgUrlData["query"]["pages"][$imagenPageId]["imageinfo"][0]["url"];
                        }
                }
            }

            // Inicialitzar variables amb missatge per defecte
            $imageUrl = "No s'ha trobat resultats";
            $extract = "No s'ha trobat resultats";
            $latitud = "No s'ha trobat resultats";
            $longitud = "No s'ha trobat resultats";
            $altitud = "No s'ha trobat resultats";
            $superficie = "No s'ha trobat resultats";
            $poblacio = "No s'ha trobat resultats";

            // Verificar si la resposta de Wikipedia conté dades de la pàgina
            if (isset($wikiData['query']['pages']) && !empty($wikiData['query']['pages'])) {
                $page = reset($wikiData['query']['pages']);

                // Obtenir la URL de la imatge si està disponible i no és una bandera o escut
                // if (isset($page['pageimage']) && !preg_match('/(Escut|Bandera|Coat_of_arms|Flag)/i', $page['pageimage'])) {
                //     $imageUrl = 'https://ca.wikipedia.org/wiki/Special:FilePath/' . urlencode($page['pageimage']);
                // }

                // Obtenir el contingut complet de la pàgina si està disponible
                if (isset($page['extract'])) {
                    $extract = $page['extract'];
                }

                // Obtenir les coordenades si estan disponibles
                if (isset($page['coordinates'][0])) {
                    $latitud = $page['coordinates'][0]['lat'] ?? "No s'ha trobat resultats";
                    $longitud = $page['coordinates'][0]['lon'] ?? "No s'ha trobat resultats";
                }

                // Obtenir l'ID de Wikidata si està disponible
                $wikidataId = $page['pageprops']['wikibase_item'] ?? null;

                // Si es disposa d'un ID de Wikidata, obtenir dades addicionals
                if ($wikidataId) {
                    $wikidataUrl = 'https://www.wikidata.org/wiki/Special:EntityData/' . $wikidataId . '.json';
                    $wikidataResponse = Http::get($wikidataUrl);
                    $wikidataData = $wikidataResponse->json();

                    if (isset($wikidataData['entities'][$wikidataId]['claims'])) {
                        $claims = $wikidataData['entities'][$wikidataId]['claims'];

                        // Superfície (P2046)
                        if (isset($claims['P2046'][0]['mainsnak']['datavalue']['value']['amount'])) {
                            $superficie = $claims['P2046'][0]['mainsnak']['datavalue']['value']['amount'];
                        }

                        // Població (P1082)
                        if (isset($claims['P1082'][0]['mainsnak']['datavalue']['value']['amount'])) {
                            $poblacio = $claims['P1082'][0]['mainsnak']['datavalue']['value']['amount'];
                        }

                        // Altitud (P2044)
                        if (isset($claims['P2044'][0]['mainsnak']['datavalue']['value']['amount'])) {
                            $altitud = $claims['P2044'][0]['mainsnak']['datavalue']['value']['amount'];
                        }
                    }
                }
            }

            // Actualitzar els camps a la base de dades
            $poble->foto = $imagenes;
            $poble->descripcio = $extract;
            $poble->latitud = $latitud;
            $poble->longitud = $longitud;
            $poble->altitud = $altitud;
            $poble->superficie = $superficie;
            $poble->poblacio = $poblacio;
            $poble->save();
        }

        return response()->json(['message' => 'Dades dels municipis actualitzades a la base de dades.']);
    }
}
