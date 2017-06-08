<?php

namespace App\Http\Requests;

use App\Exceptions\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\InvalidUserInputException;
use Illuminate\Contracts\Validation\Validator;

/**
 * Class Request
 *
 * @package App\Http\Requests
 */
abstract class Request extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();

    /**
     * @param Validator $validator
     *
     * @return array|void
     * @throws InvalidUserInputException
     */
    protected function formatErrors(Validator $validator)
    {
        throw new InvalidUserInputException(null, 400, null, $validator->errors());
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
