<?php
namespace Plinker\Tasks;

use League\CLImate\CLImate;

/**
 *
 */
class Runner
{
    public $vars   = [];
    public $state  = [];
    public $config = [];

    /**
     * @param array $config - Config which you want to pass to the task.
     */
    public function __construct($config = [
        // database connection
        'database' => [
            'dsn' => 'sqlite:./database.db',
            'host' => '',
            'name' => '',
            'username' => '',
            'password' => '',
            'freeze' => false,
            'debug' => false,
         ],
         
        // displays output to task runner console
        'debug' => true,
        
        // log output to file ./logs/d-m-Y.log
        'log' => false,
        
        // daemon sleep time
        'sleep_time' => 1,
        'pid_path' => './pids'
    ])
    {
        $this->config = $config;
        $this->constructBootTime = microtime(true);
        $this->console = new CLImate;
    }

    /**
     * Setter
     */
    public function __set($index, $value)
    {
        $this->vars[$index] = $value;
    }

    /**
     * Getter
     */
    public function __get($index)
    {
        return $this->vars[$index];
    }

    /**
     * Run once
     *
     * @param string $class - Name of the task class in /src/task/*.
     * @param array $config - Config which you want to pass to the task.
     */
    public function run($class, $config = [])
    {
        $this->config = $this->config + $config;

        $this->class = __NAMESPACE__ . '\\Task\\' . $class;

        $this->task = new $this->class($this);

        if (!empty($this->config['debug']) && !isset($this->config['tools'])) {
            $this->console->out(
                "<bold><red>DEBUG MODE ENABLED:</red></bold>\n".
                " - <underline>Turn off debug in production</underline>, which will stop this output to the console."
            );
        }

        $this->task->execute();
    }

    /**
     * Daemon - run continuously for 1 minute.
     *
     * @param string $class - Name of the task class in /src/task/*.
     * @param array $config - Config which you want to pass to the task.
     */
    public function daemon($class, $config = [])
    {
        $this->config = (array) $config + (array) $this->config;

        $pid = new Lib\PID((!empty($this->config['pid_path']) ? $this->config['pid_path'] : './pids'), $class);

        $sleep_time = !empty($this->config['sleep_time']) ? $this->config['sleep_time'] : 1;

        if ($pid->running) {
            if (!empty($this->config['debug'])) {
                $this->console->out(
                    "<bold><red>DEBUG MODE ENABLED:</red></bold>\n".
                    " - <underline>Turn off debug in production</underline>, which will stop this output to the console.\n".
                    " - Initial Memory usage: ".$pid->script_memory_usage().".\n".
                    " - Sleep time: $sleep_time second between iterations.\n".
                    " - <red>Exited, process already running!</red>"
                );
            }
            exit;
        } else {
            $startTime = microtime(true);
            $stopTime = $startTime + 59;

            if ($this->config['debug']) {
                $i = 1;
            }

            while (microtime(true) < $stopTime) {
                if (!empty($this->config['debug'])) {
                    $this->console->clear();
                    $this->console->out(
                        "<bold><red>DEBUG MODE ENABLED:</red></bold>\n".
                        " - <underline>Turn off debug in production</underline>, which will stop this output to the console.\n".
                        " - Initial Memory usage: ".$pid->script_memory_usage().".\n".
                        " - Sleep time: $sleep_time second between iterations.\n".
                        " - Stop Time: ".@date_create('@'.(int) $stopTime)->format('H:i:s')
                    );
                }

                // time the iteration as not to be running when next cron runs ...
                $loopStart = microtime(true);

                if (!empty($this->config['debug'])) {
                    $this->console->border();
                    $this->console->out(" <bold><green># Start Iteration $i</green></bold>\n");
                }

                // execute task
                $this->class = __NAMESPACE__.'\\Task\\'.$class;
                $this->task = new $this->class($this);

                $this->task->execute();

                if (!empty($this->config['debug'])) {
                    $this->console->out(
                        " - Finished Iteration.\n".
                        " - Took: ".(microtime(true) - $loopStart)." seconds.\n".
                        " - Sleeping for ".((int) $sleep_time)." seconds.\n".
                        " - Stops in: ".($stopTime-(microtime(true)+(microtime(true) - $loopStart)))." seconds.\n".
                        " - Total running time ".(microtime(true) - $this->constructBootTime)." seconds."
                    );
                }
                
                //
                sleep((int) $sleep_time);

                // break if next task will overrun minute
                if ((microtime(true)+(microtime(true) - $loopStart)) >= $stopTime) {
                    if (!empty($this->config['debug'])) {
                        $this->console->out(
                            " - Daemon finished."
                        );
                    }
                    break;
                }

                if (!empty($this->config['debug'])) {
                    $i++;
                }
            }
        }
    }
}
