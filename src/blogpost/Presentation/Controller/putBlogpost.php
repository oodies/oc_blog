<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\presentation\Controller;

use Lib\Controller\Controller;
use Blogpost\Domain\Services\BlogpostService;

/**
 * Class putBlogpost
 * @package Blogpost\presentation\Controller
 */
class putBlogpost extends Controller
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
        $postAggregate = $blogpostService->GetBlogPost($postID);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $title = (isset($_POST['title'])) ? htmlspecialchars($_POST['title']) : '';
            $brief = (isset($_POST['brief'])) ? htmlspecialchars($_POST['brief']) : '';
            $content = (isset($_POST['content'])) ? htmlspecialchars($_POST['content']) : '';

            $postAggregate->getHeader()->setTitle($title)->setBrief($brief);
            $postAggregate->getBody()->setContent($content);

            // TODO valider les données
            //if ($postAggregate->isValid()) {
            if (true) {
                // Persist data
                $blogpostService = new BlogpostService();
                $blogpostService->putBlogPost($postAggregate);

                $assign = ['success' => 'active'];
            } else {
                // TODO Message d'erreur
            }
        }

        echo $this->render('blogpost:blogpost:changePost.html.twig', ['post' => $postAggregate]);
    }
}