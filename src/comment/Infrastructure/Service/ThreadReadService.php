<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Infrastructure\Service;


use Comment\Domain\Model\Thread;
use Comment\Domain\ValueObject\ThreadID;
use Comment\Infrastructure\Persistence\CQRS\ThreadReadRepository;

class ThreadReadService
{
    /** @var ThreadReadRepository */
    protected $repository;

    /**
     * ThreadReadService constructor.
     *
     * @param ThreadReadRepository $repository
     */
    public function __construct(ThreadReadRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $threadID
     *
     * @return Thread
     */
    public function getByThreadID(string $threadID): Thread
    {
        return $this->repository->getByThreadID(new ThreadID($threadID));
    }
}