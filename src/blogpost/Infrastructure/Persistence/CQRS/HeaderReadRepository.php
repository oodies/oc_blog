<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Infrastructure\Persistence\CQRS;

use Blogpost\Domain\Model\Header;
use Blogpost\Domain\Repository\HeaderReadRepositoryInterface;
use Blogpost\Domain\ValueObject\PostID;

/**
 * Class HeaderReadRepository
 * @package Blogpost\Infrastructure\Persistence\CQRS
 */
class HeaderReadRepository implements HeaderReadRepositoryInterface
{

    /** @var HeaderReadRepositoryInterface */
    protected $repository;

    /**
     * HeaderReadRepository constructor.
     *
     * @param HeaderReadRepositoryInterface $repository
     */
    public function __construct(HeaderReadRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get the header of the post
     * identified by PostID Value object
     *
     * @param PostID $postID
     *
     * @return Header
     */
    public function getByPostID(PostID $postID): Header
    {
        return $this->repository->getByPostID($postID);
    }

    /**
     * Gives the header of all post
     *
     * @return array
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }
}
