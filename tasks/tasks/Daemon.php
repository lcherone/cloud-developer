<?php
namespace Tasks\Task {

    use Tasks\Lib;

    /**
     *
     */
    class Daemon
    {
        use Lib\Traits\Log;
        use Lib\Traits\RedBean;

        /**
         *
         */
        public function __construct(\Tasks\Runner $task)
        {
            $this->task = $task;

            // Hook into RedBean using Traits\RedBean
            if (empty($this->task->state['redbeanConnected'])) {
                $this->redbeanConnect();
            }

            $this->db = new \Tasks\Db();
        }

        /**
         * Main execute method - called by task runner
         */
        public function execute()
        {
            // find all tasks
            $tasks = $this->db->find('tasks', ' (completed IS NULL OR completed = "" OR completed = 0) ORDER BY id ASC ');

            try {
                if (!empty($this->task->config['debug'])) {
                    $this->task->climate->out(
                        '<light_blue><bold><underline>Tasks:</underline></bold></light_blue>'
                    );
                }

                foreach ($tasks as $task) {

                    if (!empty($task->run_last) && !empty($task->repeats)) {
                        if ((strtotime($task->run_last)+$task->sleep) > strtotime(date_create()->format('Y-m-d H:i:s'))) {
                            $this->task->climate->out(
                                '<light_red>Sleeping ('.(strtotime($task->run_next)-strtotime(date_create()->format('Y-m-d H:i:s'))).'): - '.$task->name.' - '.$task->params.'</light_red>'
                            );
                            continue;
                        }
                    }
                    
                    $this->task->climate->out(
                        '<light_green><bold>Running -  '.$task->name.' - '.$task->params.'</bold></light_green>'
                    );

                    $error = false;

                    // check has got source
                    if (!empty($task->tasksource_id)) {

                        //
                        if (empty($task->repeats)) {
                            $task->completed = date_create()->format('Y-m-d H:i:s');
                            $task->run_last = date_create()->format('Y-m-d H:i:s');
                        } else {
                            $task->run_last = date_create()->format('Y-m-d H:i:s');
                            $task->run_next = date_create()->modify("+".$task->sleep." seconds")->format('Y-m-d H:i:s');
                        }
                        
                        $task->run_count = (empty($task->run_count) ? 1 : (int) $task->run_count + 1);
                        
                        $this->db->store($task);
                        
                        //
                        $params = json_decode($task->params, true);

                        //
                        $return = null;
                        if ($task->tasksource->type == 'serializableclosure') {
                            ob_start();
                            $source = unserialize($task->tasksource->source);
                            $return = $source($params);
                            $task->result = ob_get_clean().$return;
                            
                        } elseif ($task->tasksource->type == 'php-closure') {
                            ob_start();
                            $source = $task->tasksource->source;
                            $source = '<?php'.PHP_EOL.'$function = function ($params = []) {'.PHP_EOL."\tob_start();".PHP_EOL."\t".$source.PHP_EOL."\t".'return trim(ob_get_clean());'.PHP_EOL.'};';
                            
                            eval('?>'.$source);
                            $return = $function(@$params);
                            $task->result = ob_get_clean().$return;
                            
                        } elseif ($task->tasksource->type == 'php-raw') {
                            ob_start();
                            $source = $task->tasksource->source;
                            eval('?>'.$source);
                            $task->result = ob_get_clean();
                            
                        } elseif ($task->tasksource->type == 'bash') {
                            file_put_contents('../tmp/'.md5($task->tasksource->name).'.sh', $task->tasksource->source);
                            ob_start();
                            echo shell_exec('/bin/bash ../tmp/'.md5($task->tasksource->name).'.sh');
                            $task->result = ob_get_clean();
                        }

                        $this->db->store($task);

                    } else {
                        $this->db->trash($task);
                        $this->task->climate->out(
                            '<light_blue><bold>Task has no source.</bold></light_blue>'
                        );
                    }
                }
            } catch (\Exception $e) {
                //$this->log($e->getMessage(), 'error');
            }
        }
    }
}
