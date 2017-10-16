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
                'mysql:host='.$this->task->config['database']['host'].';dbname='.$this->task->config['database']['name'],
                $this->task->config['database']['username'],
                $this->task->config['database']['password']
            );  
        } else {
            R::setup(
                'mysql:host='.$this->task->config['database']['host'].';dbname='.$this->task->config['database']['name']
            );
        }

        R::freeze(($this->task->config['database']['freeze'] === true));
        R::debug(($this->task->config['database']['debug'] === true));

        $this->task->state['redbeanConnected'] = true;
    }

}
