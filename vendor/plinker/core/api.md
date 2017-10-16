## Table of contents

- [\Plinker\Core\Signer](#class-plinkercoresigner)
- [\Plinker\Core\Server](#class-plinkercoreserver)
- [\Plinker\Core\Client](#class-plinkercoreclient)

<hr />

### Class: \Plinker\Core\Signer

> Payload signing class

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>string</em> <strong>$publicKey=null</strong>, <em>string</em> <strong>$privateKey=null</strong>, <em>bool</em> <strong>$encrypt=true</strong>)</strong> : <em>void</em><br /><em>Construct</em> |
| public | <strong>authenticatePacket(</strong><em>array</em> <strong>$packet=array()</strong>)</strong> : <em>bool</em><br /><em>Authenticate payload packet</em> |
| public | <strong>decode(</strong><em>array</em> <strong>$packet=array()</strong>)</strong> : <em>object</em><br /><em>Payload decode/decrypt Validates and decodes payload packet</em> |
| public | <strong>encode(</strong><em>array</em> <strong>$packet=array()</strong>)</strong> : <em>array</em><br /><em>Payload encode/encrypt Encodes and signs the payload packet</em> |

<hr />

### Class: \Plinker\Core\Server

> Server endpoint class

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>array/string</em> <strong>$post=array()</strong>, <em>string</em> <strong>$publicKey=`''`</strong>, <em>string</em> <strong>$privateKey=`''`</strong>, <em>array</em> <strong>$config=array()</strong>)</strong> : <em>void</em> |
| public | <strong>execute()</strong> : <em>void</em> |

<hr />

### Class: \Plinker\Core\Client

> Client class

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__call(</strong><em>string</em> <strong>$action</strong>, <em>array</em> <strong>$params</strong>)</strong> : <em>void</em><br /><em>Magic caller</em> |
| public | <strong>__construct(</strong><em>string</em> <strong>$endpoint</strong>, <em>string</em> <strong>$component</strong>, <em>string</em> <strong>$publicKey=`''`</strong>, <em>string</em> <strong>$privateKey=`''`</strong>, <em>array</em> <strong>$config=array()</strong>, <em>bool</em> <strong>$encrypt=true</strong>)</strong> : <em>void</em> |
| public | <strong>useComponent(</strong><em>string</em> <strong>$component=`''`</strong>, <em>array</em> <strong>$config=array()</strong>, <em>bool</em> <strong>$encrypt=true</strong>)</strong> : <em>void</em><br /><em>Helper which changes the server component on the fly without changing the connection</em> |

