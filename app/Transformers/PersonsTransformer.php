<?php
/**
 * Created by PhpStorm.
 * User: sanjib
 * Date: 8/6/17
 * Time: 11:44 PM
 */

namespace App\Transformers;

/**
 * Class PersonsTransformer
 *
 * @package App\Transformers
 */
class PersonsTransformer extends Transformer
{
    /**
     * @var array
     */
    protected $availableIncludes    = ['relations'];

    /**
     * Transform the data.
     *
     * @param $data
     *
     * @return mixed
     */
    public function transform($data)
    {
        return [
            'uuid'  => get_data($data, 'uuid'),
            'name'  => get_data($data, 'name')
        ];
    }

    /**
     * @param $data
     *
     * @return \League\Fractal\Resource\Collection|\League\Fractal\Resource\NullResource
     */
    public function includeRelations($data)
    {
        return ! empty($data->relations)
            ? $this->collection($data->relations, new RelationsTransformer())
            : $this->null();
    }
}
