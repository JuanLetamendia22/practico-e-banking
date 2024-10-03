<?php
require_once (dirname(__FILE__,3) ."/config/paths.php");
require_once ROOT_PATH."/config/conexionBD.php";
require_once ROOT_PATH.'/app/Controllers/validaciones.php';

function transferirInicio(){

    require_once ROOT_PATH.'/app/Model/cuentasModel.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $cuenta= new Cuenta($_SESSION['Email']);

    $_SESSION['NroCuenta']= $cuenta->getNroCuenta();
    $_SESSION['Saldo']= $cuenta->getSaldo();

    require_once ROOT_PATH."/app/View/viewHome.php";

}

function transferirVerificarCuenta(){

    require_once ROOT_PATH.'/app/Model/cuentasModel.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    //TODO Comprobar datos enviados por post, luego agregarlos como argumentos en la creacion del usuario, para sacar el nombre y apellido del destinatario
    $usuario= new Usuario();

    $_SESSION['NroCuenta']= $cuenta->getNroCuenta();
    $_SESSION['Saldo']= $cuenta->getSaldo();

    require_once ROOT_PATH."/app/View/viewHome.php";

}




?>