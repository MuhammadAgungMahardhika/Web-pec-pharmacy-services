<?php

namespace App\Http\Controllers;

use App\Http\Response\GlobalResponse;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductCategoryController extends Controller
{

    /**
     * Menampilkan semua data kategori produk dengan filter dan pagination.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $search = $request->input('search', ''); // Kata kunci pencarian
            $perPage = $request->input('per_page', ProductCategory::count()); // Jumlah data per halaman
            $page = $request->input('page', 1); // Halaman saat ini

            // Menghitung jumlah data yang akan dilewati berdasarkan halaman saat ini
            $skip = ($page - 1) * $perPage;

            // Membuat query awal untuk mengambil data kategori produk
            $query = ProductCategory::query();

            // Jika ada parameter search, tambahkan kondisi pencarian
            if (!empty($search)) {
                $query->where('name', 'like', "%{$search}%");
            }

            // Mengambil data kategori produk dengan pagination dan sorting
            $data = $query->orderBy('created_at', 'desc')
                ->skip($skip)
                ->take($perPage)
                ->get();

            // Mengembalikan respons JSON dengan data kategori produk
            return GlobalResponse::jsonResponse($data, 200, 'success', 'Berhasil mendapatkan data kategori produk');
        } catch (\Exception $e) {
            // Menangani kesalahan dan mengembalikan respons JSON dengan status error
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Terjadi kesalahan yang tidak terduga');
        }
    }

    /**
     * Menyimpan data kategori produk baru.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $productCategory = ProductCategory::create($validatedData);

            return GlobalResponse::jsonResponse($productCategory, 201, 'success', 'Kategori produk berhasil dibuat');
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validasi gagal');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Terjadi kesalahan yang tidak terduga');
        }
    }

    /**
     * Menampilkan kategori produk berdasarkan ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $productCategory = ProductCategory::find($id);

            if ($productCategory) {
                return GlobalResponse::jsonResponse($productCategory, 200, 'success', 'Berhasil mendapatkan data kategori produk');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Kategori produk tidak ditemukan');
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

    /**
     * Memperbarui kategori produk berdasarkan ID.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $productCategory = ProductCategory::find($id);

            if ($productCategory) {
                $productCategory->update($validatedData);
                return GlobalResponse::jsonResponse($productCategory, 200, 'success', 'Kategori produk berhasil diperbarui');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Kategori produk tidak ditemukan');
            }
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validasi gagal');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Terjadi kesalahan yang tidak terduga');
        }
    }

    /**
     * Menghapus kategori produk berdasarkan ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $productCategory = ProductCategory::find($id);

            if ($productCategory) {
                $productCategory->delete();
                return GlobalResponse::jsonResponse(null, 200, 'success', 'Kategori produk berhasil dihapus');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Kategori produk tidak ditemukan');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Terjadi kesalahan yang tidak terduga');
        }
    }
}
