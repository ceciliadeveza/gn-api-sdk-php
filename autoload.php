<?php

spl_autoload_register('api_autoload');

require_once(__DIR__. '/vendor/autoload.php');

function api_autoload($class_name){
    $root = __DIR__.'/src/';

    $dirs = glob($root . '/*' , GLOB_ONLYDIR);
    $dirs = array_merge($dirs,glob($root.'/*/*', GLOB_ONLYDIR));
    $dirs[] = $root;

    foreach ($dirs as $dir) {
        $file = "$dir/$class_name.php";

        if (file_exists($file))  {
            require_once $file;
        }

    }
}