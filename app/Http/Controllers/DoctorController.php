<?php

namespace App\Http\Controllers;

use App\Http\Response\GlobalResponse;
use App\Models\Doctor;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DoctorController extends Controller
{
    private $validatedData =
    [
        'code' => 'required|string',
        'name' => 'required|string',

    ];
    public function index(Request $request)
    {
        try {
            $search = $request->input('search', '');
            $perPage = $request->input('per_page', Doctor::count());
            $page = $request->input('page', 1);

            $skip = ($page - 1) * $perPage;

            $query = Doctor::query();

            if (!empty($search)) {
                $query->where('code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            }

            $data = $query->orderBy('id', 'desc')
                ->skip($skip)
                ->take($perPage)
                ->get();


            return GlobalResponse::jsonResponse($data, 200, 'success', 'Doctors retrieved successfully');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }


    public function store(Request $request)
    {
        try {
            $requestData =  $request->all();
            $validatedData = $request->validate($this->validatedData);

            if (!isset($validatedData['price'])) {
                $validatedData['price'] = 0;
            }

            $Doctor = Doctor::create($requestData);

            return GlobalResponse::jsonResponse($Doctor, 201, 'success', 'Doctor created successfully');
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', $e->getMessage());
        } catch (QueryException $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', $e->getMessage());
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $Doctor = Doctor::find($id);

            if ($Doctor) {
                return GlobalResponse::jsonResponse($Doctor, 200, 'success', 'Doctor retrieved successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Doctor not found');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Failed to retrieve Doctor');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate($this->validatedData);

            if (!isset($validatedData['price'])) {
                $validatedData['price'] = 0;
            }

            $Doctor = Doctor::find($id);

            if ($Doctor) {
                $Doctor->update($validatedData);
                return GlobalResponse::jsonResponse($Doctor, 200, 'success', 'Doctor updated successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Doctor not found');
            }
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (QueryException $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Failed to update Doctor');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    public function destroy($id)
    {
        try {
            $Doctor = Doctor::find($id);

            if ($Doctor) {
                $Doctor->delete();
                return GlobalResponse::jsonResponse(null, 200, 'success', 'Doctor deleted successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Product not found');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Failed to delete product');
        }
    }
}
