<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Presentation\Controller;

use Comment\Domain\Services\CommentService;
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
        $commentService = new CommentService();
        $comments = $commentService->getComments();

        echo $this->render('comment:management:commentList.html.twig', [
            'comments' => $comments
        ]);
    }
}