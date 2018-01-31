<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Infrastructure\Service;

use Blogpost\Domain\Model\PostAggregate;
use Lib\Registry;

/**
 * Class BlogpostService
 *
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

        /** @var \Blogpost\Domain\Model\Post $post */
        foreach ($posts as $post) {
            $postID = $post->getPostID()->getValue();
            /** @var PostAggregate $postAggregate */
            $postAggregate = new PostAggregate();
            // Set Post
            $post = $this->getPost($postID);
            $postAggregate
                ->setPostID($post->getPostID())
                ->setIdPost($post->getIdPost())
                ->setEnabled($post->getEnabled())
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
     * @return \Blogpost\Domain\Model\Post
     */
    protected function getPost(string $postID): \Blogpost\Domain\Model\Post
    {
        $postService = new PostService();
        $post = $postService->getByPostID($postID);

        return $post;
    }

    /**
     * @param string $postID
     *
     * @return \Blogpost\Domain\Model\Header
     */
    protected function getHeader(string $postID): \Blogpost\Domain\Model\Header
    {
        $headerService = new HeaderService();
        $header = $headerService->getByPostID($postID);

        return $header;
    }

    /**
     * @param \Blogpost\Domain\ValueObject\BloggerID $bloggerID
     *
     * @return \User\Domain\Model\User
     */
    protected function getBlogger(\Blogpost\Domain\ValueObject\BloggerID $bloggerID)
    {
        /** @var \User\Infrastructure\Service\UserService $userService */
        $userService = Registry::getInstance()->get('DIC')->get('userService');
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
        $postAggregate = new PostAggregate();

        // Set Post
        $post = $this->getPost($postID);
        $postAggregate
            ->setPostID($post->getPostID())
            ->setIdPost($post->getIdPost())
            ->setEnabled($post->getEnabled())
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
     * @return \Blogpost\Domain\Model\Body
     */
    protected function getBody(string $postID): \Blogpost\Domain\Model\Body
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
