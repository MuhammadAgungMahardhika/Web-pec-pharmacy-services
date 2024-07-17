<?php

namespace App\Http\Controllers;

use App\Http\Response\GlobalResponse;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    protected $validatedData = [
        'id_patient' => 'required|string',
        'id_doctor' => 'required|string',
        'id_poli' => 'required|integer',
        'no_of_receipt' => 'required|string|max:5|unique:orders,no_of_receipt',
        'date' => 'required|date',
        'date_of_service' => 'required|date',
        'kind_of_medicine' => 'required|in:1,2,3',
        'bpjs_sep' => 'nullable|string|max:19',
        'bpjs_iteration' => 'nullable|boolean',
    ];
    // Display all orders
    public function index(Request $request)
    {
        try {
            $search = $request->input('search', '');
            $perPage = $request->input('per_page', Order::count());
            $page = $request->input('page', 1);
            $skip = ($page - 1) * $perPage;
            $query = Order::query();

            if (!empty($search)) {
                $query->where('no_of_receipt', 'like', "%{$search}%")
                    ->orWhere('id_patient', 'like', "%{$search}%")
                    ->orWhere('date', 'like', "%{$search}%");
            }

            $data = $query->orderBy('created_at', 'desc')
                ->skip($skip)
                ->take($perPage)
                ->get();
            return GlobalResponse::jsonResponse($data, 200, 'success', 'Orders retrieved successfully');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    // Not required for API, only for displaying form
    public function create()
    {
        // Not required for API
    }

    // Store a new order
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate($this->validatedData);

            $order = Order::create($validatedData);

            return GlobalResponse::jsonResponse($order, 201, 'success', 'Order created successfully');
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', $e->getMessage());
        }
    }

    // Display an order by ID
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

    // Not required for API, only for displaying form
    public function edit($id)
    {
        // Not required for API
    }

    // Update an order by ID
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate($this->validatedData);

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

    // Delete an order by ID
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
