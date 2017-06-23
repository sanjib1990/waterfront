<?php
/**
 * User: sanjibdevnath
 * Date: 23/6/17
 * Time: 2:12 PM
 */

namespace App\Contracts;

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
     * @param array $data
     *
     * @return mixed
     */
    public function refreshToken(array $data);

    /**
     * Validate the authentication token.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function validate(array $data);
}
