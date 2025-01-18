<?php

namespace App\Http\Controllers;

use App\Models\Poble;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PobleAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Poble::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $rules = [
            'nom' => 'required',
            'comarca' => 'required',
            'provincia' => 'required',
            'descripcio' => 'required',
            'foto' => 'required',
            'latitud' => 'required',
            'longitud' => 'required',
            'altitud' => 'required',
            'superficie' => 'required',
            'poblacio' => 'required',
            'codi' => 'required',
            'codiComarca' => 'required'
        ];

        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()){
            return [
                'created' => false,
                'erros' => $validator->errors()->all()
            ];
        }
        Poble::create($request->all());
        return ['created' => true];
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Poble::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $poble = Poble::find($id);
        $poble->update($request->all());
        return ['updated' => true];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Poble::destroy($id);
        return ['deleted' => true];
    }
}
