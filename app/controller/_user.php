<?php
namespace Controller;

class User extends Base
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     */
    public function beforeRoute(\Base $f3, $params)
    {
        // init application model/s
        $this->user = \Model\User::instance();

    }

    /**
	 *
	 */
    public function signin(\Base $f3, $params)
    {
        if (!empty($f3->get('POST'))) {
            
            // set form
            $form = [
                'errors' => [],
                'values' => [
                    'username' => $f3->get('POST.username'),
                    'password' => $f3->get('POST.password')
                ]
            ];
            
            // check csrf
            if ($f3->get('POST.csrf') != $f3->get('SESSION.csrf')) {
                $form['errors']['global'] = 'Invalid security token!';
            }
            
            // expire it
            $f3->set('SESSION.csrf', '');
            
            // validate username/email
            if (empty($form['values']['username'])) {
                $form['errors']['username'] = 'Username is a required field!';
            }
    
            // validate password
            if (empty($form['values']['password'])) {
                $form['errors']['password'] = 'Password is a required field!';
            }

            //
            if (empty($form['errors'])) {
                
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
                        'last_ip' => $f3->get('helper')->getIPAddress(),
                        'last_agent' => $f3->get('AGENT'),
                        'logins' => $user->logins+1,
                        'last_login' => date_create(null, timezone_open($f3->get('TZ')))->format('Y-m-d H:i:s')
                    ]);

                    $user = $user->fresh();

                    // update user session
                    $f3->set('SESSION.user', [
                        'id' => $user->id,
                        'username' => $user->username,
                        'email' => $user->email,
                        'last_ip' => $user->last_ip
                    ]);

                    $f3->reroute('/');
                } else {
                    // failed
                    $form['errors']['global'] = 'Incorrect username or password!';
                }
            }

            //
            unset($form['values']['password']);
            
            //
            $f3->set('form', $form);
        }

        // create csrf token
        $csrf = $this->set_csrf();

        $f3->mset([
            'page' => [
                'title' => 'Sign In',
                'body' => \View::instance()->render('app/view/user/signin.php')
            ]
        ]);
    }

    /**
	 *
	 */
    public function signout(\Base $f3, $params)
    {
        $f3->set('SESSION.user', '');
        $f3->reroute('/');
    }

    /**
	 *
	 */
    public function signup(\Base $f3, $params)
    {
        $f3->mset([
            'page' => [
                'title' => 'Welcome!',
                'body' => 'Hello World!'
            ]
        ]);
    }

}