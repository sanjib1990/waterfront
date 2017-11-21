<?php
/**
 * User: sanjib
 * Date: 21/11/17
 * Time: 5:06 PM
 */

namespace App\Exceptions;

/**
 * Class HttpHeaderException
 *
 * @package App\Exceptions
 */
class HttpHeaderException extends StandardizedErrorResponseException
{
    /**
     * @var bool
     */
    public $shouldRenderAsJson  = true;

    /**
     * Error message that will be sent back to the user
     *
     * @var string
     */
    protected $message  = "Appropriate header is missing or the resource is not correct.";

    /**
     * HTTP Error Code.
     *
     * @var int
     */
    protected $code = 422;
}
