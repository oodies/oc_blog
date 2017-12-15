<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Domain\Model;

use Comment\Domain\ValueObject\AuthorID;
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

    /** @var \DateTime */
    protected $createAt;

    /**
     * Value object
     */

    /** @var ThreadID $threadID */
    protected $threadID;

    /** @var AuthorID $authorID */
    protected $authorID;

    /** *******************************
     *      METHODS
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
}