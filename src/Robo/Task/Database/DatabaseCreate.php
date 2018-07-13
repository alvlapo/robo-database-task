<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 13.07.18
 * Time: 15:01
 */

namespace Rotoscoping\Migration\Robo\Task\Database;


use Robo\Common\DynamicParams;
use Robo\Result;
use Robo\Robo;
use Robo\State\Consumer;
use Robo\State\Data;
use Robo\Task\BaseTask;

class DatabaseCreate extends BaseTask implements Consumer
{
    use DynamicParams;

    protected $name = 'test';

    private $adapter;
    /**
     * @return \Robo\Result
     */
    public function run()
    {
        $result = $this->adapter->createDatabase($this->name);

        if (!$result) {

            $message = $this->adapter->getLastResultError();

            return Result::error($this, $message, ['adapter' => $this->adapter]);
        }

        return Result::success($this,
            "Good database created",
            [
                'adapter' => $this->adapter,
                'result' => $result
            ]
        );
    }

    /**
     * @return Data
     */
    public function receiveState(Data $state)
    {
        $this->adapter = $state['adapter'];

        return $state;
    }
}