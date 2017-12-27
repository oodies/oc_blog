<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Presentation\Controller;

use Blogpost\Infrastructure\Service\BlogpostService;
use Comment\Infrastructure\Service\CommentService;
use Lib\Controller\Controller;
use Lib\Registry;

/**
 * Class GetBlogpost
 * @package Blogpost\presentation\Controller
 */
class GetBlogpost extends Controller
{
    /**
     * Get a single blogpost
     * with this comments
     *
     * @throws \Exception
     */
    public function getBlogpostAction()
    {
        $params = Registry::get('request')->getQueryParams();
        $postID = $params['id'];

        $blogpostService = new BlogpostService();
        $post = $blogpostService->getBlogpost($postID);

        $commentService = new CommentService();
        $comments = $commentService->getCommentsByPostID($postID);

        echo $this->render('blogpost:blogpost:blogpost.html.twig', [
            'post' => $post,
            'comments' => $comments
        ]);
    }
}