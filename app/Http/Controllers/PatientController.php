<?php

namespace App\Http\Controllers;

use App\Http\Response\GlobalResponse;
use App\Models\Patient;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PatientController extends Controller
{
    private $validatedData =
    [
        'no_mr' => 'required|string',
        'name' => 'required|string',

    ];
    public function index(Request $request)
    {
        try {
            $search = $request->input('search', '');
            $perPage = $request->input('per_page', Patient::count());
            $page = $request->input('page', 1);

            $skip = ($page - 1) * $perPage;

            $query = Patient::query();

            if (!empty($search)) {
                $query->where('no_mr', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            }

            $data = $query->orderBy('id', 'desc')
                ->skip($skip)
                ->take($perPage)
                ->get();


            return GlobalResponse::jsonResponse($data, 200, 'success', 'patients retrieved successfully');
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

            $patient = Patient::create($requestData);

            return GlobalResponse::jsonResponse($patient, 201, 'success', 'patient created successfully');
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
            $patient = Patient::find($id);

            if ($patient) {
                return GlobalResponse::jsonResponse($patient, 200, 'success', 'patient retrieved successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'patient not found');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Failed to retrieve patient');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate($this->validatedData);

            if (!isset($validatedData['price'])) {
                $validatedData['price'] = 0;
            }

            $patient = Patient::find($id);

            if ($patient) {
                $patient->update($validatedData);
                return GlobalResponse::jsonResponse($patient, 200, 'success', 'patient updated successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'patient not found');
            }
        } catch (ValidationException $e) {
            return GlobalResponse::jsonResponse($e->errors(), 422, 'error', 'Validation failed');
        } catch (QueryException $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Failed to update patient');
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'An unexpected error occurred');
        }
    }

    public function destroy($id)
    {
        try {
            $patient = Patient::find($id);

            if ($patient) {
                $patient->delete();
                return GlobalResponse::jsonResponse(null, 200, 'success', 'patient deleted successfully');
            } else {
                return GlobalResponse::jsonResponse(null, 404, 'error', 'Product not found');
            }
        } catch (\Exception $e) {
            return GlobalResponse::jsonResponse(null, 500, 'error', 'Failed to delete product');
        }
    }
}
