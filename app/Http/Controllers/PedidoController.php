<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit:10;
        $fi = isset($request->fi) ? $request->fi:0;
        $ff = isset($request->ff) ? $request->ff:0;

        if(isset($request->q)){
            $pedidos = Pedido::where('fecha', "like", "%".$request->q."%");
            if($fi && $ff){
                $pedidos = $pedidos->where('fecha', '>=', $fi)
                ->where('fecha', '<=', $ff);
            }
            $pedidos = $pedidos->orderBy("id", "desc")
                                    ->with(["cliente", "productos"])
                                    ->paginate($limit);
        }else{
            $pedidos = Pedido::orderBy("id", "desc");
            if($fi && $ff){
                $pedidos = $pedidos->where('fecha', '>=', $fi)
                ->where('fecha', '<=', $ff);
            }
            $pedidos = $pedidos->with(["cliente", "productos"])
                                ->paginate($limit);
        }

        return response()->json($pedidos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validar
        $request->validate([
            "cliente_id" => "required",
            "productos" => "required"
        ]);

        // guardar pedido con estado 2 en proceso
        $pedido = new Pedido();
        $pedido->fecha = date("Y-m-d H:i:s");
        $pedido->cliente_id = $request->cliente_id;
        $pedido->estado = 1;
        $pedido->observacion = $request->observacion;
        $pedido->user_id = Auth::id();
        $pedido->save();
        // asignar productos al pedido
        /*
        {
            cliente_id: 67,
            productos: [
                {producto_id: 1, cantidad: 4},
                {producto_id: 5, cantidad: 2},
                {producto_id: 2, cantidad: 1}
            ]
        }*/
        $productos = $request->productos;
        foreach ($productos as $prod) {
            $producto_id = $prod["producto_id"];
            $cantidad = $prod["cantidad"];

            $pedido->productos()->attach($producto_id, ["cantidad" => $cantidad]);
        }

        // actualizar el estado a completado
        $pedido->estado = 2;
        $pedido->update();
        // respuesta al cliente
        return response()->json(["message" => "Pedido registrado"], 201);
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
