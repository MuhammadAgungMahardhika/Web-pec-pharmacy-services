<?php

namespace App\Http\Controllers;

use App\Http\Response\GlobalResponse;
use App\Models\DetailPurchase;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DetailPurchaseController extends Controller
{
    // Menampilkan semua detail pembelian
    public function index()
    {
        try {
            $data = DetailPurchase::all();
            return GlobalResponse::jsonResponse($data, 200, 'success', 'Detail purchases retrieved successfully');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Tidak diperlukan untuk API, hanya digunakan untuk menampilkan form
    public function create()
    {
        // Tidak diperlukan untuk API
    }

    // Menyimpan detail pembelian baru
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id_product' => 'required|integer',
                'id_purchase' => 'required|integer',
                'quantity' => 'required|integer',
                'price' => 'required|integer',
            ]);

            $detailPurchase = DetailPurchase::create($validatedData);

            return GlobalResponse::jsonResponse($detailPurchase, 201, 'success', 'Detail purchase created successfully');
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Menampilkan detail pembelian berdasarkan ID
    public function show($id)
    {
        try {
            $detailPurchase = DetailPurchase::find($id);

            if ($detailPurchase) {
                return GlobalResponse::jsonResponse($detailPurchase, 200, 'success', 'Detail purchase retrieved successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Detail purchase not found');
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

    // Memperbarui detail pembelian berdasarkan ID
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'id_product' => 'required|integer',
                'id_purchase' => 'required|integer',
                'quantity' => 'required|integer',
                'price' => 'required|integer',
            ]);

            $detailPurchase = DetailPurchase::find($id);

            if ($detailPurchase) {
                $detailPurchase->update($validatedData);
                return GlobalResponse::jsonResponse($detailPurchase, 200, 'success', 'Detail purchase updated successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Detail purchase not found');
            }
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Menghapus detail pembelian berdasarkan ID
    public function destroy($id)
    {
        try {
            $detailPurchase = DetailPurchase::find($id);

            if ($detailPurchase) {
                $detailPurchase->delete();
                return GlobalResponse::jsonResponse(null, 200, 'success', 'Detail purchase deleted successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Detail purchase not found');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }
}
