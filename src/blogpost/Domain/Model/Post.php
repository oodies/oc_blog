<?php
/**
 * Created by PhpStorm.
 * User: Sébastien CHOMY
 * Date: 02/12/2017
 * Time: 10:55
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
     * @return mixed
     */
    public function getBloggerID()
    {
        return $this->bloggerID;
    }

    /**
     * @param mixed $bloggerID
     *
     * @return Post
     */
    public function setBloggerID($bloggerID)
    {
        $this->bloggerID = $bloggerID;
        return $this;
    }
}