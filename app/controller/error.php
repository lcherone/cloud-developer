<?php
namespace Controller;

class Error extends \Prefab
{
    protected $f3;
    protected $view;

    /**
     * 
     */
    public function __construct()
    {
        // framework
        $this->f3 = \Base::instance();
        
        // set framework into view scope
        $this->f3->set('f3', $this->f3);
    }
    
	/**
     * Needs doing
     */
    public function display(\Base $f3, $params)
    {
        header('Content-Type: text/plain');
        exit(print_r($f3->get('ERROR'), true));
    }

    /**
     *
     */
    public function afterRoute(\Base $f3, $params)
    {
        //echo \View::instance()->render('app/view/template.php');
    }
    
}