<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\presentation\Controller;

use Blogpost\Domain\Model\PostAggregate;
use Blogpost\Domain\Services\BlogpostService;
use Lib\Controller\Controller;

/**
 * Class postBlogpost
 * @package Blogpost\presentation\Controller
 */
class postBlogpost extends Controller
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

            $postAggregate = new PostAggregate();
            $postAggregate->getHeader()
                ->setTitle($title)
                ->setBrief($brief);
            $postAggregate->getBody()
                ->setContent($content);

            // TODO Renseigner l'auteur

            // TODO valider les données
            //if ($postAggregate->isValid()) {
            if (true) {
                // Persist data
                $blogpostService = new BlogpostService();
                $blogpostService->postBlogPost($postAggregate);

                $assign = ['success' => 'active'];
            } else {
                $assign = [
                    'title'   => $_POST['title'],
                    'brief'   => $_POST['brief'],
                    'content' => $_POST['content'],
                    'message' => ''
                ];
            }
        }
        echo $this->render('blogpost:blogpost:newPost.html.twig', $assign);
    }
}