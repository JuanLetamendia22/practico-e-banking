<?php
require_once (dirname(__FILE__,3) ."/config/paths.php");
require_once ROOT_PATH."/config/conexionBD.php";
require_once ROOT_PATH.'/app/Controllers/validaciones.php';

function registrarUsuario(){
    require_once ROOT_PATH.'/app/Model/usuarioModel.php';
    require_once ROOT_PATH.'/app/View/viewFormRegistro.php';
    $errores=""; 
    $aciertos="";
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['passwordCh']) && !empty($_POST['nombre']) && !empty($_POST['apellido'])) {

        //Datos del form
        $email= htmlspecialchars($_POST['email']);
        $password= htmlspecialchars($_POST['password']);
        $passwordCh= htmlspecialchars($_POST['passwordCh']);
        $nombre = htmlspecialchars($_POST['nombre']);
        $apellido = htmlspecialchars($_POST['apellido']);

        //Se validan los campos
        $errores= validarFormRegistro($email,$nombre ,$apellido ,$password, $passwordCh);
        
        if ($errores != '') {
            // Si hay errores, pasarlos a la vista
            require_once ROOT_PATH.'/app/View/viewFormRegistro.php';
        } else {
            // Si no hay errores, interactuar con el modelo
            $usuario = new Usuario();
            if ($usuario->registrarUsuario($email, $nombre, $apellido, $password)) {
                
                $aciertos.="Usuario registrado correctamente";
                require_once ROOT_PATH.'/app/View/viewFormRegistro.php';
            } else {
                $errores.="Error al registrar el usuario, el email ya existe en la base de datos";
                require_once ROOT_PATH.'/app/View/viewFormRegistro.php';

            }
        }
        
    }
}

function loginUsuario(){
    require_once ROOT_PATH.'/app/Model/usuarioModel.php';
    require_once ROOT_PATH.'/app/View/viewFormLogin.php';   
    $errores="";
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email']) && !empty($_POST['password'])){
        
        $email= htmlspecialchars($_POST['email']);
        $password= htmlspecialchars($_POST['password']);

        $errores= validarFormLogin($email);

        if ($errores != '') {
            // Si hay errores, pasarlos a la vista
            require_once ROOT_PATH.'/app/View/viewFormLogin.php';
         } else {
            $usuario = new Usuario();
            $usuarioLogueado= $usuario ->loginUsuario($email, $password);
            
            if ($usuarioLogueado) {
                // Iniciar sesión de PHP para mantener al usuario autenticado
                session_start();

                $_SESSION['Id'] = $usuarioLogueado['Id'];
                $_SESSION['Nombre'] = $usuarioLogueado['Nombre'];
                $_SESSION['Apellido'] = $usuarioLogueado['Apellido'];
                $_SESSION['Email'] = $usuarioLogueado['Email'];

                  // Redirigir al usuario
                  header('Location:'.URL_PATH.'/index.php?controller=homeController&action=mostrarHome');
                  exit();

            }else {
                // Mostrar un mensaje de error
                $errores .= "El usuario al que intenta acceder no existe en la base de datos";
                require_once ROOT_PATH.'/app/View/viewFormLogin.php';
            }
         }

    }
}


function logoutUsuario(){

    // Iniciar la sesión si aun no está iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Destruir todas las variables de sesion
    $_SESSION = [];

    // Destruir la sesion
    session_destroy();

    // Redirigir a la página de login
    header("Location: index.php?controller=homeController&action=mostrarLogin");
    exit();
    }
?>