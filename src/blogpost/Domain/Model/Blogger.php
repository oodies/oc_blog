<?php
/**
 * Created by PhpStorm.
 * User: Sébastien CHOMY
 * Date: 30/11/2017
 * Time: 23:03
 */

namespace Blogpost\Domain\Model;

use Blogpost\Domain\ValueObject\PostID;

/**
 * Class Blogger
 * @package Blogpost\Domain\Model
 */
class Blogger extends Person
{
    /** *******************************
     *  ATTRIBUTES
     */

    /**
     * Object-Value
     */

    /** @var PostID $postID */
    protected $postID;


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
     * @return Blogger
     */
    public function setPostID(PostID $postID): Blogger
    {
        $this->postID = $postID;
        return $this;
    }
}