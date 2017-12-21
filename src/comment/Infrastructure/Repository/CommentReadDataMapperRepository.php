<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Infrastructure\Repository;

use Comment\Domain\Model\Comment;
use Comment\Domain\Repository\CommentReadRepositoryInterface;
use Comment\Domain\ValueObject\AuthorID;
use Comment\Domain\ValueObject\ThreadID;
use Comment\Infrastructure\Repository\TableGateway\CommentTableGateway;
use Lib\Db\AbstractRepository;

/**
 * Class CommentReadDataMapperRepository
 * @package Comment\Infrastructure\Repository
 */
class CommentReadDataMapperRepository extends AbstractRepository implements CommentReadRepositoryInterface
{
    /** *******************************
     *  PROPERTIES
     */

    /**
     * @var string
     */
    protected $gatewayName = CommentTableGateway::class;


    /** *******************************
     *  METHODS
     */

    /**
     * Find all comments by ThreadID value object
     *
     * @param ThreadID $threadID
     *
     * @return array
     */
    public function findAllByThreadID(ThreadID $threadID): array
    {
        $entries = [];

        $rowSet = $this->getDbTable()->findByThreadID($threadID->getValue());
        if (count($rowSet)) {
            foreach ($rowSet as $row) {
                $comment = new Comment();
                $this->hydrate($comment, $row);
                $entries[] = $comment;
                unset($comment);
            }
        }

        return $entries;
    }

    /**
     * Find all comments
     *
     * @return array
     */
    public function findAll(): array
    {
        $entries = [];

        $rowSet = $this->getDbTable()->findAll();
        if (count($rowSet)) {
            foreach ($rowSet as $key => $row) {
                $comment = new Comment();
                $this->hydrate($comment, $row);
                $entries[] = $comment;
                unset($comment);
            }
        }

        return $entries;
    }

    /**
     * Hydrate Comment model with data
     *
     * @param Comment $comment
     * @param array   $row
     */
    protected function hydrate(Comment $comment, array $row)
    {
        $comment
            ->setIdComment($row['id_comment'])
            ->setThreadID(new ThreadID($row['threadID']))
            ->setAuthorID(new AuthorID($row['authorID']))
            ->setEnabled((bool)$row['enabled'])
            ->setBody($row['body'])
            ->setCreateAt(new \DateTime($row['create_at']))
            ->setUpdateAt(new \DateTime($row['update_at']))
        ;
    }
}