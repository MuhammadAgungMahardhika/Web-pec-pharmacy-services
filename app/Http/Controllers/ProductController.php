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
        try {
            $products = Product::all();
            return GlobalResponse::jsonResponse($products, 200, 'success', 'Products retrieved successfully');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Failed to retrieve products');
        }
    }

    public function store(Request $request)
    {
        try {
            $requestData =  $request->all();
            $validatedData = $request->validate([
                'code' => 'required|string|max:20',
                'name' => 'required|string|max:255',
                'price' => 'nullable|integer', // Price field can be nullable
                'stock_quantity' => 'required|integer',
                // Add other validation rules as needed
            ]);

            // Set default value for price if not provided
            if (!isset($validatedData['price'])) {
                $validatedData['price'] = 0;
            }

            $product = Product::create($requestData);

            return GlobalResponse::jsonResponse($product, 201, 'success', 'Product created successfully');
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', $e->getMessage());
        } catch (QueryException $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', $e->getMessage());
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $product = Product::find($id);

            if ($product) {
                return GlobalResponse::jsonResponse($product, 200, 'success', 'Product retrieved successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Product not found');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Failed to retrieve product');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'nullable|integer', // Price field can be nullable
                'stock_quantity' => 'required|integer',
                // Add other validation rules as needed
            ]);

            // Set default value for price if not provided
            if (!isset($validatedData['price'])) {
                $validatedData['price'] = 0;
            }

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
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Failed to update product');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::find($id);

            if ($product) {
                $product->delete();
                return GlobalResponse::jsonResponse(null, 200, 'success', 'Product deleted successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Product not found');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Failed to delete product');
        }
    }
}
