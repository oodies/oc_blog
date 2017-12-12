<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Domain\Services;

use Blogpost\Domain\Model\Post;
use Blogpost\Domain\Model\PostAggregate;
use Blogpost\Domain\ValueObject\BloggerID;
use Blogpost\Domain\ValueObject\VersionID;
use Blogpost\Infrastructure\Repository\BodyRepository;
use Blogpost\Infrastructure\Repository\HeaderRepository;
use Blogpost\Infrastructure\Repository\PostRepository;
use User\Infrastructure\Repository\PersonRepository;

/**
 * Class Blogpost
 */
class BlogpostService
{
    /**
     * Get a single blogpost
     *
     * @param string $postID
     *
     * @return PostAggregate
     */
    public function getBlogPost(string $postID)
    {
        $post = (new PostRepository())->findByPostId($postID);
        $postID = $post->getPostID();
        $bloggerID = $post->getBloggerID();

        $postAggregate = new PostAggregate($postID);

        $body = (new bodyRepository())->findByPostID($postID);
        $header = (new HeaderRepository())->findByPostID($postID);
        $blogger = (new PersonRepository())->findByUid($bloggerID);

        $postAggregate->setBody($body);
        $postAggregate->setHeader($header);
        $postAggregate->setBlogger($blogger);
        $postAggregate->setPostID($postID);
        $postAggregate->setBloggerID($bloggerID);
        $postAggregate->setVersionID($post->getVersionID());

        return $postAggregate;
    }

    /**
     * Return a blogpost list
     *
     * @return array
     */
    public function getBlogPosts()
    {

        $postRepository = new PostRepository();
        $posts = $postRepository->findAll();

        $entries = [];
        foreach ($posts as $key => $post) {
            /** @var Post $post */
            $postID = $post->getPostID();
            $bloggerID = $post->getBloggerID();

            $postAggregate = new postAggregate($postID);

            $header = (new HeaderRepository())->findByPostID($postID);
            $blogger = (new PersonRepository())->findByUid($bloggerID);

            $postAggregate->setHeader($header);
            $postAggregate->setBlogger($blogger);

            $entries[] = $postAggregate;
        }

        return $entries;
    }

    /**
     * Create a new blogpost
     *
     * @param PostAggregate $postAggregate
     */
    public function postBlogPost(PostAggregate $postAggregate): void
    {
        $post = new Post();
        // TODO STOB bloggerID
        $post->setBloggerID(new BloggerID('3a99db5d-45ad-4530-9f01-34d31827554d'));
        $post->setPostID($postAggregate->getPostID());
        $post->setVersionID(new VersionID());

        $postRepository = new PostRepository();
        $postRepository->save($post);

        $headerRepository = new HeaderRepository();
        $headerRepository->save($postAggregate->getHeader());

        $bodyRepository = new BodyRepository();
        $bodyRepository->save($postAggregate->getBody());
    }

    /**
     * Complete change of blogpost data
     *
     * @param PostAggregate $postAggregate
     */
    public function putBlogPost(PostAggregate $postAggregate): void
    {

        // TODO change versionID of the Post entity

        $headerRepository = new HeaderRepository();
        $headerRepository->save($postAggregate->getHeader());

        $bodyRepository = new BodyRepository();
        $bodyRepository->save($postAggregate->getBody());
    }
}