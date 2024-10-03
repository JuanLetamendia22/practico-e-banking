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

    //Hereda la conexion a BD
    public function __construct($nroCuenta=null){
        parent::__construct();
        $this -> conexion = $this -> obtenerConexion();

        if($nroCuenta!=null){
            $usuarioMom= $this->obtenerUsuarioBDporNroCuenta($nroCuenta);
            $this->nombre=$usuarioMom["Nombre"];
            $this->apellido=$usuarioMom["Apellido"];
            $this->email=$usuarioMom["email"];
            $this->nroCuenta=$nroCuenta;
        }
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

    //Logica para incorporar los datos a la BD

    private function registrarCuenta() {
        $min = 0;
        $max = (int) pow(10,24)-1;

        $nroCuenta =mt_rand($min,$max);

        if($this->existeNroCuenta($nroCuenta)){
            //Recursividad si el nro ya existe.
            $this->registrarCuenta();
            
        }else{
           
            $nroCuenta= (string) $nroCuenta;
            //Formateo el numero para que si es un numero random menor de 24 digitos, se rellene con 0 a la izquierda
            $numeroFormateado = str_pad( $nroCuenta, 24, '0', STR_PAD_LEFT);
            
            return $numeroFormateado;
            
            
        }


    }
    
    

    public function registrarUsuario($email, $nombre, $apellido, $password) {
        try{
           
            $this->conexion->beginTransaction();

            // Comprobar si el email ya está registrado
            if ($this->existeEmail($email)) {
                return false;
            }
            //Insertar cuenta en cuentas
            $nroCuenta= $this->registrarCuenta();
            
            $sqlCuenta = "INSERT INTO cuentas (NroCuenta) VALUES (:NroCuenta)";
            $stmtCuenta = $this->conexion->prepare($sqlCuenta);

            $stmtCuenta->execute([':NroCuenta' => $nroCuenta]);
            
            
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
                } 
    }

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