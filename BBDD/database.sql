
CREATE DATABASE BANCO;

CREATE TABLE CUENTAS(
     NroCuenta varchar(24) NOT NULL PRIMARY KEY,
    Saldo DOUBLE(9,2));

CREATE TABLE USUARIOS(
    Id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    NroCuenta varchar(24) NOT NULL,
    Email varchar(100),
    password varchar(255),
    Nombre varchar(50),
    Apellido varchar(50),
    FOREIGN KEY(NroCuenta) REFERENCES CUENTAS(NroCuenta));

 CREATE TABLE TRANSACCIONES(
    IdTransaccion int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    NroCuentaOrigen varchar(24) NOT NULL,
    NroCuentaDestinatario varchar(24) NOT NULL,
    Fecha DATE NOT NULL,
    Monto DOUBLE(9,2),
    Concepto varchar(200),
    FOREIGN KEY(NroCuentaOrigen) REFERENCES CUENTAS(NroCuenta),
    FOREIGN KEY(NroCuentaDestinatario) REFERENCES CUENTAS(NroCuenta));