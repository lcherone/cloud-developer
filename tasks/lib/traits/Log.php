<?php
namespace Tasks\Lib\Traits;

trait Log {

    /**
     * Log (Monolog)
     *
     * @param string $str  - Log message
     * @param string $type - Log severity type [emergency, alert, critical, error, warning, notice, info, debug]
     * @param array $data - Array of data
     */
    public function log($str, $type = 'notice', $data = [])
    {
        $log = new \Monolog\Logger('task_log');

        //add file handler - log to file
        $log->pushHandler(
            new \Monolog\Handler\StreamHandler('tasks/logs/'.date('Y-m-d').'.log')
        );
        
        $method = 'add'.$type;
        if (method_exists($log, $type)) {
            $log->$method($str, $data);
        }
    }

}