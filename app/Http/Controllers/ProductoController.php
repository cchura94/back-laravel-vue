<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // /api/producto?q=laptop&page=1&limit=10
        $limit = isset($request->limit) ? $request->limit:10;

        if(isset($request->q)){
            $productos = Producto::where('nombre', "like", "%".$request->q."%")
                                    ->orderBy("id", "desc")
                                    ->with(["categoria"])
                                    ->paginate($limit);
        }else{
            $productos = Producto::orderBy("id", "desc")->with(["categoria"])->paginate($limit);
        }

        return response()->json($productos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validar
        $request->validate([
            "nombre" => "required",
            "categoria_id" => "required"
        ]);

        // guardar
        $prod = new Producto();
        $prod->nombre = $request->nombre;
        $prod->stock = $request->stock;
        $prod->precio = $request->precio;
        $prod->descripcion = $request->descripcion;
        $prod->estado = $request->estado;
        $prod->categoria_id = $request->categoria_id;
        $prod->save();

        // respuesta
        return response()->json(["message" => "Producto registrado"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
