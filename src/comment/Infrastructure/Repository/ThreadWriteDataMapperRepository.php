<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

namespace Comment\Infrastructure\Repository;

use Comment\Domain\Model\Thread;
use Comment\Domain\Repository\ThreadWriteRepositoryInterface;
use Comment\Infrastructure\Repository\TableGateway\ThreadTableGateway;
use Lib\Db\AbstractRepository;

/**
 * Class ThreadWriteDataMapperRepository
 * @package Comment\Infrastructure\Repository
 */
class ThreadWriteDataMapperRepository extends AbstractRepository implements ThreadWriteRepositoryInterface
{
    /** *******************************
     *  PROPERTIES
     */

    /**
     * @var string
     */
    protected $gatewayName = ThreadTableGateway::class;


    /** *******************************
     *  METHODS
     */

    /**
     * Persist Thread
     *
     * @param Thread $thread
     */
    public function add(Thread $thread): void
    {
        $data['postID'] = $thread->getPostID()->getValue();
        $data['threadID'] = $thread->getThreadID()->getValue();
        $data['create_at'] = $thread->getCreateAt()->format('Y-m-d H:i:s');
        $data['update_at'] = $thread->getUpdateAt()->format('Y-m-d H:i:s');
        $data['number_of_comment'] = $thread->getNumberOfComment();

        if ($thread->getIdThread() === null) {
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, $thread->getIdThread());
        }
    }

    /**
     * @return ThreadTableGateway
     */
    protected function getDbTable(): ThreadTableGateway
    {
        return parent::getDbTable();
    }
}
