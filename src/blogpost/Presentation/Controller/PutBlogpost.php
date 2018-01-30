<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Presentation\Controller;

use Blogpost\Infrastructure\Service\ConstraintValidator;
use Blogpost\Infrastructure\Service\BlogpostService;
use Blogpost\Infrastructure\Service\PostService;
use Lib\Controller\Controller;
use Lib\HTTPFoundation\HTTPResponse;
use Lib\Registry;
use Lib\Validator\ConstraintViolationList;

/**
 * Class PutBlogpost
 *
 * @package Blogpost\Presentation\Controller
 */
class PutBlogpost extends Controller
{
    /**
     * Complete change of blogpost data
     *
     * @param string $postID
     */
    public function putBlogpostAction($postID)
    {
        $postService = new PostService();
        $post = $postService->getByPostID($postID);

        if( is_null($post) ) {
            HTTPResponse::redirect404();
        }

        /** @var \GuzzleHttp\Psr7\ServerRequest $request */
        $request = Registry::get('request');

        // view assignment
        $assign = [];

        $blogpostService = new BlogpostService();
        /** @var \Blogpost\Domain\Model\PostAggregate $postAggregate */
        $postAggregate = $blogpostService->getBlogpost($postID);

        if ($request->getMethod() === 'POST') {
            $post = $request->getParsedBody();

            $title = $post['title'] ?? '';
            $brief = $post['brief'] ?? '';
            $content = $post['content'] ?? '';

            $postAggregate->getHeader()
                          ->setTitle($title)
                          ->setBrief($brief);
            $postAggregate->getBody()->setContent($content);

            $constraintViolationList = new ConstraintViolationList();
            $isValid = ConstraintValidator::validateRegisterData(
                [
                    'title'   => $title,
                    'brief'   => $brief,
                    'content' => $content,
                ],
                $constraintViolationList
            );

            if ($isValid === true) {
                $blogpostService->updateBlogpost($postAggregate, $title, $brief, $content);
                // Redirect to BlogPost
                $this->redirectTo($this->generateUrl('blogpost_get_blogpost', ['postID' => $postID]));
            } else {
                $assign['errors'] = $constraintViolationList->getViolations();
            }
        }

        $assign['post'] = $postAggregate;

        echo $this->render('blogpost:blogpost:changePost.html.twig', $assign);
    }
}
