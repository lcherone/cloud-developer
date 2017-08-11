<?php
namespace Tasks\Lib\Traits;

use RedBeanPHP\R;

trait RedBean {

    /**
     * 
     */
    public function redbeanConnect()
    {
        if (!empty($this->task->config['database']['username'])) {
            R::setup(
                $this->task->config['database']['dsn'],
                $this->task->config['database']['username'],
                $this->task->config['database']['password']
            );  
        } else {
            R::setup(
                $this->task->config['database']['dsn']
            );
        }

        R::freeze(($this->task->config['database']['freeze'] === true));
        R::debug(($this->task->config['database']['debug'] === true));

        $this->task->state['redbeanConnected'] = true;
    }

}
