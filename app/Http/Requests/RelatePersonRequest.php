<?php
/**
 * Created by PhpStorm.
 * User: sanjib
 * Date: 9/6/17
 * Time: 12:31 AM
 */

namespace App\Http\Requests;

/**
 * Class RelatePersonRequest
 *
 * @package App\Http\Requests
 */
class RelatePersonRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'relations'                 => 'required | array | distinct',
            'relations.*.relation_uuid' => 'required | exists:relations,uuid',
            'relations.*.related_to'    => 'required | exists:persons,uuid',
        ];
    }
}
