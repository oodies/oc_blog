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

    /** @var \DateTime */
    protected $createAt;

    /** @var \DateTime */
    protected $updateAt;

    /** @var int */
    protected $numberOfComment;

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

    /**
     * @return \DateTime
     */
    public function getCreateAt(): \DateTime
    {
        return $this->createAt;
    }

    /**
     * @param \DateTime $createAt
     *
     * @return Thread
     */
    public function setCreateAt(\DateTime $createAt): Thread
    {
        $this->createAt = $createAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdateAt(): \DateTime
    {
        return $this->updateAt;
    }

    /**
     * @param \DateTime $updateAt
     *
     * @return Thread
     */
    public function setUpdateAt(\DateTime $updateAt): Thread
    {
        $this->updateAt = $updateAt;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumberOfComment(): int
    {
        return $this->numberOfComment;
    }

    /**
     * @param int $numberOfComment
     *
     * @return Thread
     */
    public function setNumberOfComment(int $numberOfComment): Thread
    {
        $this->numberOfComment = $numberOfComment;
        return $this;
    }


    /** *******************************
     *  BEHAVIOR OF THE OBJECT MODEL
     */

    /**
     * Create a comment feed for this identified post
     *
     * @param PostID $postID
     */
    public function createThread(PostID $postID)
    {
        $this->setPostID($postID)
            ->setThreadID(new ThreadID())
            ->setCreateAt(new \DateTime())
            ->setUpdateAt(new \DateTime())
            ->setNumberOfComment(1);
    }

    /**
     * Update comment feed for a new post posted
     */
    public function updateThread() {
        $this->numberOfComment = (int)$this->getNumberOfComment()+1;
        $this->setUpdateAt(new \DateTime());
    }
}