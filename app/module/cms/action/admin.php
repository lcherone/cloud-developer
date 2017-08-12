<?php
namespace Module\Cms\Action;

class Admin extends \Framework\Controller
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        // load models
        $this->user = new \Framework\Model('user');
        $this->page = new \Framework\Model('page');
        $this->menu = new \Framework\Model('menu');
        $this->tasks = new \Framework\Model('tasks');
        $this->module = new \Framework\Model('module');
        $this->servers = new \Framework\Model('servers');
        $this->objects = new \Framework\Model('objects');
        $this->snippet = new \Framework\Model('snippet');
        $this->template = new \Framework\Model('template');
        $this->settings = new \Framework\Model('settings');
        $this->tasksource = new \Framework\Model('tasksource');
    }

    /**
     *
     */
    public function index(\Base $f3, $params)
    {
        $f3->set('tasks', (array) $this->tasks->findAll());
        $f3->set('pages', (array) $this->page->findAll());
        $f3->set('menus', (array) $this->menu->findAll());
        $f3->set('templates', (array) $this->template->findAll());
        $f3->set('snippets', (array) $this->snippet->findAll());
        $f3->set('modules', (array) $this->module->findAll());
        $f3->set('objects', (array) $this->objects->findAll('ORDER by priority ASC'));

        // load local plinker server endpoint
        $server =  $this->servers->load(1);

        // connect to tracker - which is self at this stage
        $tasks = new \Plinker\Core\Client(
            $server->endpoint,
            'Tasks\Manager',
            hash('sha256', gmdate('h').$server->public_key),
            hash('sha256', gmdate('h').$server->private_key),
            json_decode($server->config, true),
            $server->encrypted
        );
        
        //
        $systeminformation = $this->tasksource->findOne('name = "System Information"');
        
        // task not found lets add it
        if (empty($systeminformation)) {
            // create the task through plinker
            try {
                // create task
                $tasks->create(
                    // name
                    'System Information',
                    // source
                    '<?php
/**
 * System information task.
 * This code hooks into the Plinker System component and reports system metrics.
 */
$system = new \Plinker\System\System();
         
// move into tmp folder so files are written there
$cwd = getcwd();
chdir(\'../tmp\');

// check then call
$result = [];
if (method_exists($system, $params[0])) {
    $result[@$params[0]] = $system->{$params[0]}(@$params[1]); 
}

// move back
chdir($cwd);

// echo task result
echo json_encode($result);
',
                    // type
                    'php-raw',
                    // description
                    'System task - Hooks into official Plinker System component and reports system metrics.',
                    // params
                    []
                );
            } catch (\Exception $e) {
                if ($e->getMessage() == 'Unauthorised') {
                    //alert('warning', '<strong>Error:</strong> Connected successfully but could not authenticate! Check public and private keys.');
                    //redirect('/nodes');
                    $form['errors']['global'] = '<strong>Plinker Error:</strong> Connected successfully but could not authenticate! Check public and private keys.';
                } else {
                    $form['errors']['global'] = '<strong>Plinker Error:</strong> '.str_replace('Could not unserialize response:', '', trim(htmlentities($e->getMessage())));
                }
            }
        
        }

        // helper to get task result from systeminformation task
        $getTaskResult = function ($params, $sleeptime = 60) use ($systeminformation, $tasks) {
            $result = $systeminformation->withCondition('params = ? LIMIT 1', [json_encode($params)])->ownTasks;
            if (empty($result)) {
                return $tasks->run('System Information', $params, $sleeptime);
            } else {
                return array_values($result)[0];
            }
        };
        $f3->set('getTaskResult', $getTaskResult);

        //
        $f3->set('tasks', $tasks);

        $f3->mset([
            'template' => 'app/module/cms/view/admin.php',
            'page' => [
                'title' => 'Admin - Dashboard',
                'body' => $this->view->render('app/module/cms/view/admin/index.php')
            ]
        ]);
    }

    /**
     *
     */
    public function sign_in(\Base $f3, $params)
    {
        // create admin user if there are no users
        if ($this->user->count() == 0) {
            $user = $this->user->findOrCreate([
                'username' => 'admin',
                'password' => password_hash('admin', PASSWORD_BCRYPT)
            ]);

            $this->user->store($user);
        }

        $form = [
            'errors' => [],
            'values' => [],
        ];

        if (!empty($f3->get('POST'))) {
            
            // check csrf
            if (!$this->check_csrf($f3->get('POST.csrf'))) {
                die('Invalid CSRF token!');
            }
            // expire it
            $f3->set('SESSION.csrf', '');

            $form = [
                'errors' => [],
                'values' => $f3->get('POST'),
            ];

            // check name
            if (empty($form['values']['username'])) {
                $form['errors']['username'] = 'Username is a required field.';
            }

            // check password
            if (empty($form['values']['password'])) {
                $form['errors']['password'] = 'Password is a required field.';
            }

            // alls good
            if (empty($form['errors'])) {
                // ..
                $user = $this->user->findOne(
                    ' username = ? ',
                    [
                        $form['values']['username']
                    ]
                );

                if (!empty($user->password) && password_verify($form['values']['password'], $user->password)) {

                    // update user
                    $user->import([
                        'password' => password_hash($form['values']['password'], PASSWORD_BCRYPT),
                        'last_agent' => $f3->get('AGENT'),
                        'logins' => $user->logins+1,
                        'last_login' => date_create(null, timezone_open($f3->get('TZ')))->format('Y-m-d H:i:s')
                    ]);

                    $user = $user->fresh();

                    // update user session
                    $f3->set('SESSION.user', [
                        'id' => $user->id,
                        'username' => $user->username
                    ]);

                    $f3->reroute('/admin');
                } else {
                    // success
                    $form['errors']['global'] = 'Incorrect username or password!';
                }
            }
        }

        $f3->set('form', $form);

        //
        $this->set_csrf();

        $f3->mset([
            'template' => 'app/module/cms/view/admin.php',
            'page' => [
                'title' => 'Admin - Sign In',
                'body' => $this->view->render('app/module/cms/view/admin/sign-in.php')
            ]
        ]);
    }

    /**
     *
     */
    public function sign_out(\Base $f3, $params)
    {
        $f3->set('SESSION', []);
        $f3->reroute('/admin');
    }

    /**
     *
     */
    public function page(\Base $f3, $params)
    {
        // we will be posting code back so turn off good old browsers xss protection
        header('X-XSS-Protection: 0');

        switch ($params['sub_action']) {
            /**
             *
             */
            case "create": {
                $form = [
                    'errors' => [],
                    'values' => !empty($f3->get('POST')) ? $f3->get('POST') : []
                ];

                //
                if (!empty($_GET['module_id'])) {
                    $module = $this->module->load((int) $_GET['module_id']);

                    if (!empty($module)) {
                        $form['values']['module_id'] = (int) $_GET['module_id'];
                        $form['values']['slug'] = '/'.strtolower($module->name);
                    }
                }

                if (!empty($f3->get('POST'))) {

                    // check csrf
                    if (!$this->check_csrf($f3->get('POST.csrf'))) {
                        $form['errors']['global'] = 'Invalid CSRF token.';
                    }
                    // expire csrf
                    $f3->set('SESSION.csrf', '');
                    unset($form['values']['csrf']);

                    // check title
                    if (empty($form['values']['title'])) {
                        $form['errors']['title'] = 'Title is a required field.';
                    }

                    // check template
                    if (empty($form['values']['template_id'])) {
                        $form['errors']['template'] = 'Template is a required field.';
                    }

                    // check slug
                    if (empty($form['values']['slug'])) {
                        $form['errors']['slug'] = 'Slug is a required field.';
                    }

                    // count source lines
                    $form['values']['line_count'] = 1;

                    $lineCount = function($key) use ($form) {
                        $lines = substr_count($form['values'][$key], PHP_EOL);
                        return $lines === 0 ? 1 : $lines;
                    };

                    $form['values']['line_count'] = $form['values']['line_count'] + $lineCount('beforeload');
                    $form['values']['line_count'] = $form['values']['line_count'] + $lineCount('body');
                    $form['values']['line_count'] = $form['values']['line_count'] + $lineCount('javascript');

                    $form['values']['site'] = $_SERVER['HTTP_HOST'];

                    // alls good
                    if (empty($form['errors'])) {
                        // fix slug
                        $form['values']['slug'] = '/'.trim($form['values']['slug'], '/ ');

                        $slug = explode('/', $form['values']['slug']);

                        if (is_numeric($form['values']['module_id'])) {
                            // define a module and assign it to it
                            $module = $this->module->load($form['values']['module_id']);
                        } else {
                            // define a module and assign it to it
                            $module = $this->module->findOrCreate([
                                'name' => (!empty($slug[1]) && is_string($slug[1]) ? ucfirst($slug[1]) : '-')
                            ]);
                        }

                        $page = $this->page->create($form['values']);

                        $page->module = $module;

                        $this->page->store($page);

                        $form['values']['module_id'] = (int) $module->id;

                        // success
                        $form['errors']['success'] = 'Page created.';
                    }
                }

                $f3->set('form', $form);

                $f3->set('menus', (array) $this->menu->findAll());
                $f3->set('templates', (array) $this->template->findAll());
                $f3->set('snippets', (array) $this->snippet->findAll());
                $f3->set('modules', (array) $this->module->findAll());
                $f3->set('objects', (array) $this->objects->findAll('ORDER by priority ASC'));

                //
                $this->set_csrf();

                $f3->mset([
                    'template' => 'app/module/cms/view/admin.php',
                    'page' => [
                        'title' => 'Admin - Page - Create',
                        'body' => $this->view->render('app/module/cms/view/admin/page/create.php')
                    ]
                ]);
            } break;

            /**
             *
             */
            case "edit": {

                $page = $this->page->load($params['sub_action_id']);

                $form = [
                    'errors' => [],
                    'values' => !empty($f3->get('POST')) ? $f3->get('POST') : $page
                ];

                if (!empty($f3->get('POST'))) {

                    // check csrf
                    if (!$this->check_csrf($f3->get('POST.csrf'))) {
                        $form['errors']['global'] = 'Invalid CSRF token.';
                    }
                    // expire csrf
                    $f3->set('SESSION.csrf', '');
                    unset($form['values']['csrf']);

                    // check title
                    if (empty($form['values']['title'])) {
                        $form['errors']['title'] = 'Title is a required field.';
                    }

                    // check template
                    if (empty($form['values']['template_id'])) {
                        $form['errors']['template_id'] = 'Template is a required field.';
                    }

                    // count source lines
                    $form['values']['line_count'] = 1;

                    $lineCount = function($key) use ($form) {
                        $lines = substr_count($form['values'][$key], PHP_EOL);
                        return $lines === 0 ? 1 : $lines;
                    };

                    $form['values']['line_count'] = $form['values']['line_count'] + $lineCount('beforeload');
                    $form['values']['line_count'] = $form['values']['line_count'] + $lineCount('body');
                    $form['values']['line_count'] = $form['values']['line_count'] + $lineCount('javascript');

                    // alls good
                    if (empty($form['errors'])) {
                        // fix slug
                        $form['values']['slug'] = '/'.trim($form['values']['slug'], '/ ');

                        $slug = explode('/', $form['values']['slug']);

                        if (is_numeric($form['values']['module_id'])) {
                            // define a module and assign it to it
                            $module = $this->module->load($form['values']['module_id']);
                        } else {
                            // define a module and assign it to it
                            $module = $this->module->findOrCreate([
                                'name' => (!empty($slug[1]) && is_string($slug[1]) ? ucfirst($slug[1]) : '-')
                            ]);
                        }

                        // ..
                        $page->import($form['values']);
                        $page->module = $module;

                        $form['values']['module_id'] = (int) $module->id;

                        $this->page->store($page);

                        // success
                        $form['errors']['success'] = 'Page updated.';
                    }
                }

                // set into form
                $f3->set('form', $form);

                // load model data
                $f3->set('menus', (array) $this->menu->findAll());
                $f3->set('templates', (array) $this->template->findAll());
                $f3->set('snippets', (array) $this->snippet->findAll());
                $f3->set('modules', (array) $this->module->findAll());
                $f3->set('objects', (array) $this->objects->findAll('ORDER by priority ASC'));
                
                //
                $this->set_csrf();

                $f3->mset([
                    'template' => 'app/module/cms/view/admin.php',
                    'page' => [
                        'title' => 'Admin - Page - Edit',
                        'body' => $this->view->render('app/module/cms/view/admin/page/edit.php')
                    ]
                ]);
            } break;

            /**
             *
             */
            case "delete": {
                $page = $this->page->load($params['sub_action_id']);
                $this->page->trash($page);
                $f3->reroute('/admin/page');
            } break;

            /**
             *
             */
            default: {
                $f3->set('pages', (array)$this->page->findAll('ORDER by slug'));
                
                // helper - visibility name
                $f3->set('visibilityname', function ($key = null) {
                    $n = [
                        1 => 'Always',
                        2 => 'When not signed in',
                        3 => 'When signed in',
                        4 => 'When developer',
                    ];
                    return (isset($n[$key]) ? $n[$key] : '');
                });

                $f3->mset([
                    'template' => 'app/module/cms/view/admin.php',
                    'page' => [
                        'title' => 'Admin - Page',
                        'body' => $this->view->render('app/module/cms/view/admin/page/index.php')
                    ]
                ]);
            } break;
        }
    }

    /**
     *
     */
    public function menu(\Base $f3, $params)
    {
        switch ($params['sub_action']) {
            /**
             *
             */
            case "create": {
                $form = [
                    'errors' => [],
                    'values' => !empty($f3->get('POST')) ? $f3->get('POST') : []
                ];

                if (!empty($f3->get('POST'))) {

                    // check csrf
                    if (!$this->check_csrf($f3->get('POST.csrf'))) {
                        $form['errors']['global'] = 'Invalid CSRF token.';
                    }
                    // expire csrf
                    $f3->set('SESSION.csrf', '');
                    unset($form['values']['csrf']);

                    // check title
                    if (empty($form['values']['title'])) {
                        $form['errors']['title'] = 'Title is a required field.';
                    }

                    // check slug
                    if (empty($form['values']['slug'])) {
                        $form['errors']['slug'] = 'Slug is a required field.';
                    }

                    $form['values']['site'] = $_SERVER['HTTP_HOST'];

                    // alls good
                    if (empty($form['errors'])) {
                        $menu = $this->menu->create($form['values']);
                        $this->menu->store($menu);

                        // success
                        $form['errors']['success'] = 'Menu created.';
                    }
                }

                $f3->set('form', $form);

                //
                $this->set_csrf();

                $f3->mset([
                    'template' => 'app/module/cms/view/admin.php',
                    'page' => [
                        'title' => 'Admin - Menu - Create',
                        'body' => $this->view->render('app/module/cms/view/admin/menu/create.php')
                    ]
                ]);
            } break;

            /**
             *
             */
            case "edit": {

                $menu = $this->menu->load($params['sub_action_id']);

                $form = [
                    'errors' => [],
                    'values' => !empty($f3->get('POST')) ? $f3->get('POST') : $menu
                ];

                if (!empty($f3->get('POST'))) {

                    // check csrf
                    if (!$this->check_csrf($f3->get('POST.csrf'))) {
                        $form['errors']['global'] = 'Invalid CSRF token.';
                    }
                    // expire csrf
                    $f3->set('SESSION.csrf', '');
                    unset($form['values']['csrf']);

                    // check title
                    if (empty($form['values']['title'])) {
                        $form['errors']['title'] = 'Title is a required field.';
                    }

                    // check slug
                    if (empty($form['values']['slug'])) {
                        $form['errors']['slug'] = 'Slug is a required field.';
                    }

                    // alls good
                    if (empty($form['errors'])) {
                        // ..
                        $menu->import($form['values']);
                        $this->menu->store($menu);

                        // success
                        $form['errors']['success'] = 'Menu updated.';
                    }
                }

                $f3->set('form', $form);

                //
                $this->set_csrf();

                $f3->mset([
                    'template' => 'app/module/cms/view/admin.php',
                    'page' => [
                        'title' => 'Admin - Menu - Edit',
                        'body' => $this->view->render('app/module/cms/view/admin/menu/edit.php')
                    ]
                ]);
            } break;

            /**
             *
             */
            case "delete": {
                $menu = $this->menu->load($params['sub_action_id']);
                $this->menu->trash($menu);
                $f3->reroute('/admin/menu');
            } break;

            /**
             *
             */
            default: {
                $f3->set('menus', (array) $this->menu->findAll());
                
                // helper - visibility name
                $f3->set('visibilityname', function ($key = null) {
                    $n = [
                        1 => 'Always',
                        2 => 'When not signed in',
                        3 => 'When signed in',
                        4 => 'When developer',
                    ];
                    return (isset($n[$key]) ? $n[$key] : '');
                });
                
                $f3->mset([
                    'template' => 'app/module/cms/view/admin.php',
                    'page' => [
                        'title' => 'Admin - Menu',
                        'body' => $this->view->render('app/module/cms/view/admin/menu/index.php')
                    ]
                ]);
            } break;
        }
    }

    /**
     *
     */
    public function module(\Base $f3, $params)
    {
        switch ($params['sub_action']) {
            /**
             *
             */
            case "create": {
                $form = [
                    'errors' => [],
                    'values' => !empty($f3->get('POST')) ? $f3->get('POST') : []
                ];

                if (!empty($f3->get('POST'))) {

                    // check csrf
                    if (!$this->check_csrf($f3->get('POST.csrf'))) {
                        $form['errors']['global'] = 'Invalid CSRF token.';
                    }
                    // expire csrf
                    $f3->set('SESSION.csrf', '');
                    unset($form['values']['csrf']);

                    // check title
                    if (empty($form['values']['name'])) {
                        $form['errors']['name'] = 'Title is a required field.';
                    }

                    $form['values']['site'] = $_SERVER['HTTP_HOST'];

                    // alls good
                    if (empty($form['errors'])) {
                        // count source lines
                        $form['values']['line_count'] = 1;

                        $lineCount = function($key) use ($form) {
                            $lines = substr_count($form['values'][$key], PHP_EOL);
                            return $lines === 0 ? 1 : $lines;
                        };

                        $form['values']['line_count'] = $form['values']['line_count'] + $lineCount('beforeload');

                        $module = $this->module->create($form['values']);
                        $this->module->store($module);
                        
                        $module = $module->fresh();
                        
                        $f3->reroute('/admin/module/view/'.$module->id.'?c');

                        // success
                        $form['errors']['success'] = 'Module created.';
                    }
                }

                $f3->set('form', $form);

                $f3->set('snippets', (array) $this->snippet->findAll());

                //
                $this->set_csrf();

                $f3->mset([
                    'template' => 'app/module/cms/view/admin.php',
                    'page' => [
                        'title' => 'Admin - Module - Create',
                        'body' => $this->view->render('app/module/cms/view/admin/module/create.php')
                    ]
                ]);
            } break;

            /**
             *
             */
            case "edit": {

                $module = $this->module->load($params['sub_action_id']);

                $form = [
                    'errors' => [],
                    'values' => !empty($f3->get('POST')) ? $f3->get('POST') : $module
                ];

                if (!empty($f3->get('POST'))) {

                    // check csrf
                    if (!$this->check_csrf($f3->get('POST.csrf'))) {
                        $form['errors']['global'] = 'Invalid CSRF token.';
                    }
                    // expire csrf
                    $f3->set('SESSION.csrf', '');
                    unset($form['values']['csrf']);

                    // check name
                    if (empty($form['values']['name'])) {
                        $form['errors']['name'] = 'Name is a required field.';
                    }

                    // alls good
                    if (empty($form['errors'])) {
                        // count source lines
                        $form['values']['line_count'] = 1;

                        $lineCount = function($key) use ($form) {
                            $lines = substr_count($form['values'][$key], PHP_EOL);
                            return $lines === 0 ? 1 : $lines;
                        };

                        $form['values']['line_count'] = $form['values']['line_count'] + $lineCount('beforeload');

                        // ..
                        $module->import($form['values']);
                        $this->module->store($module);

                        // success
                        $form['errors']['success'] = 'Module updated.';

                        $f3->reroute('/admin/module/view/'.$module->id.'?s');
                    }
                }

                $f3->set('form', $form);

                $f3->set('snippets', (array) $this->snippet->findAll());

                //
                $this->set_csrf();

                $f3->mset([
                    'template' => 'app/module/cms/view/admin.php',
                    'page' => [
                        'title' => 'Admin - Module - Edit',
                        'body' => $this->view->render('app/module/cms/view/admin/module/edit.php')
                    ]
                ]);
            } break;

            /**
             *
             */
            case "view": {

                $module = $this->module->load((int)$params['sub_action_id']);

                $f3->mset([
                    'module' => $module
                ]);

                $form = [
                    'errors' => [],
                    'values' => !empty($f3->get('POST')) ? $f3->get('POST') : $module
                ];

                if (!empty($f3->get('POST'))) {

                    // check csrf
                    if (!$this->check_csrf($f3->get('POST.csrf'))) {
                        $form['errors']['global'] = 'Invalid CSRF token.';
                    }
                    // expire csrf
                    $f3->set('SESSION.csrf', '');
                    unset($form['values']['csrf']);

                    // check name
                    if (empty($form['values']['name'])) {
                        $form['errors']['name'] = 'Name is a required field.';
                    }

                    // alls good
                    if (empty($form['errors'])) {
                        // ..
                        $module->import($form['values']);
                        $this->module->store($module);

                        // success
                        $form['errors']['success'] = 'Module updated.';
                    }
                }

                // bit of a hack coz not using session flashbag
                if (isset($_GET['s'])) {
                    $form['errors']['success'] = 'Module Updated.';
                }
                if (isset($_GET['c'])) {
                    $form['errors']['success'] = 'Module Created.';
                }

                $f3->set('form', $form);

                $f3->set('snippets', (array) $this->snippet->findAll());

                //
                $this->set_csrf();

                $f3->mset([
                    'template' => 'app/module/cms/view/admin.php',
                    'page' => [
                        'title' => 'Admin - Module - View',
                        'body' => $this->view->render('app/module/cms/view/admin/module/view.php')
                    ]
                ]);
            } break;

            /**
             *
             */
            case "delete": {
                $module = $this->module->load($params['sub_action_id']);
                $this->module->trash($module);
                $f3->reroute('/admin/module');
            } break;

            /**
             *
             */
            default: {
                $f3->set('modules', (array) $this->module->findAll());
                $f3->mset([
                    'template' => 'app/module/cms/view/admin.php',
                    'page' => [
                        'title' => 'Admin - Modules',
                        'body' => $this->view->render('app/module/cms/view/admin/module/index.php')
                    ]
                ]);
            } break;
        }
    }

    /**
     *
     */
    public function template(\Base $f3, $params)
    {
        // we will be posting code back so turn off good old browsers xss protection
        header('X-XSS-Protection: 0');

        switch ($params['sub_action']) {
            /**
             *
             */
            case "create": {
                $form = [
                    'errors' => [],
                    'values' => !empty($f3->get('POST')) ? $f3->get('POST') : []
                ];

                if (!empty($f3->get('POST'))) {

                    // check csrf
                    if (!$this->check_csrf($f3->get('POST.csrf'))) {
                        $form['errors']['global'] = 'Invalid CSRF token.';
                    }
                    // expire csrf
                    $f3->set('SESSION.csrf', '');
                    unset($form['values']['csrf']);

                    // check name
                    if (empty($form['values']['name'])) {
                        $form['errors']['name'] = 'Name is a required field.';
                    }

                    // check source
                    if (empty($form['values']['source'])) {
                        $form['errors']['source'] = 'Source is a required field.';
                    }

                    $form['values']['site'] = $_SERVER['HTTP_HOST'];

                    // alls good
                    if (empty($form['errors'])) {
                        $template = $this->template->create($form['values']);
                        $this->template->store($template);

                        // create template file
                        if (!file_exists('tmp/template/'.$template->id)) {
                            mkdir('tmp/template/'.$template->id, 0755, true);
                            mkdir('tmp/template/'.$template->id.'/css', 0755, true);
                            mkdir('tmp/template/'.$template->id.'/js', 0755, true);
                            mkdir('tmp/template/'.$template->id.'/img', 0755, true);
                            mkdir('tmp/template/'.$template->id.'/dist', 0755, true);
                        }
                        file_put_contents('tmp/template/'.$template->id.'/template.php', $form['values']['source']);

                        // success
                        $form['errors']['success'] = 'Template created.';
                    }
                }

                $f3->set('form', $form);

                //
                $this->set_csrf();

                $f3->mset([
                    'template' => 'app/module/cms/view/admin.php',
                    'page' => [
                        'title' => 'Admin - Template - Create',
                        'body' => $this->view->render('app/module/cms/view/admin/template/create.php')
                    ]
                ]);
            } break;

            /**
             *
             */
            case "edit": {

                $template = $this->template->load($params['sub_action_id']);

                $form = [
                    'errors' => [],
                    'values' => !empty($f3->get('POST')) ? $f3->get('POST') : $template
                ];

                if (!empty($f3->get('POST'))) {

                    // check csrf
                    if (!$this->check_csrf($f3->get('POST.csrf'))) {
                        $form['errors']['global'] = 'Invalid CSRF token.';
                    }
                    // expire csrf
                    $f3->set('SESSION.csrf', '');
                    unset($form['values']['csrf']);

                    // check name
                    if (empty($form['values']['name'])) {
                        $form['errors']['name'] = 'Name is a required field.';
                    }

                    // check source
                    if (empty($form['values']['source'])) {
                        $form['errors']['source'] = 'Source is a required field.';
                    }

                    // alls good
                    if (empty($form['errors'])) {
                        // ..
                        $template->import($form['values']);
                        $this->template->store($template);

                        // update template file
                        if (!file_exists('tmp/template/'.$template->id)) {
                            mkdir('tmp/template/'.$template->id, 0755, true);
                            mkdir('tmp/template/'.$template->id.'/css', 0755, true);
                            mkdir('tmp/template/'.$template->id.'/js', 0755, true);
                            mkdir('tmp/template/'.$template->id.'/img', 0755, true);
                            mkdir('tmp/template/'.$template->id.'/dist', 0755, true);
                        }
                        file_put_contents('tmp/template/'.$template->id.'/template.php', $form['values']['source']);

                        //
                        $form['values']['id'] = $params['sub_action_id'];

                        // success
                        $form['errors']['success'] = 'Template updated.';
                    }
                }

                $f3->set('form', $form);

                //
                $this->set_csrf();

                $f3->mset([
                    'template' => 'app/module/cms/view/admin.php',
                    'page' => [
                        'title' => 'Admin - Template - Edit',
                        'body' => $this->view->render('app/module/cms/view/admin/template/edit.php')
                    ]
                ]);
            } break;

            /**
             *
             */
            case "preview": {

                $pdf_pages = [
                    'http://c9-cloud.free.lxd.systems/admin/template/preview/'.$params['sub_action_id']."?display=". (int) $params['sub_action_id'],
                ];

                if (isset($_GET['display'])) {
                    $template = $this->template->load($_GET['display']);

                    $_SESSION['template_id'] = (int) $template->id;

                    // get site settings
                    foreach ((array) $this->settings->findAll() as $row) {
                        $f3->set('setting.'.$row->key, $row->value);
                    }

                    // menu links
                    $f3->set('menus', (array) $this->menu->findAll());

                    //
                    $f3->mset([
                        'template' => 'tmp/template/'.$template->id.'/template.php',
                        'page' => [
                            'page_id' => '0',
                            'title' => 'Template Preview',
                            'body' => '
                            <div class="row">
                                <div class="col-lg-12">
                                    <h1 class="page-header">
                                        Template Preview <small> - Looking good!</small>
                                    </h1>
                                    <ol class="breadcrumb">
                                        <li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>
                                    </ol>
                                </div>
                            </div>
                            <p>Your <code>'.htmlentities('<?= $f3->decode($page[\'body\']) ?>').'</code> contents will go here.</p>
                            '
                        ]
                    ]);

                    return $f3;
                } else {
                    // init snappy lib and instance
                    $snappy = new \Knp\Snappy\Image('vendor/bin/wkhtmltoimage-amd64');

                    // loop over and apply wkhtmltopdf options
                    foreach ([
                        //'cookie' => [
                        //    'callback-token' => hash('sha256', 'x')
                        //],
                        //'cache-dir'     => './tmp/',
                        //'enable-smart-shrinking' => false,
                        'enable-smart-width'=>true
                        //'lowquality'    => true,
                        // 'dpi'           => 1920,
                        // 'image-dpi'     => 1920,
                        // 'margin-top'    => 0,
                        // 'margin-right'  => 0,
                        // 'margin-bottom' => 0,
                        // 'margin-left'   => 0,
                    ] as $margin => $value) {
                        $snappy->setOption($margin, $value);
                    }

                    // out string
                    $out = $snappy->getOutput($pdf_pages);

                    header('Content-Type: image/jpeg');
                    header('Content-Length: '.strlen($out));
                    header('Cache-Control: public, must-revalidate, max-age=0');
                    header('Pragma: public');
                    header('Expires: Thurs, 24 Mar 1983 00:00:00 GMT');
                    header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
                    die($out);
                }
            } break;

            /**
             *
             */
            case "file": {
                $template = $this->template->load($params['sub_action_id']);

                $server =  $this->servers->load(1);

                $error = [];
                $tasks = new \Plinker\Core\Client(
                    $server->endpoint,
                    'Tasks\Manager',
                    hash('sha256', gmdate('h').$server->public_key),
                    hash('sha256', gmdate('h').$server->private_key),
                    json_decode($server->config, true),
                    $server->encrypted // enable encryption [default: true]
                );

                $path = str_replace('/admin/template/file/'.$params['sub_action_id'].'/', '', $params[0]);

                header('Content-Type: text/plain; charset=utf-8');

                if (isset($_GET['del'])) {
                    exit(base64_decode($tasks->deleteFile('/var/www/html/tmp/template/'.(int) $params['sub_action_id'].'/'.$path)));
                } elseif(isset($_GET['save'])) {
                    // if template.php also update database
                    if ($path == 'template.php') {
                        // ..
                        $template->import([
                            'source' => $_POST['data']
                        ]);
                        $this->template->store($template);
                    }

                    exit(base64_decode($tasks->saveFile('/var/www/html/tmp/template/'.(int) $params['sub_action_id'].'/'.$path, base64_encode($_POST['data']))));
                } else {
                    exit(base64_decode($tasks->getFile('/var/www/html/tmp/template/'.(int) $params['sub_action_id'].'/'.$path)));
                }

                $f3->reroute('/admin/template');
            } break;

            /**
             *
             */
            case "upload-file": {
                $template = $this->template->load($params['sub_action_id']);

                $server =  $this->servers->load(1);

                $error = [];
                $tasks = new \Plinker\Core\Client(
                    $server->endpoint,
                    'Tasks\Manager',
                    hash('sha256', gmdate('h').$server->public_key),
                    hash('sha256', gmdate('h').$server->private_key),
                    json_decode($server->config, true),
                    $server->encrypted // enable encryption [default: true]
                );

                $path = str_replace('/admin/template/upload-file/'.$params['sub_action_id'], '', $params[0]);

                $fileData = '';
                if (move_uploaded_file($_FILES["file"]["tmp_name"], '/var/www/html/tmp/template/'.(int) $params['sub_action_id'].$path.'/'.basename($_FILES['file']['name']))) {
                  $fileData = file_get_contents('/var/www/html/tmp/template/'.(int) $params['sub_action_id'].$path.'/'.basename($_FILES['file']['name']));
                }

                header('Content-Type: text/plain; charset=utf-8');

                try {
                    $tasks->saveFile('/var/www/html/tmp/template/'.(int) $params['sub_action_id'].$path.'/'.basename($_FILES['file']['name']), base64_encode($fileData));
                } catch(\Exception $e) {
                    exit('error');
                }
                exit('1');
            } break;

            /**
             *
             */
            case "delete": {
                $template = $this->template->load($params['sub_action_id']);
                $this->template->trash($template);
                $f3->reroute('/admin/template');
            } break;

            /**
             *
             */
            default: {
                $f3->set('templates', (array) $this->template->findAll());
                $f3->mset([
                    'template' => 'app/module/cms/view/admin.php',
                    'page' => [
                        'title' => 'Admin - Templates',
                        'body' => $this->view->render('app/module/cms/view/admin/template/index.php')
                    ]
                ]);
            } break;
        }
    }

    /**
     *
     */
    public function tasks(\Base $f3, $params)
    {
        $server = $this->servers->load(1);

        // connect to tracker - which is self at this stage
        $tasks = new \Plinker\Core\Client(
            $server->endpoint,
            'Tasks\Manager',
            hash('sha256', gmdate('h').$server->public_key),
            hash('sha256', gmdate('h').$server->private_key),
            json_decode($server->config, true),
            $server->encrypted
        );

        // we will be posting code back so turn off good old browsers xss protection
        header('X-XSS-Protection: 0');

        switch ($params['sub_action']) {
            /**
             *
             */
            case "create": {
                $form = [
                    'errors' => [],
                    'values' => !empty($f3->get('POST')) ? $f3->get('POST') : []
                ];

                if (!empty($f3->get('POST'))) {

                    // check csrf
                    if (!$this->check_csrf($f3->get('POST.csrf'))) {
                        $form['errors']['global'] = 'Invalid CSRF token.';
                    }
                    // expire csrf
                    $f3->set('SESSION.csrf', '');
                    unset($form['values']['csrf']);

                    $form = [
                        'errors' => [],
                        'values' => [
                            'name'    => (isset($_POST['name'])    ? trim($_POST['name'])   : null),
                            'description' => (isset($_POST['description']) ? trim($_POST['description']) : null),
                            'type'    => (isset($_POST['type'])    ? trim($_POST['type'])   : null),
                            'params'  => (isset($_POST['params'])  ? $_POST['params'] : []),
                            'repeats' => (isset($_POST['repeats']) ? 1 : 0),
                            'sleep'   => (isset($_POST['sleep'])   ? (int) $_POST['sleep']  : 0),
                            'source'  => (isset($_POST['source'])  ? trim($_POST['source']) : null),
                        ]
                    ];

                    // type
                    if (!in_array($form['values']['type'], ['php-closure', 'php-raw', 'bash'])) {
                        $form['errors']['type'] = 'Invalid task source type, choose from the list.';
                    }

                    // name
                    if (empty($form['values']['name'])) {
                        $form['errors']['name'] = 'Name is a required field.';
                    }

                    // description
                    if (empty($form['values']['description'])) {
                        //$form['errors']['description'] = 'Description is a required field.';
                    } else {
                        $form['values']['description'] = strip_tags($form['values']['description']);
                    }

                    // source
                    if (empty($form['values']['source'])) {
                        $form['errors']['source'] = 'Source is a required field.';
                    }

                    $form['values']['site'] = $_SERVER['HTTP_HOST'];

                    // alls good
                    if (empty($form['errors'])) {

                        $form['values']['params'] = json_encode($form['values']['params']);

                        $task = $this->tasksource->create($form['values']);
                        $this->tasksource->store($task);

                        $form['values']['params'] = json_decode($form['values']['params'], true);

                        // success
                        $form['errors']['success'] = 'Task created.';
                    }
                }

                $f3->set('form', $form);

                //
                $this->set_csrf();

                $f3->mset([
                    'template' => 'app/module/cms/view/admin.php',
                    'page' => [
                        'title' => 'Admin - Template - Create',
                        'body' => $this->view->render('app/module/cms/view/admin/task/create.php')
                    ]
                ]);
            } break;

            /**
             *
             */
            case "edit": {

                $task = $this->tasksource->load((int) $params['sub_action_id']);
                $tasklog = $this->tasks->findAll('tasksource_id = ? ORDER BY id DESC', [(int) $params['sub_action_id']]);

                $form = [
                    'errors' => [],
                    'values' => !empty($f3->get('POST')) ? $f3->get('POST') : $task
                ];

                if (!empty($f3->get('POST'))) {

                    // check csrf
                    if (!$this->check_csrf($f3->get('POST.csrf'))) {
                        $form['errors']['global'] = 'Invalid CSRF token.';
                    }
                    // expire csrf
                    $f3->set('SESSION.csrf', '');
                    unset($form['values']['csrf']);

                    // type
                    if (!in_array($form['values']['type'], ['php-closure', 'php-raw', 'bash'])) {
                        $form['errors']['type'] = 'Invalid task source type, choose from the list.';
                    }

                    // name
                    if (empty($form['values']['name'])) {
                        $form['errors']['name'] = 'Name is a required field.';
                    }

                    // description
                    if (empty($form['values']['description'])) {
                        $form['errors']['description'] = 'Description is a required field.';
                    } else {
                        $form['values']['description'] = strip_tags($form['values']['description']);
                    }

                    // source
                    if (empty($form['values']['source'])) {
                        $form['errors']['source'] = 'Source is a required field.';
                    }

                    // alls good
                    if (empty($form['errors'])) {

                        $form['values']['params'] = json_encode($form['values']['params']);
                        // ..
                        $task->import($form['values']);
                        $this->tasksource->store($task);

                        $form['values']['params'] = json_decode($form['values']['params'], true);

                        // success
                        $form['errors']['success'] = 'Task updated.';
                    }
                }

                $f3->set('form', $form);

                //
                $this->set_csrf();

                $f3->mset([
                    'template' => 'app/module/cms/view/admin.php',
                    'page' => [
                        'title' => 'Admin - Tasks - Edit',
                        'body' => $this->view->render('app/module/cms/view/admin/task/edit.php')
                    ]
                ]);
            } break;
            
            
            case "inline_edit": {

                // AJAX
                if (!empty($f3->get('AJAX'))) {
                    
                    header('Content-Type: application/json; charset=utf-8');

                    if (!is_numeric($params['sub_action_id'])) {
                        exit('{"success": false, "msg": "Invalid task id."}');
                    }
                    
                    $id = (int) $params['sub_action_id'];

                    $update = [
                        'id'    => @$_POST['pk'],
                        'name'  => @$_POST['name'],
                        'value' => @$_POST['value']
                    ];
                    
                    $task = $this->tasks->load($update['id']);
                    
                    if (empty($task)) {
                        exit('{"success": false, "msg": "Invalid task id."}');
                    }
                    
                    if (!isset($task[$update['name']])){
                        exit('{"success": false, "msg": "Invalid task property."}');
                    }
                    
                    // handle sleep update
                    if ($_POST['name'] == 'sleep' && !is_numeric($_POST['value']) && !is_int($_POST['value'])) {
                        exit('{"success": false, "msg": "Invalid sleep value, expected integer."}');
                    } elseif ($_POST['name'] == 'sleep' && $_POST['value'] < 1) {
                        exit('{"success": false, "msg": "Invalid sleep value, must be greater than 0"}');
                    } elseif ($_POST['name'] == 'sleep' && $_POST['value'] > 31557600) {
                        exit('{"success": false, "msg": "Invalid sleep value, must be less than 31557600"}');
                    } elseif ($_POST['name'] == 'sleep') {
                        $task->run_next = date_create($task->run_last)->modify("+".(int) $_POST['value']." seconds")->format('Y-m-d h:i:s');
                    }
                    
                    // update
                    $task[$update['name']] = $update['value'];
                    
                    // addons
                    if ($update['name'] == 'repeats') {
                        if ($update['value'] == '1') {
                            $task['completed'] = '';
                        }
                    }
                
                    $this->tasks->store($task);
                
                    exit('{"success": true, "msg": "Task queue item updated."}');
                }
                
                $f3->error(404);
            } break;

            /**
             *
             */
            case "view": {

                $task = $this->tasksource->load((int)$params['sub_action_id']);
                $tasklog = $this->tasks->findAll('tasksource_id = ? ORDER BY id DESC', [(int) $params['sub_action_id']]);

                $f3->mset([
                    'task' =>$task,
                    'tasklog' => $tasklog
                ]);

                $form = [
                    'errors' => [],
                    'values' => !empty($f3->get('POST')) ? $f3->get('POST') : $task
                ];

                if (!empty($f3->get('POST'))) {

                    // check csrf
                    if (!$this->check_csrf($f3->get('POST.csrf'))) {
                        $form['errors']['global'] = 'Invalid CSRF token.';
                    }
                    // expire csrf
                    $f3->set('SESSION.csrf', '');
                    unset($form['values']['csrf']);

                    // check title
                    if (empty($form['values']['title'])) {
                        $form['errors']['title'] = 'Title is a required field.';
                    }

                    // check source
                    if (empty($form['values']['source'])) {
                        $form['errors']['source'] = 'Source is a required field.';
                    }

                    // alls good
                    if (empty($form['errors'])) {
                        // ..
                        $task->import($form['values']);
                        $this->tasks->store($task);

                        // success
                        $form['errors']['success'] = 'Task updated.';
                    }
                }

                $f3->set('form', $form);

                //
                $this->set_csrf();

                $f3->mset([
                    'template' => 'app/module/cms/view/admin.php',
                    'page' => [
                        'title' => 'Admin - Tasks - Edit',
                        'body' => $this->view->render('app/module/cms/view/admin/task/view.php')
                    ]
                ]);
            } break;

            /**
             *
             */
            case "run": {

                $task = $this->tasksource->load((int) $params['sub_action_id']);
                $tasks->run($task->name, $task->params, $task->sleep);

                $f3->reroute('/admin/tasks/view/'.(int) $params['sub_action_id']);
            } break;

            /**
             *
             */
            case "remove": {
                $task = $this->tasksource->load($params['sub_action_id']);
                $this->tasksource->trash($task);
                $f3->reroute('/admin/tasks');
            } break;

            /**
             *
             */
            default: {
                $f3->set('tasksources', $this->tasksource->findAll());
                $f3->mset([
                    'template' => 'app/module/cms/view/admin.php',
                    'page' => [
                        'title' => 'Admin - Templates',
                        'body' => $this->view->render('app/module/cms/view/admin/task/index.php')
                    ]
                ]);
            } break;
        }
    }

    /**
     *
     */
    public function snippet(\Base $f3, $params)
    {
        // we will be posting code back so turn off good old browsers xss protection
        header('X-XSS-Protection: 0');

        switch ($params['sub_action']) {
            /**
             *
             */
            case "get": {

                $snippet = $this->snippet->load($params['sub_action_id']);

                header('Content-Type: text/plain; charset=UTF-8');
                if (!empty($snippet)) {
                    exit($snippet->source);
                } else {
                    $f3->error(404);
                }
            } break;

            /**
             *
             */
            case "create": {
                $form = [
                    'errors' => [],
                    'values' => !empty($f3->get('POST')) ? $f3->get('POST') : []
                ];

                if (!empty($f3->get('POST'))) {

                    // check csrf
                    if (!$this->check_csrf($f3->get('POST.csrf'))) {
                        $form['errors']['global'] = 'Invalid CSRF token.';
                    }
                    // expire csrf
                    $f3->set('SESSION.csrf', '');
                    unset($form['values']['csrf']);

                    // check title
                    if (empty($form['values']['title'])) {
                        $form['errors']['title'] = 'Title is a required field.';
                    }

                    // check source
                    if (empty($form['values']['source'])) {
                        $form['errors']['source'] = 'Source is a required field.';
                    }

                    // check type
                    if (empty($form['values']['type'])) {
                        $form['errors']['type'] = 'Type is a required field.';
                    }

                    $form['values']['site'] = $_SERVER['HTTP_HOST'];

                    // alls good
                    if (empty($form['errors'])) {
                        $snippet = $this->snippet->create($form['values']);
                        $this->snippet->store($snippet);
                        
                        $snippet = $snippet->fresh();
                        
                        $f3->reroute('/admin/snippet/edit/'.$snippet->id.'?c');

                        // success
                        $form['errors']['success'] = 'Snippet created.';
                    }
                }

                $f3->set('form', $form);

                //
                $this->set_csrf();

                $f3->mset([
                    'template' => 'app/module/cms/view/admin.php',
                    'page' => [
                        'title' => 'Admin - Snippet - Create',
                        'body' => $this->view->render('app/module/cms/view/admin/snippet/create.php')
                    ]
                ]);
            } break;

            /**
             *
             */
            case "edit": {

                $snippet = $this->snippet->load($params['sub_action_id']);

                $form = [
                    'errors' => [],
                    'values' => !empty($f3->get('POST')) ? $f3->get('POST') : $snippet
                ];

                if (!empty($f3->get('POST'))) {

                    // check csrf
                    if (!$this->check_csrf($f3->get('POST.csrf'))) {
                        $form['errors']['global'] = 'Invalid CSRF token.';
                    }
                    // expire csrf
                    $f3->set('SESSION.csrf', '');
                    unset($form['values']['csrf']);

                    // check title
                    if (empty($form['values']['title'])) {
                        $form['errors']['title'] = 'Title is a required field.';
                    }

                    // check source
                    if (empty($form['values']['source'])) {
                        $form['errors']['source'] = 'Source is a required field.';
                    }

                    // check type
                    if (empty($form['values']['type'])) {
                        $form['errors']['type'] = 'Type is a required field.';
                    }

                    // alls good
                    if (empty($form['errors'])) {
                        // ..
                        $snippet->import($form['values']);
                        $this->snippet->store($snippet);

                        // update template file
                        file_put_contents('tmp/template.'.$template->id.'.php', $form['values']['source']);

                        // success
                        $form['errors']['success'] = 'Snippet updated.';
                    }
                } else {
                    // bit of a hack coz not using session flashbag
                    if (isset($_GET['c'])) {
                        $form['errors']['success'] = 'Snippet created.';
                    }
                }

                $f3->set('form', $form);

                //
                $this->set_csrf();

                $f3->mset([
                    'template' => 'app/module/cms/view/admin.php',
                    'page' => [
                        'title' => 'Admin - Snippet - Edit',
                        'body' => $this->view->render('app/module/cms/view/admin/snippet/edit.php')
                    ]
                ]);
            } break;

            /**
             *
             */
            case "delete": {
                $snippet = $this->snippet->load($params['sub_action_id']);
                $this->snippet->trash($snippet);
                $f3->reroute('/admin/snippet');
            } break;

            /**
             *
             */
            default: {
                $f3->set('snippets', (array) $this->snippet->findAll());
                $f3->mset([
                    'template' => 'app/module/cms/view/admin.php',
                    'page' => [
                        'title' => 'Admin - Snippets',
                        'body' => $this->view->render('app/module/cms/view/admin/snippet/index.php')
                    ]
                ]);
            } break;
        }
    }

    /**
     *
     */
    public function objects(\Base $f3, $params)
    {
        // we will be posting code back so turn off good old browsers xss protection
        header('X-XSS-Protection: 0');

        switch ($params['sub_action']) {
            /**
             *
             */
            case "get": {

                $snippet = $this->objects->load($params['sub_action_id']);

                header('Content-Type: text/plain; charset=UTF-8');
                if (!empty($snippet)) {
                    exit($snippet->source);
                } else {
                    $f3->error(404);
                }
            } break;

            /**
             *
             */
            case "create": {
                $form = [
                    'errors' => [],
                    'values' => !empty($f3->get('POST')) ? $f3->get('POST') : []
                ];

                if (!empty($f3->get('POST'))) {

                    // check csrf
                    if (!$this->check_csrf($f3->get('POST.csrf'))) {
                        $form['errors']['global'] = 'Invalid CSRF token.';
                    }
                    // expire csrf
                    $f3->set('SESSION.csrf', '');
                    unset($form['values']['csrf']);

                    // check title
                    if (empty($form['values']['title'])) {
                        $form['errors']['title'] = 'Title is a required field.';
                    }

                    // check source
                    if (empty($form['values']['source'])) {
                        $form['errors']['source'] = 'Source is a required field.';
                    }

                    $form['values']['site'] = $_SERVER['HTTP_HOST'];

                    // alls good
                    if (empty($form['errors'])) {
                        
                        // count source lines
                        $form['values']['line_count'] = 1;
    
                        $lineCount = function($key) use ($form) {
                            $lines = substr_count($form['values'][$key], PHP_EOL);
                            return $lines === 0 ? 1 : $lines;
                        };
                        $form['values']['line_count'] = $form['values']['line_count'] + $lineCount('source');
                        
                        $object = $this->objects->create($form['values']);
                        $this->objects->store($object);
                        
                        $object = $object->fresh();
                        
                        $f3->reroute('/admin/objects/edit/'.$object->id.'?c');

                        // success
                        $form['errors']['success'] = 'Object created.';
                    }
                }

                $f3->set('form', $form);

                //
                $this->set_csrf();
                
                //
                $objects = (array) $this->objects->findAll();
                $f3->set('objects', $objects);
                
                // helper function pick out object based on priority
                $f3->set('helper.getObjectNameByPriority', function($priority = null) use ($objects) {
                    $matched = [];
                    foreach ($objects as $row) {
                        if ($row->priority == $priority) {
                            $matched[] = $row->title;
                        }
                    }
                    
                    if (empty($matched)) {
                        return;
                    } else {
                        return ' ('.implode(', ', $matched).')';
                    }
                });

                $f3->mset([
                    'template' => 'app/module/cms/view/admin.php',
                    'page' => [
                        'title' => 'Admin - Object - Create',
                        'body' => $this->view->render('app/module/cms/view/admin/objects/create.php')
                    ]
                ]);
            } break;

            /**
             *
             */
            case "edit": {

                $object = $this->objects->load($params['sub_action_id']);

                $form = [
                    'errors' => [],
                    'values' => !empty($f3->get('POST')) ? $f3->get('POST') : $object
                ];

                if (!empty($f3->get('POST'))) {

                    // check csrf
                    if (!$this->check_csrf($f3->get('POST.csrf'))) {
                        $form['errors']['global'] = 'Invalid CSRF token.';
                    }
                    // expire csrf
                    $f3->set('SESSION.csrf', '');
                    unset($form['values']['csrf']);

                    // check title
                    if (empty($form['values']['title'])) {
                        $form['errors']['title'] = 'Title is a required field.';
                    }

                    // check source
                    if (empty($form['values']['source'])) {
                        $form['errors']['source'] = 'Source is a required field.';
                    }

                    // alls good
                    if (empty($form['errors'])) {
                        // count source lines
                        $form['values']['line_count'] = 1;
    
                        $lineCount = function($key) use ($form) {
                            $lines = substr_count($form['values'][$key], PHP_EOL);
                            return $lines === 0 ? 1 : $lines;
                        };
                        $form['values']['line_count'] = $form['values']['line_count'] + $lineCount('source');
                        
                        // ..
                        $object->import($form['values']);
                        $this->objects->store($object);

                        // update template file
                        file_put_contents('tmp/template.'.$object->id.'.php', $form['values']['source']);

                        // success
                        $form['errors']['success'] = 'Object updated.';
                    }
                }

                $f3->set('form', $form);
                
                //
                $objects = (array) $this->objects->findAll();
                $f3->set('objects', $objects);
                
                // helper function pick out object based on priority
                $f3->set('helper.getObjectNameByPriority', function($priority = null) use ($objects) {
                    $matched = [];
                    foreach ($objects as $row) {
                        if ($row->priority == $priority) {
                            $matched[] = $row->title;
                        }
                    }
                    
                    if (empty($matched)) {
                        return;
                    } else {
                        return ' ('.implode(', ', $matched).')';
                    }
                });
                
                // bit of a hack coz not using session flashbag
                if (isset($_GET['u'])) {
                    $form['errors']['success'] = 'Object Updated.';
                }
                if (isset($_GET['c'])) {
                    $form['errors']['success'] = 'Object Created.';
                }

                //
                $this->set_csrf();

                $f3->mset([
                    'template' => 'app/module/cms/view/admin.php',
                    'page' => [
                        'title' => 'Admin - Objects - Edit',
                        'body' => $this->view->render('app/module/cms/view/admin/objects/edit.php')
                    ]
                ]);
            } break;

            /**
             *
             */
            case "delete": {
                $object = $this->objects->load($params['sub_action_id']);
                $this->objects->trash($object);
                $f3->reroute('/admin/objects');
            } break;

            /**
             *
             */
            default: {
                $f3->set('objects', (array) $this->objects->findAll('ORDER by priority ASC'));
                $f3->mset([
                    'template' => 'app/module/cms/view/admin.php',
                    'page' => [
                        'title' => 'Admin - Objects',
                        'body' => $this->view->render('app/module/cms/view/admin/objects/index.php')
                    ]
                ]);
            } break;
        }
    }

    /**
     *
     */
    public function settings(\Base $f3, $params)
    {
        switch ($params['sub_action']) {
            /**
             *
             */
            case "backups": {
                // create
                if ($params['sub_action_id'] == 'create') {
                    
                    $db = $f3->get('db');
                    $date = date_create()->format('Y-m-d_H:i:s');
                    
                    `mysqldump --add-drop-table --user={$db['username']} --password={$db['password']} --host=127.0.0.1 app | gzip > /var/www/html/backups/backup.{$date}.sql.gz &`;
                    
                    $f3->reroute('/admin/settings');
                } 
                // remove
                elseif ($params['sub_action_id'] == 'remove') {
                    $file = base64_decode($f3->get('GET.file'));
                    
                    unlink('backups/'.basename($file));
                    $f3->reroute('/admin/settings');
                }
                // restore
                elseif ($params['sub_action_id'] == 'restore') {
                    $file = base64_decode($f3->get('GET.file'));
                    
                    $db = $f3->get('db');
                    $date = date_create()->format('Y-m-d_H:i:s');
                    
                    // backup current
                    `mysqldump --add-drop-table --user={$db['username']} --password={$db['password']} --host=127.0.0.1 app | gzip > /var/www/html/backups/before.restore.{$date}.sql.gz`;
                    
                    // restore
                    `zcat /var/www/html/backups/{$file} | mysql --user={$db['username']} --password={$db['password']} app`;

                    $f3->reroute('/admin/settings');
                } else {
                    $f3->error(404);
                }
            } break;
            
            default: {
                $settings = $this->settings->findAll();

                $server = $this->servers->load(1);

                // connect to tracker - which is self at this stage
                $tasks = new \Plinker\Core\Client(
                    $server->endpoint,
                    'Tasks\Manager',
                    hash('sha256', gmdate('h').$server->public_key),
                    hash('sha256', gmdate('h').$server->private_key),
                    json_decode($server->config, true),
                    $server->encrypted
                );

                $form = [
                    'errors' => [],
                    'values' => !empty($f3->get('POST')) ? $f3->get('POST') : (array) $settings
                ];

                if (!empty($f3->get('POST'))) {

                    // check csrf
                    if (!$this->check_csrf($f3->get('POST.csrf'))) {
                        $form['errors']['global'] = 'Invalid CSRF token.';
                    }
                    // expire csrf
                    $f3->set('SESSION.csrf', '');
                    unset($form['values']['csrf']);

                    // check title
                    if (empty($form['values']['sitename'])) {
                        $form['errors']['title'] = 'Site name is a required field.';
                    }

                    // alls good
                    if (empty($form['errors'])) {
                        foreach ($form['values'] as $key => $value) {
                            // update composer file
                            if ($key == 'composer') {
                                chmod('./composer.json', 0664);
                                file_put_contents('./composer.json', $value);

                                try {
                                    // create task
                                    $tasks->create(
                                        // name
                                        'Composer Update',
                                        // source
                                        "#!/bin/bash\n\n".
                                        "# Run composer update\n".
                                        "/usr/local/bin/composer update -d /var/www/html 2>&1\n\n".
                                        "# Change files ownership to www-data user\n".
                                        "chown www-data:www-data /var/www/html/.* -R",
                                        // type
                                        'bash',
                                        // description
                                        'Executes composer update, required for system settings.',
                                        // params
                                        []
                                    );
                                    $tasks->run('Composer Update', []);
                                } catch (\Exception $e) {

                                }
                            }
                            // everything else
                            else {
                                $setting = $this->settings->findOrCreate([
                                    'key' => $key
                                ]);
                                $setting->value = $value;
                                $this->settings->store($setting);
                            }
                        }

                        // good
                        $settings = $this->settings->findAll();
                        $form = [
                            'errors' => [
                                'success' => 'Settings updated.'
                            ],
                            'values' => $settings
                        ];
                    }
                }

                try {
                    $composerTask = $tasks->get('Composer Update');
                    $form['values']['composer_result'] = $tasks->getTasksLog($composerTask->id);
                    $form['values']['composer_result'] = array_values($form['values']['composer_result'])[0]->result;
                } catch (\Exception $e) {

                }

                $f3->set('form', $form);

                $f3->set('helper.extractValue', function($key) use ($settings) {
                    foreach ($settings as $row) {
                        if ($row->key == $key) return $row->value;
                    }
                    return;
                });

                //
                $this->set_csrf();

                $f3->mset([
                    'template' => 'app/module/cms/view/admin.php',
                    'page' => [
                        'title' => 'Admin - Settings',
                        'body' => $this->view->render('app/module/cms/view/admin/settings/index.php')
                    ]
                ]);
            } break;
        }
    }

}