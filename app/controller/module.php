<?php
namespace Controller;

class Module extends \Framework\Controller
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
    public function init(\Base $f3, $params)
    {
        //
        if ($f3->get('PATH') == '/') {
            $params['module'] = 'cms';
        }

        //
        if (file_exists(getcwd().'/app/module/'.$params['module'].'/controller.php')) {
            $namespace = '\\Module\\'.ucfirst($params['module']).'\\Controller';

            $controller = new $namespace();

            if (!empty($params['action'])) {
                if (method_exists($controller, $params['action'])) {
                    return $controller->{$params['action']}($f3, $params);
                } else {
                    $f3->error(404);
                }
            } else {
                return $controller->index($f3, $params);
            }
        } else {
            $namespace = '\\Module\\Cms\\Controller';

            $controller = new $namespace();

            if (!empty($params['module'])) {
                if (method_exists($controller, $params['module'])) {
                    return $controller->{$params['module']}($f3, $params);
                } else {
                    return $controller->index($f3, $params);
                }
            } else {
                return $controller->index($f3, $params);
            }
        }
    }
}
