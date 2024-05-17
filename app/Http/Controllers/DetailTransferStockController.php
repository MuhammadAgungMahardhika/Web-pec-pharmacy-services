<?php

namespace App\Http\Controllers;

use App\Http\Response\GlobalResponse;
use App\Models\DetailTransferStock;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DetailTransferStockController extends Controller
{
    // Menampilkan semua detail transfer stok
    public function index()
    {
        try {
            $data = DetailTransferStock::all();
            return GlobalResponse::jsonResponse($data, 200, 'success', 'Detail transfer stocks retrieved successfully');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Tidak diperlukan untuk API, hanya digunakan untuk menampilkan form
    public function create()
    {
        // Tidak diperlukan untuk API
    }

    // Menyimpan detail transfer stok baru
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id_product' => 'required|integer',
                'id_transfer_stock' => 'required|integer',
                'quantity' => 'required|integer',
                'price' => 'required|integer',
            ]);

            $detailTransferStock = DetailTransferStock::create($validatedData);

            return GlobalResponse::jsonResponse($detailTransferStock, 201, 'success', 'Detail transfer stock created successfully');
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Menampilkan detail transfer stok berdasarkan ID
    public function show($id)
    {
        try {
            $detailTransferStock = DetailTransferStock::find($id);

            if ($detailTransferStock) {
                return GlobalResponse::jsonResponse($detailTransferStock, 200, 'success', 'Detail transfer stock retrieved successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Detail transfer stock not found');
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

    // Memperbarui detail transfer stok berdasarkan ID
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'id_product' => 'required|integer',
                'id_transfer_stock' => 'required|integer',
                'quantity' => 'required|integer',
                'price' => 'required|integer',
            ]);

            $detailTransferStock = DetailTransferStock::find($id);

            if ($detailTransferStock) {
                $detailTransferStock->update($validatedData);
                return GlobalResponse::jsonResponse($detailTransferStock, 200, 'success', 'Detail transfer stock updated successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Detail transfer stock not found');
            }
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Menghapus detail transfer stok berdasarkan ID
    public function destroy($id)
    {
        try {
            $detailTransferStock = DetailTransferStock::find($id);

            if ($detailTransferStock) {
                $detailTransferStock->delete();
                return GlobalResponse::jsonResponse(null, 200, 'success', 'Detail transfer stock deleted successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Detail transfer stock not found');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }
}
