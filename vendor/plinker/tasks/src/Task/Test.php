<?php
namespace Plinker\Tasks\Task {

    //use Plinker\Tasks\Lib;

    /**
     * An example task, which prints "Hello Task!"
     * @usage:
     *    $task->run('Test');
     *    $task->daemon('Test');
     */
    class Test
    {
        //use Lib\Traits\RedBean;

        /**
         *
         */
        public function __construct(\Plinker\Tasks\Runner $task)
        {
            $this->task = $task;
        }

        /**
         * Main execute method - called by task runner
         */
        public function execute()
        {
            echo 'Hello Task!'.PHP_EOL;
        }
    }
}
