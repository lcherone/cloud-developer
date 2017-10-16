<?php
namespace Plinker\Core;

/**
 * Server endpoint class
 */
class Server
{
    private $post       = array();
    private $config     = array();
    private $publicKey  = '';
    private $privateKey = '';
    
    /**
     * @param string $post
     * @param string $publicKey
     * @param string $privateKey
     * @param array  $config
     */
    public function __construct(
        $post       = array(),
        $publicKey  = '',
        $privateKey = '',
        $config     = array()
    ) {
        // define vars
        $this->post       = $post;
        $this->config     = $config;
        $this->publicKey  = hash('sha256', gmdate('h').$publicKey);
        $this->privateKey = hash('sha256', gmdate('h').$privateKey);
        
        // init signer
        $this->signer = new Signer(
            $this->publicKey,
            $this->privateKey,
            (!empty($this->post['encrypt']) ? true : false)
        );
    }

    /**
     *
     */
    public function execute()
    {
        header('Content-Type: text/plain; charset=utf-8');
        
        // check allowed ips
        if (
            !empty($this->config['allowed_ips']) &&
            !in_array($_SERVER['REMOTE_ADDR'], $this->config['allowed_ips'])
        ) {
            return serialize($this->signer->encode(array(
                'response' => [
                    'error' => 'ip not allowed ('.$_SERVER['REMOTE_ADDR'].')'
                ]
            )));
        }
        
        // verify request token
        if (
            empty($this->post['token']) ||
            empty($_SERVER['HTTP_TOKEN']) ||
            hash_hmac('sha256', $this->post['token'], $this->privateKey) != $_SERVER['HTTP_TOKEN']
        ) {
            return serialize($this->signer->encode(array(
                'response' => [
                    'error' => 'invalid packet token'
                ]
            )));
        }

        $data = $this->signer->decode(
            $this->post
        );

        if (!is_array($data)) {
            return serialize($data);
        }

        if (!isset($data['params'])) {
            $data['params'] = array();
        }

        if (!empty($data['config'])) {
            $this->config = $data['config'];
        }

        if (empty($data['component'])) {
            return serialize($this->signer->encode(array(
                'response' => [
                    'error' => 'component class cannot be empty'
                ]
            )));
        }

        if (empty($data['action'])) {
            return serialize($this->signer->encode(array(
                'response' => [
                    'error' => 'action cannot be empty'
                ]
            )));
        }

        $class = '\\Plinker\\'.$data['component'];

        if (class_exists($class)) {
            $componentClass = new $class($this->config+$data+$this->post);

            if (method_exists($componentClass, $data['action'])) {
                $return = call_user_func(
                    array(
                        $componentClass,
                        $data['action']
                    ),
                    $data['params']
                );
            } else {
                $return = 'action not implemented';
            }
        } else {
            $return = 'not implemented';
        }
        
        return serialize($this->signer->encode(array(
            'response' => $return
        )));
    }
}
