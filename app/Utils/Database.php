<?php

namespace App\Utils;

use Illuminate\Foundation\Application;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Connectors\ConnectionFactory;

/**
 * Class Database
 *
 * @package App\Utils
 */
class Database extends DatabaseManager
{
    /**
     * Database constructor.
     *
     * @param Application       $app
     * @param ConnectionFactory $connectionFactory
     */
    public function __construct(Application $app, ConnectionFactory $connectionFactory)
    {
        parent::__construct($app, $connectionFactory);
    }

    /**
     * Creates the connection.
     *
     * @param string $connection
     *
     * @return \Illuminate\Database\Connection
     */
    public function mysql($connection = 'mysql')
    {
        return $this->connection($connection);
    }
}
