<?php

namespace App\Http\Controllers;

use App\Http\Response\GlobalResponse;
use App\Models\DetailOrder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DetailOrderController extends Controller
{
    // Menampilkan semua detail order
    public function index()
    {
        try {
            $data = DetailOrder::all();
            return GlobalResponse::jsonResponse($data, 200, 'success', 'Detail orders retrieved successfully');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Tidak diperlukan untuk API, hanya digunakan untuk menampilkan form
    public function create()
    {
        // Tidak diperlukan untuk API
    }

    // Menyimpan detail order baru
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id_product' => 'required|integer',
                'id_signa' => 'required|integer',
                'id_order' => 'required|integer',
                'quantity' => 'required|integer',
                'price' => 'required|integer',
                'dosis' => 'nullable|integer',
                'note' => 'nullable|string|max:255',
                'note2' => 'nullable|string|max:255',
            ]);

            $detailOrder = DetailOrder::create($validatedData);

            return GlobalResponse::jsonResponse($detailOrder, 201, 'success', 'Detail order created successfully');
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Menampilkan detail order berdasarkan ID
    public function show($id)
    {
        try {
            $detailOrder = DetailOrder::find($id);

            if ($detailOrder) {
                return GlobalResponse::jsonResponse($detailOrder, 200, 'success', 'Detail order retrieved successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Detail order not found');
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

    // Memperbarui detail order berdasarkan ID
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'id_product' => 'required|integer',
                'id_signa' => 'required|integer',
                'id_order' => 'required|integer',
                'quantity' => 'required|integer',
                'price' => 'required|integer',
                'dosis' => 'nullable|integer',
                'note' => 'nullable|string|max:255',
                'note2' => 'nullable|string|max:255',
            ]);

            $detailOrder = DetailOrder::find($id);

            if ($detailOrder) {
                $detailOrder->update($validatedData);
                return GlobalResponse::jsonResponse($detailOrder, 200, 'success', 'Detail order updated successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Detail order not found');
            }
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Menghapus detail order berdasarkan ID
    public function destroy($id)
    {
        try {
            $detailOrder = DetailOrder::find($id);

            if ($detailOrder) {
                $detailOrder->delete();
                return GlobalResponse::jsonResponse(null, 200, 'success', 'Detail order deleted successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Detail order not found');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }
}
