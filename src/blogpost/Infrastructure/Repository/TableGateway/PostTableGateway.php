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
 * Class PostTableGateway
 * @package Blogpost\Infrastructure\Repository\TableGateway
 */
class PostTableGateway extends AbstractTableGateway
{

    /** *******************************
     *      PROPERTIES
     * ********************************/

    protected $primary = 'id_post';

    protected $tableName = 'blogpost_post';

    /** *******************************
     *      METHODS
     * ********************************/


    /**
     * Fetches a row by 'postID' foreign key
     *
     * @param string $postID
     *
     * @return array|false
     * @throws \Exception
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