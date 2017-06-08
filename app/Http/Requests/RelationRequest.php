<?php
/**
 * Created by PhpStorm.
 * User: sanjib
 * Date: 9/6/17
 * Time: 12:13 AM
 */

namespace App\Http\Requests;

/**
 * Class RelationRequest
 *
 * @package App\Http\Requests
 */
class RelationRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'relation'  => 'required | unique:relations,relation,'. $this->uuid.',uuid,slug,'
                .snake_case($this->get('relation'))
        ];
    }
}
