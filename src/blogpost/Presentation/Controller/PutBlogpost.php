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
use Lib\Registry;

/**
 * Class PutBlogpost
 * @package Blogpost\Presentation\Controller
 */
class PutBlogpost extends Controller
{
    /**
     * Complete change of blogpost data
     *
     */
    public function putBlogpostAction()
    {
        $params = Registry::get('request')->getQueryParams();
        $postID = $params['id'];

        $blogpostService = new BlogpostService();
        $postAggregate = $blogpostService->getBlogpost($postID);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $title = (isset($_POST['title'])) ? htmlspecialchars($_POST['title']) : '';
            $brief = (isset($_POST['brief'])) ? htmlspecialchars($_POST['brief']) : '';
            $content = (isset($_POST['content'])) ? htmlspecialchars($_POST['content']) : '';

            $blogpostService->updateBlogpost($postAggregate, $title, $brief, $content);
        }

        echo $this->render('blogpost:blogpost:changePost.html.twig', ['post' => $postAggregate]);
    }
}