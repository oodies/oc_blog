<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Presentation\Controller;

use Comment\Domain\Model\ThreadAggregate;
use Comment\Domain\Services\CommentService;
use Lib\Controller\Controller;


/**
 * Class getComments
 * @package Comment\Presentation\Controller
 */
class getComments extends Controller
{

    public function getCommentsAction()
    {
        // TODO STOB $postID
        $postID = '4075e3e5-ba4e-4dbd-a888-8026e317a263';

        $commentService = new CommentService();
        /** @var ThreadAggregate $threadAggregate */
        $threadAggregate = $commentService->getComments($postID);

        echo $this->render('comment:comment:commentList.html.twig',
            [
                'comments' => $threadAggregate->getComments(),
                'thread'   => $threadAggregate->getThread()
            ]);
    }
}