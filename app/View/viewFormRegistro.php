<?php   

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if($_SESSION !=[]){
        if (isset($_SESSION['Id'])) {
            header('Location:'.URL_PATH.'/index.php?controller=homeController&action=mostrarHome');
            exit();
        }
    }


    //Rutas
    $css = URL_PATH.'/assets/css/styles.css';
    $action = URL_PATH.'/index.php?controller=usuarioController&action=registrarUsuario';
    $login =URL_PATH.'/index.php?controller=usuarioController&action=loginUsuario';
    $js = URL_PATH.'/js/registro-script.js';
    $img = URL_PATH.'/assets/img/';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap');
    </style>
    <link href="<?php echo $css; ?>" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="<?php echo $img;?>Logo e-Bank.png">
    <title>Registro e-Bank</title>
</head>
<body>
    <main>
        <h1 class="titulo titulo-centrado">Registro e-Bank</h1>
        <hr>
        <form class="form" id="form-registro" method="POST" action="<?php echo $action; ?>">

                <label class="item-form" for="nombre">Nombre </label>
                <input class="item-form" type="text" id="nombre" name="nombre" autocomplete="name" required/>
                    <p class="aviso-off" id="avisoNombre"> *El campo nombre es necesario, debe contener solamente letras</p>
                
                <label class="item-form" for="Apellido">Apellido </label>
                <input class="item-form" type="text" id="apellido" name="apellido" autocomplete="family-name" required/>
                    <p class="aviso-off" id="avisoApellido"> *El campo apellido es necesario, debe contener solamente letras</p>
                
                <label class="item-form" for="correo">Correo </label>
                <input class="item-form" type="email" id="correo" name="email" autocomplete="email" required/>
                    <p class="aviso-off" id="avisoEmail"> *El campo correo es necesario, debe ser un formato de correo valido. <br> Ej: juan@gmail.com</p>
                
                <label class="item-form" for="password">Contraseña </label>
                <input class="item-form" type="password" id="password" name="password" autocomplete="new-password" required/>
                    <p class="aviso-off" id="avisoPassword"> *El campo contraseña es necesario, debe contener entre 8 y 20 digitos, <br>mayusculas, minusculas y al menos un número, sin caracteres especiales.</p>
                
                <label class="item-form" for="confirmacion">Confirmación de contraseña </label>
                <input class="item-form" type="password" id="passwordCh" name="passwordCh" autocomplete="new-password" required/>
                    <p class="aviso-off" id="avisoConfirmacion"> *El campo confirmacion es necesario y debe coincidir con el campo contraseña</p>
                
                <input class="item-form" type="submit" value="Registrarse"/>
        </form>
        <?php
        // Mostrar errores si existen
            if (!empty($errores)) {
                echo "<p style='color:red; text-align:center;'>$errores</p>";
            }
            if (isset($errores)) {
                echo $errores;
            }
            if (!empty($aciertos)) {
                echo "<p style='color:green; text-align:center;'>$aciertos</p>";
            }
        ?>
        <hr>
        
        <h3 class="titulo titulo-centrado">¿Ya eres usuario? <a href="<?php echo $login;?>"> Acceder </a></h3>
    </main>
    
    <script src="<?php echo $js; ?>"></script>
</body>
</html>