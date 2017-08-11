<?php
namespace Tasks;

class Runner
{
    use Lib\Traits\Log;

    public $vars = [];
    public $state = [];
    public $config = [];

    /**
     * 
     */
    public function __construct($config = [])
    {
        $this->config = $config;
        $this->constructBootTime = microtime(true);
    }

    /**
     * setter 
     */
    public function __set($index, $value)
    {
        $this->vars[$index] = $value;
    }

    /**
     * getter 
     */
    public function __get($index)
    {
        return $this->vars[$index];
    }

    /**
     * run once
     */
    public function run($class, $config = [])
    {
        $this->config = $this->config + $config;

        // is the cli tool because it contains the tools array
        if (!empty($this->config['tools'])) {
            $this->class = __NAMESPACE__ . '\\Tool\\' . $class;
        } else {
            $this->class = __NAMESPACE__ . '\\Task\\' . $class;
        }

        $this->task = new $this->class($this);

        if ($this->config['debug'] && !isset($this->config['tools'])) {
            $this->climate->addArt('lib/art');
            $this->climate->draw('header');
            $this->climate->out("<bold><red>DEBUG MODE ENABLED:</red></bold>");
            $this->climate->out(" - <underline>Turn off debug in production</underline>, which will stop this output to the console.");
        }

        $this->task->execute();
    }

    /**
     * daemon
     */
    public function daemon($class, $config = [])
    {
        $this->config = $this->config + $config;

        $pid = new PID('./pids', $class);

        $sleep_time = ($this->config['sleep_time'] ? $this->config['sleep_time'] : 1);
        
        //clear terminal
        $this->climate->clear();

        if ($pid->running) {
            if ($this->config['debug']) {
                $this->climate->addArt('lib/art');
                $this->climate->draw('header');
                $this->climate->out("<bold><red>DEBUG MODE ENABLED:</red></bold>");
                $this->climate->out(" - <underline>Turn off debug in production</underline>, which will stop this output to the console.");
                $this->climate->out(" - Initial Memory usage: ".$pid->script_memory_usage().".");
                $this->climate->out(" - Sleep time: $sleep_time second between iterations.");
                $this->climate->error("Exited, process already running!");
            }
            exit;
        } else {

            $startTime = microtime(true);
            $stopTime = $startTime + 59;

            if ($this->config['debug']) {
                $i = 1;
            }

            while (microtime(true) < $stopTime) {
                
                if ($this->config['debug']) {
                    $this->climate->clear();
                    $this->climate->addArt('lib/art');
                    $this->climate->draw('header');
                    $this->climate->out("<bold><red>DEBUG MODE ENABLED:</red></bold>");
                    $this->climate->out(" - <underline>Turn off debug in production</underline>, which will stop this output to the console.");
                    $this->climate->out(" - Initial Memory usage: ".$pid->script_memory_usage().".");
                    $this->climate->out(" - Sleep time: $sleep_time second between iterations.");
                    //$this->climate->out(" - Stop Time: ".@date_create('@'.$stopTime)->format('H:i:s'));
                }

                // time the iteration as not to be running when next cron runs ...
                $loopStart = microtime(true);

                if ($this->config['debug']) {
                    $this->climate->border();
                    $this->climate->out(" <bold><green># Start Iteration $i</green></bold>");
                    $this->climate->br();
                }

                // execute task
                $this->class = __NAMESPACE__.'\\Task\\'.$class;
                $this->task = new $this->class($this);

                $this->task->execute();

                if ($this->config['debug']) {
                    $this->climate->br();
                    $this->climate->out(" - Finished Iteration");
                    $this->climate->out(" - Took: ".(microtime(true) - $loopStart)." seconds");
                    $this->climate->out(" - Memory usage: ".$pid->script_memory_usage());
                    $this->climate->out(" - Sleeping for ".((int) $sleep_time)." seconds");
                    $this->climate->out(" - Now: ".(microtime(true)+(microtime(true) - $loopStart)).' Stop time:'.$stopTime.' - When: '.($stopTime-(microtime(true)+(microtime(true) - $loopStart))));
                    $this->climate->out(" - Total running time ".(microtime(true) - $this->constructBootTime)." seconds");
                }
                sleep((int) $sleep_time);

                // break if next task will overrun minute, +1 second fudge
                if ((microtime(true)+(microtime(true) - $loopStart)) >= $stopTime) {
                    
                    if ($this->config['debug']) {
                        $this->climate->out(" - Now: ".(microtime(true)+(microtime(true) - $loopStart)).' Stop time:'.$stopTime.' - When: '.($stopTime-(microtime(true)+(microtime(true) - $loopStart))));
                        $this->climate->out(" - Process completed in ".(microtime(true) - $loopStart)." seconds");
                        $this->climate->shout(" - Total running time ".(microtime(true) - $this->constructBootTime)." seconds");
                    }
                    break;
                }

                if ($this->config['debug']) {
                    $i++;
                }
            }

        }

    }

}
