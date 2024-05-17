<?php

namespace App\Http\Response;

use Illuminate\Http\JsonResponse;

class GlobalResponse
{
    /**
     * Create a JSON response.
     *
     * @param mixed $data The data to be returned in the response.
     * @param int $code The HTTP status code.
     * @param string $status The status of the response (e.g., 'success' or 'error').
     * @param string $message A message describing the response.
     * @return \Illuminate\Http\JsonResponse
     */
    public static function jsonResponse($data, int $code = 200, string $status = 'success', string $message = ''): JsonResponse
    {
        $response = [
            'data' => $data,
            'code' => $code,
            'status' => $status,
            'message' => $message
        ];

        return response()->json($response, $code);
    }
}
