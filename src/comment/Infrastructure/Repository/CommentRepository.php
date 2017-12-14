<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Infrastructure\Repository;

use Comment\Domain\Model\Comment;
use Comment\Domain\ValueObject\AuthorID;
use Comment\Domain\ValueObject\ThreadID;
use Comment\Infrastructure\Repository\TableGateway\CommentTableGateway;
use Lib\Db\AbstractRepository;

/**
 * Class CommentRepository
 * @package Comment\Infrastructure\Repository
 */
class CommentRepository extends AbstractRepository
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
     * @param ThreadID $threadID
     *
     * @return array
     */
    public function findByThreadID(ThreadID $threadID): array
    {
        $rowSet = $this->getDbTable()->findByThreadID($threadID->getValue());

        $entries = [];
        if (count($rowSet)) {
            foreach ($rowSet as $row) {
                $comment = new Comment();
                $comment
                    ->setIdComment($row['id_comment'])
                    ->setThreadID(new ThreadID($row['threadID']))
                    ->setAuthorID(new AuthorID($row['authorID']))
                    ->setBody($row['body'])
                    ->setCreateAt($row['create_at'])
                ;
                $entries[] = $comment;
                unset($comment);
            }
        }
        return $entries;
    }

    /**
     * Persist model
     *
     * @param Comment $comment
     *
     * @throws \Exception
     */
    public function save(Comment $comment)
    {
        $data['threadID'] = $comment->getThreadID()->getValue();
        $data['body'] = $comment->getBody();
        $data['create_at'] = $comment->getCreateAt();

        if ($comment->getIdComment() === null) {
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, $comment->getIdComment());
        }
    }
}