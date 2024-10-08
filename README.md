# Practico E-Banking
Realizado por: **Juan Letamendía y Erick Marcoff**
------------------
### Tecnologias utilizadas
- Lenguajes de programacion: PHP y Javascript
- Lenguajes de marcado: HTML y CSS
- IDE: Visual Studio Code
- Control de versiones: Git
- Base de datos y gestor: Relacional - MariaDB
--------------

### Usuarios y contraseñas de prueba

 - Usuario 1: prueba@gmail.com - Contraseña: "Usuario1" -> Sin comillas
 - Usuario 2: prueba2@gmail.com - Contraseña: "Usuario2" -> Sin comillas

----------------
### Funciones principales

##### Funciones relacionadas con el usuario
---------------
- registrarCuenta() : Genera un numero de cuenta random, para realizar esta función nos informarmos sobre las funciones mt_rand() para generar un numero random, pow() para generar el máximo limite superior introduciendo solo una cantidad de un digito, str_pad() para rellenar el string de la cuenta con 0 a la izquierda hasta llegar a 24 digitos, tambien realiza una llamada a una función interna existeNroCuenta().

- existeNroCuenta($nroCuenta) : Consulta en la base si existe la cuenta en la base de datos, toma un número de cuenta y ejecuta una sentencia select sencilla.

- registrarUsuario($email, $nombre, $apellido, $password) : Registra al usuario en la base datos, para ello realiza una llamada interna a la función registrarCuenta(), para realizar esta función nos informamos sobre las transacciones de base de datos en php, realizando dos insert, un commit todo esto dentro de un bloque try-catch para atrapar las excepciones.

- loginUsuario($email, $password) : Login estandar ya trabajado en clases.

##### Funciones relacionadas con las cuentas
--------------------------

- constructor($email = null): Para realizar el constructor nos informamos sobre la incapacidad de php para realizar sobrecarga de constructores y como suplirlo con argumentos con valores por default. De ingresar un email realiza una llamada interna a un metodo(obtenerCuentaBD($email)) de la clase que obtiene, utilizando el email, los datos de la base de datos.

- obtenerCuentaBD($email) : Realiza una sentencia select simple que consulta la coincidencia entre el nroCuenta en la tabla cuentas y el nroCuenta en la tabla usuario donde el email de la tabla usuario coincide con el email ingresado.

##### Funciones relacionadas con las transferencias
--------------

- constructor($cuentaOrigen=null,$cuentaDestino=null,$monto=null, $concepto=null) : Utilizando lo aprendido anteriormente dependiendo de las entradas el tipo de objeto obtenido.

- realizarTransferencia() : Utiliza los atributos del objeto para realizar la transferencia, de no tener los atributos devuelve false y no realiza la transacción.

-listarTransferencias() : Lista las transferencias hechas por el usuario, no muestra las transacciones recibidas. 
