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
 * Class CommentTableGateway
 * @package Comment\Insfrasctructure\Repository\TableGateway
 */
class CommentTableGateway extends AbstractTableGateway
{

    /** *******************************
     *      PROPERTIES
     * ********************************/

    protected $primary = 'id_comment';

    protected $tableName = 'comment_comment';


    /** *******************************
     *      METHODS
     * ********************************/

    /**
     * fetches a rowSet by 'threadID' foreign key
     *
     * @param string $threadID
     *
     * @return array|false
     * @throws \Exception
     */
    public function findByThreadID(string $threadID)
    {
        $sql = "SELECT * FROM " . $this->tableName .
            " WHERE threadID" . "= :threadID";

        /** @var \PDOStatement $statement */
        $statement = $this->getAdapter()->getConnection()->prepare($sql);
        $statement->execute([':threadID' => $threadID]);

        return $statement->fetchAll();
    }

    /**
     * fetch a row by 'commentID'
     *
     * @param string $commentID
     *
     * @return array|false
     * @throws \Exception
     */
    public function findByCommentID(string $commentID)
    {
        $sql = "SELECT * FROM " . $this->tableName .
            " WHERE commentID" . "= :commentID";

        /** @var \PDOStatement $statement */
        $statement = $this->getAdapter()->getConnection()->prepare($sql);
        $statement->execute([':commentID' => $commentID]);

        return $statement->fetch();
    }
}