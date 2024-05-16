<?php

class WebAPI
{
    public function __construct()
    {
        // if (php_sapi_name() == "cli") {
        //     global $__site_config;
        //     $__site_config_path = "/home/sibidharan/htdocs/photogram/project/photogramconfig.json";
        //     $__site_config = file_get_contents($__site_config_path);
        // //print($__site_config);
        // } elseif (php_sapi_name() == "apache2handler") {
        //     global $__site_config;
        //     $__site_config_path = dirname(is_link($_SERVER['DOCUMENT_ROOT']) ? readlink($_SERVER['DOCUMENT_ROOT']) : $_SERVER['DOCUMENT_ROOT']).'/project/photogramconfig.json';
        //     $__site_config = file_get_contents($__site_config_path);
        // }
        // print(__DIR__);
        global $__site_config;
        $__site_config_path = __DIR__ . '/../../../../workspace/cinemateconfig.json';
        $__site_config = file_get_contents($__site_config_path);
        Database::getConnection();
    }

    public function initiateSession()
    {
        Session::start();
        // $__base_path = get_config('base_path');
    }
}
