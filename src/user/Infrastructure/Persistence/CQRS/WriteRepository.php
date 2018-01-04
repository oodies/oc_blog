<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace User\Infrastructure\Persistence\CQRS;

use User\Domain\Model\User;
use User\Domain\Repository\WriteRepositoryInterface;

/**
 * Class WriteRepository
 * @package User\Infrastructure\Persistence
 */
class WriteRepository implements WriteRepositoryInterface
{

    /**
     * @var WriteRepositoryInterface
     */
    protected $repository;

    /**
     * WriteRepository constructor.
     *
     * @param WriteRepositoryInterface $repository
     *
     */
    public function __construct(WriteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Persist user
     *
     * @param User $user
     *
     */
    public function add(User $user): void
    {
        $this->repository->add($user);
    }
}
