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

//RUTAS
$css = URL_PATH.'/assets/css/styles.css';
$action = URL_PATH.'/index.php?controller=usuarioController&action=loginUsuario';
$js = URL_PATH.'/js/login-script.js';
$img = URL_PATH.'/assets/img/';
$registro = URL_PATH.'/index.php?controller=usuarioController&action=registrarUsuario';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap');
    </style>
    <link href=<?php echo $css;?> rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="<?php echo $img;?>Logo e-Bank.png">
    <title>E-Banking</title>
</head>
<body>
    <header class="header-login" >
        <div class="logo-login">
            <img src="<?php echo $img;?>Logo e-Bank.png" alt="Logo e-Bank"/>
        </div>
    </header>
    <main>
        <h1 class="titulo titulo-centrado">Acceso a e-Bank</h1>
        <hr>
        
        <?php if(isset($_SESSION['mensajeExitoRegistro'])):?>
            <div>
                 <p class="mensajeExito"> <?php echo $_SESSION['mensajeExitoRegistro'] ?> </p>
                <?php unset( $_SESSION['mensajeExitoRegistro'] );?>
            </div>
        <?php endif?>
        <form class="form" id="form-login" method="POST" action="<?php echo $action; ?>">
    
                <label class="item-form" for="correo">Correo </label>
                <input class="item-form" type="email" id="correo" name="email" autocomplete="username" required/>
                    <p class="aviso-off" id="avisoEmail"> *El campo correo es necesario, debe ser un formato de correo valido. <br> Ej: juan@gmail.com</p>

                <label class="item-form" for="password">Contraseña </label>
                <input class="item-form" type="password" id="password" name="password" autocomplete="current-password" required/>
                    <p class="aviso-off" id="avisoPassword"> *El campo contraseña es necesario, debe contener al menos 8 digitos, <br>mayusculas, minusculas y al menos un número, sin caracteres especiales.</p>
                
                <input class="item-form" type="submit" value="Acceder"/>

                <?php if(isset($errorLogin)):?>
            <div class="mensajeError">
                <?php echo $errorLogin; ?>
            </div>
         <?php endif?>
        </form>
        
        <hr>
        <h3 class="titulo titulo-centrado">¿No eres usuario? <a href="<?php echo $registro;?>"> Regístrate </a></h3>       
    </main>
    <script src="<?php echo $js;?>"></script>
</body>
</html>