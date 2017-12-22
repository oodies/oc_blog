<?php
/**
 * Created by PhpStorm.
 * User: Sébastien CHOMY
 * Date: 01/12/2017
 * Time: 10:29
 */

namespace Blogpost\Domain\Repository;

use Blogpost\Domain\Model\Post;
use Blogpost\Domain\ValueObject\PostID;

/**
 * Interface PostReadRepositoryInterface
 * @package Blogpost\Domain\Repository
 */
interface PostReadRepositoryInterface
{
    /**
     * Get the post
     *
     * @param PostID $postID
     *
     * @return Post
     */
    public function getByPostID(PostID $postID): Post;

    /**
     * Gives all posts
     *
     * @return array
     */
    public function findAll(): array;
}