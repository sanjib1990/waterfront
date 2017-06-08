<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

/**
 * Class Transformer
 *
 * @package App\Http\Transformers\V1
 */
abstract class Transformer extends TransformerAbstract
{
    /**
     * Transform the data.
     *
     * @param $data
     *
     * @return mixed
     */
    abstract public function transform($data);
}
