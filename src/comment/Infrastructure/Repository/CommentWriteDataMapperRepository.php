<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Infrastructure\Repository;

use Comment\Domain\Model\Comment;
use Comment\Domain\Repository\CommentWriteRepositoryInterface;
use Comment\Infrastructure\Repository\TableGateway\CommentTableGateway;
use Lib\Db\AbstractRepository;

/**
 * Class CommentWriteDataMapperRepository
 * @package Comment\Infrastructure\Repository
 */
class CommentWriteDataMapperRepository extends AbstractRepository implements CommentWriteRepositoryInterface
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
     * @param Comment $comment
     */
    public function add(Comment $comment): void
    {
        $data['threadID'] = $comment->getThreadID()->getValue();
        $data['authorID'] = $comment->getAuthorID()->getValue();
        $data['body'] = $comment->getBody();
        $data['create_at'] = $comment->getCreateAt()->format('Y-m-d H:i:s');
        $data['update_at'] = $comment->getUpdateAt()->format('Y-m-d H:i:s');

        if ($comment->getIdComment() === null) {
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, $comment->getIdComment());
        }
    }
}