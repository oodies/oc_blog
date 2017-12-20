<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace User\Infrastructure\Persistence\CQRS;

use User\Domain\Repository\ReadRepositoryInterface;
use User\Domain\ValueObject\UserID;
use User\Domain\Model\User;

/**
 * Class UserRepository
 * @package User\Infrastructure\Persistence
 */
class ReadRepository implements ReadRepositoryInterface
{

    /**
     * @var ReadRepositoryInterface
     */
    protected $repository;

    /**
     * ReadRepository constructor.
     *
     * @param ReadRepositoryInterface $repository
     */
    public function __construct(ReadRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * Get user by UserID value object
     *
     * @param UserID $userID
     *
     * @return User
     */
    public function getByUserID(UserID $userID): User
    {
        return $this->repository->getByUserID($userID);
    }

    /**
     * Find a user by email
     *
     * @param string $email
     *
     * @return null|User
     */
    public function findByEmail(string $email): ?User
    {
        return $this->repository->findByEmail($email);
    }

    /**
     * Find a user by username
     *
     * @param string $username
     *
     * @return null|User
     */
    public function findByUsername(string $username): ?User
    {
        return $this->repository->findByUsername($username);
    }
}