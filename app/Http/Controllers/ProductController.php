<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Response\GlobalResponse;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Throwable;

class ProductController extends Controller
{
    private $validatedData =
    [
        'id_category' => 'nullable|integer',
        'id_unit' => 'nullable|integer',
        'code' => 'required|string|max:20',
        'name' => 'required|string|max:255',
        'price' => 'required|integer|min:0',
        'stock_quantity' => 'nullable|integer|min:0',
        'description' => 'nullable|string|max:500',
        'expired' => 'nullable|date',
        'restriction' => 'nullable|string|max:255',
        'bpjs_prb' => 'nullable|boolean',
        'chronic' => 'nullable|boolean',
        'generic' => 'nullable|string|max:255',

    ];
    public function index(Request $request)
    {
        try {
            $search = $request->input('search', '');
            $perPage = $request->input('per_page', Product::count());
            $page = $request->input('page', 1);

            $skip = ($page - 1) * $perPage;

            $query = Product::query();

            if (!empty($search)) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            }

            $data = $query->with(['category', 'unit'])->orderBy('id', 'desc')
                ->skip($skip)
                ->take($perPage)
                ->get();


            return GlobalResponse::jsonResponse($data, 200, 'success', 'Berhasil mendapatkan produk');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', $e->getMessage());
        }
    }


    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate($this->validatedData);

            if (!isset($validatedData['price'])) {
                $validatedData['price'] = 0;
            }

            $product = Product::create($validatedData);

            return GlobalResponse::jsonResponse($product, 201, 'success', 'Berhasil membuat produk');
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse(null, 422, 'error', 'Input tidak valid');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $product = Product::find($id);

            if ($product) {
                return GlobalResponse::jsonResponse($product, 200, 'success', 'Berhasil mendapatkan produk');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Gagal menampilkan produk, Produk tidak ditemukan');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate($this->validatedData);

            if (!isset($validatedData['price'])) {
                $validatedData['price'] = 0;
            }

            $product = Product::find($id);

            if ($product) {
                $product->update($validatedData);
                return GlobalResponse::jsonResponse($product, 200, 'success', 'Berhasil mengubah produk');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Produk tidak ditemukan');
            }
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse(null, 422, 'error', 'Input tidak valid');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Gagal mengubah produk');
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::find($id);

            if ($product) {
                $product->delete();
                return GlobalResponse::jsonResponse(null, 200, 'success', 'Berhasil menghapus produk');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Gagal menghapus produk, Produk tidak ditemukan');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Gagal menghapus produk');
        }
    }
}
