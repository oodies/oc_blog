<?php
/**
 * Created by PhpStorm.
 * User: Sébastien CHOMY
 * Date: 30/11/2017
 * Time: 22:06
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
    /** @var integer */
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
     * @return int
     */
    public function getIdBody(): int
    {
        return $this->idBody;
    }

    /**
     * @param int $idBody
     *
     * @return Body
     */
    public function setIdBody(int $idBody): Body
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
}