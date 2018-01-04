<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Infrastructure\Repository;


use Blogpost\Domain\Model\Body;
use Blogpost\Domain\Repository\BodyWriteRepositoryInterface;
use Blogpost\Infrastructure\Repository\TableGateway\BodyTableGateway;
use Lib\Db\AbstractRepository;

/**
 * Class BodyWriteDataMapperRepository
 * @package Blogpost\Infrastructure\Repository
 */
class BodyWriteDataMapperRepository extends AbstractRepository implements BodyWriteRepositoryInterface
{
    /** *******************************
     *  PROPERTIES
     */

    /**
     * @var string
     */
    protected $gatewayName = BodyTableGateway::class;

    /** *******************************
     *  METHODS
     */

    /**
     * Persist Body
     *
     * @param Body $body
     *
     * @throws \Exception
     */
    public function add(Body $body): void
    {
        $data['content'] = $body->getContent();
        $data['postID'] = $body->getPostID()->getValue();

        if ($body->getIdBody() === null) {
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, $body->getIdBody());
        }
    }

    /**
     * @return BodyTableGateway
     */
    protected function getDbTable(): BodyTableGateway
    {
        return parent::getDbTable();
    }
}
