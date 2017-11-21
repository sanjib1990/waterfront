<?php

namespace App\Exceptions;

/**
 * Class ConvertionException
 *
 * @package App\Exceptions
 */
class ConvertionException extends StandardizedErrorResponseException
{
    /**
     * Send back a HTTP 400 Bad Request status code
     *
     * @var int
     */
    protected $code = 500;

    /**
     * Error message that will be sent back to the user
     *
     * @var string
     */
    protected $message = 'Error while conversion.';
}
