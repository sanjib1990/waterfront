<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TokenRequest;
use App\Contracts\ApiAuthenticateContract;

/**
 * Class AuthenticateController
 *
 * @package App\Http\Controllers\Api
 */
class AuthenticateController extends Controller
{
    /**
     * @var \App\Contracts\ApiAuthenticateContract
     */
    private $authenticator;

    /**
     * AuthenticateController constructor.
     *
     * @param \App\Contracts\ApiAuthenticateContract $authenticator
     */
    public function __construct(ApiAuthenticateContract $authenticator)
    {
        $this->authenticator    = $authenticator;
    }

    /**
     * Authenticate and generate token.
     *
     * @param \App\Http\Requests\Api\TokenRequest $request
     *
     * @return mixed
     */
    public function token(TokenRequest $request)
    {
        return response()->jsend($this->authenticator->token($request->all()), trans("api.success"));
    }

    /**
     * Refresh Token.
     *
     * @param \App\Http\Requests\Api\TokenRequest $request
     *
     * @return mixed
     */
    public function refreshToken(TokenRequest $request)
    {
        return response()->jsend($this->authenticator->refreshToken($request->all()), trans("api.success"));
    }
}
