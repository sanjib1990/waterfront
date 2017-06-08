<?php

namespace App\Exceptions;

/**
 * Class StandardizedErrorResponseException
 *
 * @package App\Exceptions
 */
abstract class StandardizedErrorResponseException extends \Exception
{
    /**
     * Send back a HTTP 500 status code by default
     *
     * @var int
     */
    protected $code = 500;

    /**
     * Send back validation errors if available
     *
     * @var array
     */
    protected $validationErrors = [];

    /**
     * @var array
     */
    private $errors;

    /**
     * StandardizedErrorResponseException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Exception|null $previous
     * @param array          $errors
     * {@inheritdoc}
     */
    public function __construct($message = '', $code = 0, Exception $previous = null, $errors = [])
    {
        $this->message  = $message == '' ? $this->message : $message;
        $this->code     = $code == 0 ? $this->code : $code;
        $this->errors   = $errors;
    }

    /**
     * Method to return validation errors
     * g
     * @return array
     */
    public function getValidationErrors()
    {
        return $this->errors;
    }
}
