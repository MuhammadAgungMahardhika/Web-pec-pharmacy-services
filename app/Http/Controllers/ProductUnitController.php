<?php

namespace App\Http\Controllers;

use App\Http\Response\GlobalResponse;
use App\Models\ProductUnit;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductUnitController extends Controller
{
    // Menampilkan semua data product unit
    public function index(Request $request)
    {
        try {
            $search = $request->input('search', '');
            $perPage = $request->input('per_page', ProductUnit::count());
            $page = $request->input('page', 1);

            $skip = ($page - 1) * $perPage;
            $query = ProductUnit::query();


            if (!empty($search)) {
                $query->where('name', 'like', "%{$search}%");
            }

            $data = $query->orderBy('created_at', 'desc')
                ->skip($skip)
                ->take($perPage)
                ->get();
            return GlobalResponse::jsonResponse($data, 200, 'success', 'Product Unit retrieved successfully');
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

            $productUnit = ProductUnit::create($validatedData);

            return GlobalResponse::jsonResponse($productUnit, 201, 'success', 'Product unit created successfully');
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Menampilkan data product unit berdasarkan ID
    public function show($id)
    {
        try {
            $productUnit = ProductUnit::find($id);

            if ($productUnit) {
                return GlobalResponse::jsonResponse($productUnit, 200, 'success', 'Product unit retrieved successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Product unit not found');
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

    // Memperbarui data product unit berdasarkan ID
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $productUnit = ProductUnit::find($id);

            if ($productUnit) {
                $productUnit->update($validatedData);
                return GlobalResponse::jsonResponse($productUnit, 200, 'success', 'Product unit updated successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Product unit not found');
            }
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Menghapus data product unit berdasarkan ID
    public function destroy($id)
    {
        try {
            $productUnit = ProductUnit::find($id);

            if ($productUnit) {
                $productUnit->delete();
                return GlobalResponse::jsonResponse(null, 200, 'success', 'Product unit deleted successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Product unit not found');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }
}
