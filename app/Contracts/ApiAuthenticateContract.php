<?php
/**
 * User: sanjibdevnath
 * Date: 23/6/17
 * Time: 2:12 PM
 */

namespace App\Contracts;

use Illuminate\Http\Request;

/**
 * Interface ApiAuthenticateContract
 *
 * @package App\Contracts
 */
interface ApiAuthenticateContract
{
    /**
     * Authenticate the user and generate token.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function token(array $data);

    /**
     * Refrest the generated token.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function refreshToken(Request $request);

    /**
     * Validate the authentication token.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function validate(array $data);
}
