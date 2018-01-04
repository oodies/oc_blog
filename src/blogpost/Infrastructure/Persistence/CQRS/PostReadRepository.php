<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Infrastructure\Persistence\CQRS;

use Blogpost\Domain\Model\Post;
use \Blogpost\Domain\Repository\PostReadRepositoryInterface;
use Blogpost\Domain\ValueObject\PostID;

/**
 * Class PostReadRepositoryInterface
 * @package Blogpost\Infrastructure\Persistence\CQRS
 */
class PostReadRepository implements PostReadRepositoryInterface
{
    /** @var PostReadRepositoryInterface */
    protected $repository;

    /**
     * PostReadRepository constructor.
     *
     * @param PostReadRepositoryInterface $repository
     */
    public function __construct(PostReadRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get the post
     *
     * @param PostID $postID
     *
     * @return Post
     */
    public function getByPostID(PostID $postID): Post
    {
        return $this->repository->getByPostID($postID);
    }

    /**
     * Gives all posts
     *
     * @return array
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }
}
