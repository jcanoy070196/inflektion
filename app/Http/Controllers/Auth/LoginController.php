<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\HttpJsonResponseException;
use App\Http\Controllers\Controller;
use App\Traits\Auth\Authenticatable;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;

class LoginController extends Controller
{
    use Authenticatable;
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $data = [
                'grant_type'    => 'client_credentials',
                'client_id'     => $request->client_id,
                'client_secret' => $request->client_secret
            ];
    
            $response = Http::asForm()->post(config('app.url') . '/oauth/token', $data);

            $token = json_decode($response->getBody(), false, 512, JSON_THROW_ON_ERROR);

            return $this->respondWithToken($token);
        } catch (HttpJsonResponseException $exception) {
            return $this->httpErrorResponse($exception);
        } catch (Exception | Throwable $exception) {
            return $this->serverErrorResponse($exception);
        }
    }
}
