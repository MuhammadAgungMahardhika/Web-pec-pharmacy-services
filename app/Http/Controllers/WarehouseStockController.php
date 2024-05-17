<?php

namespace App\Http\Controllers;

use App\Http\Response\GlobalResponse;
use App\Models\WarehouseStock;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class WarehouseStockController extends Controller
{
    // Menampilkan semua stok gudang
    public function index()
    {
        try {
            $data = WarehouseStock::all();
            return GlobalResponse::jsonResponse($data, 200, 'success', 'Warehouse stocks retrieved successfully');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Tidak diperlukan untuk API, hanya digunakan untuk menampilkan form
    public function create()
    {
        // Tidak diperlukan untuk API
    }

    // Menyimpan stok gudang baru
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id_product' => 'required|integer',
                'id_warehouse' => 'required|integer',
                'quantity' => 'required|integer',
            ]);

            $warehouseStock = WarehouseStock::create($validatedData);

            return GlobalResponse::jsonResponse($warehouseStock, 201, 'success', 'Warehouse stock created successfully');
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Menampilkan stok gudang berdasarkan ID
    public function show($id)
    {
        try {
            $warehouseStock = WarehouseStock::find($id);

            if ($warehouseStock) {
                return GlobalResponse::jsonResponse($warehouseStock, 200, 'success', 'Warehouse stock retrieved successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Warehouse stock not found');
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

    // Memperbarui stok gudang berdasarkan ID
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'id_product' => 'required|integer',
                'id_warehouse' => 'required|integer',
                'quantity' => 'required|integer',
            ]);

            $warehouseStock = WarehouseStock::find($id);

            if ($warehouseStock) {
                $warehouseStock->update($validatedData);
                return GlobalResponse::jsonResponse($warehouseStock, 200, 'success', 'Warehouse stock updated successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Warehouse stock not found');
            }
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Menghapus stok gudang berdasarkan ID
    public function destroy($id)
    {
        try {
            $warehouseStock = WarehouseStock::find($id);

            if ($warehouseStock) {
                $warehouseStock->delete();
                return GlobalResponse::jsonResponse(null, 200, 'success', 'Warehouse stock deleted successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Warehouse stock not found');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }
}
