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
use Comment\Domain\ValueObject\ThreadID;
use Comment\Infrastructure\Repository\TableGateway\ThreadTableGateway;
use Lib\Db\AbstractRepository;


/**
 * Class ThreadRepository
 * @package Comment\Infrastructure\Repository
 */
class ThreadRepository extends AbstractRepository
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
     * @param PostID $postID
     *
     * @return Thread
     */
    public function findByPostID(PostID $postID): Thread
    {
        $thread = new Thread();

        $row = $this->getDbTable()->findByPostID($postID->getValue());
        if ($row !== false) {
            $thread->setIdThread($row['id_thread'])
                ->setThreadID(new ThreadID($row['threadID']))
                ->setPostID($postID);
        }
        return $thread;
    }

    /**
     * Persist model
     *
     * @param Thread $thread
     *
     * @throws \Exception
     */
    public function save(Thread $thread)
    {
        $data['postID'] = $thread->getPostID()->getValue();
        $data['threadID'] = $thread->getThreadID()->getValue();

        if ($thread->getIdThread() === null) {
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, $thread->getIdThread());
        }
    }
}