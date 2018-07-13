<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 12.07.18
 * Time: 9:48
 */

namespace Rotoscoping\Migration\Robo\Dialect;


use Robo\Contract\TaskInterface;
use Robo\Result;

interface DialectInterface
{
    /**
     * @param TaskInterface $task
     * @return Result
     */
    public function checkParams(TaskInterface $task);

    public function hasParam($param);

    public function setParam($key, $param);

    /**
     * @param $params array
     * @return string
     */
    public function createDsn($params);

    public function getPDO();
}