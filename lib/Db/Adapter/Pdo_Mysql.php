<?php
/**
 * Created by PhpStorm.
 * User: Sébastien CHOMY
 * Date: 07/12/2017
 * Time: 15:36
 */

namespace Lib\Db\Adapter;

/**
 * Class Pdo_Mysql
 * @package Lib\Db\Adapter
 */
class Pdo_Mysql extends AbstractDB
{
    /**
     * PDO type.
     *
     * @var string
     */
    protected $pdoType = 'mysql';

    /**
     * Creates a PDO object and connects to the database
     *
     * @throws \Exception
     */
    public function connect(): void
    {
        if ($this->connection) {
            return;
        }

        parent::connect();

    }
}