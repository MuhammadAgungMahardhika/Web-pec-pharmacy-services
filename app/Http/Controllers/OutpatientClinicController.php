<?php

namespace App\Http\Controllers;

use App\Http\Response\GlobalResponse;
use App\Models\OutpatientClinic;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OutpatientClinicController extends Controller
{

    public function index(Request $request)
    {
        try {
            $search = $request->input('search', '');
            $perPage = $request->input('per_page', OutpatientClinic::count());
            $page = $request->input('page', 1);
            $skip = ($page - 1) * $perPage;
            $query = OutpatientClinic::query();

            if (!empty($search)) {
                $query->where('code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            }

            $data = $query->orderBy('created_at', 'desc')
                ->skip($skip)
                ->take($perPage)
                ->get();
            return GlobalResponse::jsonResponse($data, 200, 'success', 'OutpatientClinic retrieved successfully');
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

            $OutpatientClinic = OutpatientClinic::create($validatedData);

            return GlobalResponse::jsonResponse($OutpatientClinic, 201, 'success', 'OutpatientClinic created successfully');
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }


    public function show($id)
    {
        try {
            $OutpatientClinic = OutpatientClinic::find($id);

            if ($OutpatientClinic) {
                return GlobalResponse::jsonResponse($OutpatientClinic, 200, 'success', 'OutpatientClinic retrieved successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'OutpatientClinic not found');
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

            $OutpatientClinic = OutpatientClinic::find($id);

            if ($OutpatientClinic) {
                $OutpatientClinic->update($validatedData);
                return GlobalResponse::jsonResponse($OutpatientClinic, 200, 'success', 'OutpatientClinic updated successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'OutpatientClinic not found');
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
            $OutpatientClinic = OutpatientClinic::find($id);

            if ($OutpatientClinic) {
                $OutpatientClinic->delete();
                return GlobalResponse::jsonResponse(null, 200, 'success', 'OutpatientClinic deleted successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'OutpatientClinic not found');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }
}
