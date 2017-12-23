<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Presentation\Controller;

use Comment\Infrastructure\Persistence\CQRS\CommentReadRepository;
use Comment\Infrastructure\Repository\CommentReadDataMapperRepository;
use Comment\Infrastructure\Service\CommentReadService;
use Lib\Controller\Controller;

/**
 * Class management
 * @package Comment\Presentation\Controller
 */
class management extends controller
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
}