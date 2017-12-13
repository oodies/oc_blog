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
use Blogpost\Domain\ValueObject\VersionID;

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

    /**
     * Object-Value
     */

    /** @var PostID */
    protected $postID;

    /** @var VersionID */
    protected $versionID;

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
     * @return VersionID
     */
    public function getVersionID(): VersionID
    {
        return $this->versionID;
    }

    /**
     * @param VersionID $versionID
     *
     * @return Post
     */
    public function setVersionID(VersionID $versionID): Post
    {
        $this->versionID = $versionID;
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
}