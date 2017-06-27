<?php
/**
 * User: sanjibdevnath
 * Date: 23/6/17
 * Time: 2:26 PM
 */

namespace App\Utils;

use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Contracts\ApiAuthenticateContract;
use App\Exceptions\InvalidUserInputException;

/**
 * Class JwtAuthenticator
 *
 * @package App\Utils
 */
class JwtAuthenticator implements ApiAuthenticateContract
{
    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    private $auth;

    /**
     * JwtAuthenticator constructor.
     *
     * @param \Tymon\JWTAuth\JWTAuth $auth
     */
    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Authenticate the user and generate token.
     *
     * @param array $data
     *
     * @return mixed
     * @throws \Exception
     */
    public function token(array $data)
    {
        try {
            $token  = $this->auth->attempt(["email" => $data["email"], "password" => $data["password"]]);

            if (! $token) {
                throw new InvalidUserInputException(trans("api.validations.auth"));
            }

            return $token;
        } catch (JWTException $exception) {
            throw new \Exception($exception);
        }
    }

    /**
     * Refrest the generated token.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function refreshToken(Request $request)
    {
        return $this->auth->setRequest($request)->refresh();
    }

    /**
     * Validate the authentication token.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function validate(array $data)
    {
        // TODO: Implement validate() method.
    }
}
