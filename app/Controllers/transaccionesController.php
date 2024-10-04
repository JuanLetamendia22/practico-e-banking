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
    require_once ROOT_PATH.'/app/Model/usuarioModel.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['cuentaDestino'])){

        $cuenta= htmlspecialchars($_POST['cuentaDestino']);
        $errores= verificarFormatoCuenta($cuenta);

        if($errores==""){
        $usuario= new Usuario($cuenta);
            if(($usuario->getNombre()&&$usuario->getApellido())!=null){

                $_SESSION["nombreDestinatario"]=$usuario->getNombre();
                $_SESSION["apellidoDestinatario"]=$usuario->getApellido();
                $_SESSION["cuentaDestinatario"]=$cuenta;
        }else{
                $_SESSION["nombreDestinatario"]="";
                $_SESSION["apellidoDestinatario"]="";
                $_SESSION["cuentaDestinatario"]="";
            require_once ROOT_PATH."/app/View/viewHome.php";
        }

    }
    

    require_once ROOT_PATH."/app/View/viewHome.php";

    }
}



?>