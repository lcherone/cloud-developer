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
    }
    
	/**
     * CSS load & minify
     */
    public function css(\Base $f3, $params)
    {
        if (isset($_SESSION['template_id'])) {
            $template = 'tmp/template/'.$_SESSION['template_id'].'/css/'.basename($params['filename']);
        } else {
            $template = 'app/template/css/'.basename($params['filename']);
        }
        exit(\Web::instance()->minify(
            $template
        ));
    }

	/**
     * JS load & minify
     */
    public function js(\Base $f3, $params)
    {
        if (isset($_SESSION['template_id'])) {
            $template = 'tmp/template/'.$_SESSION['template_id'].'/js/'.basename($params['filename']);
        } else {
            $template = 'app/template/js/'.basename($params['filename']);
        }
        exit(\Web::instance()->minify(
            $template
        ));
    }

	/**
     * Dist load & send
     */
    public function dist(\Base $f3, $params)
    {
        if (isset($_SESSION['template_id'])) {
            $template = 'tmp/template/'.$_SESSION['template_id'].'/dist/'.basename($params['filename']);
        } else {
            $template = 'app/template/dist/'.basename($params['filename']);
        }
        exit( \Web::instance()->send(
            $template, null, 1024, false
        ));
    }

	/**
     * Dist load & send
     */
    public function img(\Base $f3, $params)
    {
        if (isset($_SESSION['template_id'])) {
            $template = 'tmp/template/'.$_SESSION['template_id'].'/img/'.basename($params['filename']);
        } else {
            $template = 'app/template/img/'.basename($params['filename']);
        }

        exit( \Web::instance()->send(
            $template, null, 1024, false
        ));
    }

}