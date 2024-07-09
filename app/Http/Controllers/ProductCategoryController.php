<?php

namespace App\Http\Controllers;

use App\Http\Response\GlobalResponse;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductCategoryController extends Controller
{

    public function index(Request $request)
    {
        try {
            $search = $request->input('search', '');
            $perPage = $request->input('per_page', ProductCategory::count());
            $page = $request->input('page', 1);

            $skip = ($page - 1) * $perPage;
            $query = ProductCategory::query();


            if (!empty($search)) {
                $query->where('name', 'like', "%{$search}%");
            }

            $data = $query->orderBy('created_at', 'desc')
                ->skip($skip)
                ->take($perPage)
                ->get();
            return GlobalResponse::jsonResponse($data, 200, 'success', 'ProductCategory retrieved successfully');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $productCategory = ProductCategory::create($validatedData);

            return GlobalResponse::jsonResponse($productCategory, 201, 'success', 'Product category created successfully');
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    public function show($id)
    {
        try {
            $productCategory = ProductCategory::find($id);

            if ($productCategory) {
                return GlobalResponse::jsonResponse($productCategory, 200, 'success', 'Product category retrieved successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Product category not found');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
            ]);


            $productCategory = ProductCategory::find($id);

            if ($productCategory) {
                $productCategory->update($validatedData);
                return GlobalResponse::jsonResponse($productCategory, 200, 'success', 'Product category updated successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Product category not found');
            }
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    public function destroy($id)
    {
        try {
            $productCategory = ProductCategory::find($id);

            if ($productCategory) {
                $productCategory->delete();
                return GlobalResponse::jsonResponse(null, 200, 'success', 'Product category deleted successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Product category not found');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }
}
