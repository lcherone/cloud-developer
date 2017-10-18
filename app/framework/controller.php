<?php
namespace Framework;

class Controller extends \Prefab
{
    protected $f3;
    protected $view;
    
    use \Framework\Traits\CSRF;

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
        if ($f3->get('AJAX') && file_exists(dirname($f3->get('template')).'/ajax.php')) {
            echo \View::instance()->render(dirname($f3->get('template')).'/ajax.php');
        } else {
            echo \View::instance()->render($f3->get('template'));
        }
    }
    
}