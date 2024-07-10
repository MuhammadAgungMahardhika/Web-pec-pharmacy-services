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
    private $validatedData =
    [
        'id_category' => 'integer',
        'id_unit' => 'integer',
        'code' => 'required|string|max:20',
        'name' => 'required|string|max:255',
        'price' => 'required|integer|min:0',
        'stock_quantity' => 'nullable|integer|min:0',
        'description' => 'nullable|string|max:500',
        'expired' => 'nullable|date',
        'restriction' => 'nullable|string|max:255',
        'bpjs_prb' => 'nullable|boolean',
        'chronic' => 'nullable|boolean',
        'generic' => 'nullable|string|max:255',

    ];
    public function index(Request $request)
    {
        try {
            $search = $request->input('search', '');
            $perPage = $request->input('per_page', Product::count());
            $page = $request->input('page', 1);

            $skip = ($page - 1) * $perPage;

            $query = Product::query();

            if (!empty($search)) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            }

            $data = $query->with(['category', 'unit'])->orderBy('id', 'desc')
                ->skip($skip)
                ->take($perPage)
                ->get();


            return GlobalResponse::jsonResponse($data, 200, 'success', 'Products retrieved successfully');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }


    public function store(Request $request)
    {
        try {
            $requestData =  $request->all();
            $validatedData = $request->validate($this->validatedData);

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
            $validatedData = $request->validate($this->validatedData);

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
