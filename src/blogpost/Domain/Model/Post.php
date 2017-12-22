<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Domain\Model;

use Blogpost\Domain\ValueObject\BloggerID;
use Blogpost\Domain\ValueObject\PostID;

/**
 * Class Post
 * @package Blogpost\Domain\Model
 */
class Post
{

    /** *******************************
     *  ATTRIBUTES
     */

    /** @var integer */
    protected $idPost;

    /** @var \DateTime */
    protected $createAt;

    /** @var \DateTime */
    protected $updateAt;

    /**
     * Object-Value
     */

    /** @var PostID */
    protected $postID;

    /** @var BloggerID */
    protected $bloggerID;


    /** *******************************
     *  GETTER/SETTER
     */

    /**
     * @return int|null
     */
    public function getIdPost(): ?int
    {
        return $this->idPost;
    }

    /**
     * @param int|null $idPost
     *
     * @return Post
     */
    public function setIdPost(?int $idPost): Post
    {
        $this->idPost = $idPost;
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
     * @return Post
     */
    public function setPostID(PostID $postID): Post
    {
        $this->postID = $postID;
        return $this;
    }

    /**
     * @return BloggerID
     */
    public function getBloggerID(): BloggerID
    {
        return $this->bloggerID;
    }

    /**
     * @param BloggerID $bloggerID
     *
     * @return Post
     */
    public function setBloggerID(BloggerID $bloggerID)
    {
        $this->bloggerID = $bloggerID;
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
     * @return Post
     */
    public function setCreateAt(\DateTime $createAt): Post
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
     * @return Post
     */
    public function setUpdateAt(\DateTime $updateAt): Post
    {
        $this->updateAt = $updateAt;
        return $this;
    }

    /** *******************************
     *  BEHAVIOR OF THE OBJECT MODEL
     */

    /**
     * Create a post
     *
     * @param BloggerID $bloggerID
     */
    public function create(BloggerID $bloggerID)
    {
        $date = new \DateTime();

        $this->setPostID(new PostID())
            ->setBloggerID($bloggerID)
            ->setCreateAt($date)
            ->setUpdateAt($date);
    }

    /**
     * Update a post
     */
    public function update()
    {
        $this->setUpdateAt(new \DateTime());
    }

}