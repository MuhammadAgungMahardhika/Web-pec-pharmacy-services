<?php

namespace App\Http\Controllers;

use App\Http\Response\GlobalResponse;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SupplierController extends Controller
{
    // Menampilkan semua supplier
    public function index()
    {
        try {
            $data = Supplier::all();
            return GlobalResponse::jsonResponse($data, 200, 'success', 'Suppliers retrieved successfully');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Tidak diperlukan untuk API, hanya digunakan untuk menampilkan form
    public function create()
    {
        // Tidak diperlukan untuk API
    }

    // Menyimpan supplier baru
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'contact' => 'nullable|string|max:15',
                'address' => 'nullable|string',
            ]);

            $supplier = Supplier::create($validatedData);

            return GlobalResponse::jsonResponse($supplier, 201, 'success', 'Supplier created successfully');
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Menampilkan supplier berdasarkan ID
    public function show($id)
    {
        try {
            $supplier = Supplier::find($id);

            if ($supplier) {
                return GlobalResponse::jsonResponse($supplier, 200, 'success', 'Supplier retrieved successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Supplier not found');
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

    // Memperbarui supplier berdasarkan ID
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'contact' => 'nullable|string|max:15',
                'address' => 'nullable|string',
            ]);

            $supplier = Supplier::find($id);

            if ($supplier) {
                $supplier->update($validatedData);
                return GlobalResponse::jsonResponse($supplier, 200, 'success', 'Supplier updated successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Supplier not found');
            }
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Menghapus supplier berdasarkan ID
    public function destroy($id)
    {
        try {
            $supplier = Supplier::find($id);

            if ($supplier) {
                $supplier->delete();
                return GlobalResponse::jsonResponse(null, 200, 'success', 'Supplier deleted successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Supplier not found');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }
}
