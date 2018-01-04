<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Presentation\Controller;

use Comment\Domain\Model\Comment;
use Comment\Domain\Model\CommentAggregate;
use Comment\Domain\ValueObject\ThreadID;
use Comment\Infrastructure\Persistence\CQRS\CommentReadRepository;
use Comment\Infrastructure\Persistence\CQRS\CommentWriteRepository;
use Comment\Infrastructure\Repository\CommentReadDataMapperRepository;
use Comment\Infrastructure\Repository\CommentWriteDataMapperRepository;
use Comment\Infrastructure\Service\CommentReadService;
use Comment\Infrastructure\Service\CommentWriteService;
use Lib\Controller\Controller;
use Lib\Registry;

/**
 * Class Management
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

        echo $this->render('comment:management:commentList.html.twig', [
            'comments' => $comments
        ]);
    }

    /**
     * @throws \Exception
     */
    public function putCommentAction()
    {
        $params = Registry::get('request')->getQueryParams();
        $commentID = $params['id'];

        /** @var CommentReadService $commentReadService */
        $commentReadService = new CommentReadService(
            new CommentReadRepository(
                new CommentReadDataMapperRepository()
            )
        );
        /** @var Comment $comment */
        $comment = $commentReadService->getByCommentID($commentID);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = Registry::get('request')->getParsedBody();
            $body = htmlspecialchars($post['body']);

            $commentWriteService = new CommentWriteService(
                new CommentWriteRepository(
                    new CommentWriteDataMapperRepository()
                )
            );
            $commentWriteService->changeBody($comment, $body);

            $this->redirectToAdminComments();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            echo $this->render('comment:management:changeComment.html.twig', ['comment' => $comment]);
        }
    }

    /**
     * Approve a comment
     */
    public function approveAction()
    {
        $params = Registry::get('request')->getQueryParams();
        $commentID = $params['id'];

        /** @var CommentReadService $commentReadService */
        $commentReadService = new CommentReadService(
            new CommentReadRepository(
                new CommentReadDataMapperRepository()
            )
        );
        /** @var Comment $comment */
        $comment = $commentReadService->getByCommentID($commentID);

        /** @var CommentWriteService $commentWriteService */
        $commentWriteService = new CommentWriteService(
            new CommentWriteRepository(
                new CommentWriteDataMapperRepository()
            )
        );
        $commentWriteService->approve($comment);

        $this->redirectToAdminComments();
    }

    /**
     * Disapprove a comment
     */
    public function disapproveAction()
    {
        $params = Registry::get('request')->getQueryParams();
        $commentID = $params['id'];

        /** @var CommentReadService $commentReadService */
        $commentReadService = new CommentReadService(
            new CommentReadRepository(
                new CommentReadDataMapperRepository()
            )
        );
        /** @var Comment $comment */
        $comment = $commentReadService->getByCommentID($commentID);

        /** @var CommentWriteService $commentWriteService */
        $commentWriteService = new CommentWriteService(
            new CommentWriteRepository(
                new CommentWriteDataMapperRepository()
            )
        );
        $commentWriteService->disapprove($comment);

        $this->redirectToAdminComments();
    }

    /**
     * Redirect to admin comment list
     */
    protected function redirectToAdminComments()
    {
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/admin/comments");
    }
}
