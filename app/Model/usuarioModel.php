<?php

class Usuario extends conexionBD
    {
    //Atributos del objeto usuario.
    private $nombre;
    private $apellido;
    private $email;
    private $password;
    private $nroCuenta;
    private $conexion;

    /**
     * Permite crear un usuario y acceder a sus funciones
     * con el parametro nroCuenta permite asignar al objeto los atributos correspondientes al 
     * usuario que posea dicho numero de cuenta.
     * @param mixed $nroCuenta
     */
    public function __construct($nroCuenta=null){
        parent::__construct();
        $this -> conexion = $this -> obtenerConexion();

        if($nroCuenta!=null){
           
            if($this->obtenerUsuarioBDporNroCuenta($nroCuenta)!=false){
                $usuarioMom= $this->obtenerUsuarioBDporNroCuenta($nroCuenta);
                $this->nombre=$usuarioMom["Nombre"];
                $this->apellido=$usuarioMom["Apellido"];
                $this->email=$usuarioMom["Email"];
                $this->nroCuenta=$nroCuenta;
            }
        }
    }


    public function getNombre(){
        return $this ->nombre;
    }
    public function getApellido(){
        return $this ->apellido;
    }
    private function existeEmail($email) {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch() !== false;
    }

    private function obtenerUsuarioBD($email){
        
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this-> conexion ->prepare($sql);
     
        // Ejecutar la consulta SQL, pasando el nombre de usuario como parámetro        
        $stmt->execute([':email' => $email]);
     
      // Obtener la fila del usuario de la base de datos
      $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

      return $usuario;
    }

    private function obtenerUsuarioBDporNroCuenta($nroCuenta){
        $sql = "SELECT * FROM usuarios WHERE NroCuenta = :NroCuenta";
        $stmt = $this-> conexion ->prepare($sql);
     
        // Ejecutar la consulta SQL, pasando el nombre de usuario como parámetro        
        $stmt->execute([':NroCuenta' => $nroCuenta]);
     
      // Obtener la fila del usuario de la base de datos
      $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

      return $usuario;

    }

    private function existeNroCuenta($nroCuenta){
        $sql = "SELECT NroCuenta FROM cuentas WHERE NroCuenta = :NroCuenta";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':NroCuenta' => $nroCuenta]);
        return $stmt->fetch() !== false;
    }
    /**
     * Crea un numero entero random entre 0 y 24 digitos
     * Luego comprueba que no exista en la base de datos
     * En caso de exito devuelve un string formateado para contener si o si 24 digitos 
     * @return string
     */
    private function registrarCuenta() {
        $longitud = 24; 
        $min = 0;
        $max = (int) pow(10, $longitud) - 1;
    
        do {
            $nroCuenta = mt_rand($min, $max);
        } while ($this->existeNroCuenta($nroCuenta));
    
        // Convertir a string y rellenar con ceros a la izquierda si es necesario.
        return str_pad((string) $nroCuenta, $longitud, '0', STR_PAD_LEFT);

    }
    
    
    /**
     * Realiza una transaccion a la base de datos y en caso de exito registra usuario y cuenta
     * Realiza una llamada a la función privada registrar cuenta
     * Retorna true en caso de exito de lo contrario devuelve falsew
     * @param string $email
     * @param string $nombre
     * @param string $apellido
     * @param string $password
     * @return bool
     */
    public function registrarUsuario($email, $nombre, $apellido, $password) {
        try{
           
            $this->conexion->beginTransaction();

            // Comprobar si el email ya está registrado
            if ($this->existeEmail($email)) {
                return false;
            }
            //Insertar cuenta en cuentas
            $nroCuenta= $this->registrarCuenta();
            
            $sqlCuenta = "INSERT INTO cuentas (NroCuenta, Saldo) VALUES (:NroCuenta, :Saldo)";
            $stmtCuenta = $this->conexion->prepare($sqlCuenta);

            $stmtCuenta->execute([
                ':NroCuenta' => $nroCuenta,
                ':Saldo'=>5000
            ]);
            
            
            // Insertar el nuevo usuario en la tabla usuarios
            $sql = "INSERT INTO usuarios (NroCuenta, Email, password, Nombre, Apellido) VALUES (:NroCuenta, :Email, :password, :Nombre, :Apellido)";
            $stmt = $this->conexion->prepare($sql);
            
            
            //Encriptar contraseña
            $passwordEnc = password_hash($password, PASSWORD_BCRYPT);

            $stmt->execute([
                ':NroCuenta' => $nroCuenta,
                ':Email' => $email,
                ':password' => $passwordEnc,
                ':Nombre'=> $nombre,
                ':Apellido' => $apellido
            ]);

            $this->conexion->commit();
            
            return true;

               }catch (Exception $e) {       
                    // Revertir transaccion
                    $this->conexion->rollBack();
                    
                    echo "Error: ". $e -> getMessage();
                    return false;
                } 
    }
    /**
     * Permite loguear usuarios, recibe email y contraseña como parametro
     * Devuelve el usuario en caso de exito de lo contrario devuelve false
     * @param string $email
     * @param string $password
     * @return mixed
     */
    public function loginUsuario($email, $password){
    
        if ($this->existeEmail($email)) {

            $usuario = $this->obtenerUsuarioBD($email);

                if (password_verify($password, $usuario['password'])) {
                // Si la contraseña coincide, devolver la información del usuario
                    return $usuario;
                }else{
                    return false;
                }
           
        }else{
            return false;
        }
    }
    
}



?>