<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 13.07.18
 * Time: 11:46
 */

namespace Rotoscoping\Migration\Robo\Task\Connection;


use Robo\Result;
use Rotoscoping\Migration\Robo\Adapter\AbstractAdapter;
use Rotoscoping\Migration\Robo\Dialect\DialectInterface;

abstract class AbstractConnection extends \Robo\Task\BaseTask
{
    /** @var $adapter AbstractAdapter */
    protected $adapter;

    /** @var $dialect DialectInterface */
    protected $dialect;

    public function __construct($params = [])
    {
    }

    public function __call($function, $args)
    {
        if ($this->adapter->hasParam($function)) {

            $this->adapter->setParam($function, $args[0]);
            return $this;
        }

        throw new \BadMethodCallException("Method $function does not exist.\n");
    }

    /**
     * @return DialectInterface
     */
    public function getDialect()
    {
        return $this->dialect;
    }

    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * @param $dialect
     */
    public function setDialect($dialect)
    {
        $this->dialect = $dialect;
    }

    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;
    }

    public function run()
    {
        $check = $this->adapter->checkParams($this);

        if (!$check->wasSuccessful()) {

            throw new \BadMethodCallException($check->getMessage());
        }

        if (!$this->adapter->connect()) {

            return Result::error($this, "Bad connection status", ['adapter' => $this->adapter]);
        }

        return Result::success($this, 'Connection status OK', ['adapter' => $this->adapter]);
    }
}