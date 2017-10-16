<?php
namespace Plinker\Core;

use Plinker\Base91\Base91;
use phpseclib\Crypt\AES;

/**
 * Payload signing class
 */
class Signer
{

    /**
     * Construct
     *
     * @param string $publicKey
     * @param string $privateKey
     */
    public function __construct($publicKey = null, $privateKey = null, $encrypt = true)
    {
        $this->publicKey  = $publicKey;
        $this->privateKey = $privateKey;
        $this->encrypt    = $encrypt;

        // set encryption
        if ($this->encrypt) {
            $this->encryption = new AES('ecb');
            $this->encryption->setPassword($this->privateKey);
        }
    }

    /**
     * Payload encode/encrypt
     * Encodes and signs the payload packet
     *
     * @param array $signer
     * @return array
     */
    public function encode($packet = array())
    {
        // serialize response data
        if (!empty($packet['response'])) {
            $packet['response'] = serialize($packet['response']);
        }
        
        // set time into packet
        $packet['time'] = microtime(true);

        $data = serialize($packet);

        $packet = array(
            'data'         => ($this->encrypt ? Base91::encode($this->encryption->encrypt($data)) : $data),
            'public_key'   => $this->publicKey,
            'time'         => microtime(true),
            'encrypt'      => $this->encrypt
        );

        // sign packet
        $packet['token'] = hash_hmac(
            'sha256',
            $packet['data'],
            $this->privateKey
        );

        return $packet;
    }

    /**
     * Payload decode/decrypt
     * Validates and decodes payload packet
     *
     * @param array $signer
     * @return object
     */
    public function decode($packet = array())
    {
        // failed packet validation
        if (!$this->authenticatePacket($packet)) {
            // unset not needed response vars
            unset($packet['data']);
            unset($packet['public_key']);
            unset($packet['token']);
            unset($packet['encrypt']);

            $packet['response'] = serialize(['error' => $this->packet_state]);
            return $packet;
        }

        if ($this->encrypt) {
            $packet['data'] = $this->encryption->decrypt(Base91::decode($packet['data']));
        }

        return unserialize($packet['data']);
    }

    /**
     * Authenticate payload packet
     *
     * @param array $signer
     * @return bool
     */
    public function authenticatePacket($packet = array())
    {
        $this->packet_state = 'valid';

        // public key required
        if (empty($packet['public_key'])) {
            $this->packet_state = 'public key required';
            return false;
        }

        // token required
        if (empty($packet['token'])) {
            $this->packet_state = 'token required';
            return false;
        }

        // data required
        if (empty($packet['data'])) {
            $this->packet_state = 'empty data';
            return false;
        }

        // authenticate packet signature/token
        if (hash_hmac(
            'sha256',
            $packet['data'],
            $this->privateKey
        ) == $packet['token']) {
            return true;
        } else {
            $this->packet_state = 'unauthorised';
            return false;
        }
    }
}
