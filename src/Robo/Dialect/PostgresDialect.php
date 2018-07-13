<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 12.07.18
 * Time: 12:00
 */

namespace Rotoscoping\Migration\Robo\Dialect;


use Rotoscoping\Migration\Robo\Constant\DialectTypes;

class PostgresDialect extends AbstractDialect implements DialectInterface
{
    protected $adapter = DialectTypes::POSTGRES;

    protected $connection;

    protected $defaultParams = [
        'host' => 'localhost',
        'port' => '5432',
        'dbname' => null,
        'user' => 'postgres',
        'password' => null
    ];

    protected $requiredParams = [
        'user',
        'password',
        'dbname'
    ];

    /**
     * @param $params array
     * @return string
     */
    public function createDsn($params)
    {

    }

    /**
     * @return \PDO
     */
    public function createConnection()
    {
        $adapter = $this->adapter;

        $host       = $this->getParam('host');
        $dbname     = $this->getParam('dbname');
        $port       = $this->getParam('port');
        $user       = $this->getParam('user');
        $password   = $this->getParam('password');

        $dsn = "$adapter:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";

        return $this->connection = pg_connect($dsn);
    }

    public function listTables($schemaName = 'public')
    {
        return "SELECT table_name 
                FROM information_schema.tables 
                WHERE table_schema = '$schemaName' 
                ORDER BY table_name";
    }

    /**
     * @return \PDO
     */
    public function getConnection()
    {
        if (!$this->connection) {

            $this->connection = $this->createConnection();
        }

        return $this->connection;
    }

    public function getPDO()
    {
        // TODO: Implement getPDO() method.
    }
}