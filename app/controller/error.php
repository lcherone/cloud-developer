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
        
        // load core models
        $this->menu     = new \Framework\Model('menu');
        $this->template = new \Framework\Model('template');
        $this->settings = new \Framework\Model('settings');
    }
    
    /**
     * Needs doing
     */
    public function display(\Base $f3, $params)
    {
        // get menus
        $f3->set('menus', (array) $this->menu->findAll('ORDER BY `order` ASC, id ASC'));

        // get site settings
        foreach ((array) $this->settings->findAll() as $row) {
            $f3->set('setting.'.$row->key, $row->value);
        }
        
        //
        $_SESSION['template_path'] = 'tmp/template/';
        $_SESSION['template_id'] = $f3->get('setting.error_template');
        
        //
        $body = '
        <style>
            .error-template {}
            .error-details {}
            .error-actions { margin-top:15px }
        </style>
        <div class="row">
            <div class="col-md-12">
                <div class="error-template">
                    <h1>Oops!</h1>
                    <h2>'.$f3->get('ERROR.code').' '.$f3->get('ERROR.status').'</h2>
                    <div class="error-details">
                        Sorry, an error has occured, requested page was '.strtolower($f3->get('ERROR.status')).'!
                    </div>
                    <div class="error-actions">
                        <a href="/" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-home"></span> Got to Home</a>
                    </div>
                </div>
            </div>
        </div>';
        
        $template_id = $f3->get('setting.error_template');
        
        if (empty($template_id)) {
            $template_id = 1;
        }

        //
        $f3->mset([
            'template' => 'tmp/template/'.$template_id.'/template.php',
            'page' => [
                'page_id' => 0,
                'title' => $f3->get('ERROR.code').': '.$f3->get('ERROR.status'),
                'body' => $body
            ]
        ]);
    }

    /**
     *
     */
    public function afterRoute(\Base $f3, $params)
    {
        echo \View::instance()->render($f3->get('template'));
    }
}
