<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
class CartController extends Controller
{
    public function index() {
        $CartItems = Cart::all();
        return response()->json([
            'data' => $CartItems,
            'status' => 'success',
            'message' => 'Cart items fetched successfully'
        ], 200);
    }
    public function store() {
       try{
        $validation = request()->validate([
            'product_id'=>'required|exists:products,id',
            'quantity'=>'integer'
        ]);
        $CartItem = Cart::updateOrCreate(
            ['product_id'=>$validation['product_id']],
            ['quantity'=>DB::raw('quantity + '.$validation['quantity'])]
        );
        return response()->json([
            'data' => $CartItem,
            'status' => 'success',
            'message' => 'Product added to cart successfully'
        ], 201);
       }catch(Exception $e){
        return response()->json([
            'data' => $e->getMessage(),
            'status' => 'error',
            'message' => 'Product addition to cart failed'
        ], 500);
       }
    }
}
