<?php

namespace App\Utils\Fractal\Serializers;

use League\Fractal\Serializer\ArraySerializer as FractalArraySerializer;

/**
 * Class ArraySerializer
 *
 * @package App\Utils\Fractal\Serializers
 */
class ArraySerializer extends FractalArraySerializer
{
    /**
     * @inheritDoc
     */
    public function collection($resourceKey, array $data)
    {
        return $data;
    }

    /**
     * @inheritDoc
     */
    public function item($resourceKey, array $data)
    {
        return $data;
    }
}
