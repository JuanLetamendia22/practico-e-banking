<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
    }
    if($_SESSION !=[]){
        if (!isset($_SESSION['Id'])) {
            header('Location:'.URL_PATH.'/index.php?controller=homeController&action=mostrarLogin');
            exit();
        }else{
           $nombre= $_SESSION['Nombre']." ".$_SESSION['Apellido'];
           $nroCuenta= $_SESSION['NroCuenta'];
           $saldo= $_SESSION['Saldo'];
        }
    }else{
        header('Location:'.URL_PATH.'/index.php?controller=homeController&action=mostrarLogin');
        exit();
    }

//RUTAS
$css = URL_PATH.'/assets/css/styles.css';
$img = URL_PATH.'/assets/img/';
$actionValidarCuenta= URL_PATH.'/index.php?controller=transaccionesController&action=transferirVerificarCuenta';
$verHistorial= URL_PATH."/index.php?controller=homeController&action=mostrarTransacciones";
$transferir= URL_PATH.'/index.php?controller=transaccionesController&action=transferirIncio';
$logout= URL_PATH."/index.php?controller=usuarioController&action=logoutUsuario";
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
            <li><a href=<?php echo $logout; ?>><img src="<?php echo $img;?>logout.png" alt="Logout" class="user"></a></li>
            <li><a href=<?php echo $transferir; ?>><img src="<?php echo $img;?>transfer.png" alt="Transferir" class="user"></a></li>
            <li><a href=<?php echo $verHistorial;?>><img src="<?php echo $img;?>historial.png" alt="Historial de transacciones" class="user"></a></li>
        </ul>
        </nav>
        <h1 class="titulo titulo-centrado">Sistema de transacciones bancarias</h1>
        <hr>
    </header>
    <main>
        <?php switch($_GET['action']): ?>
<?php case 'mostrarHome':?>
            <h2 class='titulo titulo-centrado'>Bienvenid@ $nombre</h2>
            <p class='texto-centrado'>Si lo deseas, en el menú superior tienes una serie de opciones para elegir, puedes realizar una transferencia <br> ver el historial de transferencias o si entraste accidentalmente puedes desloguearte.</p>
<?php case 'transferirInicio':?>
        <h2 class='titulo titulo-centrado'>Transferir</h2>
        <form method="POST" action="<?php echo $actionValidarCuenta;?>">
            <div class="form-transferir">
                <label for="cuentaOrigen">Cuenta Origen</label>
                <input type="text" id="cuentaOrigen" name="cuentaOrigen" readonly value="<?php echo $nroCuenta;?>">
                
                <label for="saldo">Saldo</label>
                <input type="text" id="saldo" name="saldo" readonly value="<?php echo $saldo;?>">
            </div>

            <div class="form-transferir-destino">
                <label for="cuentaDestino">Insertar cuenta destino</label>
                <input type="text" id="cuentaDestino" name="cuentaDestino">
            </div>
            <div class="form-submit">
                <input type="submit" value="Verificar cuenta de destino">
            </div>
        </form>
<?php case 'transferirVerificarCuenta':?>
<?php endswitch ?>
        

        
        
    </main>
</body>
</html>