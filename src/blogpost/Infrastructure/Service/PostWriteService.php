<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Infrastructure\Service;

use Blogpost\Domain\Model\Post;
use Blogpost\Domain\ValueObject\BloggerID;
use Blogpost\Infrastructure\Persistence\CQRS\BodyWriteRepository;
use Blogpost\Infrastructure\Persistence\CQRS\HeaderWriteRepository;
use Blogpost\Infrastructure\Persistence\CQRS\PostWriteRepository;
use Blogpost\Infrastructure\Repository\BodyWriteDataMapperRepository;
use Blogpost\Infrastructure\Repository\HeaderWriteDataMapperRepository;

/**
 * Class PostWriteService
 * @package Blogpost\Infrastructure\Service
 */
class PostWriteService
{
    /** @var PostWriteRepository */
    protected $repository;

    /**
     * PostWriteService constructor.
     *
     * @param PostWriteRepository $repository
     */
    public function __construct(PostWriteRepository $repository)
    {
        $this->repository = $repository;
    }

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
        // Step one - Create post
        $post = new Post();
        $post->create(new BloggerID($bloggerID));
        $this->repository->add($post);

        // Step two - Create header of this post
        $headerWriteService = new HeaderWriteService(
            new HeaderWriteRepository(
                new HeaderWriteDataMapperRepository()
            )
        );
        $headerWriteService->create($post->getPostID()->getValue(), $title, $brief);

        // Step three - Create body of this post
        $bodyWriteService = new BodyWriteService(
            new BodyWriteRepository(
                new BodyWriteDataMapperRepository()
            )
        );
        $bodyWriteService->create($post->getPostID()->getValue(), $content);

        return $post;
    }

    /**
     * @param Post $post
     *
     * @return Post
     */
    public function update(Post $post): Post
    {
        $post->update();
        $this->repository->add($post);

        return $post;
    }
}
