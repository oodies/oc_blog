<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Infrastructure\Persistence\CQRS;

use Blogpost\Domain\Model\Body;
use Blogpost\Domain\Repository\BodyReadRepositoryInterface;
use Blogpost\Domain\ValueObject\PostID;

/**
 * Class BodyReadRepository
 * @package Blogpost\Infrastructure\Persistence\CQRS
 */
class BodyReadRepository implements BodyReadRepositoryInterface
{
    /** @var BodyReadRepositoryInterface */
    protected $repository;

    /**
     * BodyReadRepository constructor.
     *
     * @param BodyReadRepositoryInterface $repository
     */
    public function __construct(BodyReadRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get the content of the post
     * identified by PostID Value object
     *
     * @param PostID $postID
     *
     * @return Body
     */
    public function getByPostID(PostID $postID): Body
    {
        return $this->repository->getByPostID($postID);
    }
}