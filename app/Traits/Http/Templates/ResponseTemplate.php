<?php

namespace App\Traits\Http\Templates;

use App\Exceptions\HttpJsonResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

trait ResponseTemplate
{

    public function getPermissions(): array
    {
        return [];
    }

    public function successResponse(
        int $status = 200,
        string $message = '',
        array|object $result = [],
        bool $withPermissions = false,
        array $headers = [],
        int $options = 0
    ): JsonResponse {
        $data = [
            'status'        => $status,
            'message'       => $message,
            'result'        => (object) $result
        ];

        if ($withPermissions) {
            $data['permissions'] = (object) $this->getPermissions();
        }

        return response()->json($data, $status, $headers, $options);
    }

    public function noContentResponse(array $headers = []): JsonResponse
    {
        return response()->json([], 204, $headers);
    }

    public function errorResponse(
        $status,
        $errorCode = null,
        string $message = '',
        array $errors = [],
        array $data = [],
        array $headers = [],
        int $options = 0
    ): JsonResponse {
        return response()->json([
            'status'        => $status,
            'error_code'    => $errorCode, 
            'message'       => $message,
            'errors'        => (object) $errors,
            'data'          => (object) $data
        ], $status, $headers, $options);
    }

    public function httpErrorResponse(HttpJsonResponseException $exception): JsonResponse
    {
        return $this->errorResponse(
            $exception->getStatus(),
            $exception->getErrorCode(),
            $exception->getMessage(),
            $exception->getErrors(),
            $exception->getData()
        );
    }

    public function serverErrorResponse(Throwable $exception): JsonResponse
    {
        return $this->errorResponse(
            Response::HTTP_INTERNAL_SERVER_ERROR,
            'internalServerError',
            'Internal server error.',
            [
                'server' => $exception->getMessage(),
            ],
        );
    }
}