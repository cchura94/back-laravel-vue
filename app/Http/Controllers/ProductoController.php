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
                                    ->where("estado", true)
                                    ->orderBy("id", "desc")
                                    ->with(["categoria"])
                                    ->paginate($limit);
        }else{
            $productos = Producto::orderBy("id", "desc")->where("estado", true)->with(["categoria"])->paginate($limit);
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

    public function actualizarImagen($id, Request $request) {

        if($file = $request->file('imagen')){
            $direccion_imagen = time() . "-" . $file->getClientOriginalName();
            $file->move("imagenes/", $direccion_imagen);

            $direccion_imagen = "imagenes/". $direccion_imagen;

            $prod = Producto::findOrFail($id);
            $prod->imagen = $direccion_imagen;
            $prod->update();

            return response()->json(["message" => "Producto Actualizado"], 200);

        }
        return response()->json(["message" => "Se requiere la imagen"], 422);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $prod = Producto::findOrFail($id);

        return response()->json($prod);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validar
        $request->validate([
            "nombre" => "required",
            "categoria_id" => "required"
        ]);

        // guardar
        $prod = Producto::findOrFail($id);
        $prod->nombre = $request->nombre;
        $prod->stock = $request->stock;
        $prod->precio = $request->precio;
        $prod->descripcion = $request->descripcion;
        $prod->estado = $request->estado;
        $prod->categoria_id = $request->categoria_id;
        $prod->update();

        // respuesta
        return response()->json(["message" => "Producto actualizado"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prod = Producto::findOrFail($id);
        $prod->estado = false;
        $prod->update();

        return response()->json(["message" => "Producto inactivo"]);
    }
}
