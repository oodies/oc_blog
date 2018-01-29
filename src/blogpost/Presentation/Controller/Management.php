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
use Lib\Registry;

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
        /** @var array Post $posts */
        $posts = $blogpostService->getBlogposts();

        echo $this->render('blogpost:management:postList.html.twig', ['posts' => $posts]);
    }

    /**
     * Enable post
     *
     * @param string $postID
     *
     * @throws \Exception
     */
    public function enabledAction($postID)
    {
        $postReadService = new PostReadService(
            new PostReadRepository(
                new PostReadDataMapperRepository()
            )
        );
        $post = $postReadService->getByPostID($postID);

        $postWriteService = new PostWriteService(
            new PostWriteRepository(
                new PostWriteDataMapperRepository()
            )
        );
        $postWriteService->enabled($post);

        $this->redirectToAdminPosts();
    }

    /**
     * Disable post
     *
     * @param string $postID
     *
     * @throws \Exception
     */
    public function disabledAction($postID)
    {
        $postReadService = new PostReadService(
            new PostReadRepository(
                new PostReadDataMapperRepository()
            )
        );
        $post = $postReadService->getByPostID($postID);

        $postWriteService = new PostWriteService(
            new PostWriteRepository(
                new PostWriteDataMapperRepository()
            )
        );
        $postWriteService->disabled($post);

        $this->redirectToAdminPosts();
    }

    /**
     * Redirect to admin posts list
     */
    protected function redirectToAdminPosts()
    {
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/admin/posts");
    }
}
