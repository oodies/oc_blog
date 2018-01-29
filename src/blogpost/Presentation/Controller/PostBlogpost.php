<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Presentation\Controller;

use Blogpost\Domain\Model\Post;
use Blogpost\Domain\Model\PostAggregate;
use Blogpost\Infrastructure\Service\ConstraintValidator;
use Blogpost\Infrastructure\Service\PostService;
use Lib\Controller\Controller;
use Lib\Registry;
use Lib\Validator\ConstraintViolationList;

/**
 * Class PostBlogpost
 *
 * @package Blogpost\Presentation\Controller
 */
class PostBlogpost extends Controller
{
    /**
     * Create a new blogpost
     */
    public function postBlogpostAction()
    {
        /** @var \GuzzleHttp\Psr7\ServerRequest $request */
        $request = Registry::get('request');

        // view assignment
        $assign = [];

        $postAggregate = new PostAggregate();

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
                    'title' => $title,
                    'brief' => $brief,
                    'content' => $content,
                ],
                $constraintViolationList
            );

            if ($isValid === true) {
                /** @var PostService $postService */
                $postService = new PostService();
                /** @var Post $post */
                $post = $postService->create($_SESSION['userID'], $title, $brief, $content);
                // Redirect to BlogPost
                $this->redirectTo(
                    $this->generateUrl('blogpost_get_blogpost', ['postID' => $post->getPostID()->getValue()])
                );
            } else {
                $assign['errors'] = $constraintViolationList->getViolations();
            }
        }

        $assign['post'] = $postAggregate;

        echo $this->render('blogpost:blogpost:newPost.html.twig', $assign);
    }
}
