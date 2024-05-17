<?php

namespace App\Http\Controllers;

use App\Http\Response\GlobalResponse;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class WarehouseController extends Controller
{
    // Menampilkan semua warehouse
    public function index()
    {
        try {
            $data = Warehouse::all();
            return GlobalResponse::jsonResponse($data, 200, 'success', 'Warehouses retrieved successfully');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Tidak diperlukan untuk API, hanya digunakan untuk menampilkan form
    public function create()
    {
        // Tidak diperlukan untuk API
    }

    // Menyimpan warehouse baru
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'order_date' => 'required|date',
            ]);

            $warehouse = Warehouse::create($validatedData);

            return GlobalResponse::jsonResponse($warehouse, 201, 'success', 'Warehouse created successfully');
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Menampilkan warehouse berdasarkan ID
    public function show($id)
    {
        try {
            $warehouse = Warehouse::find($id);

            if ($warehouse) {
                return GlobalResponse::jsonResponse($warehouse, 200, 'success', 'Warehouse retrieved successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Warehouse not found');
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

    // Memperbarui warehouse berdasarkan ID
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'order_date' => 'required|date',
            ]);

            $warehouse = Warehouse::find($id);

            if ($warehouse) {
                $warehouse->update($validatedData);
                return GlobalResponse::jsonResponse($warehouse, 200, 'success', 'Warehouse updated successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Warehouse not found');
            }
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Menghapus warehouse berdasarkan ID
    public function destroy($id)
    {
        try {
            $warehouse = Warehouse::find($id);

            if ($warehouse) {
                $warehouse->delete();
                return GlobalResponse::jsonResponse(null, 200, 'success', 'Warehouse deleted successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Warehouse not found');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }
}
