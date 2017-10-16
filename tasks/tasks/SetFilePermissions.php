<?php
namespace Tasks\Task {

    use Tasks\Lib;

    class SetFilePermissions
    {
        use Lib\Traits\Log;

        /**
         *
         */
        public function __construct($task)
        {
            $this->task = $task;

            // Hook into RedBean using Traits\RedBean
            if (!$this->task->state['redbeanConnected']) {
                $this->redbeanConnect();
            }
        }

        /**
         * 
         */
        public function execute()
        {
            $this->task->log('Changing ownership of all files to www-data', 'info', []);
            
            //set all files to be owned by www-data:www-data
            //system("/bin/chown -R www-data: /var/www/html");
            
            //...
        }
    }

}
