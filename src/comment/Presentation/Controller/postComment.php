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
use Lib\Controller\Controller;

/**
 * Class postComment
 * @package Comment\Presentation\Controller
 */
class postComment extends Controller
{
    /**
     * Add a comment for a post
     */
    public function postCommentAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $body = $_POST['comment'] ?? '';
            $postID = $_POST['postID'] ?? null;

            $commentWriteService = new CommentWriteService(
                new CommentWriteRepository(
                    new CommentWriteDataMapperRepository()
                )
            );

            $commentWriteService->create($postID, $username, $email, $body);
        }
        echo $this->render('comment:comments:newComment.html.twig', []);
    }
}