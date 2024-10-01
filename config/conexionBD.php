<?php
class ConexionBD{
     private $host = 'mysql:host=localhost';
     private $dbname = 'dbname=banco';
     private $username = 'root';
     private $password = '';
     private $conexion;

     public function __construct(){
      try {
       $this -> conexion = new PDO($this -> host.";".$this -> dbname, $this -> username, $this -> password);
       $this -> conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       } catch (PDOException $e) {
             die("Error connecting to the database: " . $e->getMessage());
       }
     
      }

      public function obtenerConexion(){
            return $this -> conexion;
      }


}


?>