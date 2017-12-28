<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Infrastructure\Service;

use Blogpost\Domain\Model\Body;
use Blogpost\Domain\Model\Header;
use Blogpost\Domain\Model\Post;
use Blogpost\Domain\Model\PostAggregate;
use Blogpost\Domain\ValueObject\BloggerID;
use User\Domain\Model\User;
use User\Infrastructure\Service\UserService;

/**
 * Class BlogpostService
 * @package Blogpost\Infrastructure\Service
 */
class BlogpostService
{

    /**
     * @return array
     */
    public function getBlogposts(): array
    {
        $entries = [];

        $postService = new PostService();
        $posts = $postService->findAll();

        /** @var Post $post */
        foreach ($posts as $post) {

            $postID = $post->getPostID()->getValue();

            /** @var PostAggregate $postAggregate */
            $postAggregate = new PostAggregate();

            // Set Post
            $post = $this->getPost($postID);
            $postAggregate
                ->setPostID($post->getPostID())
                ->setIdPost($post->getIdPost())
                ->setCreateAt($post->getCreateAt())
                ->setUpdateAt($post->getUpdateAt())
                ->setBloggerID($post->getBloggerID());

            // Set Header
            $postAggregate->setHeader(
                $this->getHeader($postID)
            );
            // Set Blogger
            $postAggregate->setBlogger(
                $this->getBlogger($post->getBloggerID())
            );

            $entries[] = $postAggregate;
        }

        return $entries;
    }

    /**
     * @param string $postID
     *
     * @return Post
     */
    protected function getPost(string $postID): Post
    {
        $postService = new PostService();
        $post = $postService->getByPostID($postID);

        return $post;
    }

    /**
     * @param string $postID
     *
     * @return Header
     */
    protected function getHeader(string $postID): Header
    {
        $headerService = new HeaderService();
        $header = $headerService->getByPostID($postID);

        return $header;
    }

    /**
     * @param BloggerID $bloggerID
     *
     * @return User
     */
    protected function getBlogger(BloggerID $bloggerID): User
    {
        $userService = new UserService();
        $blogger = $userService->getByUserID($bloggerID->getValue());

        return $blogger;
    }

    /**
     * @param string $postID
     *
     * @return PostAggregate
     */
    public function getBlogpost(string $postID): PostAggregate
    {
        /** @var PostAggregate $postAggregate */
        $postAggregate = new PostAggregate();

        // Set Post
        $post = $this->getPost($postID);
        $postAggregate
            ->setPostID($post->getPostID())
            ->setIdPost($post->getIdPost())
            ->setCreateAt($post->getCreateAt())
            ->setUpdateAt($post->getUpdateAt())
            ->setBloggerID($post->getBloggerID());
        // Set Header
        $postAggregate->setHeader(
            $this->getHeader($postID)
        );
        // Set Body
        $postAggregate->setBody(
            $this->getBody($postID)
        );
        // Set Blogger
        $postAggregate->setBlogger(
            $this->getBlogger($post->getBloggerID())
        );

        return $postAggregate;
    }

    /**
     * @param string $postID
     *
     * @return Body
     */
    protected function getBody(string $postID): Body
    {
        $bodyService = new BodyService();
        $body = $bodyService->getByPostID($postID);

        return $body;
    }

    /**
     * @param PostAggregate $postAggregate
     * @param string        $title
     * @param string        $brief
     * @param string        $content
     */
    public function updateBlogpost(
        PostAggregate $postAggregate,
        string $title,
        string $brief,
        string $content
    ) {
        $headerService = new HeaderService();
        $headerService->update($postAggregate->getHeader(), $title, $brief);

        $bodyService = new BodyService();
        $bodyService->update($postAggregate->getBody(), $content);

        $postService = new PostService();
        $postService->update($postAggregate);
    }
}