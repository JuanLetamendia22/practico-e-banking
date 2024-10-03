<?php

class Cuenta extends ConexionBD{
 
    private $NroCuenta;

    private $saldo;

    private $transacciones;

    private $conexion;

    public function __construct($email=null){
        parent::__construct();
        $this -> conexion = $this -> obtenerConexion();

        if($email!=null){
            $cuentaMom=$this->obtenerCuentaBD($email);
            $this->NroCuenta=$cuentaMom['NroCuenta'];
            $this->saldo=$cuentaMom['Saldo'];   
        }
    }

    private function obtenerCuentaBD($email){

        $sql = "SELECT * FROM cuentas AS c JOIN usuarios AS u ON u.Email = :Email";
        $stmt = $this -> conexion ->prepare($sql);
     
    // Ejecutar la consulta SQL, pasando el nombre de usuario como parámetro        
      $stmt->execute([':Email' => $email]);
     
      // Obtener la fila del usuario de la base de datos
      $cuenta = $stmt->fetch(PDO::FETCH_ASSOC);

      return $cuenta;
    }


    public function getNroCuenta(){
        return $this -> NroCuenta;
    }

    public function getSaldo(){
        return $this -> saldo;
    }
}

class Transaccion extends ConexionBD{
    private $idTransaccion;
    private $cuentaOrigen;
    private $cuentaDestino;
    private $fecha;
    private $monto;
    private $concepto;
}
?>