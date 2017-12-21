<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Presentation\Controller;

use Comment\Domain\Model\ThreadAggregate;
use Comment\Domain\Services\ThreadService;
use Lib\Controller\Controller;


/**
 * Class getComments
 * @package Comment\Presentation\Controller
 */
class comments extends Controller
{

    public function getThreadAction()
    {
        // TODO STUB $postID
        $postID = '4075e3e5-ba4e-4dbd-a888-8026e317a263';

        $threadService = new ThreadService();
        /** @var ThreadAggregate $threadAggregate */
        $threadAggregate = $threadService->getThread($postID);

        echo $this->render('comment:comment:commentList.html.twig',
            [
                'comments' => $threadAggregate->getComments(),
                'thread'   => $threadAggregate->getThread()
            ]);
    }
}