<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Infrastructure\Persistence\CQRS;

use Blogpost\Domain\Model\Post;
use Blogpost\Domain\Repository\PostWriteRepositoryInterface;

/**
 * Class PostWriteRepository
 * @package Blogpost\Infrastructure\Persistence\CQRS
 */
class PostWriteRepository implements PostWriteRepositoryInterface
{
    /** *******************************
     *  PROPERTIES
     */

    /** @var PostWriteRepositoryInterface */
    protected $repository;

    /** *******************************
     *  METHODS
     */

    /**
     * PostWriteRepository constructor.
     *
     * @param PostWriteRepositoryInterface $repository
     */
    public function __construct(PostWriteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Persist Post
     *
     * @param Post $post
     */
    public function add(Post $post): void
    {
        $this->repository->add($post);
    }
}