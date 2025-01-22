<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Exception;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        if ($products->isEmpty()) {
            return response()->json([
                'data' => [],
                'status' => 'success',
                'message' => 'No products found'
            ], 404);
        }else{
            return response()->json([
                'data' => $products,
                'status' => 'success',
                'message' => 'Products fetched successfully'
            ], 200);
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
    try{
        $validate = $request->validate([
            'name' => 'required|string',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);
        $product  = Product::create($validate);
        return response()->json([
            'data' => $product,
            'status' => 'success',
            'message' => 'Product created successfully'
        ], 201);

    }catch(Exception $e){
        return response()->json([
            'data' => $e->getMessage(),
            'status' => 'error',
            'message' => 'Product creation failed'
        ], 500);
    }
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
        $singleProduct = Product::find($id);
        return response()->json([
            'data' => $singleProduct,
            'status' => 'success',
            'message' => 'Product fetched successfully'
        ], 200);
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
        try{
            $findProduct = Product::find($id);
            if(!$findProduct){
                return response()->json([
                    'data' => [],
                    'status' => 'error',
                    'message' => 'Product not found'
                ], 404);
            }else{
                $validate = $request->validate([
                    'name' => 'required|string',
                    'description' => 'required',
                    'price' => 'required|numeric',
                    'stock' => 'required|integer',
                ]);
                $findProduct->update($validate);
                return response()->json([
                    'data' => $findProduct,
                    'status' => 'success',
                    'message' => 'Product updated successfully'
                ], 200);
            }

        }catch(Exception $e){
            return response()->json([
                'data' => $e->getMessage(),
                'status' => 'error',
                'message' => 'Product update failed'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $findProduct = Product::find($id);
        if(!$findProduct){
            return response()->json([
                'data' => [],
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }else{
            $findProduct->delete();
            return response()->json([
                'data' => $findProduct,
                'status' => 'success',
                'message' => 'Product deleted successfully'
            ], 200);
        }
        }catch(Exception $e){
            return response()->json([
                'data' => $e->getMessage(),
                'status' => 'error',
                'message' => 'Product deletion failed'
            ], 500);
        }
    }
}
