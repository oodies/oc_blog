<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Domain\Repository;

use Blogpost\Domain\Model\Header;
use Blogpost\Domain\ValueObject\PostID;

/**
 * Interface HeaderReadRepositoryInterface
 * @package Blogpost\Domain\Repository
 */
interface HeaderReadRepositoryInterface
{
    /**
     * Get the header of the post
     * identified by PostID Value object
     *
     * @param PostID $postID
     *
     * @return Header
     */
    public function getByPostID(PostID $postID): Header;

    /**
     * Gives the header of all post
     *
     * @return array
     */
    public function findAll(): array;
}