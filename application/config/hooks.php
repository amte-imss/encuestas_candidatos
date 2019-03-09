<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

//$hook['post_controller_constructor'] = array(
//    'function' => 'login',
//    'class'    => 'Iniciar_sesion',
//    'filename' => 'hooks.php',
//    'filepath' => 'hooks'
//);
$hook['post_controller_constructor'] = array(
    'function' => 'load',
    'class'    => 'LoaderSIED',
    'filename' => 'LoaderSIED.php',
    'filepath' => 'hooks'
);

$hook['pre_controller'] = array(
    'function' => 'pre',
    'class'    => 'LoaderSIED',
    'filename' => 'LoaderSIED.php',
    'filepath' => 'hooks'
);
