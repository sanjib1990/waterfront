<?php
/**
 * Created by PhpStorm.
 * User: sanjib
 * Date: 8/6/17
 * Time: 11:44 PM
 */

namespace App\Transformers;

use App\Models\Person;

/**
 * Class RelationsTransformer
 *
 * @package App\Transformers
 */
class RelationsTransformer extends Transformer
{
    /**
     * @var array
     */
    protected $availableIncludes    = ['persons', 'related_to'];

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
            'uuid'      => get_data($data, 'uuid'),
            'relation'  => get_data($data, 'relation'),
            'slug'      => get_data($data, 'slug')
        ];
    }

    /**
     * @param $data
     *
     * @return \League\Fractal\Resource\Item|\League\Fractal\Resource\NullResource
     */
    public function includeRelatedTo($data)
    {
        return ! empty(get_data($data, 'pivot.related_to'))
            ? $this->item($this->getRelatedTo($data->pivot->related_to), new PersonsTransformer())
            : $this->null();
    }

    /**
     * @param int $personId
     *
     * @return mixed
     */
    private function getRelatedTo(int $personId)
    {
        $person = new Person();

        return $person->find($personId)->toArray();
    }
}
