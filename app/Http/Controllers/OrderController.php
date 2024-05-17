<?php

namespace App\Http\Controllers;

use App\Http\Response\GlobalResponse;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    // Menampilkan semua order
    public function index()
    {
        try {
            $data = Order::all();
            return GlobalResponse::jsonResponse($data, 200, 'success', 'Orders retrieved successfully');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Tidak diperlukan untuk API, hanya digunakan untuk menampilkan form
    public function create()
    {
        // Tidak diperlukan untuk API
    }

    // Menyimpan order baru
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id_patient' => 'required|integer',
                'id_resep' => 'required|string|max:255',
                'date' => 'required|date',
                'total_amount' => 'required|integer',
                'status' => 'required|in:pending,processing,completed,cancelled',
            ]);

            $order = Order::create($validatedData);

            return GlobalResponse::jsonResponse($order, 201, 'success', 'Order created successfully');
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Menampilkan order berdasarkan ID
    public function show($id)
    {
        try {
            $order = Order::find($id);

            if ($order) {
                return GlobalResponse::jsonResponse($order, 200, 'success', 'Order retrieved successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Order not found');
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

    // Memperbarui order berdasarkan ID
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'id_patient' => 'required|integer',
                'id_resep' => 'required|string|max:255',
                'date' => 'required|date',
                'total_amount' => 'required|integer',
                'status' => 'required|in:pending,processing,completed,cancelled',
            ]);

            $order = Order::find($id);

            if ($order) {
                $order->update($validatedData);
                return GlobalResponse::jsonResponse($order, 200, 'success', 'Order updated successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Order not found');
            }
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Menghapus order berdasarkan ID
    public function destroy($id)
    {
        try {
            $order = Order::find($id);

            if ($order) {
                $order->delete();
                return GlobalResponse::jsonResponse(null, 200, 'success', 'Order deleted successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Order not found');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }
}
