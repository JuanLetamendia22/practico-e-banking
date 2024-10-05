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

    $_SESSION['nroCuenta']= $cuenta->getNroCuenta();
    $_SESSION['saldo']= $cuenta->getSaldo();

    require_once ROOT_PATH."/app/View/viewHome.php";

}

function transferirVerificarCuenta(){

    require_once ROOT_PATH.'/app/Model/cuentasModel.php';
    require_once ROOT_PATH.'/app/Model/usuarioModel.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['cuentaDestino'])){

        $cuentaDestinatario= htmlspecialchars($_POST['cuentaDestino']);
        $errores= verificarFormatoCuenta($cuentaDestinatario);

        if($errores!=""){
            
        $nombreDestinatario="";
        $cuentaDestinatario="";
        $cuentaInexistente="Usted no ha ingresado un formato de cuenta correcto, las cuentas estan conformadas por 24 digitos"; 

    }else{
        $usuario= new Usuario($cuentaDestinatario);

        if(($usuario->getNombre()&&$usuario->getApellido())!=null){

            $nombreDestinatario= $usuario->getNombre();
            $nombreDestinatario.=" ".$usuario->getApellido();
        }else{
            $nombreDestinatario="";
            $cuentaDestinatario="";

            $cuentaInexistente="La cuenta que usted ha ingresado no se encuentra en el sistema.<br> Vuelva a hacer click en la opcion transferir e ingrese un numero de cuenta correcto";
           
        require_once ROOT_PATH."/app/View/viewHome.php";
    }
    }

    require_once ROOT_PATH."/app/View/viewHome.php";

    }
        $nombreDestinatario="";
        $cuentaDestinatario="";

        $cuentaInexistente="La cuenta que usted ha ingresado no se encuentra en el sistema.<br> Vuelva a hacer click en la opcion transferir e ingrese un numero de cuenta correcto";

    require_once ROOT_PATH."/app/View/viewHome.php";
}

function transferirFinal(){
    require_once ROOT_PATH.'/app/Model/cuentasModel.php';
    require_once ROOT_PATH.'/app/Model/usuarioModel.php';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && (!empty($_POST['monto'] || $_POST['monto']==0))){

        $cuentaOrigen= $_POST['cuentaOrigen'];
        $saldoCuenta= $_POST['saldo'];
        $cuentaDestino= $_POST['cuentaDestino'];
        $montoTransferir= $_POST['monto'];
        $concepto="";
        $errores= verificarFormatoMonto($montoTransferir);
      
        if($errores!=""){
            $errores.="<br> Transacción fallida";
            require_once ROOT_PATH."/app/View/viewHome.php";
        }else{
            if($saldoCuenta<$montoTransferir){
                $errores.= "Monto introducido supera el saldo de la cuenta <br>Transacción fallida";
                require_once ROOT_PATH."/app/View/viewHome.php";
            }else{
                $transferencia = new Transaccion($cuentaOrigen,$cuentaDestino,$montoTransferir, $concepto);
                $transferencia->realizarTransferencia();
                require_once ROOT_PATH."/app/View/viewHome.php";
            }


        }

    }else{
        
        $noIngresaMonto="No ha ingresado un monto para realizar la transaccion";
        require_once ROOT_PATH."/app/View/viewHome.php";

    }

}



?>