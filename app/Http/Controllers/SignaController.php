<?php

namespace App\Http\Controllers;

use App\Http\Response\GlobalResponse;
use App\Models\Signa;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SignaController extends Controller
{

    /**
     * Menampilkan semua data signa dengan filter dan pagination.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            // Mendapatkan parameter search, per_page, dan page dari request
            $search = $request->input('search', ''); // Kata kunci pencarian
            $perPage = $request->input('per_page', Signa::count()); // Jumlah data per halaman
            $page = $request->input('page', 1); // Halaman saat ini

            // Menghitung jumlah data yang akan dilewati berdasarkan halaman saat ini
            $skip = ($page - 1) * $perPage;

            // Membuat query awal untuk mengambil data signa
            $query = Signa::query();

            // Jika ada parameter search, tambahkan kondisi pencarian
            if (!empty($search)) {
                $query->where('name', 'like', "%{$search}%");
            }

            // Mengambil data signa dengan pagination dan sorting
            $data = $query->orderBy('id', 'desc')
                ->skip($skip)
                ->take($perPage)
                ->get();

            // Mengembalikan respons JSON dengan data signa
            return GlobalResponse::jsonResponse($data, 200, 'success', 'Berhasil mendapatkan data signa');
        } catch (\Exception $e) {
            // Menangani kesalahan dan mengembalikan respons JSON dengan status error
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Terjadi kesalahan yang tidak terduga');
        }
    }

    /**
     * Menyimpan data signa baru.
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

            $signa = Signa::create($validatedData);

            return GlobalResponse::jsonResponse($signa, 201, 'success', 'Signa berhasil dibuat');
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validasi gagal');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Terjadi kesalahan yang tidak terduga');
        }
    }

    /**
     * Menampilkan signa berdasarkan ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $signa = Signa::find($id);

            if ($signa) {
                return GlobalResponse::jsonResponse($signa, 200, 'success', 'Berhasil mendapatkan data signa');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Signa tidak ditemukan');
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
     * Memperbarui signa berdasarkan ID.
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

            $signa = Signa::find($id);

            if ($signa) {
                $signa->update($validatedData);
                return GlobalResponse::jsonResponse($signa, 200, 'success', 'Signa berhasil diperbarui');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Signa tidak ditemukan');
            }
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validasi gagal');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Terjadi kesalahan yang tidak terduga');
        }
    }

    /**
     * Menghapus signa berdasarkan ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $signa = Signa::find($id);

            if ($signa) {
                $signa->delete();
                return GlobalResponse::jsonResponse(null, 200, 'success', 'Signa berhasil dihapus');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Signa tidak ditemukan');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Terjadi kesalahan yang tidak terduga');
        }
    }
}
