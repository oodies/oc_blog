<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Presentation\Controller;

use Blogpost\Infrastructure\Service\PostService;
use Lib\Controller\Controller;

/**
 * Class PostBlogpost
 * @package Blogpost\Presentation\Controller
 */
class PostBlogpost extends Controller
{
    /**
     * Create a new blogpost
     */
    public function postBlogpostAction()
    {
        // view assignment
        $assign = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $title = (isset($_POST['title'])) ? htmlspecialchars($_POST['title']) : '';
            $brief = (isset($_POST['brief'])) ? htmlspecialchars($_POST['brief']) : '';
            $content = (isset($_POST['content'])) ? htmlspecialchars($_POST['content']) : '';

            $postService = new PostService();

            // TODO STUB Renseigner l'auteur selon la session
            $post = $postService->create(
                'daa3327d-787d-4b6c-9a50-caada7db013e',
                $title,
                $brief,
                $content
            );

            $assign = ['success' => 'active'];

        }
        echo $this->render('blogpost:blogpost:newPost.html.twig', $assign);
    }
}