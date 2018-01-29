<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Presentation\Controller;

use Comment\Infrastructure\Persistence\CQRS\CommentWriteRepository;
use Comment\Infrastructure\Repository\CommentWriteDataMapperRepository;
use Comment\Infrastructure\Service\CommentWriteService;
use Comment\Infrastructure\Service\ConstraintValidator;
use Lib\Controller\Controller;
use Lib\Registry;
use Lib\Validator\ConstraintViolationList;

/**
 * Class PostComment
 *
 * @package Comment\Presentation\Controller
 */
class PostComment extends Controller
{
    /**
     * Add a comment for a post
     */
    public function postCommentAction()
    {
        /** @var \GuzzleHttp\Psr7\ServerRequest $request */
        $request = Registry::get('request');

        $assign = [];

        if ($request->getMethod() === 'POST') {
            $post = $request->getParsedBody();

            $username = $post['username'] ?? '';
            $email = $post['email'] ?? '';
            $body = $post['comment'] ?? '';
            $postID = $post['postID'] ?? null;

            $constraintViolationList = new ConstraintViolationList();
            $isValid = ConstraintValidator::validateRegisterData(
                [
                    'username' => $username,
                    'email'    => $email,
                    'body'     => $body,
                ],
                $constraintViolationList
            );

            if ($isValid === true) {
                $commentWriteService = new CommentWriteService(
                    new CommentWriteRepository(
                        new CommentWriteDataMapperRepository()
                    )
                );
                // TODO Use $comment for update view with AJAX
                $comment = $commentWriteService->create($postID, $username, $email, $body);
                // Redirect to BlogPost
                $this->redirectTo($this->generateUrl('blogpost_get_blogpost', ['postID' => $postID ]));
            } else {
                $assign = [
                    'errors'   => $constraintViolationList->getViolations(),
                    'username' => $username,
                    'email'    => $email,
                    'comment'  => $body,
                    'postID'   => $postID,
                ];

                echo $this->render('comment:comments:newComment.html.twig', $assign);
            }
        }
    }
}
