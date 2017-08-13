<?php
namespace Module\Cms;

class Controller extends \Framework\Controller
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->user     = new \Framework\Model('user');
        $this->page     = new \Framework\Model('page');
        $this->menu     = new \Framework\Model('menu');
        $this->module   = new \Framework\Model('module');
        $this->servers  = new \Framework\Model('servers');
        $this->objects  = new \Framework\Model('objects');
        $this->template = new \Framework\Model('template');
        $this->settings = new \Framework\Model('settings');
    }

    /**
     *
     */
    public function index(\Base $f3, $params)
    {
        // load local plinker server config
        $server = $this->servers->load(1);

        // if empty insert self into db
        if (empty($server->id)) {
            /**
             * Plinker Config
             */
            $plinker = [
                // plinker configuration
                'plinker' => [
                    // endpoint should point to this instance
                    'endpoint' => 'http://'.$_SERVER['HTTP_HOST'],
            
                    // network keys
                    'public_key'  => hash('sha256', microtime(true).uniqid(true)),
                    
                    // should be the same across all servers
                    'private_key' => $f3->get('plinker.private_key'),
            
                    'enabled' => $f3->get('plinker.enabled'),
                    'encrypted' => true
                ],
                    
                // database connection
                'database' => $f3->get('db'),
                    
                // displays output to task runner console
                'debug' => true,
                    
                // daemon sleep time
                'sleep_time' => 1
            ];

            // insert config into database
            $server = $this->servers->create([
                'name'    => $_SERVER['HTTP_HOST'],
                'endpoint'    => $plinker['plinker']['endpoint'],
                'public_key' => $plinker['plinker']['public_key'],
                'private_key' => $plinker['plinker']['private_key'],
                'enabled' =>  $plinker['plinker']['enabled'],
                'encrypted' =>  $plinker['plinker']['encrypted'],
                'config' => json_encode($plinker)
            ]);
            $this->servers->store($server);
            
            $server = $server->fresh();
        }

        // get site settings
        foreach ((array) $this->settings->findAll() as $row) {
            $f3->set('setting.'.$row->key, $row->value); 
        }
        
        // plinker handler
        /**
         * Plinker Server
         */
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
            /** 
             * Plinker server listener
             */
            if (isset($_POST['data']) && 
                isset($_POST['token']) && 
                isset($_POST['public_key'])
            ) {
                // test its encrypted
                file_put_contents('./tmp/encryption-proof.txt', print_r($_POST, true));
        
                //
                $server = new \Plinker\Core\Server(
                    $_POST,
                    hash('sha256', gmdate('h').$server->public_key),
                    hash('sha256', gmdate('h').$server->private_key)
                );
                exit($server->execute());
            }
        }

        //
        if (!empty($f3->get('setting.autogenerate'))) {
            // create page (wiki style)
            $page = $this->page->findOrCreate([
                'site' => $_SERVER['HTTP_HOST'],
                'slug' => $f3->get('PATH')
            ]);
            
            // fix slug
            $slug = explode('/', '/'.trim($f3->get('PATH'), '/ '));
            
            // define a module and assign it to it
            $module = $this->module->findOrCreate([
                'name' => (!empty($slug[1]) && is_string($slug[1]) ? ucfirst($slug[1]) : '-')
            ]);
            
            $page->module = $module;
 
        } else {
            // create page (wiki style)
            $page = $this->page->findOne('site = ? AND slug = ?', [
                $_SERVER['HTTP_HOST'],
                $f3->get('PATH')
            ]);
            
            // must be found
            if (empty($page)) {
                $f3->error(404);
            }
        }
        
        // visibility
        // when not signed in
        if (!empty($f3->get('SESSION.user')) && $page->visibility == 2) {
            $f3->error(401);
        }
        // when signed in
        if (empty($f3->get('SESSION.user')) && $page->visibility == 3) {
            $f3->error(401);
        }
        // check for admin/developer
        if (empty($f3->get('SESSION.developer')) && $page->visibility == 4) {
            $f3->error(401);
        }

        if (empty($page->template_id)) {
            $page->template_id = 1;
        }
        
        if (empty($page->body) && $page->id == 1) {
            $page->body = '<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Welcome <small> - to my little website.</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> Home</li>
        </ol>
    </div>
</div>

<p>You can edit me by signing in <a href="/admin">here</a> as <strong>admin:admin</strong>.</p>';
        } elseif (empty($page->body) && empty($page->views)) {
            if (empty($page->title)) {
                $page->title = ucwords(str_replace('/', ' - ', trim($f3->get('PATH'), '/ ')));
            }
            
            $breadcrumb = '<li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>'.PHP_EOL."\t\t\t";
            $breadcrumb .= '<li class="active"><i class="fa fa-folder-o"></i> '.$page->module->name.'</li>'.PHP_EOL."\t\t";
           
            if (!empty($slug[2])) {
                $breadcrumb = '<li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>'.PHP_EOL."\t\t\t";
                $breadcrumb .= '<li><i class="fa fa-folder-o"></i> '.$page->module->name.'</li>'.PHP_EOL."\t\t\t";
                $breadcrumb .= '<li class="active"><i class="fa fa-page-o"></i> '.$slug[2].'</li>'.PHP_EOL."\t\t";
            }

            $page->body = '<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            '.$page->title.' <small> - Auto generated.</small>
        </h1>
        <ol class="breadcrumb">
            '.$breadcrumb.'</ol>
    </div>
</div>

<p>
    This page and any associated module have been automatically generated. 
    You should now go code it <a href="/admin/page/edit/'.$page->id.'">here</a>.<br>
    If you no longer want pages to be automatically generated then <a href="/admin/settings">turn off the setting here</a>.
</p>
';
        }
        
        $_SESSION['template_id'] = (int) $page->template_id;
        
        $page->views = (int) $page->views+1;
        
        $this->page->store($page);

        // get menus
        $f3->set('menus', (array) $this->menu->findAll());

        // execute all object code
        foreach ((array) $this->objects->findAll('ORDER BY priority DESC, id DESC') as $row) {
            ob_start();
            eval('?>'.$row->source);
            $page->body = ob_get_clean().$page->body;
        }
        
        // execute module beforeload source
        ob_start();
        eval('?>'.@$page->module->beforeload);
        $page->body = ob_get_clean().$page->body;
        
        // execute page beforeload
        if (!empty($page->beforeload)) {
            ob_start();
            eval('?>'.$page->beforeload);
            $page->body = ob_get_clean().$page->body;
        }
        
        // execute page body
        if (!empty($page->body)) {
            ob_start();
            eval('?>'.$page->body);
            $page->body = ob_get_clean();
        }

        // execute page javascript
        if (!empty($page->javascript)) {
            ob_start();
            eval('?>'.$page->javascript);
            $f3->set('javascript', $f3->get('javascript').ob_get_clean());
        }

        //
        $f3->mset([
            'template' => 'tmp/template/'.$page->template_id.'/template.php',
            'page' => [
                'page_id' => $page->id,
                'title' => $page->title,
                'body' => $page->body
            ]
        ]);
    }
    
    /**
     *
     */
    public function admin(\Base $f3, $params)
    {
        $bypass = ($params['action'] == 'template' && $params['sub_action'] == 'preview');
        
        // check user is logged in
        if (empty($f3->get('SESSION.developer')) && !$bypass) {
            if ($params['action'] != 'sign-in') {
                $f3->reroute('/admin/sign-in');
            }
        }
        
        $action = str_replace('-', '_', strtolower($params['action']));
        $this->action = new Action\Admin();
        
        if (empty($action)) {
            $action = 'index';
        }
        
        if (method_exists($this->action, $action)) {
            $this->action->{$action}($f3, $params);
        } else {
            $f3->error(404);
        }
    }

}