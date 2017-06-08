<?php
/**
 * Created by PhpStorm.
 * User: sanjib
 * Date: 8/6/17
 * Time: 11:02 PM
 */

namespace App\Contracts;

/**
 * Interface RelationContract
 *
 * @package App\Contracts
 */
interface RelationContract
{
    /**
     * Get relations by uuid.
     *
     * @param string $uuid
     *
     * @return mixed
     */
    public function getByUuid(string $uuid);

    /**
     * Create a relation.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function store(array $data);
}
