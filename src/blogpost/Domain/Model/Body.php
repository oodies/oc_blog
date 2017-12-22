<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Domain\Model;

use Blogpost\Domain\ValueObject\PostID;

/**
 * Class Body
 * @package Blogpost\Domain\Model\Post
 */
class Body
{

    /** *******************************
     *  ATTRIBUTES
     */
    /** @var integer|null */
    protected $idBody;


    /** @var string */
    protected $content;

    /**
     * Object-Value
     */

    /** @var PostID */
    protected $postID;


    /** *******************************
     *  GETTER/SETTER
     */

    /**
     * @return int|null
     */
    public function getIdBody(): ?int
    {
        return $this->idBody;
    }

    /**
     * @param int|null $idBody
     *
     * @return Body
     */
    public function setIdBody(?int $idBody): Body
    {
        $this->idBody = $idBody;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     *
     * @return Body
     */
    public function setContent(?string $content): Body
    {
        $this->content = $content;

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
     * @return Body
     */
    public function setPostID(PostID $postID): Body
    {
        $this->postID = $postID;
        return $this;
    }

    /** *******************************
     *  BEHAVIOR OF THE OBJECT MODEL
     */

    /**
     * Create a content of this post
     *
     * @param PostID $postID
     * @param string $content
     */
    public function create(PostID $postID, string $content)
    {
        $this->setPostID($postID)
            ->setContent($content);
    }
}