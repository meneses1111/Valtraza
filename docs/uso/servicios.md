# Registro y asignación de servicios

RF06 permite al administrador seleccionar un cliente y uno de sus computadores, indicar la fecha, el nombre del servicio y el problema presentado. La validación comprueba también que el computador pertenezca al cliente seleccionado.

El servicio nace pendiente y sin técnico. Un observer genera su código, por ejemplo SRV-0001, y un código de seguimiento aleatorio de 32 caracteres. Valtraza envía el código al correo registrado del cliente y permite reenviarlo desde el comprobante. El comprobante sigue disponible para copiar o imprimir. Muestra la fecha del servicio y la hora en que se registró en Valtraza, en hora de Colombia. El cliente usa el código en la [consulta pública](consulta-publica.md).

En **Nuevo servicio**, selecciona el cliente y pulsa **Ver computadores**. Si aún no tiene un computador registrado, abre su ficha desde el enlace que muestra el formulario. La aplicación indica qué campos faltan para seguir y valida los datos en el servidor.

RF07 permite filtrar servicios con o sin técnico, asignar un técnico registrado y cambiar al encargado. La reasignación bloquea la fila, conserva el estado y los registros anteriores, y guarda la hora del cambio en el historial. Los cambios de estado también aparecen con su hora.

Los códigos consecutivos se coordinan con bloqueos de transacción de PostgreSQL. Si se presenta una colisión de códigos de servicio, la creación se reintenta en una nueva transacción.
