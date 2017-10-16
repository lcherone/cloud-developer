<?php
namespace Controller;

class Asset extends \Prefab
{
    protected $f3;
    protected $view;

    /**
     *
     */
    public function __construct()
    {
        // framework
        $this->f3 = \Base::instance();

        // set framework into view scope
        $this->f3->set('f3', $this->f3);

        // helper - get active template path from session
        $this->f3->set('getAssetPath', function($params = [], $type = 'css') {
            //
            if (isset($_SESSION['template_path'])) {
                //
                if (isset($_SESSION['template_id']) && is_numeric($_SESSION['template_id'])) {
                    $template = $_SESSION['template_path'].$_SESSION['template_id'].'/'.$type.'/'.basename($params['filename']);
                }
                //
                else {
                    $template = 'app/template/default/'.$type.'/'.basename($params['filename']);
                }

                // force to default
                if (isset($_GET['developer'])) {
                    $template = 'app/template/developer/'.$type.'/'.basename($params['filename']);
                }
            }
            //
            else {
                $template = 'app/template/default/'.$type.'/'.basename($params['filename']);
            }

            // check exists
            if (!file_exists($template)) {
                $template = '';
            }

            return $template;
        });
    }

    /**
     * CSS load & minify
     */
    public function css(\Base $f3, $params)
    {
        $path = $this->f3->get('getAssetPath')($params, 'css');

        if (empty($path)) {
            $f3->error(404);
        }

        exit(\Web::instance()->send($path, 'text/css', 4096, false));
    }

    /**
     * JS load & minify
     */
    public function js(\Base $f3, $params)
    {
        $path = $this->f3->get('getAssetPath')($params, 'js');

        if (empty($path)) {
            $f3->error(404);
        }

        exit(\Web::instance()->send($path, 'application/javascript', 4096, false));
    }

    /**
     * Dist load & send
     */
    public function dist(\Base $f3, $params)
    {
        $path = $this->f3->get('getAssetPath')($params, 'dist');

        if (empty($path)) {
            $f3->error(404);
        }
        
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        
        $mime = null;
        if ($ext == 'css') {
            $mime = 'text/css';
        }
        
        if ($ext == 'js') {
            $mime = 'application/javascript';
        }

        exit(\Web::instance()->send($path, $mime, 4096, false));
    }

    /**
     * Dist load & send
     */
    public function img(\Base $f3, $params)
    {
        $path = $this->f3->get('getAssetPath')($params, 'img');

        if (empty($path)) {
            $f3->error(404);
        }

        exit(\Web::instance()->send($path, null, 4096, false));
    }
    
    /**
     * Fonts load & send
     */
    public function fonts(\Base $f3, $params)
    {
        $path = $this->f3->get('getAssetPath')($params, 'fonts');

        if (empty($path)) {
            $f3->error(404);
        }

        exit(\Web::instance()->send($path, null, 4096, false));
    }

    /**
     * Favicon load & send
     */
    public function favicon(\Base $f3, $params)
    {
        $path = $this->f3->get('getAssetPath')($params, 'img');

        if (empty($path)) {
            $f3->error(404);
        }

        exit(\Web::instance()->send($path, null, 4096, false));
    }

}