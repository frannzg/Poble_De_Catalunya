<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Poble;

class MainController extends Controller
{
    //Obtenir totes les dades del poble
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
        return view("main", compact("pobles", "provinciaTotal", "comarcatotal"));
    }

    //Obtenir dades dels filtres
    public function obtenirDadesFiltres(Request $request)
    {
        $query = DB::table('pobles');

        if ($request->has('provincia') && $request->provincia != '') {
            $query->where('provincia', $request->provincia);
        }

        if ($request->has('comarca') && $request->comarca != '') {
            $query->where('comarca', $request->comarca);
        }

        $data = $query->paginate(20);

        return response()->json($data);
    }

    // Recarregar el selector de comarques
    public function recarregaSelectComarques(Request $request)
    {
        if ($request->data != "XXXX") {
            $datos = DB::table('pobles')
            ->select('comarca', 'codiComarca')
            ->where('provincia', $request->data)
            ->get()
            ->toArray();
        } 

        return response()->json($datos, 200);
    }

    // Recarregar la taula amb el filtre de comarques
    public function recargarTaulaAmbComarques(Request $request){
        $datos = DB::table('pobles')->select('*')->whereIn('codiComarca', $request->data)->get()->toArray();
        
        return response()->json($datos, 200);
    }

    public function obtenirById(Request $request){
        $id = $request->input('id');
        $poble = Poble::select('*')->where('id', $id)->first();

        if (!$poble) {
            return response()->json(['message' => 'Poble no trobat'], 404);
        }

        return response()->json([
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
}
