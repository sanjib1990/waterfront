<?php
/**
 * Created by PhpStorm.
 * User: sanjib
 * Date: 7/6/17
 * Time: 12:13 PM
 */

use Ramsey\Uuid\Uuid;

if (! function_exists('get_data')) {
    /**
     * Method gets a value from the array  which is not empty.
     *
     * @param array|object $data
     * @param string $key
     * @param string $default
     * @return mixed
     */
    function get_data($data, $key, $default = null)
    {
        $value = data_get($data, $key);

        return !empty($value) ? $value : $default;
    }
}

if (! function_exists('timestamp')) {
    /**
     * Method gets a 13 digit current timestamp.
     */
    function timestamp()
    {
        return (int) round(microtime(true) * 1000);
    }
}

if (! function_exists('uuid')) {
    /**
     * Generate Uuid.
     */
    function uuid()
    {
        return Uuid::uuid4()->toString();
    }
}
