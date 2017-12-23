<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Presentation\Controller;

use Blogpost\Infrastructure\Service\BlogpostService;
use Lib\Controller\Controller;

/**
 * Class GetBlogposts
 * @package Blogpost\Presentation\Controller
 */
class GetBlogposts extends Controller
{
    /**
     * Return a blogpost list
     */
    public function getBlogpostsAction()
    {
        $blogpostService = new BlogpostService();
        $posts = $blogpostService->getBlogposts();

        echo $this->render('blogpost:blogpost:blogpostList.html.twig', array(
            'posts' => $posts
        ));
    }
}