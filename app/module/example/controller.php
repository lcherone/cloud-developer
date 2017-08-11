<?php
namespace Module\Example;

class Controller extends \Framework\Controller
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->module = new \Framework\Model('module');
        $this->objects = new \Framework\Model('objects');
        $this->template = new \Framework\Model('template');
        $this->settings = new \Framework\Model('settings');
        $this->user = new \Framework\Model('user');
        $this->page = new \Framework\Model('page');
        $this->menu = new \Framework\Model('menu');
    }

	/**
	 *
	 */
	public function index(\Base $f3, $params)
	{
	    // get site settings
        foreach ((array) $this->settings->findAll() as $row) {
            $f3->set('setting.'.$row->key, $row->value); 
        }
        
	    // get site menus
        $f3->set('menus', (array) $this->menu->findAll());

        $f3->mset([
            'template' => 'app/template/main.php',
            'page' => [
                'title' => 'Example',
                'body' => $this->view->render('app/module/example/view/index.php')
            ]
        ]);
        
	}

}