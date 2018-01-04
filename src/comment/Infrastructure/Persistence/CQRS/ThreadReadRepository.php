<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Infrastructure\Persistence\CQRS;

use Blogpost\Domain\ValueObject\PostID;
use Comment\Domain\Model\Thread;
use Comment\Domain\Repository\ThreadReadRepositoryInterface;
use Comment\Domain\ValueObject\ThreadID;

/**
 * Class ThreadReadRepository
 * @package Comment\Infrastructure\Persistence\CQRS
 */
class ThreadReadRepository implements ThreadReadRepositoryInterface
{
    /** @var ThreadReadRepositoryInterface */
    protected $repository;

    /**
     * ThreadReadRepository constructor.
     *
     * @param ThreadReadRepositoryInterface $repository
     */
    public function __construct(ThreadReadRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get thread by ThreadID value object
     *
     * @param ThreadID $threadID
     *
     * @return Thread
     */
    public function getByThreadID(ThreadID $threadID): Thread
    {
        return $this->repository->getByThreadID($threadID);
    }

    /**
     * Find thread by PostID value object
     *
     * @param PostID $postID
     *
     * @return null|Thread
     */
    public function findByPostID(PostID $postID): ?Thread
    {
        return $this->repository->findByPostID($postID);
    }
}
