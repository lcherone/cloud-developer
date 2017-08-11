<?php
namespace Framework;

class Controller extends \Prefab
{
    protected $f3;
    protected $view;

    /**
     * 
     */
    public function __construct()
    {
        // framework
        $this->f3       = \Base::instance();
        $this->view     = \View::instance();
        $this->template = \Template::instance();
        
        // set framework into view scope
        $this->f3->set('f3', $this->f3);
        $this->f3->set('view', $this->view);
        $this->f3->set('template', $this->template);
    }
    
    /**
     * Checks passed token against one in sesssion
     * 
     * Expires the one in session once checked, so it must be right first time 
     * to obtain true return value
     * 
     * @param string $csrf - Value to compare with current
     */
    public function check_csrf($csrf = null)
    {
        // check both passed and session are not empty
        if (is_null($csrf) || $this->f3->devoid('SESSION.csrf')) {
            return false;
        }

        // check
        $result = ($csrf == $this->f3->get('SESSION.csrf'));
        
        // expire current
        $this->f3->set('SESSION.csrf', '');
        
        return $result;
    }

    /**
     * Generate and set csrf token into session
     */
    public function set_csrf()
    {
        $csrf = hash('sha256', uniqid(true).microtime(true));
        
        $this->f3->mset([
            'csrf' => $csrf,
            'SESSION.csrf' => $csrf
        ]);
        
        return $csrf;
    }
    
    /**
     * Send json
     */
    public function json($data = null)
    {
        header('Content-Type: application/json;charset=utf8');
        exit(json_encode($data, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK));
    }

    /**
     *
     */
    public function afterRoute(\Base $f3, $params)
    {
        echo \View::instance()->render($f3->get('template'));
    }
    
}