<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Domain\Model;

use Comment\Domain\ValueObject\ThreadID;

/**
 * Class ThreadAggregate
 * @package Comment\Domain\Model
 */
class ThreadAggregate
{
    /** *******************************
     *  PROPERTIES
     */

    /** @var Thread $thread */
    protected $thread;

    /** @var array $comments
     * array commentAggregate */
    protected $comments;


    /** *******************************
     *  METHODS
     */

    /**
     * ThreadAggregate constructor.
     *
     * @param ThreadID|null $threadID
     */
    public function __construct(?ThreadID $threadID = null)
    {
        if ($threadID === null) {
            $threadID = new ThreadID();
        }

        $this->thread = new Thread();
        $this->thread->setThreadID($threadID);
        $this->comments = new \ArrayObject();
    }

    /**
     * @return Thread
     */
    public function getThread(): Thread
    {
        return $this->thread;
    }

    /**
     * @param Thread $thread
     *
     * @return ThreadAggregate
     */
    public function setThread(Thread $thread): ThreadAggregate
    {
        $this->thread = $thread;
        return $this;
    }

    /**
     * @return array
     */
    public function getComments(): array
    {
        return $this->comments;
    }

    /**
     * @param array $comments
     *
     * @return ThreadAggregate
     */
    public function setComments(array $comments): ThreadAggregate
    {
        $this->comments = $comments;
        return $this;
    }
}