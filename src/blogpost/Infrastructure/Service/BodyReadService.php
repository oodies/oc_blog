<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Infrastructure\Service;

use Blogpost\Domain\ValueObject\PostID;

/**
 * Class BodyReadService
 *
 * @package Blogpost\Infrastructure\Service
 */
class BodyReadService
{
    /** @var \Blogpost\Infrastructure\Persistence\CQRS\BodyReadRepository */
    protected $repository;

    /**
     * BodyReadService constructor.
     *
     * @param \Blogpost\Infrastructure\Persistence\CQRS\BodyReadRepository $repository
     */
    public function __construct(\Blogpost\Infrastructure\Persistence\CQRS\BodyReadRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get a body of the post
     *
     * @param string $postID
     *
     * @return \Blogpost\Domain\Model\Body
     */
    public function getByPostID(string $postID): \Blogpost\Domain\Model\Body
    {
        return $this->repository->getByPostID(new PostID($postID));
    }
}
