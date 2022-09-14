<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseCodes;

class BaseAPIController extends Controller
{
    public function respond($data, $code = ResponseCodes::HTTP_OK)
    {
        return response()->json(['data' => $data])->setStatusCode($code);
    }

    public function respondSuccessWithMessage(string $message, $code = ResponseCodes::HTTP_OK)
    {
        return response()->json(['message' => $message])->setStatusCode($code);
    }

    public function complain(string $message): JsonResponse
    {
        return $this->respondWithError($message);
    }

    public function unauthorized(string $message = 'Unauthorized.'): JsonResponse
    {
        return $this->respondWithError($message, ResponseCodes::HTTP_UNAUTHORIZED);
    }

    public function notFound(string $message = 'Not Found.'): JsonResponse
    {
        return $this->respondWithError($message, ResponseCodes::HTTP_NOT_FOUND);
    }

    public function respondWithError(
        string $message = 'Something Went wrong.',
        int $code = ResponseCodes::HTTP_BAD_REQUEST,
        array $errors = []
    ): JsonResponse {
        $response = [
            'message' => $message,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return Response()->json($response)->setStatusCode($code);
    }
}
