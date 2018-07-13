<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 13.07.18
 * Time: 11:37
 */

namespace Rotoscoping\Migration\Robo\Task\Connection;


use Rotoscoping\Migration\Robo\Adapter\PostgresAdapter;

class PostgresConnection extends AbstractConnection
{
    public function __construct(array $params = [])
    {
        $this->setAdapter( new PostgresAdapter($params) );
    }
}