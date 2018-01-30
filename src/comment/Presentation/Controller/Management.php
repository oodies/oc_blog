<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Presentation\Controller;

use Comment\Domain\Model\Comment;
use Comment\Infrastructure\Persistence\CQRS\CommentReadRepository;
use Comment\Infrastructure\Persistence\CQRS\CommentWriteRepository;
use Comment\Infrastructure\Repository\CommentReadDataMapperRepository;
use Comment\Infrastructure\Repository\CommentWriteDataMapperRepository;
use Comment\Infrastructure\Service\CommentReadService;
use Comment\Infrastructure\Service\CommentWriteService;
use Lib\Controller\Controller;
use Lib\HTTPFoundation\HTTPResponse;
use Lib\Registry;

/**
 * Class Management
 *
 * @package Comment\Presentation\Controller
 */
class Management extends controller
{

    /**
     * Return a comments list
     */
    public function getCommentsAction()
    {
        $commentReadService = new CommentReadService(
            new CommentReadRepository(
                new CommentReadDataMapperRepository()
            )
        );
        $comments = $commentReadService->getComments();

        echo $this->render(
            'comment:management:commentList.html.twig', [
                                                          'comments' => $comments,
                                                      ]
        );
    }

    /**
     * @param string $commentID
     *
     * @throws \Exception
     */
    public function putCommentAction($commentID)
    {
        /** @var \GuzzleHttp\Psr7\ServerRequest $request */
        $request = Registry::get('request');

        /** @var CommentReadService $commentReadService */
        $commentReadService = new CommentReadService(
            new CommentReadRepository(
                new CommentReadDataMapperRepository()
            )
        );
        /** @var Comment $comment */
        $comment = $commentReadService->getByCommentID($commentID);

        if (is_null($comment)) {
            HTTPResponse::redirect404();
        }

        if ($request->getMethod() === 'POST') {
            $post = $request->getParsedBody();
            $body = htmlspecialchars($post['body']);

            $commentWriteService = new CommentWriteService(
                new CommentWriteRepository(
                    new CommentWriteDataMapperRepository()
                )
            );
            $commentWriteService->changeBody($comment, $body);

            $this->redirectToAdminComments();
        }

        if ($request->getMethod() === 'GET') {
            echo $this->render('comment:management:changeComment.html.twig', ['comment' => $comment]);
        }
    }

    /**
     * Approve a comment
     *
     * @param string $commentID
     */
    public function approveAction($commentID)
    {
        /** @var CommentReadService $commentReadService */
        $commentReadService = new CommentReadService(
            new CommentReadRepository(
                new CommentReadDataMapperRepository()
            )
        );
        /** @var Comment $comment */
        $comment = $commentReadService->getByCommentID($commentID);

        if (!is_null($comment)) {
            /** @var CommentWriteService $commentWriteService */
            $commentWriteService = new CommentWriteService(
                new CommentWriteRepository(
                    new CommentWriteDataMapperRepository()
                )
            );
            $commentWriteService->approve($comment);
        }

        $this->redirectToAdminComments();
    }

    /**
     * Disapprove a comment
     *
     * @param string $commentID
     */
    public function disapproveAction($commentID)
    {
        /** @var CommentReadService $commentReadService */
        $commentReadService = new CommentReadService(
            new CommentReadRepository(
                new CommentReadDataMapperRepository()
            )
        );
        /** @var Comment $comment */
        $comment = $commentReadService->getByCommentID($commentID);

        if (!is_null($comment)) {
            /** @var CommentWriteService $commentWriteService */
            $commentWriteService = new CommentWriteService(
                new CommentWriteRepository(
                    new CommentWriteDataMapperRepository()
                )
            );
            $commentWriteService->disapprove($comment);
        }

        $this->redirectToAdminComments();
    }

    /**
     * Redirect to admin comment list
     */
    protected function redirectToAdminComments()
    {
        $this->redirectTo($this->generateUrl('comment_management_comments'));
    }
}
