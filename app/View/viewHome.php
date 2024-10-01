<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
    }
    if($_SESSION !=[]){
        if (!isset($_SESSION['Id'])) {
            header('Location:'.URL_PATH.'/index.php?controller=homeController&action=mostrarLogin');
            exit();
        }
    }else{
        header('Location:'.URL_PATH.'/index.php?controller=homeController&action=mostrarLogin');
        exit();
    }

//RUTAS
$css = URL_PATH.'/assets/css/styles.css';
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
    <link href=<?php echo $css;?> rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="<?php echo $img;?>Logo e-Bank.png">
    <title>E-Banking</title>
</head>
<body>
    <header class="header-login" >
        <div class="logo-login">
            <img src="<?php echo $img;?>Logo e-Bank.png" alt="Logo e-Bank"/>
        </div>
        <nav>
            <ul>
            <li><a href=<?php echo URL_PATH.'/index.php?controller=usuarioController&action=logoutUsuario'?>><img src="<?php echo $img;?>logout.png" alt="Logout" class="user"></a></li>
            <li><a href=<?php echo URL_PATH.'/index.php?controller=homeController&action=mostrarTransacciones'?>><img src="<?php echo $img;?>transaccion.png" alt="Historial de transacciones" class="user"></a></li>
        </ul>
        </nav>
        <h1 class="titulo titulo-centrado">Transacciones bancarias</h1>
        <hr>
    </header>
    
    <main>
              
    </main>
</body>
</html>