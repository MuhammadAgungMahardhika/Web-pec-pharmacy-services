<?php

namespace App\Http\Controllers;

use App\Http\Response\GlobalResponse;
use App\Models\DetailOrder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DetailOrderController extends Controller
{
    protected $validatedData = [
        'id_product' => 'required|integer',
        'id_signa' => 'required|integer',
        'id_order' => 'required|integer',
        'quantity' => 'required',
        // 'price' => 'required',
        'dosis' => 'nullable|string',
        'note' => 'nullable|string|max:255',
        'note2' => 'nullable|string|max:255',
    ];
    // Menampilkan semua detail order
    public function index()
    {
        try {
            $data = DetailOrder::with(['product', 'signa'])->get();
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
            $validatedData = $request->validate($this->validatedData);

            $detailOrder = DetailOrder::create($validatedData);
            $detailOrder->load('product', 'signa');
            return GlobalResponse::jsonResponse($detailOrder, 201, 'success', 'Detail order created successfully');
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', $e->getMessage());
        }
    }

    // Menampilkan detail order beradarkan order id
    public function showByOrderId($orderId)
    {
        try {
            // Cari detail order berdasarkan ID order
            $detailOrder = DetailOrder::with(['product', 'signa'])->where('id_order', $orderId)->get();

            // Pastikan jika tidak ditemukan detail order untuk ID order tersebut
            if ($detailOrder) {
                return GlobalResponse::jsonResponse($detailOrder, 200, 'success', 'Detail order retrieved successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Detail order not found');
            }
        } catch (\Throwable $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', $e->getMessage());
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', $e->getMessage());
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
            return GlobalResponse::jsonResponse(null, 500, 'error', $e->getMessage());
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
            $validatedData = $request->validate($this->validatedData);

            $detailOrder = DetailOrder::find($id);

            if ($detailOrder) {
                $detailOrder->update($validatedData);
                $detailOrder->load('product', 'signa');
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
