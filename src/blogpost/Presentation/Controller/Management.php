<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2018/01
 */

namespace Blogpost\Presentation\Controller;

use Blogpost\Infrastructure\Persistence\CQRS\PostReadRepository;
use Blogpost\Infrastructure\Persistence\CQRS\PostWriteRepository;
use Blogpost\Infrastructure\Repository\PostReadDataMapperRepository;
use Blogpost\Infrastructure\Repository\PostWriteDataMapperRepository;
use Blogpost\Infrastructure\Service\BlogpostService;
use Blogpost\Infrastructure\Service\PostReadService;
use Blogpost\Infrastructure\Service\PostWriteService;
use Lib\Controller\Controller;

/**
 * Class Management
 * @package Blogpost\Presentation\Controller
 */
class Management extends Controller
{

    /**
     * Show post list
     */
    public function getPostsAction()
    {
        $blogpostService = new BlogpostService();
        /** @var array of PostAggregate $posts */
        $posts = $blogpostService->getBlogposts();

        echo $this->render('blogpost:management:postList.html.twig', ['posts' => $posts]);
    }

    /**
     * Publish a post
     *
     * @param string $postID
     *
     * @throws \Exception
     */
    public function publishAction($postID)
    {
        $postReadService = new PostReadService(
            new PostReadRepository(
                new PostReadDataMapperRepository()
            )
        );
        $post = $postReadService->getByPostID($postID);

        if (!is_null($post)) {
            $postWriteService = new PostWriteService(
                new PostWriteRepository(
                    new PostWriteDataMapperRepository()
                )
            );
            $postWriteService->enabled($post);
        }

        $this->redirectToAdminPosts();
    }

    /**
     * Unpublish a post
     *
     * @param string $postID
     *
     * @throws \Exception
     */
    public function unpublishAction($postID)
    {
        $postReadService = new PostReadService(
            new PostReadRepository(
                new PostReadDataMapperRepository()
            )
        );
        $post = $postReadService->getByPostID($postID);

        if (!is_null($post)) {
            $postWriteService = new PostWriteService(
                new PostWriteRepository(
                    new PostWriteDataMapperRepository()
                )
            );
            $postWriteService->disabled($post);
        }

        $this->redirectToAdminPosts();
    }

    /**
     * Redirect to admin posts list
     */
    protected function redirectToAdminPosts()
    {
        $this->redirectTo($this->generateUrl('blogpost_management_postList'));
    }
}
