<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Domain\Repository;

use Comment\Domain\Model\Thread;

/**
 * Interface ThreadWriteRepositoryInterface
 * @package Comment\Domain\Repository
 */
interface ThreadWriteRepositoryInterface
{
    /**
     * Persist Thread
     *
     * @param Thread $thread
     */
    public function add(Thread $thread): void;
}