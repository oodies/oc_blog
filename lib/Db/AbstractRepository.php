<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Lib\Db;

/**
 * Class AbstractRepository
 * @package Lib\Db
 */
class AbstractRepository
{

    /**
     * @var AbstractTableGateway $dbTable
     */
    protected $dbTable;


    /**
     * AbstractRepository constructor.
     *
     * Children's classes must have a 'gatewayName' property.
     *
     */
    public final function __construct()
    {
        if (!isset($this->gatewayName)) {
            throw new \LogicException(get_class($this) . ' must have a $gatewayName property');
        }
    }

    /**
     * @return AbstractTableGateway
     */
    public function getDbTable()
    {
        if (null === $this->dbTable) {
            self::setDbTable($this->gatewayName);
        }
        return $this->dbTable;
    }

    /**
     * @param $dbTable
     *
     * @return $this
     */
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (! $dbTable instanceof AbstractTableGateway) {
            throw new \Exception('Invalid table data gateway provided');
        }
        $this->dbTable = $dbTable;
        return $this;
    }
}
