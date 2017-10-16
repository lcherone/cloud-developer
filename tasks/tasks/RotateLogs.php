<?php
namespace Tasks\Task {

    use Tasks\Lib;

    /**
     * Little logrotate task which tars up previous days logs, simplz..
     */
    class RotateLogs
    {
        use Lib\Traits\Log;

        /**
         * 
         */
        public function __construct($task)
        {
            $this->task = $task;
        }
        
        /**
         * 
         */
        private function rotate($type = 'default')
        {
            // Move into log directory
            chdir(dirname(__FILE__).'/logs'.$type);
            
            // Get logs
            $logs = array_filter(glob('*.log'), 'is_file');
            
            // There are no logs
            if (empty($logs)) {
                return;
            }
            
            // Remove the the current log from the array
            array_pop($logs);

            // Rotate logs - tar then remove log file
            foreach ($logs as $logfile) {
                `/bin/tar czf $logfile.tar.gz $logfile && rm -f $logfile`;
            }
        }

        /**
         * 
         */
        public function execute()
        {
            $this->rotate('tasks');
        }
    }

}
