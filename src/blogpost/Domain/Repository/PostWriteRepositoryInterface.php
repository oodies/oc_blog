<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Domain\Repository;

use Blogpost\Domain\Model\Post;

/**
 * Interface PostWriteRepositoryInterface
 * @package Blogpost\Domain\Repository
 */
interface PostWriteRepositoryInterface
{
    /**
     * Persist Post
     *
     * @param Post $post
     */
    public function add(Post $post): void;
}