<?php

namespace App\Traits\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait Authenticatable
{
    /**
     * Response with token.
     *
     * @param $token
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return $this->successResponse(
            Response::HTTP_OK,
            'Successfully logged in.',
            [
                'token_type'    => $token->token_type,
                'expires_in'    => $token->expires_in,
                'access_token'  => $token->access_token,
            ]
        );
    }
}
