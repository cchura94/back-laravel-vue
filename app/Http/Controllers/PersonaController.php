<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // SELECT * FROM personas
        $personas = DB::select("select * from personas");

        return response()->json($personas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $nom_completo = $request->nombre_completo;
        $ci = $request->ci;
        $estado = $request->estado;
        $user_id = $request->user_id;

        DB::insert("insert into personas (nombre_completo, ci, estado, user_id) values (?, ?, ?, ?)", [$nom_completo, $ci, $estado, $user_id]);

        return response()->json(["mensaje" => "Persona Registrado"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $persona = DB::select("select p.id, p.nombre_completo, u.email from personas as p, users as u where p.id = ? and u.id=p.user_id", [$id]);
        return response()->json($persona);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $nom_completo = $request->nombre_completo;
        $ci = $request->ci;
        $estado = $request->estado;
        $user_id = $request->user_id;

        DB::table("personas")
            ->where('id', $id)->update([
                "nombre_completo" => $nom_completo,
                "ci" => $ci,
                "estado" => $estado,
                "user_id" => $user_id,
            ]);

            return response()->json(["mensaje" => "Persona Actualizada"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
