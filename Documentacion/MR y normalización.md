# practico-e-banking

MR y Normalización e-Banking

**USUARIO**(ID(**PK**), NroCuenta(FK), Email, Contraseña, Nombre, Apellido)
**CUENTA**(NroCuenta(**PK**),Saldo)
**TRANSACCION**(IdTransaccion(**PK**), NroCuentaOrigen(**FK**), NroCuentaDestinatario(**FK**), Fecha, Monto, Concepto)

Considero que las tablas cumplen con la 3FN.