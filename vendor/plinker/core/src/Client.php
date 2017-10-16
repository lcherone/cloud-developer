<?php
namespace Plinker\Core;

use Requests;

/**
 * Client class
 */
class Client
{
    private $endpoint;
    private $component;
    private $publicKey;
    private $privateKey;
    private $config;
    private $encrypt;

    /**
     * @param string $endpoint
     * @param string $component
     * @param string $publicKey
     * @param string $privateKey
     * @param array $config
     * @param bool $encrypt
     */
    public function __construct(
        $endpoint,
        $component,
        $publicKey = '',
        $privateKey = '',
        $config = array(),
        $encrypt = true
    ) {
        // define vars
        $this->endpoint   = $endpoint;
        $this->component  = $component;
        $this->publicKey  = hash('sha256', gmdate('h').$publicKey);
        $this->privateKey = hash('sha256', gmdate('h').$privateKey);
        $this->config     = $config;
        $this->encrypt    = $encrypt;
        $this->response   = null;

        // init signer
        $this->signer = new Signer($this->publicKey, $this->privateKey, $this->encrypt);
    }

    /**
     * Helper which changes the server component on the fly without changing
     * the connection
     *
     * @param string $component - component class namespace
     * @param array  $config    - component array
     */
    public function useComponent($component = '', $config = array(), $encrypt = true)
    {
        $this->component = $component;
        $this->config    = $config;
        $this->encrypt   = $encrypt;

        return new $this(
            $this->endpoint,
            $this->component,
            $this->publicKey,
            $this->privateKey,
            $this->config,
            $this->encrypt
        );
    }

    /**
     * Magic caller
     *
     * @param string $action
     * @param array  $params
     */
    public function __call($action, $params)
    {
        if (!is_scalar($action)) {
            throw new \Exception('Method name has no scalar value');
        }

        if (!is_array($params)) {
            throw new \Exception('Params must be given as array');
        }

        // change params array into numeric
        $params = array_values($params);

        // unset local private key
        unset($this->config['plinker']['private_key']);

        $encoded = $this->signer->encode(array(
            'time' => microtime(true),
            'self' => $this->endpoint,
            'component' => $this->component,
            'config' => $this->config,
            'action' => $action,
            'params' => $params
        ));

        // send request and store in response
        $this->response = Requests::post(
            $this->endpoint,
            array(
                // send plinker header
                'plinker' => true,
                // sign token generated from encoded packet, send as header
                'token'   => hash_hmac('sha256', $encoded['token'], $this->privateKey)
            ),
            $encoded,
            array(
                'timeout' => (!empty($this->config['timeout']) ? (int) $this->config['timeout'] : 60),
            )
        );

        // check response is a serialized string
        if (@unserialize($this->response->body) === false) {
            throw new \Exception('Could not unserialize response: '.$this->response->body);
        }

        // initial unserialize response body
        $this->response->body = unserialize($this->response->body);

        // decode response
        $this->response->data = $this->signer->decode(
            $this->response->body
        );

        // verify response packet timing validity
        $this->response->data['packet_time'] = microtime(true) - $this->response->body['time'];
        if ($this->response->data['packet_time'] >= 1) {
            throw new \Exception('Response timing packet check failed');
        }

        // verify data timing validity
        $this->response->data['data_time'] = (microtime(true) - $this->response->data['time']);
        if ($this->response->data['data_time'] >= 1) {
            throw new \Exception('Response timing data check failed');
        }

        // decode response data
        if (is_string($this->response->data['response'])) {
            // check response is a serialized string
            if (@unserialize($this->response->data['response']) === false) {
                throw new \Exception('Could not unserialize response: '.$this->response->data['response']);
            }
            $this->response->data['response'] = unserialize($this->response->data['response']);
        }

        // check for errors
        if (is_array($this->response->data['response']) && !empty($this->response->data['response']['error'])) {
            throw new \Exception(ucfirst($this->response->data['response']['error']));
        }

        // unserialize data
        return $this->response->data['response'];
    }
}
