<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Infrastructure\Persistence\CQRS;

use Comment\Domain\Repository\CommentReadRepositoryInterface;
use Comment\Domain\ValueObject\ThreadID;
use User\Domain\Repository\ReadRepositoryInterface;

/**
 * Class CommentReadRepository
 * @package Comment\Infrastructure\Persistence\CQRS
 */
class CommentReadRepository implements CommentReadRepositoryInterface
{

    /** @var CommentReadRepositoryInterface */
    protected $repository;

    /**
     * CommentReadRepository constructor.
     *
     * @param ReadRepositoryInterface $repository
     */
    public function __construct(ReadRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Find all comments by ThreadID value object
     *
     * @param ThreadID $threadID
     *
     * @return array
     */
    public function findAllByThreadID(ThreadID $threadID): array
    {
        return $this->repository->findAllByThreadID($threadID);
    }

    /**
     * Find all comments
     *
     * @return array
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }
}