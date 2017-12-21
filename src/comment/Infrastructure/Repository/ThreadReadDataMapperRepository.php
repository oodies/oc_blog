<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Infrastructure\Repository;

use Blogpost\Domain\ValueObject\PostID;
use Comment\Domain\Model\Thread;
use Comment\Domain\Repository\ThreadReadRepositoryInterface;
use Comment\Domain\ValueObject\ThreadID;
use Comment\Infrastructure\Repository\TableGateway\ThreadTableGateway;
use Lib\Db\AbstractRepository;

/**
 * Class ThreadReadDataMapperRepository
 * @package Comment\Infrastructure\Repository
 */
class ThreadReadDataMapperRepository extends AbstractRepository implements ThreadReadRepositoryInterface
{
    /** *******************************
     *  PROPERTIES
     */

    /**
     * @var string
     */
    protected $gatewayName = ThreadTableGateway::class;

    /** *******************************
     *  METHODS
     */


    /**
     * Get thread by ThreadID value object
     *
     * @param ThreadID $threadID
     *
     * @return Thread
     */
    public function getByThreadID(ThreadID $threadID): Thread
    {
        $thread = new Thread();

        $row = $this->getDbTable()->findByThreadID($threadID->getValue());
        if ($row !== false) {
            $this->hydrate($thread, $row);
        }

        return $thread;
    }

    /**
     * @param Thread $thread
     * @param array  $row
     */
    protected function hydrate(Thread $thread, array $row)
    {
        $thread
            ->setIdThread($row['id_thread'])
            ->setThreadID(new ThreadID($row['threadID']))
            ->setPostID(new PostID($row['postID']))
            ->setCreateAt(new \DateTime($row['create_at']))
            ->setUpdateAt(new \DateTime($row['update_at']))
            ->setNumberOfComment((int)$row['number_of_comment']);
    }

    /**
     * Find thread by PostID value object
     *
     * @param PostID $postID
     *
     * @return null|Thread
     */
    public function findByPostID(PostID $postID): ?Thread
    {
        $thread = null;

        $row = $this->getDbTable()->findByPostID($postID->getValue());
        if ($row !== false) {
            $thread = new Thread();
            $this->hydrate($thread, $row);
        }

        return $thread;
    }
}