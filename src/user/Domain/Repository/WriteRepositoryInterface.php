<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace User\Domain\Repository;

use User\Domain\Model\User;

/**
 * Interface WriteRepositoryInterface
 * @package User\Domain\Repository
 */
interface WriteRepositoryInterface
{
    /**
     * Persist user
     *
     * @param User $user
     *
     */
    public function add(User $user): void;
}