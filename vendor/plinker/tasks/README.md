**Plinker-RPC - Tasks**
=========

Plinker PHP RPC client/server makes it really easy to link and execute PHP component classes on remote systems, while maintaining the feel of a local method call.

The tasks component allows you to write code based tasks which are completed by a daemon, 
this could allow you to create a single interface to control a cluster of servers tasks.

Want to see an example project? Check out [PlinkerUI](https://github.com/lcherone/PlinkerUI).

**Composer**

    {
    	"require": {
    		"plinker/core": ">=v0.1",
    		"plinker/tasks": ">=v0.1"
    	}
    }

[Example source](https://github.com/plinker-rpc/development/tree/master/examples/tasks)

You should create a file which will be run via cron, for example:

**cron.php**

    <?php
    require '../../vendor/autoload.php';
    
    /*
    the cron job
    
    @reboot while sleep 1; do cd /var/www/html/examples/tasks && /usr/bin/php run.php ; done
    */
    
    // init task runner
    $task = new Plinker\Tasks\Runner([
        // database connection
        'database' => [
            'dsn'      => 'sqlite:./database.db',
            'host'     => '',
            'name'     => '',
            'username' => '',
            'password' => '',
            'freeze'   => false,
            'debug'    => false,
        ],
             
        // displays output to task runner console
        'debug' => true,
            
        // daemon sleep time
        'sleep_time' => 1,
        'pid_path'   => './pids'
    ]);
    
    // $task->run('Test');
    
    $task->daemon('Queue', [
        'sleep_time' => 1
    ]);



Making a remote call.
--------------------


    <?php
    require '../../vendor/autoload.php';
    
    /**
     * Plinker Config
     */
    $config = [
        // plinker connection
    	'plinker' => [
    		'endpoint' => 'http://127.0.0.1/examples/tasks/server.php',
    		'public_key'  => 'makeSomethingUp',
    		'private_key' => 'againMakeSomethingUp'
    	],
    	
    	// database connection
    	'database' => [
    		'dsn'      => 'sqlite:./database.db',
    		'host'     => '',
    		'name'     => '',
    		'username' => '',
    		'password' => '',
    		'freeze'   => false,
    		'debug'    => false,
    	],
    
    	// displays output to task runner console
    	'debug' => true,
    
    	// daemon sleep time
    	'sleep_time' => 1,
    	'pid_path'   => './pids'
    ];
    
    // init plinker client
    $tasks = new \Plinker\Core\Client(
    	// where is the plinker server
    	$config['plinker']['endpoint'],
    
    	// component namespace to interface to
    	'Tasks\Manager',
    
    	// keys
    	hash('sha256', gmdate('h').$config['plinker']['public_key']),
    	hash('sha256', gmdate('h').$config['plinker']['private_key']),
    
    	// construct values which you pass to the component, which the component
    	//  will use, for RedbeanPHP component you would send the database connection
    	//  dont worry its AES encrypted. see: encryption-proof.txt
    	$config
    );
    
    /**
     * Example
     */
    
    // create the task
    try {
    	// create task
    	$tasks->create(
    		// name
    		'Hello World',
    		// source
    		'<?php echo "Hello World";',
    		// type
    		'php',
    		// description
    		'...',
    		// default params
    		[]
    	);
    } catch (\Exception $e) {
    	if ($e->getMessage() == 'Unauthorised') {
    		echo 'Error: Connected successfully but could not authenticate! Check public and private keys.';
    	} else {
    		echo 'Error:'.str_replace('Could not unserialize response:', '', trim(htmlentities($e->getMessage())));
    	}
    }
    
    //run task now - executed as apache user
    //print_r($tasks->runNow('Hello World'));
    
    // place task in queue to run
    print_r($tasks->run('Hello World', [1], 5));
    
    // get task status
    print_r($tasks->status('Hello World'));
    
    // get task run count
    print_r($tasks->runCount('Hello World'));
    
    // clear all tasks
    //$tasks->clear();


**then the server part...**


    <?php
    require '../../vendor/autoload.php';
    
    /**
     * Plinker Server
     */
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
        /**
         * Plinker Config
         */
        $plinker = [
            'public_key'  => 'makeSomethingUp',
            'private_key' => 'againMakeSomethingUp'
        ];
    
        /**
         * Plinker server listener
         */
        if (isset($_POST['data']) &&
            isset($_POST['token']) &&
            isset($_POST['public_key'])
        ) {
            // test its encrypted
            file_put_contents('./encryption-proof.txt', print_r($_POST, true));
    
            //
            $server = new \Plinker\Core\Server(
                $_POST,
                hash('sha256', gmdate('h').$plinker['public_key']),
                hash('sha256', gmdate('h').$plinker['private_key'])
            );
    
            exit($server->execute());
        }
    }


See the [organisations page](https://github.com/plinker-rpc) for additional components and examples.