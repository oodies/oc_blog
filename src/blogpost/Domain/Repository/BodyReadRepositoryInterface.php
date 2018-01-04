<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Domain\Repository;

use Blogpost\Domain\Model\Body;
use Blogpost\Domain\ValueObject\PostID;

/**
 * Interface BodyReadRepositoryInterface
 * @package Blogpost\Domain\Repository
 */
interface BodyReadRepositoryInterface
{
    /**
     * Get the content of the post
     * identified by PostID Value object
     *
     * @param PostID $postID
     *
     * @return Body
     */
    public function getByPostID(PostID $postID): Body;
}
