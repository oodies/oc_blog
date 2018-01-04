<?php


namespace Lib\Db\Adapter;

/**
 * Class AbstractDB
 * @package Lib\Db\Adapter
 */
class AbstractDB implements AdapterInterface
{

    /** *******************************
     *  PROPERTIES
     * ****************************** */

    /**
     * Database connection
     *
     * @var null
     */
    protected $connection = null;

    /**
     * @var array|null
     */
    protected $config = null;

    /**
     * @var string|null
     */
    protected $pdoType = null;

    /** *******************************
     *  METHODS
     * ****************************** */

    /**
     * AbstractDB constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = array())
    {
        $this->config = $config;
    }

    /**
     * @return \PDO
     *
     * @throws \Exception
     */
    public function getConnection(): \PDO
    {
        $this->connect();
        return $this->connection;
    }

    /**
     * Creates a PDO object and connects to the database
     *
     * @throws  \Exception
     */
    public function connect(): void
    {
        if ($this->connection) {
            return;
        }

        $dsn = $this->dsn();

        try {
            $this->connection = new \PDO(
                $dsn,
                $this->config['username'],
                $this->config['password']
            );
            // Exception Mode
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage() . " " . $e->getCode());
        }
    }

    /**
     * Creates a PDO DSN from $this->config
     *
     * @return string
     */
    protected function dsn(): string
    {

        $dsn = $this->config;
        // don't pass the username, password in the DSN
        unset($dsn['username']);
        unset($dsn['password']);

        foreach ($dsn as $key => $val) {
            $dsn[$key] = "$key=$val";
        }

        return $this->pdoType . ':' . implode(';', $dsn);
    }
}
