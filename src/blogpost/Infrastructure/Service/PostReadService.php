<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Infrastructure\Service;


use Blogpost\Domain\Model\Post;
use Blogpost\Domain\ValueObject\PostID;
use Blogpost\Infrastructure\Persistence\CQRS\PostReadRepository;

/**
 * Class PostReadService
 * @package Blogpost\Infrastructure\Service
 */
class PostReadService
{

    /** @var PostReadRepository */
    protected $repository;

    /**
     * PostReadService constructor.
     *
     * @param PostReadRepository $repository
     */
    public function __construct(PostReadRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get a post by identified post
     *
     * @param string $postID
     *
     * @return Post
     */
    public function getByPostID(string $postID): Post
    {
        return $this->repository->getByPostID(new PostID($postID));
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }
}
