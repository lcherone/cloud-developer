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
            //dir
            $dir = (!empty($params['dir']) ? basename($params['dir']) : null);
            
            //filename
            $filename = (!empty($params['filename']) ? basename($params['filename']) : null);
            
            //
            if (!empty($dir)) {
                $filename = $dir.'/'.$filename;
            }
            
            //
            if (isset($_SESSION['template_path'])) {
                //
                if (isset($_SESSION['template_id']) && is_numeric($_SESSION['template_id'])) {
                    $template = $_SESSION['template_path'].$_SESSION['template_id'].'/'.$type.'/'.$filename;
                }
                //
                else {
                    $template = 'app/template/default/'.$type.'/'.$filename;
                }

                // force to default
                if (isset($_GET['developer'])) {
                    $template = 'app/template/developer/'.$type.'/'.$filename;
                }
            }
            //
            else {
                $template = 'app/template/default/'.$type.'/'.$filename;
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
        
        exit(\Web::instance()->send($path, null, 1024, false));
        //exit(\Web::instance()->minify($path, 'text/css'));
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

        exit(\Web::instance()->send($path, null, 1024, false));
        //exit(\Web::instance()->minify($path, 'application/javascript'));
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

        exit(\Web::instance()->send($path, null, 1024, false));
        //exit(\Web::instance()->minify($path, 'application/javascript'));
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

        exit(\Web::instance()->send($path, null, 1024, false));
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

        exit(\Web::instance()->send($path, null, 1024, false));
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

        exit(\Web::instance()->send($path, null, 1024, false));
    }

}