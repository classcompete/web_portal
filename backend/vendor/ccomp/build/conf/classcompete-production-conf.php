<?php
// This file generated by Propel 1.6.6-dev convert-conf target
// from XML runtime conf file D:\workspace\classcompete\vendor\ccomp\runtime-conf.xml
$conf = array (
  'datasources' => 
  array (
    'classcompete' => 
    array (
      'adapter' => 'mysql',
      'connection' => 
      array (
        'dsn' => 'mysql:host=50.56.216.210;dbname=class_compete',
        'user' => 'webdev',
        'password' => 'cl@sscomp3t3!@#',
      ),
    ),
    'default' => 'classcompete',
  ),
  'generator_version' => '1.6.6-dev',
);
$conf['classmap'] = include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classmap-classcompete-conf.php');
return $conf;