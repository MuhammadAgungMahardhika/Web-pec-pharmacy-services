<?php

namespace App\Http\Controllers;

use App\Http\Response\GlobalResponse;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductCategoryController extends Controller
{
    // Menampilkan semua data product category
    public function index()
    {
        try {
            $data = ProductCategory::all();
            return GlobalResponse::jsonResponse($data, 200, 'success', 'Product categories retrieved successfully');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Tidak diperlukan untuk API, hanya digunakan untuk menampilkan form
    public function create()
    {
        // Tidak diperlukan untuk API
    }

    // Menyimpan data product category baru
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

    // Menampilkan data product category berdasarkan ID
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

    // Tidak diperlukan untuk API, hanya digunakan untuk menampilkan form
    public function edit($id)
    {
        // Tidak diperlukan untuk API
    }

    // Memperbarui data product category berdasarkan ID
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

    // Menghapus data product category berdasarkan ID
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
