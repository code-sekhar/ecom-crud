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
    public function show(string $id) {
        try{
            $singleCartItem = Cart::find($id);
            if(!$singleCartItem){
                return response()->json([
                    'data' => [],
                    'status' => 'error',
                    'message' => 'Cart item not found'
                ]);
            }else{
                return response()->json([
                    'data' => $singleCartItem,
                    'status' => 'success',
                    'message' => 'Cart item fetched successfully'
                ], 200);
            }
        }catch(Exception $e){
            return response()->json([
                'data' => $e->getMessage(),
                'status' => 'error',
                'message' => 'Cart item fetch failed'
            ], 500);
        }
    }
    public function destroy(string $id) {
        try{
            $findCartItem = Cart::find($id);
            if(!$findCartItem){
                return response()->json([
                    'data' => [],
                    'status' => 'error',
                    'message' => 'Cart item not found'
                ], 404);
            }else{
                $findCartItem->delete();
                return response()->json([
                    'data' => $findCartItem,
                    'status' => 'success',
                    'message' => 'Cart item deleted successfully'
                ], 200);
            }
        }catch(Exception $e){
            return response()->json([
                'data' => $e->getMessage(),
                'status' => 'error',
                'message' => 'Cart item deletion failed'
            ], 500);
        }
    }
    public function update(Request $request, string $id) {
        try{
            $findCartItem = Cart::find($id);
            if(!$findCartItem){
                return response()->json([
                    'data' => [],
                    'status' => 'error',
                    'message' => 'Cart item not found'
                ], 404);
            }else{
                $validate = $request->validate([
                    'quantity'=>'integer'
                ]);
                $findCartItem->update($validate);
                return response()->json([
                    'data' => $findCartItem,
                    'status' => 'success',
                    'message' => 'Cart item updated successfully'
                ], 200);
            }
        }catch(Exception $e){
            return response()->json([
                'data' => $e->getMessage(),
                'status' => 'error',
                'message' => 'Cart item update failed'
            ], 500);
        }
    }


}
