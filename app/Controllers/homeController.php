<?php
    require_once (dirname(__FILE__,3) ."/config/paths.php");

function mostrarLogin(){
    require_once ROOT_PATH.'/app/View/viewFormLogin.php';
}

function mostrarRegistro(){
    require_once ROOT_PATH.'/app/View/viewFormRegistro.php';
}

function mostrarHome(){
    require_once ROOT_PATH.'/app/View/viewHome.php';
}
?>