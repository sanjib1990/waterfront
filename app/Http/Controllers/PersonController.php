<?php
/**
 * Created by PhpStorm.
 * User: sanjib
 * Date: 8/6/17
 * Time: 11:40 PM
 */

namespace App\Http\Controllers;

use App\Contracts\RelationContract;
use Carbon\Carbon;
use App\Utils\Transformer;
use App\Contracts\PersonContract;
use App\Http\Requests\PersonRequest;
use App\Transformers\PersonsTransformer;
use App\Http\Requests\RelatePersonRequest;

/**
 * Class PersonController
 *
 * @package App\Http\Controllers
 */
class PersonController extends Controller
{
    /**
     * @var PersonContract
     */
    private $person;

    /**
     * @var Transformer
     */
    private $transformer;

    /**
     * PersonController constructor.
     *
     * @param PersonContract $person
     * @param Transformer    $transformer
     */
    public function __construct(PersonContract $person, Transformer $transformer)
    {
        $this->person       = $person;
        $this->transformer  = $transformer;
    }

    /**
     * Get Person list..
     *
     * @return mixed
     */
    public function get()
    {
        if (request()->uuid) {
            return $this->getByUuid();
        }

        $persons    = $this->transformer->process($this->person->all(), new PersonsTransformer());

        return response()->jsend($persons, trans('api.success'));
    }

    /**
     * Get person by uuid.
     *
     * @return mixed
     */
    private function getByUuid()
    {
        $person = $this
            ->transformer
            ->process(
                $this->person->getByUuid(request()->uuid),
                new PersonsTransformer()
            );

        return response()->jsend($person, trans('api.success'));
    }

    /**
     * Create a Person.
     *
     * @param PersonRequest $request
     *
     * @return mixed
     */
    public function create(PersonRequest $request)
    {
        $person = $this->person->store($request->all());

        return response()->jsend(
            $this->transformer->process($person, new PersonsTransformer()),
            trans('api.success'),
            201
        );
    }

    /**
     * Update a Person.
     *
     * @param PersonRequest $request
     *
     * @return mixed
     */
    public function update(PersonRequest $request)
    {
        $person = $this->person->getByUuid($request->uuid);

        $person->name       = $request->get('name');
        $person->updated_at = Carbon::now();

        $person->save();

        return response(null, 205);
    }

    public function relate(RelatePersonRequest $request, RelationContract $relation)
    {
        $person         = $this->person->getByUuid($request->uuid);
        $relationsData  = collect($request->get('relations'));

        $relationMap    = $relation
            ->select('id', 'uuid')
            ->whereIn('uuid', $relationsData->pluck('relation_uuid')->toArray())
            ->get()
            ->reduce(function ($array, $item) {
                $array[$item->uuid] = $item->id;

                return $array;
            });

        $relatedToMap   = $this
            ->person
            ->select('id', 'uuid')
            ->whereIn('uuid', $relationsData->pluck('related_to')->toArray())
            ->get()
            ->reduce(function ($array, $item) {
                $array[$item->uuid] = $item->id;

                return $array;
            });

        $person->relations()->detach();

        foreach ($relationsData as $relation) {
            $person
                ->relations()
                ->attach(
                    $relationMap[$relation['relation_uuid']],
                    [
                        'related_to' => $relatedToMap[$relation['related_to']]
                    ]
                );
        }

        return response(null, 205);
    }
}
