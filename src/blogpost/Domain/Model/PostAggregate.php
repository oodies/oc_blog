<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Domain\Model;

use Blogpost\Domain\ValueObject\PostID;
use User\Domain\Model\User;

/**
 * Class PostAggregate
 * @package Blogpost\Domain\Model
 */
class PostAggregate extends Post
{
    /** *******************************
     *  ATTRIBUTES
     */

    /** @var Header $header */
    protected $header;

    /** @var Body $body */
    protected $body = null;

    /** @var Blogger $blogger */
    protected $blogger = null;


    /** *******************************
     *  METHODS
     */

    /**
     * PostAggregate constructor.
     *
     * @param PostID|null $postID
     */
    public function __construct(?PostID $postID = null)
    {
        if ($postID === null) {
            $postID = new PostID();
        }

        $this->setPostID($postID);
        $this->header = new Header();
        $this->header->setPostID($postID);
        $this->body = new Body();
        $this->body->setPostID($postID);
        $this->blogger = new Blogger();
    }


    /** *******************************
     *  GETTER/SETTER
     */

    /**
     * @return Body
     */
    public function getBody(): Body
    {
        return $this->body;
    }

    /**
     * @param Body $body
     *
     * @return PostAggregate
     */
    public function setBody(Body $body): PostAggregate
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return User|null
     */
    public function getBlogger(): ?User
    {
        return $this->blogger;
    }

    /**
     * @param User $blogger
     *
     * @return PostAggregate
     */
    public function setBlogger(User $blogger): PostAggregate
    {
        $this->blogger = $blogger;
        return $this;
    }

    /**
     * @return Header
     */
    public function getHeader(): Header
    {
        return $this->header;
    }

    /**
     * @param Header $header
     *
     * @return PostAggregate
     */
    public function setHeader(Header $header): PostAggregate
    {
        $this->header = $header;
        return $this;
    }
}
