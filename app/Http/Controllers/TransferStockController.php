<?php

namespace App\Http\Controllers;

use App\Http\Response\GlobalResponse;
use App\Models\TransferStock;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TransferStockController extends Controller
{
    // Menampilkan semua transfer stock
    public function index()
    {
        try {
            $data = TransferStock::all();
            return GlobalResponse::jsonResponse($data, 200, 'success', 'Transfer stocks retrieved successfully');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Tidak diperlukan untuk API, hanya digunakan untuk menampilkan form
    public function create()
    {
        // Tidak diperlukan untuk API
    }

    // Menyimpan transfer stock baru
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id_pharmacy' => 'required|integer',
                'id_warehouse' => 'required|integer',
                'date' => 'required|date',
                'status' => 'required|in:pending,processing,completed,cancelled',
            ]);

            $transferStock = TransferStock::create($validatedData);

            return GlobalResponse::jsonResponse($transferStock, 201, 'success', 'Transfer stock created successfully');
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Menampilkan transfer stock berdasarkan ID
    public function show($id)
    {
        try {
            $transferStock = TransferStock::find($id);

            if ($transferStock) {
                return GlobalResponse::jsonResponse($transferStock, 200, 'success', 'Transfer stock retrieved successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Transfer stock not found');
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

    // Memperbarui transfer stock berdasarkan ID
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'id_pharmacy' => 'required|integer',
                'id_warehouse' => 'required|integer',
                'date' => 'required|date',
                'status' => 'required|in:pending,processing,completed,cancelled',
            ]);

            $transferStock = TransferStock::find($id);

            if ($transferStock) {
                $transferStock->update($validatedData);
                return GlobalResponse::jsonResponse($transferStock, 200, 'success', 'Transfer stock updated successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Transfer stock not found');
            }
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Menghapus transfer stock berdasarkan ID
    public function destroy($id)
    {
        try {
            $transferStock = TransferStock::find($id);

            if ($transferStock) {
                $transferStock->delete();
                return GlobalResponse::jsonResponse(null, 200, 'success', 'Transfer stock deleted successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Transfer stock not found');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }
}
