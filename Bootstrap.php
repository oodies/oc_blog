<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2017/12
 */

use Lib\Db\DbFactory;
use Lib\Registry;

/**
 * Class Bootstrap
 */
class Bootstrap
{

    /**
     * Main init
     */
    public function init()
    {
        $this->initDb();
    }


    /**
     * Initialization connection database
     *
     * @throws Exception
     */
    protected function initDb()
    {
        $adapter = 'Pdo_Mysql';

        $config = \parse_ini_file(ROOT_DIR . '/configs/application.ini', true );

        if (false === $config) {
            throw new \Exception('Error while reading configuration parameters');
        }

        /** @var \Lib\Db\Adapter\Pdo_Mysql $db */
        $dbAdapter = DbFactory::create($adapter, $config['DB']);

        try {
            // connection attempt
            $dbAdapter->getConnection();
        } catch (\PDOException $e) {
            die("Probably wrong identifiers, or the DBMS is not reachable: " . $e->getMessage());
        }

        // Set the adapter database to a registry
        Registry::set('db', $dbAdapter);
    }
}