<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Presentation\Controller;

use Blogpost\Domain\ValueObject\PostID;
use Comment\Domain\Model\Author;
use Comment\Domain\Model\Comment;
use Comment\Domain\Model\CommentAggregate;
use Comment\Domain\Model\Thread;
use Comment\Domain\Model\ThreadAggregate;
use Comment\Domain\Services\ThreadService;
use Comment\Domain\ValueObject\AuthorID;
use Comment\Domain\ValueObject\ThreadID;
use Comment\Infrastructure\Repository\ThreadRepository;
use Lib\Controller\Controller;
use User\Domain\Model\User;
use User\Domain\Services\UserService;
use User\Infrastructure\Repository\UserRepository;

/**
 * Class postComment
 * @package Comment\Presentation\Controller
 */
class postComment extends Controller
{
    /**
     * Add a comment for a psot
     */
    public function postCommentAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lastname = $_POST['lastname'] ?? '';
            $firstname = $_POST['firstname'] ?? '';
            $email = $_POST['email'] ?? '';
            $body = $_POST['comment'] ?? '';
            $postID = $_POST['postID'] ?? null;

            $postID = new PostID($postID);

            // 1- Search user by Email
            $userService = new UserService();
            /** @var User $likelyAuthor */
            $likelyAuthor = $userService->getUserByEmail($email);

            if ($likelyAuthor->getIdUser() == null) {
                // Create Author, if unknown likelyAuthor
                $author = new Author();
                $author->setLastname($lastname)
                    ->setFirstname($firstname)
                    ->setEmail($email)
                    ->setUserID(new AuthorID());
                $userRepository = new UserRepository();
                $userRepository->save($author);
            } else {
                $author = $likelyAuthor;
            }

            // 2- Search Thread
            $threadRepository = new ThreadRepository();
            $likelyThread = $threadRepository->getDbTable()->findByPostID($postID->getValue());

            if ($likelyThread == false) {
                // Create Thread
                $thread = new Thread();
                $thread->setPostID($postID);
                $thread->setThreadID(new ThreadID());
            } else {
                $thread = $threadRepository->findByPostID($postID);
            }

            // Create comment
            $comment = new Comment();
            $comment->setThreadID($thread->getThreadID())
                ->setAuthorID($author->getUserID())
                ->setBody($body)
                ->setCreateAt(new \DateTime())
            ;

            // And Create a commentAggregate
            $commentAggregate = new CommentAggregate();
            $commentAggregate->setAuthor($author)
                ->setComment($comment);

            // set $thread and $commentAggregate to threadAggregate
            /** @var ThreadAggregate $threadAggregate */
            $threadAggregate = new ThreadAggregate();
            $threadAggregate
                ->setThread($thread)
                ->setComments($commentAggregate);

            /** @var ThreadService $threadService */
            $threadService = new ThreadService();
            $threadService->postThread($threadAggregate);
        }
        echo $this->render('comment:comment:newComment.html.twig', []);
    }
}