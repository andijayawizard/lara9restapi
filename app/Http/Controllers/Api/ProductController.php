<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class ProductController extends Controller
{
    public function index()
    {
        // $products = Product::all();
        $products = Product::latest()->paginate(10);
        return response()->json([
            'success' => true, 'message' => 'Product List', 'data' => $products
        ]);
    }
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = FacadesValidator::make($input, [
            'name' => 'required',
            'detail' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors());
        }
        $product = Product::create($input);
        return response()->json([
            'success' => true, 'message' => 'Product created successfully', 'data' => $product,
        ]);
    }
    public function show($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return $this->sendError('Product not found');
        }
        return response()->json([
            'success' => true, 'message' => 'Product retrieved successfully', 'data' => $product,
        ]);
    }
    public function update(Request $request, Product $product)
    {
        $input = $request->all();
        $validator = FacadesValidator::make($input, [
            'name' => 'required',
            'detail' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors());
        }
        $product->name = $input['name'];
        $product->detail = $input['detail'];
        $product->save();
        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product,
        ]);
    }
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully',
            'data' => $product,
        ]);
    }
}