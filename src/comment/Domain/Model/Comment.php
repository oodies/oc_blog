<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Domain\Model;

use Comment\Domain\ValueObject\AuthorID;
use Comment\Domain\ValueObject\CommentID;
use Comment\Domain\ValueObject\ThreadID;
use User\Domain\ValueObject\UserID;

/**
 * Class Comment
 * @package Comment\Domain\Model
 */
class Comment
{
    /** *******************************
     *      PROPERTIES
     */

    /** @var int $idComment */
    protected $idComment;

    /** @var string $body */
    protected $body;

    /** @var boolean $enabled */
    protected $enabled;

    /** @var \DateTime $createAt */
    protected $createAt;

    /** @var \DateTime $updateAt */
    protected $updateAt;

    /**
     * Value object
     */

    /** @var ThreadID $threadID */
    protected $threadID;

    /** @var AuthorID $authorID */
    protected $authorID;

    /** @var CommentID $commentID */
    protected $commentID;

    /** *******************************
     *      SETTER / GETTER
     */

    /**
     * @return null|int
     */
    public function getIdComment(): ?int
    {
        return $this->idComment;
    }

    /**
     * @param null|int $idComment
     *
     * @return Comment
     */
    public function setIdComment(?int $idComment): Comment
    {
        $this->idComment = $idComment;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     *
     * @return Comment
     */
    public function setBody(string $body): Comment
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return null|\DateTime
     */
    public function getCreateAt(): ?\DateTime
    {
        return $this->createAt;
    }

    /**
     * @param null|\DateTime $createAt
     *
     * @return Comment
     */
    public function setCreateAt(?\DateTime $createAt): Comment
    {
        $this->createAt = $createAt;
        return $this;
    }

    /**
     * @return UserID
     */
    public function getAuthorID(): UserID
    {
        return $this->authorID;
    }

    /**
     * @param UserID $authorID
     *
     * @return Comment
     */
    public function setAuthorID(UserID $authorID): Comment
    {
        $this->authorID = $authorID;
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
     * @return Comment
     */
    public function setThreadID(ThreadID $threadID): Comment
    {
        $this->threadID = $threadID;
        return $this;
    }

    /**
     * @return CommentID
     */
    public function getCommentID(): CommentID
    {
        return $this->commentID;
    }

    /**
     * @param CommentID $commentID
     *
     * @return Comment
     */
    public function setCommentID(CommentID $commentID): Comment
    {
        $this->commentID = $commentID;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     *
     * @return Comment
     */
    public function setEnabled(bool $enabled): Comment
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * @return bool
     */
    public function getEnabled(): bool
    {
        return $this->enabled;
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
     * @return Comment
     */
    public function setUpdateAt(\DateTime $updateAt): Comment
    {
        $this->updateAt = $updateAt;
        return $this;
    }


    /** *******************************
     *  BEHAVIOR OF THE OBJECT MODEL
     */

    /**
     * Add a comment to a post as an identified author
     * Note : The comment must be approved to be posted
     *
     * @param AuthorID $authorID
     * @param ThreadID $threadID
     * @param string   $body
     */
    public function createComment(AuthorID $authorID, ThreadID $threadID, string $body)
    {
        $date = new \DateTime();

        $this
            ->setCommentID(new CommentID())
            ->setAuthorID($authorID)
            ->setThreadID($threadID)
            ->setBody($body)
            ->setEnabled(false)
            ->setCreateAt($date)
            ->setUpdateAt($date);
    }

    /**
     * The comment is approve
     */
    public function approve()
    {
        $this->setEnabled(true);
        $this->setUpdateAt(new \DateTime());
    }

    /**
     * The comment is disapprove
     */
    public function disapprove()
    {
        $this->setEnabled(false);
        $this->setUpdateAt(new \DateTime());
    }

    /**
     * The comment change his body
     */
    public function changeBody(string $body)
    {
        $this->setBody($body);
        $this->setUpdateAt(new \DateTime());
    }
}