<?php
/**
 * Created by PhpStorm.
 * User: sanjib
 * Date: 8/6/17
 * Time: 11:40 PM
 */

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Utils\Transformer;
use App\Contracts\RelationContract;
use App\Http\Requests\RelationRequest;
use App\Transformers\RelationsTransformer;

/**
 * Class RelationController
 *
 * @package App\Http\Controllers
 */
class RelationController extends Controller
{
    /**
     * @var RelationContract
     */
    private $relation;

    /**
     * @var Transformer
     */
    private $transformer;

    /**
     * RelationController constructor.
     *
     * @param RelationContract $relation
     * @param Transformer      $transformer
     */
    public function __construct(RelationContract $relation, Transformer $transformer)
    {
        $this->relation     = $relation;
        $this->transformer  = $transformer;
    }

    /**
     * Get Relations.
     *
     * @return mixed
     */
    public function get()
    {
        if (request()->uuid) {
            return $this->getByUuid();
        }

        $relations  = $this->transformer->process($this->relation->all(), new RelationsTransformer());

        return response()->jsend($relations, trans('api.success'));
    }

    /**
     * Get Relation by uuid.
     *
     * @return mixed
     */
    private function getByUuid()
    {
        $relation   = $this
            ->transformer
            ->process(
                $this->relation->getByUuid(request()->uuid),
                new RelationsTransformer()
            );

        return response()->jsend($relation, trans('api.success'));
    }

    /**
     * Create a relation.
     *
     * @param RelationRequest $request
     *
     * @return mixed
     */
    public function create(RelationRequest $request)
    {
        $relation   = $this->relation->store($request->all());

        return response()->jsend(
            $this->transformer->process($relation, new RelationsTransformer()),
            trans('api.success'),
            201
        );
    }

    /**
     * Update a relation.
     *
     * @param RelationRequest $request
     *
     * @return mixed
     */
    public function update(RelationRequest $request)
    {
        $relation   = $this->relation->getByUuid($request->uuid);

        $relation->relation     = $request->get('relation');
        $relation->updated_at   = Carbon::now();

        $relation->save();

        return response(null, 205);
    }
}
