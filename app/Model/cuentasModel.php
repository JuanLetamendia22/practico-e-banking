<?php

/**
 * Permite realizar funciones sobre las cuentas
 */
class Cuenta extends ConexionBD{
 
    private $NroCuenta;

    private $saldo;

    private $transacciones;

    private $conexion;
    /**
     * Si se ingresa el email permite obtener los atributos del objeto de la base de datos
     * @param mixed $email string o null por defecto
     */
    public function __construct($email=null){
        parent::__construct();
        $this -> conexion = $this -> obtenerConexion();

        if($email!=null){
            $cuentaMom=$this->obtenerCuentaBD($email);
            $this->NroCuenta=$cuentaMom['NroCuenta'];
            $this->saldo=$cuentaMom['Saldo'];
        }
    }

    /**
     * Permite obtener la cuenta del usuario en la base de datos de acuerdo a la coincidencia con el nro de cuenta y el email introducido
     * Funcion privada solo utilizada para obtener los atributos en el constructor
     * @param string $email
     * @return mixed array o false
     */
    private function obtenerCuentaBD($email){

        $sql = "SELECT * FROM cuentas AS c JOIN usuarios AS u ON u.NroCuenta = c.NroCuenta WHERE u.Email = :Email";
        $stmt = $this -> conexion ->prepare($sql);
     
          
      $stmt->execute([':Email' => $email]);
     
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
/**
 * Permite realizar funciones relacionadas con las transferencias como: realizar transferencias y listar transferencias
 */
class Transaccion extends ConexionBD{
    private $idTransaccion;
    private $cuentaOrigen;
    private $cuentaDestino;
    private $fecha;
    private $monto;
    private $concepto;
    private $conexion;
    /**
     * Constructor de la clase, permite atributos null, si se rellena el constructor debe ser con todos los parametros
     * en el caso contrario no se rellenaran los atributos de la instancia.
     * @param mixed $cuentaOrigen
     * @param mixed $cuentaDestino
     * @param mixed $monto
     * @param mixed $concepto
     */
    public function __construct($cuentaOrigen=null,$cuentaDestino=null,$monto=null, $concepto=null){
        parent::__construct();
        $this -> conexion = $this -> obtenerConexion();

        if($cuentaOrigen !=null && $cuentaDestino !=null && $monto !=null && $concepto !=null ){
            $this -> cuentaOrigen= $cuentaOrigen;
            $this -> cuentaDestino= $cuentaDestino;
            $this -> monto= $monto;
            $this -> concepto= $concepto;
        }
    }
    /**
     * Utiliza las variables de la instancia de la clase, si se utiliza sin un constructor poblado retorna falso
     * en caso de exito retorna true
     * @return bool
     */
    public function realizarTransferencia(){
        if($this->cuentaOrigen !=null && $this->cuentaDestino !=null && $this->monto !=null && $this->concepto !=null ){
            try{
               $this->conexion->beginTransaction();

               //Obtener la fecha actual
               $this->fecha= date('Y-m-d');

            $sql = "INSERT INTO transacciones (NroCuentaOrigen, NroCuentaDestinatario, Fecha, Monto, Concepto) VALUES (:NroCuentaOrigen, :NroCuentaDestinatario, :Fecha, :Monto, :Concepto)";
            $stmt = $this->conexion->prepare($sql);

            $stmt->execute([
                ':NroCuentaOrigen' => $this->cuentaOrigen,
                ':NroCuentaDestinatario' => $this->cuentaDestino,
                ':Fecha' => $this->fecha,
                ':Monto'=> $this->monto,
                ':Concepto' => $this->concepto
            ]);

            $sqlCuentaOrigen= "UPDATE cuentas SET saldo = saldo - :monto WHERE NroCuenta = :NroCuenta";
            $stmtCuOrigen= $this->conexion->prepare($sqlCuentaOrigen);

            $stmtCuOrigen->execute([
                ':monto' => $this->monto,
                ':NroCuenta' => $this->cuentaOrigen
            ]);
            

            $sqlCuentaDestino= "UPDATE cuentas SET saldo = saldo + :monto WHERE NroCuenta = :NroCuenta";
            $stmtCuDestino= $this->conexion->prepare($sqlCuentaDestino);

            $stmtCuDestino->execute([
                ':monto' => $this->monto,
                ':NroCuenta' => $this->cuentaDestino
            ]);


            $this->conexion->commit();

                return true;
            }catch (Exception $e) {       
                // Revertir transaccion
                $this->conexion->rollBack();

                echo "Error: ". $e -> getMessage();
            } 
        }else{
            return false;
        }
    }

    /**
     * Lista las transferencias de acuerdo a el nro de cuenta introducido
     * TODO: Agregar paginacion de 10 elementos por pagina
     * @param string $nroCuenta
     * @return mixed array o false
     */
    public function listarTransferencias($nroCuenta){

        $sql = "SELECT t.IdTransaccion, t.NroCuentaOrigen, t.NroCuentaDestinatario, t.Fecha, t.Monto, t.Concepto FROM transacciones AS t JOIN usuarios AS u ON u.NroCuenta = t.NroCuentaOrigen WHERE u.NroCuenta = :NroCuenta";
        $stmt = $this -> conexion ->prepare($sql);
     
            
      $stmt->execute([':NroCuenta' => $nroCuenta]);
     
    
      $transferencias = $stmt->fetchAll(PDO::FETCH_ASSOC);

      return $transferencias;

    }
}
?>