<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 12.07.18
 * Time: 9:18
 */

namespace Rotoscoping\Migration;


use Rotoscoping\Migration\Robo\Task\Connection\PostgresConnection;
use Rotoscoping\Migration\Robo\Task\Database\DatabaseCreate;
use Rotoscoping\Migration\Robo\Task\PdoStack;

trait Tasks
{
    /**
     * @param $adapter
     * @param $options
     * @return PdoStack
     */
    public function taskPdoStack($adapter, $options = [])
    {
        return $this->task(PdoStack::class, $adapter, $options);
    }

    public function taskPostgresConnection($params = [])
    {
        return $this->task(PostgresConnection::class, $params);
    }

    public function taskDatabaseCreate()
    {
        return $this->task(DatabaseCreate::class);
    }
}