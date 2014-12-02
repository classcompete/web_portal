<?php
// Include the main Propel script

require_once dirname(__FILE__).'/../../../propel/runtime/lib/Propel.php';
Propel::init(dirname(__FILE__).'/../../../ccomp/build/conf/classcompete-conf.php');
set_include_path(dirname(__FILE__).'/../../../ccomp/build/classes' . PATH_SEPARATOR . get_include_path());

$config = array(
    'properl' => '1.6.6',
);