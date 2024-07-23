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

            return GlobalResponse::jsonResponse($data, 200, 'success', 'Berhasil mendapatkan data unit produk');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Terjadi kesalahan yang tidak terduga');
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

            return GlobalResponse::jsonResponse($productUnit, 201, 'success', 'Berhasil menambahkan unit produk');
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validasi gagal');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Terjadi kesalahan yang tidak terduga');
        }
    }

    // Menampilkan data product unit berdasarkan ID
    public function show($id)
    {
        try {
            $productUnit = ProductUnit::find($id);

            if ($productUnit) {
                return GlobalResponse::jsonResponse($productUnit, 200, 'success', 'Berhasil mendapatkan unit produk');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Unit produk tidak ditemukan');
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
                return GlobalResponse::jsonResponse($productUnit, 200, 'success', 'Berhasil memperbarui unit produk');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Unit produk tidak ditemukan');
            }
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validasi gagal');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Terjadi kesalahan yang tidak terduga');
        }
    }

    // Menghapus data product unit berdasarkan ID
    public function destroy($id)
    {
        try {
            $productUnit = ProductUnit::find($id);

            if ($productUnit) {
                $productUnit->delete();
                return GlobalResponse::jsonResponse(null, 200, 'success', 'Berhasil menghapus unit produk');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Unit produk tidak ditemukan');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Terjadi kesalahan yang tidak terduga');
        }
    }
}
