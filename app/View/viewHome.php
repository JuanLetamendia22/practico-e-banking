<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
    }
    if($_SESSION !=[]){
        if (!isset($_SESSION['Id'])) {
            header('Location:'.URL_PATH.'/index.php?controller=homeController&action=mostrarLogin');
            exit();
        }if(isset($_SESSION['Nombre'])){
            $nombre= $_SESSION['Nombre']." ".$_SESSION['Apellido'];
        }if(isset($_SESSION['nroCuenta']) && isset($_SESSION['saldo'])){
            $nroCuenta= $_SESSION['nroCuenta'];
            $saldo= $_SESSION['saldo'];
        }
    }else{
        header('Location:'.URL_PATH.'/index.php?controller=homeController&action=mostrarLogin');
        exit();
    }

//RUTAS
$css = URL_PATH.'/assets/css/styles.css';
$img = URL_PATH.'/assets/img/';
$actionRealizarTransferencia= URL_PATH.'/index.php?controller=transaccionesController&action=transferirFinal';
$actionValidarCuenta= URL_PATH.'/index.php?controller=transaccionesController&action=transferirVerificarCuenta';
$verHistorial= URL_PATH."/index.php?controller=homeController&action=mostrarTransacciones";
$transferir= URL_PATH.'/index.php?controller=transaccionesController&action=transferirInicio';
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
            <h2 class='titulo titulo-centrado'>Bienvenid@ <?php echo $nombre?></h2>
            <p class='texto-centrado'>Si lo deseas, en el menú superior tienes una serie de opciones para elegir, puedes realizar una transferencia <br> ver el historial de transferencias o si entraste accidentalmente puedes desloguearte.</p>
<?php break;?>
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
<?php break;?>
<?php case 'transferirVerificarCuenta':?>
    <form method="POST" action="<?php echo $actionRealizarTransferencia;?>">
            <div class="form-transferir">
                <label for="cuentaOrigen">Cuenta Origen</label>
                <input type="text" id="cuentaOrigen" name="cuentaOrigen" readonly value="<?php echo $nroCuenta;?>">
                
                <label for="saldo">Saldo</label>
                <input type="text" id="saldo" name="saldo" readonly value="<?php echo $saldo;?>">
            </div>

            <div class="form-transferir">
                <label for="cuentaDestino">Nro cuenta destino</label>
                <input type="text" id="cuentaDestino" name="cuentaDestino"  readonly value="<?php echo $cuentaDestinatario;?>">
            </div>

            <div class="form-transferir">
                <label for="destinatario">Nombre destinatario</label>
                <input type="text" id="destinatario" name="destinatario"  readonly value="<?php echo $nombreDestinatario; ?>">
            </div>
                <?php if(!isset($cuentaInexistente)):?>
                    <div class="form-transferir-destino">
                        <label for="monto">Monto a transferir</label>
                        <input type="text" id="monto" name="monto">
                    </div>
                    <div class="form-submit">
                        <input type="submit" value="Transferir">
                    </div>
                    <?php else:?>
                        <div class="mensajeError">
                            <?php echo "<p>$cuentaInexistente</p>"?>
                        </div>
                <?php endif?>
        </form>
    <?php break;?>
<?php case 'transferirFinal':?>
    <?php if(isset($errores) && $errores!=""):?>
        <div class="mensajeError">
            <?php echo "<p>$errores</p>" ?>
        </div>
    <?php else:?>
    
    <?php endif?>
<?php endswitch ?>
        

        
        
    </main>
</body>
</html>