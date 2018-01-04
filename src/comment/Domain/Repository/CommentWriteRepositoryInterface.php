<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Domain\Repository;

use Comment\Domain\Model\Comment;

/**
 * Interface CommentWriteRepositoryInterface
 * @package Comment\Domain\Repository
 */
interface CommentWriteRepositoryInterface
{
    /**
     * Persist comment
     *
     * @param Comment $comment
     */
    public function add(Comment $comment): void;
}
