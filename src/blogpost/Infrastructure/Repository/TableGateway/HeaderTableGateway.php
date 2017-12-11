<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Infrastructure\Repository\TableGateway;

use Lib\Db\AbstractTableGateway;

/**
 * Class HeaderTableGateway
 * @package Blogpost\Infrastructure\Repository\TableGateway
 */
class HeaderTableGateway extends AbstractTableGateway
{

    /** *******************************
     *      PROPERTIES
     * ********************************/

    protected $primary = 'id_header';

    protected $tableName = 'blogpost_header';


    /** *******************************
     *      METHODS
     * ********************************/

    /**
     * Fetches a row by 'postID' foreign key
     *
     * @param string $postID
     *
     * @return array|false
     */
    public function findByPostId(string $postID)
    {
        $sql = "SELECT * FROM " . $this->tableName .
            " WHERE postID" . "= :postID";

        /** @var \PDOStatement $statement */
        $statement = $this->getAdapter()->getConnection()->prepare($sql);
        $statement->execute([':postID' => $postID]);

        return $statement->fetch();
    }
}