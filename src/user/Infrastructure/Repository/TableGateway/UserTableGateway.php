<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace user\Infrastructure\Repository\TableGateway;

use Lib\Db\AbstractTableGateway;

/**
 * Class UserTableGateway
 * @package user\Infrastructure\Repository\TableGateway
 */
class UserTableGateway extends AbstractTableGateway
{
    /** *******************************
     *      PROPERTIES
     * ********************************/

    protected $primary = 'id_user';

    protected $tableName = 'user_user';

    /** *******************************
     *      METHODS
     * ********************************/

    /**
     * Fetches a row by userID
     *
     * @param string $userID
     *
     * @return false|array
     * @throws \Exception
     */
    public function findByUserID(string $userID)
    {
        $sql = "SELECT * FROM " . $this->tableName .
            " WHERE userID" . " = :userID";

        /** @var \PDOStatement $statement */
        $statement = $this->getAdapter()->getConnection()->prepare($sql);
        $statement->execute([':userID' => $userID]);

        return $statement->fetch();
    }
}