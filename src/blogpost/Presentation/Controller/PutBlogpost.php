<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Presentation\Controller;

use Blogpost\Domain\Model\PostAggregate;
use Blogpost\Infrastructure\Service\ConstraintValidator;
use Blogpost\Infrastructure\Service\BlogpostService;
use Lib\Controller\Controller;
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
     */
    public function putBlogpostAction()
    {
        /** @var \GuzzleHttp\Psr7\ServerRequest $request */
        $request = Registry::get('request');

        // view assignment
        $assign = [];
        // Query String
        $params = $request->getQueryParams();
        $postID = $params['id'];

        $blogpostService = new BlogpostService();
        /** @var PostAggregate $postAggregate */
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
                $host = $_SERVER['HTTP_HOST'];
                $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                header("Location: http://$host$uri/post?id=" . $postID);
            } else {
                $assign['errors'] = $constraintViolationList->getViolations();
            }
        }

        $assign['post'] = $postAggregate;

        echo $this->render('blogpost:blogpost:changePost.html.twig', $assign);
    }
}
