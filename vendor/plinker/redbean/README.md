**Plinker-RPC - RedBeanPHP**
=========

Plinker PHP RPC client/server makes it really easy to link and execute PHP component classes on remote systems, while maintaining the feel of a local method call.

RedBeanPHP component which will enable you to directly manage databases on remote sites.

**Composer**

    {
    	"require": {
    		"plinker/redbean": ">=v0.1"
    	}
    }




Making a remote call.
--------------------

    <?php
    require 'vendor/autoload.php';
    
    try {
        
        /**
         * Plinker Config
         */
        $config = [
            // plinker connection | using tasks as to write in the correct .sqlite file
            'plinker' => [
                'endpoint' => 'http://127.0.0.1/examples/redbean/server.php',
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
            ]
        ];
        
        // init plinker endpoint client
        $rdb = new \Plinker\Core\Client(
            // where is the plinker server
            $config['plinker']['endpoint'],
        
            // component namespace to interface to
            'Redbean\Redbean',
        
            // keys
            $config['plinker']['public_key'],
            $config['plinker']['private_key'],
        
            // construct values which you pass to the component
            $config['database']
        );
    
        //..
        
    } catch (\Exception $e) {
        exit(get_class($e).': '.$e->getMessage());
    }



**then the server part...**

    <?php
    require 'vendor/autoload.php';

    /**
     * POST Server Part
     */
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $server = new Plinker\Core\Server(
            $_POST,
            'username',
            'password'
        );
        exit($server->execute());
    }
    

See the [organisations page](https://github.com/plinker-rpc) for additional components.