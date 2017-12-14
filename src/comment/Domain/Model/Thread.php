<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Domain\Model;

use Blogpost\Domain\ValueObject\PostID;
use Comment\Domain\ValueObject\ThreadID;

/**
 * Class Thread
 * @package Comment\Domain\Model
 */
class Thread
{

    /** *******************************
     *  PROPERTIES
     */

    /** @var int */
    protected $idThread;

    /**
     * Value Object
     */

    /** @var threadID */
    protected $threadID;

    /** @var PostID */
    protected $postID;

    /** *******************************
     *  METHODS
     */

    /**
     * @return null|int
     */
    public function getIdThread(): ?int
    {
        return $this->idThread;
    }

    /**
     * @param null|int $idThread
     *
     * @return Thread
     */
    public function setIdThread(?int $idThread): Thread
    {
        $this->idThread = $idThread;
        return $this;
    }

    /**
     * @return PostID
     */
    public function getPostID(): PostID
    {
        return $this->postID;
    }

    /**
     * @param PostID $postID
     *
     * @return Thread
     */
    public function setPostID(PostID $postID): Thread
    {
        $this->postID = $postID;
        return $this;
    }

    /**
     * @return ThreadID
     */
    public function getThreadID(): ThreadID
    {
        return $this->threadID;
    }

    /**
     * @param ThreadID $threadID
     *
     * @return Thread
     */
    public function setThreadID(ThreadID $threadID): Thread
    {
        $this->threadID = $threadID;
        return $this;
    }
}