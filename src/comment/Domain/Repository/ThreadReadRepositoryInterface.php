<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Domain\Repository;


use Blogpost\Domain\ValueObject\PostID;
use Comment\Domain\Model\Thread;
use Comment\Domain\ValueObject\ThreadID;

interface ThreadReadRepositoryInterface
{
    /**
     * Get thread by ThreadID value object
     *
     * @param ThreadID $threadID
     *
     * @return Thread
     */
    public function getByThreadID(ThreadID $threadID): Thread;

    /**
     * Find thread by PostID value object
     *
     * @param PostID $postID
     *
     * @return null|Thread
     */
    public function findByPostID(PostID $postID): ?Thread;
}
