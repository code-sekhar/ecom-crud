<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use Exception;
class OrderController extends Controller
{
    public function buy(Request $request){
       try{
        $validate = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        $product = Product::find( $validate['product_id']);
        if($product->stock < $validate['quantity']){
            return response()->json([
                'data' => [],
                'status' => 'error',
                'message' => 'Insufficient stock'
            ], 404);
        }
        $product->stock -= $validate['quantity'];
        $product->save();
        $order = Order::create([
            'product_id' => $validate['product_id'],
            'quantity' => $validate['quantity'],
            'total_price' => $product->price * $validate['quantity']
        ]);
        return response()->json([
            'data' => $order,
            'status' => 'success',
            'message' => 'Order placed successfully'
        ], 201);
       }catch(Exception $e){
        return response()->json([
            'data' => $e->getMessage(),
            'status' => 'error',
            'message' => 'Order placement failed'
        ], 500);
       }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
