<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\presentation\Controller;

use Blogpost\Domain\Services\BlogpostService;
use Lib\Controller\Controller;
use Lib\Registry;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class getBlogpost
 * @package Blogpost\presentation\Controller
 */
class getBlogpost extends Controller
{
    /**
     * Get a single blogpost
     *
     * @param string $postID
     */
    public function getBlogpostAction()
    {
        $params = Registry::get('request')->getQueryParams();
        $postID = $params['id'];

        $blogpostService = new BlogpostService();
        $post = $blogpostService->GetBlogPost($postID);

        echo $this->render('blogpost:blogpost:blogpost.html.twig', [
            'post' => $post
        ]);
    }
}