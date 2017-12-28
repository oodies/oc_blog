<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Infrastructure\Service;

use Blogpost\Domain\Model\Post;
use Blogpost\Infrastructure\Persistence\CQRS\PostReadRepository;
use Blogpost\Infrastructure\Persistence\CQRS\PostWriteRepository;
use Blogpost\Infrastructure\Repository\PostReadDataMapperRepository;
use Blogpost\Infrastructure\Repository\PostWriteDataMapperRepository;

/**
 * Class PostService
 * @package Blogpost\Infrastructure\Service
 */
class PostService
{
    /**
     * @param string $bloggerID
     * @param string $title
     * @param string $brief
     * @param string $content
     *
     * @return Post
     */
    public function create(string $bloggerID, string $title, string $brief, string $content): Post
    {
        $postWriteService = new PostWriteService(
            new PostWriteRepository(
                new PostWriteDataMapperRepository()
            ));

        $post = $postWriteService->create($bloggerID, $title, $brief, $content);

        return $post;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $postReadService = new PostReadService(
            new PostReadRepository(
                new PostReadDataMapperRepository()
            )
        );

        return $postReadService->findAll();
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
        $postReadService = new PostReadService(
            new PostReadRepository(
                new PostReadDataMapperRepository()
            )
        );

        return $postReadService->getByPostID($postID);
    }

    /**
     * Update Post
     *
     * @param Post $post
     *
     * @return Post
     */
    public function update(Post $post): Post
    {
        $postWriteService = new PostWriteService(
            new PostWriteRepository(
                new PostWriteDataMapperRepository()
            ));

        return $post = $postWriteService->update($post);
    }
}