<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 12.07.18
 * Time: 12:13
 */

namespace Rotoscoping\Migration\Robo\Adapter;


use Robo\Contract\TaskInterface;
use Robo\Result;

abstract class AbstractAdapter
{
    protected $adapter;

    protected $defaultParams = [];
    protected $requiredParams = [];

    protected $params = [];

    protected $connection;

    public function __construct($params)
    {
        $this->params = array_merge($this->defaultParams, $params);
    }

    public function createDatabase($name)
    {
        return @pg_exec($this->connection, "CREATE DATABASE $name");
    }

    public function getLastResultError()
    {
        return pg_last_error();
    }

    public function setParam($key, $param)
    {
        if ($this->hasParam($key)) {

            $this->params[$key] = $param;

            return true;
        }

        return false;
    }

    public function hasParam($param)
    {
        return key_exists($param, $this->defaultParams);
    }

    public function getParam($param)
    {
        return $this->hasParam($param) ? $this->params[$param] : null;
    }

    public function checkParams(TaskInterface $task)
    {
        $missing = [];

        foreach ($this->requiredParams as $key) {

            if (!isset($this->params[$key])) {

                $missing[] = $key;
            }
        }

        return count($missing)
            ? Result::error($task, "Missing required filds: " . implode(', ', $missing), $this->params)
            : Result::success($task, 'Cool');
    }

    public function getParams()
    {
        return $this->params;
    }

    abstract public function isStatusOK();

    abstract public function connect();

    public function getConnection()
    {
        if (!$this->connection) {

            $this->connection = $this->connect();
        }

        return $this->connection;
    }
}