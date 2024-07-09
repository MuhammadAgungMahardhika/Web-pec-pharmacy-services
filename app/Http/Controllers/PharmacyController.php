<?php

namespace App\Http\Controllers;

use App\Http\Response\GlobalResponse;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PharmacyController extends Controller
{

    public function index()
    {
        try {
            $data = Pharmacy::all();
            return GlobalResponse::jsonResponse($data, 200, 'success', 'Pharmacies retrieved successfully');
        } catch (\Exception $e) {
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

            $pharmacy = Pharmacy::create($validatedData);

            return GlobalResponse::jsonResponse($pharmacy, 201, 'success', 'Pharmacy created successfully');
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }


    public function show($id)
    {
        try {
            $pharmacy = Pharmacy::find($id);

            if ($pharmacy) {
                return GlobalResponse::jsonResponse($pharmacy, 200, 'success', 'Pharmacy retrieved successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Pharmacy not found');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }


    public function edit($id)
    {
    }


    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $pharmacy = Pharmacy::find($id);

            if ($pharmacy) {
                $pharmacy->update($validatedData);
                return GlobalResponse::jsonResponse($pharmacy, 200, 'success', 'Pharmacy updated successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Pharmacy not found');
            }
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }


    public function destroy($id)
    {
        try {
            $pharmacy = Pharmacy::find($id);

            if ($pharmacy) {
                $pharmacy->delete();
                return GlobalResponse::jsonResponse(null, 200, 'success', 'Pharmacy deleted successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Pharmacy not found');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }
}
