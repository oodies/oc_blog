<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Infrastructure\Repository\TableGateway;

use Lib\Db\AbstractTableGateway;

/**
 * Class ThreadTableGateway
 * @package Comment\Insfrasctructure\Repository\TableGateway
 */
class ThreadTableGateway extends AbstractTableGateway
{

    /** *******************************
     *      PROPERTIES
     * ********************************/

    protected $primary = 'id_thread';

    protected $tableName = 'comment_thread';


    /** *******************************
     *      METHODS
     * ********************************/

    /**
     * fetches a row by 'postID' foreign key
     *
     * @param string $postID
     *
     * @return array|false
     * @throws \Exception
     */
    public function findByPostID(string $postID)
    {
        $sql = "SELECT * FROM " . $this->tableName .
            " WHERE postID" . "= :postID";

        /** @var \PDOStatement $statement */
        $statement = $this->getAdapter()->getConnection()->prepare($sql);
        $statement->execute([':postID' => $postID]);

        return $statement->fetch();
    }
}