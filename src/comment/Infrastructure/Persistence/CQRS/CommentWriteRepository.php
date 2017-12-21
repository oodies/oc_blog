<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Infrastructure\Persistence\CQRS;

use Comment\Domain\Model\Comment;
use Comment\Domain\Repository\CommentWriteRepositoryInterface;

/**
 * Class CommentWriteRepository
 * @package Comment\Infrastructure\Persistence\CQRS
 */
class CommentWriteRepository implements CommentWriteRepositoryInterface
{

    /** @var CommentWriteRepositoryInterface */
    protected $repository;

    /**
     * CommentWriteRepository constructor.
     *
     * @param CommentWriteRepositoryInterface $repository
     */
    public function __construct(CommentWriteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Persist Comment
     */
    public function add(Comment $comment): void
    {
        $this->repository->add($comment);
    }
}