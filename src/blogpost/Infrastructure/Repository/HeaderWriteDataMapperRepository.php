<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Blogpost\Infrastructure\Repository;

use Blogpost\Domain\Model\Header;
use Blogpost\Domain\Repository\HeaderWriteRepositoryInterface;
use Blogpost\Infrastructure\Repository\TableGateway\HeaderTableGateway;
use Lib\Db\AbstractRepository;

/**
 * Class HeaderWriteDataMapperRepository
 * @package Blogpost\Infrastructure\Repository
 */
class HeaderWriteDataMapperRepository extends AbstractRepository implements HeaderWriteRepositoryInterface
{
    /** *******************************
     *  PROPERTIES
     */

    /** @var string  */
    protected $gatewayName = HeaderTableGateway::class;

    /** *******************************
     *  METHODS
     */

    /**
     * Persist Header
     *
     * @param Header $header
     *
     * @throws \Exception
     */
    public function add(Header $header): void
    {
        $data['title'] = $header->getTitle();
        $data['brief'] = $header->getBrief();
        $data['postID'] = $header->getPostID()->getValue();

        if ($header->getIdHeader() === null) {
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, $header->getIdHeader());
        }
    }

    /**
     * @return HeaderTableGateway
     */
    protected function getDbTable(): HeaderTableGateway
    {
        return parent::getDbTable();
    }
}
