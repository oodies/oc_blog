<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Infrastructure\Repository;

use Blogpost\Domain\Model\Body;
use Blogpost\Domain\ValueObject\PostID;
use Blogpost\Infrastructure\Repository\TableGateway\BodyTableGateway;
use Lib\Db\AbstractRepository;

/**
 * Class PersonMapping
 * @package Blogpost\Infrastructure\Repository
 */
class BodyRepository extends AbstractRepository
{
    /** *******************************
     *      PROPERTIES
     * ********************************/

    /** @var string $gatewayName */
    protected $gatewayName = BodyTableGateway::class;


    /** *******************************
     *      METHODS
     * ********************************/

    /**
     * @param PostID $postID
     *
     * @return Body
     */
    public function findByPostID(postID $postID): body
    {
        /** @var Body $body */
        $body = new body();

        $row = $this->getDbTable()->findByPostId($postID->getValue());
        // Hydrate
        if ($row !== false) {
            $body->setIdBody($row['id_body'])
                ->setContent($row['content'])
                ->setPostID($postID);
        }
        return $body;
    }

    /**
     * Persist model
     *
     * @param Body $body
     *
     * @throws \Exception
     */
    public function save(Body $body)
    {
        $data['content'] = $body->getContent();
        $data['postID'] = $body->getPostID()->getValue();

        if ($body->getIdBody() === null) {
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, $body->getIdBody());
        }
    }
}