<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Response\GlobalResponse;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Throwable;

class ProductController extends Controller
{

    public function index()
    {
        $data = Product::all();
        return GlobalResponse::jsonResponse($data, 200, 'success', 'Products retrieved successfully');
    }

    public function create()
    {
    }


    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                // 'id_unit' => 'required|integer',
                // 'id_category' => 'required|integer',
                'name' => 'required|string|max:255',
                // 'description' => 'nullable|string|max:255',
                'price' => 'required|integer',
                'stock_quantity' => 'required|integer',
                // 'expired' => 'required|date',
            ]);

            $product = Product::create($validatedData);

            return GlobalResponse::jsonResponse($product, 201, 'success', 'Product created successfully');
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (QueryException $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Failed to retrieve products');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    public function show($id)
    {
        $product = Product::find($id);

        if ($product) {
            return GlobalResponse::jsonResponse($product, 200, 'success', 'Product retrieved successfully');
        } else {
            return GlobalResponse::jsonResponse(null, 404, 'error', 'Product not found');
        }
    }


    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                // 'id_unit' => 'required|integer',
                // 'id_category' => 'required|integer',
                'name' => 'required|string|max:255',
                // 'description' => 'nullable|string|max:255',
                'price' => 'required|integer',
                'stock_quantity' => 'required|integer',
                // 'expired' => 'required|date',
            ]);

            $product = Product::find($id);

            if ($product) {
                $product->update($validatedData);
                return GlobalResponse::jsonResponse($product, 200, 'success', 'Product updated successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Product not found');
            }
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (QueryException $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Failed to retrieve products');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return GlobalResponse::jsonResponse(null, 200, 'success', 'Product deleted successfully');
        } else {
            return GlobalResponse::jsonResponse(null, 404, 'error', 'Product not found');
        }
    }
}
