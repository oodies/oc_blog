<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Infrastructure\Persistence\CQRS;

use Comment\Domain\Model\Thread;
use Comment\Domain\Repository\ThreadWriteRepositoryInterface;

/**
 * Class ThreadWriteRepository
 * @package Comment\Infrastructure\Persistence\CQRS
 */
class ThreadWriteRepository implements ThreadWriteRepositoryInterface
{
    /** @var ThreadWriteRepositoryInterface */
    protected $repository;

    /**
     * ThreadWriteRepository constructor.
     *
     * @param ThreadWriteRepositoryInterface $repository
     */
    public function __construct(ThreadWriteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Persist Thread
     *
     * @param Thread $thread
     */
    public function add(Thread $thread): void
    {
        $this->repository->add($thread);
    }
}