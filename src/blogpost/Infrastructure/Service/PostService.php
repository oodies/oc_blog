<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Infrastructure\Service;

use Blogpost\Domain\Model\Post;
use Blogpost\Infrastructure\Persistence\CQRS\PostWriteRepository;
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
}