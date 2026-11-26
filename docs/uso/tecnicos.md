# Registro de técnicos

RF02 permite al administrador registrar un técnico con nombre e identificación obligatorios y correo electrónico opcional. Selecciona el tipo de documento y escribe el número. Las cédulas y la tarjeta de identidad aceptan solo dígitos. El pasaporte admite letras y números. El número de identificación no se puede repetir. Los avisos de validación conservan la información ingresada para corregirla.

La pantalla Técnicos muestra el formulario y los técnicos registrados. Registrar un técnico no crea una cuenta de acceso; esa operación corresponde a RF03, desde Cuentas.

El controlador TecnicosController recibe el formulario, RegistrarTecnicoRequest valida la entrada y RegistroTecnicos registra los datos dentro de una transacción. El servidor exige sesión y rol administrador.
