<?php

namespace App\Utils;

use League\Fractal\Manager;
use App\Utils\Fractal\Serializers\ArraySerializer;

/**
 * Class Transformer
 *
 * @package App\Utils
 */
class Transformer
{
    /**
     * @var Manager
     */
    private $manager;

    /**
     * @var Factory
     */
    private $factory;

    /**
     * Transformer constructor.
     *
     * @param Factory $factory
     * @param Manager $manager
     */
    public function __construct(Factory $factory, Manager $manager)
    {
        $this->factory = $factory;
        $this->manager = $manager;
    }

    /**
     * @param      $data
     * @param      $transform
     * @param      $includes
     * @return array
     */
    public function process($data, $transform, $includes = null)
    {
        if (empty($data)) {
            return [];
        }

        $this->manager->setSerializer(new ArraySerializer());

        $includes   = $includes ?? request()->get('includes');

        if (!empty($includes)) {
            $this->manager->parseIncludes($includes);
        }

        $resource = $this->factory->make($data, $transform);

        return $this->manager->createData($resource)->toArray();
    }
}
