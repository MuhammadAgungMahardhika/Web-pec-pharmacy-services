<?php

namespace App\Http\Controllers;

use App\Http\Response\GlobalResponse;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PurchaseController extends Controller
{
    // Menampilkan semua data pembelian
    public function index()
    {
        try {
            $data = Purchase::all();
            return GlobalResponse::jsonResponse($data, 200, 'success', 'Purchases retrieved successfully');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Tidak diperlukan untuk API, hanya digunakan untuk menampilkan form
    public function create()
    {
        // Tidak diperlukan untuk API
    }

    // Menyimpan data pembelian baru
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id_warehouse' => 'required|integer',
                'id_supplier' => 'required|integer',
                'date' => 'required|date',
                'total_amount' => 'required|integer',
            ]);

            $purchase = Purchase::create($validatedData);

            return GlobalResponse::jsonResponse($purchase, 201, 'success', 'Purchase created successfully');
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Menampilkan data pembelian berdasarkan ID
    public function show($id)
    {
        try {
            $purchase = Purchase::find($id);

            if ($purchase) {
                return GlobalResponse::jsonResponse($purchase, 200, 'success', 'Purchase retrieved successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Purchase not found');
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

    // Memperbarui data pembelian berdasarkan ID
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'id_warehouse' => 'required|integer',
                'id_supplier' => 'required|integer',
                'date' => 'required|date',
                'total_amount' => 'required|integer',
            ]);

            $purchase = Purchase::find($id);

            if ($purchase) {
                $purchase->update($validatedData);
                return GlobalResponse::jsonResponse($purchase, 200, 'success', 'Purchase updated successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Purchase not found');
            }
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Menghapus data pembelian berdasarkan ID
    public function destroy($id)
    {
        try {
            $purchase = Purchase::find($id);

            if ($purchase) {
                $purchase->delete();
                return GlobalResponse::jsonResponse(null, 200, 'success', 'Purchase deleted successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Purchase not found');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }
}
