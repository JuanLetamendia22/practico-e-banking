<?php

function validarFormLogin($email){
    $mensajeDeError='';

    //Email
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);  
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $mensajeDeError.='Usted ha ingresado un email no valido.<br>Ejemplo de email valido: juan@gmail.com';
    }
    
    return $mensajeDeError;
}

function validarFormRegistro($email,$nombre ,$apellido , $password, $passwordCh){
    $mensajeDeError='';
    $regexPassword = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{8,30}$/";
    $regexTexto="/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s']+$/";

    //Email
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);  
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $mensajeDeError.='Usted ha ingresado un email no valido.<br>Ejemplo de email valido: juan@gmail.com';
    }
    //Nombre y apellido
    if(!preg_match($regexTexto, $nombre)){
        $mensajeDeError.= 'El nombre ingresado no es correcto, el mismo no puede contener numeros o caracteres especiales';
    }

    if(!preg_match($regexTexto, $apellido)){
        $mensajeDeError.= 'El apellido ingresado no es correcto, el mismo no puede contener numeros o caracteres especiales';
    }


    //Password
    if(!preg_match($regexPassword, $password) || $password != $passwordCh){
        $mensajeDeError.='Hay un error en los campos relacionados con la contraseña.<br>Recuerde que la misma ha de ser de entre 8 y 30 caracteres y contener al menos 1 mayuscula, 1 minuscula y 1 numero';
    }

    return $mensajeDeError;
}

function verificarFormatoCuenta($cuenta){
    $regexFormatoCuenta="/^\d{24}$/";

    if (preg_match($regexFormatoCuenta, $cuenta)) {
        return "";
    } else {
        return "El formato de cuenta no es valido.";
    }
}

function verificarFormatoMonto($monto){
    $regexFormatoMonto= "/^\d+$/";

    if (preg_match($regexFormatoMonto, $monto)) {
        return "";
    } else {
        return "El formato de monto no es valido.";
    }
}
?>