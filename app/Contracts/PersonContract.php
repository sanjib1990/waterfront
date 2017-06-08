<?php
/**
 * Created by PhpStorm.
 * User: sanjib
 * Date: 8/6/17
 * Time: 11:05 PM
 */

namespace App\Contracts;

/**
 * Interface PersonContract
 *
 * @package App\Contracts
 */
interface PersonContract
{
    /**
     * Get Person by uuid.
     *
     * @param string $uuid
     *
     * @return mixed
     */
    public function getByUuid(string $uuid);

    /**
     * Create a person.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function store(array $data);
}
