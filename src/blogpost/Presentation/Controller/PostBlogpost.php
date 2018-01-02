<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Presentation\Controller;

use Blogpost\Domain\Model\Post;
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

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            echo $this->render('blogpost:blogpost:newPost.html.twig', $assign);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = (isset($_POST['title'])) ? htmlspecialchars($_POST['title']) : '';
            $brief = (isset($_POST['brief'])) ? htmlspecialchars($_POST['brief']) : '';
            $content = (isset($_POST['content'])) ? htmlspecialchars($_POST['content']) : '';

            /** @var PostService $postService */
            $postService = new PostService();

            /** @var Post $post */
            $post = $postService->create(
                $_SESSION['userID'],
                $title,
                $brief,
                $content
            );

            // Redirect to BlogPost
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            header("Location: http://$host$uri/post?id=" . $post->getPostID()->getValue());
        }
    }
}