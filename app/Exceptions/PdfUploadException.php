<?php

namespace App\Exceptions;

/**
 * Class PdfUploadException
 *
 * @package App\Exceptions
 */
class PdfUploadException extends StandardizedErrorResponseException
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
    protected $message = 'Unable to upload';
}
