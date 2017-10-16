<?php
namespace Tasks;

class PID
{
    protected $pidfile;
    public $running = false;

    /**
     * 
     */
    public function __construct($directory = '', $task = 'default')
    {
        $this->pidfile = (!empty($directory) ? $directory.'/' : null) . $task.'.pid';

        if (!empty($directory) && !file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        if (is_writable($this->pidfile) || is_writable($directory)) {
            // remove pid if its older then 5min
            if (file_exists($this->pidfile) && filemtime($this->pidfile) < (time() - 300)) {
                unlink($this->pidfile);
            }

            if (file_exists($this->pidfile)) {

                $pid = (int) trim(file_get_contents($this->pidfile));

                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    $wmi = new COM("winmgmts:{impersonationLevel=impersonate}!\\\\.\\root\\cimv2");
                    $procs = $wmi->ExecQuery("SELECT * FROM Win32_Process WHERE ProcessId='".$pid."'");
                    foreach ($procs as $proc) {
                        $proc->Terminate();
                        $this->running = true;
                    }
                } else {
                    if (posix_kill($pid, 0)) {
                        $this->running = true;
                    }
                }
            }
        } else {
            die("Cannot write to pid file '{$this->pidfile}'. Program execution halted.\n");
        }

        if (!$this->running) {
            file_put_contents($this->pidfile, getmypid());
        }
    }

    /**
     * 
     */
    public function script_memory_usage()
    {
        $mem_usage = memory_get_usage(true);

        if ($mem_usage < 1024) {
            return $mem_usage." bytes";
        } elseif ($mem_usage < 1048576) {
            return round($mem_usage/1024, 2)." kilobytes";
        } else {
            return round($mem_usage/1048576, 2)." megabytes";
        }
    }

    /**
     * 
     */
    public function __destruct()
    {
        if (!$this->running && file_exists($this->pidfile) && is_writeable($this->pidfile)) {
            unlink($this->pidfile);
        }
    }
}