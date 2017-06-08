<?php
/**
 * Created by PhpStorm.
 * User: sanjib
 * Date: 9/6/17
 * Time: 12:13 AM
 */

namespace App\Http\Requests;

/**
 * Class PersonRequest
 *
 * @package App\Http\Requests
 */
class PersonRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => 'required | unique:persons,name,'.$this->uuid.',uuid'
        ];
    }
}
