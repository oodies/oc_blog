<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Lib\Db;

use Lib\Db\Adapter\AbstractDB;
use Lib\Registry;

/**
 * Class AbstractTableGateway
 * @package Lib\Db
 */
class AbstractTableGateway
{
    /** *******************************
     * PROPERTIES
     * ****************************** */

    /**
     * @var AbstractDB null
     */
    public $db = null;


    /** *******************************
     * METHODS
     * ****************************** */

    /**
     * AbstractTableGateway constructor.
     *
     * Children's classes must have a 'tableName' property.
     * Children's classes must have a 'primary' property.
     */
    public final function __construct()
    {
        if (!isset($this->tableName)) {
            throw new \LogicException(get_class($this) . ' must have a $tableName property');
        }

        if (!isset($this->primary)) {
            throw new \LogicException(get_class($this) . ' must have a $primary property');
        }
    }

    /**
     * Fetches rows by primary key
     *
     * @param $id
     *
     * @return false|array
     */
    public function find($id)
    {
        $sql = "SELECT * FROM " . $this->tableName .
            " WHERE " . $this->primary . "= :id";

        /** @var \PDOStatement $statement */
        $statement = $this->getAdapter()->getConnection()->prepare($sql);
        $statement->execute([':id' => $id]);

        return $statement->fetch();
    }

    /**
     * @return AbstractDB
     */
    public function getAdapter()
    {
        if ($this->db === null) {
            self::setAdapter(Registry::get('db'));
        }
        return $this->db;
    }

    /**
     * Set dbAdapter property
     *
     * @param AbstractDB $db
     *
     * @return AbstractTableGateway
     */
    public function setAdapter(AbstractDB $db): AbstractTableGateway
    {
        $this->db = $db;
        return $this;
    }

    /**
     * Find all row
     *
     * @return array
     */
    public function findAll()
    {
        $sql = "SELECT * FROM " . $this->tableName;
        /** @var \PDOStatement $statement */
        $statement = $this->getAdapter()->getConnection()->prepare($sql);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * Insert a new row
     *
     * @param array $data
     *
     * @throws \Exception
     */
    public function insert(array $data)
    {

        $sql = 'INSERT INTO ';
        $sql .= $this->tableName . '(';
        $sql .= rtrim(implode(',', array_keys($data)), ',');

        $sql .= ') VALUES(:';
        $sql .= rtrim(implode(',:', array_keys($data)), ',:');
        $sql .= ')';

        $bind = [];
        foreach ($data as $field => $value) {
            // TODO Ici un quoteInto
            $bind[$field] = $value;
        }

        $statement = $this->getAdapter()->getConnection()->prepare($sql);
        $statement->execute($bind);
    }


    /**
     * Updates existing rows
     *
     * @param array $data
     * @param       $where
     */
    public function update(array $data, $where)
    {
        $sql = 'UPDATE ' . $this->tableName . ' SET ';
        $fields = array_keys($data);
        foreach ($fields as $field) {
            $sql .= ' ' . $field . ' =:' . $field . ',';
        }
        $sql = rtrim($sql, ',');
        $sql .= ' WHERE ' . $this->primary . ' = ' . $where;

        $bind = [];
        foreach ($data as $field => $value) {
            // TODO Ici un quoteInto
            $bind[$field] = $value;
        }
        $statement = $this->getAdapter()->getConnection()->prepare($sql);
        $statement->execute($bind);
    }
}