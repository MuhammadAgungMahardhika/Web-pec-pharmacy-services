<?php

namespace App\Http\Controllers;

use App\Http\Response\GlobalResponse;
use App\Models\Signa;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SignaController extends Controller
{

    public function index(Request $request)
    {
        try {
            // Mendapatkan parameter search, per_page, dan page dari request
            $search = $request->input('search', ''); // Kata kunci pencarian
            $perPage = $request->input('per_page', Signa::count());
            $page = $request->input('page', 1);

            // Menghitung jumlah data yang akan dilewati
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
            return GlobalResponse::jsonResponse($data, 200, 'success', 'Signas retrieved successfully');
        } catch (\Exception $e) {
            // Menangani kesalahan dan mengembalikan respons JSON dengan status error
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
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


            $signa = Signa::create($validatedData);

            return GlobalResponse::jsonResponse($signa, 201, 'success', 'Signa created successfully');
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Menampilkan signa berdasarkan ID
    public function show($id)
    {
        try {
            $signa = Signa::find($id);

            if ($signa) {
                return GlobalResponse::jsonResponse($signa, 200, 'success', 'Signa retrieved successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Signa not found');
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

    // Memperbarui signa berdasarkan ID
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $signa = Signa::find($id);

            if ($signa) {
                $signa->update($validatedData);
                return GlobalResponse::jsonResponse($signa, 200, 'success', 'Signa updated successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Signa not found');
            }
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Menghapus signa berdasarkan ID
    public function destroy($id)
    {
        try {
            $signa = Signa::find($id);

            if ($signa) {
                $signa->delete();
                return GlobalResponse::jsonResponse(null, 200, 'success', 'Signa deleted successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Signa not found');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }
}
