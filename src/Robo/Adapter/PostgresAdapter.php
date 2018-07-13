<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 12.07.18
 * Time: 12:00
 */

namespace Rotoscoping\Migration\Robo\Adapter;


use Rotoscoping\Migration\Robo\Constant\DialectTypes;

class PostgresAdapter extends AbstractAdapter
{
    protected $adapter = DialectTypes::POSTGRES;

    protected $defaultParams = [
        'host' => 'localhost',
        'port' => '5432',
        'dbname' => null,
        'user' => 'postgres',
        'password' => null
    ];

    protected $requiredParams = [
        'password'
    ];

    /**
     * @return bool
     */
    public function connect()
    {
        $host       = 'host=' .     $this->getParam('host');
        $dbname     = 'dbname=' .   $this->getParam('dbname');
        $port       = 'port=' .     $this->getParam('port');
        $user       = 'user=' .     $this->getParam('user');
        $password   = 'password=' . $this->getParam('password');

        if ($this->getParam('dbname') == null) {

            $dbname = null;
        }

        $dsn = "$host $port $dbname $user $password";

        $this->connection = @pg_connect($dsn);

        return $this->isStatusOK();
    }

    public function isStatusOK()
    {
        return pg_connection_status($this->connection) === PGSQL_CONNECTION_OK;
    }

    public function listTables($schemaName = 'public')
    {
        return "SELECT table_name 
                FROM information_schema.tables 
                WHERE table_schema = '$schemaName' 
                ORDER BY table_name";
    }
}