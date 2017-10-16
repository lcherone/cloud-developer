**Plinker-RPC - Core**
=========

Plinker PHP RPC client/server makes it really easy to link and execute PHP component classes on remote systems, while maintaining the feel of a local method call.

Required base component which contains the client and server. (Its all you need if you just want the client).

**Composer**

    {
    	"require": {
    		"plinker/core": ">=v0.1"
    	}
    }



Making a remote call.
--------------------


    <?php
    require 'vendor/autoload.php';

    /**
     * Initialize plinker client.
     *
     * @param string $url to host
     * @param string $component namespace of class to interface to
     * @param string $public_key to authenticate on host
     * @param string $private_key to authenticate on host
     * @param string $config component construct config
     */
    $plink = new Plinker\Core\Client(
        'http://example.com',
        'Test\Demo',
        'username',
        'password',
        array(
            'time' => time()
        )
    );
    echo '<pre>'.print_r($plink->test(), true).'</pre>';


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