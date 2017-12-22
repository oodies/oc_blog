<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Infrastructure\Repository;

use Blogpost\Domain\Model\Body;
use Blogpost\Domain\Repository\BodyReadRepositoryInterface;
use Blogpost\Domain\ValueObject\PostID;
use Blogpost\Infrastructure\Repository\TableGateway\BodyTableGateway;
use Lib\Db\AbstractRepository;

class BodyReadDataMapperRepository extends AbstractRepository implements BodyReadRepositoryInterface
{
    /** *******************************
     *      PROPERTIES
     **/

    /** @var string $gatewayName */
    protected $gatewayName = BodyTableGateway::class;


    /** *******************************
     *      METHODS
     **/

    /**
     * @param PostID $postID
     *
     * @return Body
     */
    public function getByPostID(PostID $postID): body
    {
        /** @var Body $body */
        $body = new body();

        $row = $this->getDbTable()->findByPostId($postID->getValue());
        if ($row !== false) {
            $this->hydrate($body, $row);
        }

        return $body;
    }

    /**
     * @param Body  $body
     * @param array $row
     */
    protected function hydrate(Body $body, array $row)
    {
        $body->setIdBody($row['id_body'])
            ->setContent($row['content'])
            ->setPostID(new PostID($row['postID']));
    }
}