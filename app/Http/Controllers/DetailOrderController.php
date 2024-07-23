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
            return GlobalResponse::jsonResponse($data, 200, 'success', 'Berhasil mendapatkan detail order');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Terjadi kesalahan yang tidak terduga');
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
            return GlobalResponse::jsonResponse($detailOrder, 201, 'success', 'Detail order berhasil dibuat');
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validasi gagal');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Terjadi kesalahan yang tidak terduga');
        }
    }

    // Menampilkan detail order berdasarkan ID order
    public function showByOrderId($orderId)
    {
        try {
            // Cari detail order berdasarkan ID order
            $detailOrder = DetailOrder::with(['product', 'signa'])->where('id_order', $orderId)->get();

            // Pastikan jika tidak ditemukan detail order untuk ID order tersebut
            if ($detailOrder->isNotEmpty()) {
                return GlobalResponse::jsonResponse($detailOrder, 200, 'success', 'Detail order berhasil ditemukan');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Detail order tidak ditemukan');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Terjadi kesalahan yang tidak terduga');
        }
    }

    // Menampilkan detail order berdasarkan ID
    public function show($id)
    {
        try {
            $detailOrder = DetailOrder::find($id);

            if ($detailOrder) {
                return GlobalResponse::jsonResponse($detailOrder, 200, 'success', 'Detail order berhasil ditemukan');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Detail order tidak ditemukan');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Terjadi kesalahan yang tidak terduga');
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
                return GlobalResponse::jsonResponse($detailOrder, 200, 'success', 'Detail order berhasil diperbarui');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Detail order tidak ditemukan');
            }
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validasi gagal');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Terjadi kesalahan yang tidak terduga');
        }
    }

    // Menghapus detail order berdasarkan ID
    public function destroy($id)
    {
        try {
            $detailOrder = DetailOrder::find($id);

            if ($detailOrder) {
                $detailOrder->delete();
                return GlobalResponse::jsonResponse(null, 200, 'success', 'Detail order berhasil dihapus');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Detail order tidak ditemukan');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Terjadi kesalahan yang tidak terduga');
        }
    }
}
