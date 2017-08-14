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
                    $template = 'app/template/'.$type.'/'.basename($params['filename']);
                }
                
                // force to default
                if (isset($_GET['default'])) {
                    $template = 'app/template/'.$type.'/'.basename($params['filename']);
                }
            } 
            //
            else {
                $template = 'app/template/'.$type.'/'.basename($params['filename']);
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
        exit( \Web::instance()->send(
            $this->f3->get('getAssetPath')($params, 'css'), 'text/css', 1024, false
        ));
    }

	/**
     * JS load & minify
     */
    public function js(\Base $f3, $params)
    {
        exit( \Web::instance()->send(
            $this->f3->get('getAssetPath')($params, 'js'), null, 1024, false
        ));
    }

	/**
     * Dist load & send
     */
    public function dist(\Base $f3, $params)
    {
        exit( \Web::instance()->send(
            $this->f3->get('getAssetPath')($params, 'dist'), null, 1024, false
        ));
    }

	/**
     * Dist load & send
     */
    public function img(\Base $f3, $params)
    {
        exit( \Web::instance()->send(
            $this->f3->get('getAssetPath')($params, 'img'), null, 1024, false
        ));
    }

}