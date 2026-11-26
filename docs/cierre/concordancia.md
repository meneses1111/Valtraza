# Concordancia de Valtraza

La referencia funcional es la ERS definitiva 1.1 del 26 de octubre de 2026. La revisión del 21 de noviembre contrasta los talleres de diseño con las rutas, los controladores, los servicios y los modelos de `main` en `a60d061`. Las ejecuciones se documentan por versión en [Estado y evidencias](../pruebas/estado-y-evidencias.md).

## Requisitos funcionales

Las ubicaciones de controladores parten de `app/Http/Controllers` y las de servicios de `app/Services`.

| ERS | Módulo del diseño | Implementación de referencia |
| --- | --- | --- |
| RF01 | Cuentas y acceso | `AccesoController`, `Cuentas/Acceso` |
| RF02 | Técnicos | `Tecnicos/TecnicosController`, `Tecnicos/RegistroTecnicos` |
| RF03 | Cuentas y acceso | `CuentasController`, `Cuentas/Acceso` |
| RF04 | Clientes y equipos | `ClientesEquipos/ClientesController`, `RegistroClientesEquipos` |
| RF05 | Clientes y equipos | `ClientesEquipos/EquiposController`, `Servicios/FichaClienteController`, `Servicios/HistorialEquipos` |
| RF06 | Servicios | `Servicios/ServiciosController`, `Servicios/GestionServicios` |
| RF07 | Servicios | `Servicios/ServiciosController`, `Servicios/GestionServicios` |
| RF08 | Mantenimientos y reparaciones | `TrabajoTecnico/MisServiciosController`, `RegistroTrabajoTecnico`, `GestionServicios` |
| RF09 | Mantenimientos y reparaciones | `TrabajoTecnico/DiagnosticosController`, `RegistroTrabajoTecnico` |
| RF10 | Mantenimientos y reparaciones | `TrabajoTecnico/TrabajosController`, `RegistroTrabajoTecnico` |
| RF11 | Mantenimientos y reparaciones | `TrabajoTecnico/RepuestosController`, `RegistroTrabajoTecnico` |
| RF12 | Mantenimientos y reparaciones | `TrabajoTecnico/EstadosController`, `RegistroTrabajoTecnico`, `app/States/Servicios` |
| RF13 | Consulta y seguimiento | `Supervision/SupervisionController`, `Consulta/SupervisionServicios` |
| RF14 | Consulta y seguimiento | `Consulta/ConsultaController`, `Consulta/ConsultaPublica` |

## Lectura del diseño y del código

El Taller 1 representa seis módulos conceptuales. La implementación reparte sus operaciones entre varios controladores; la carpeta de un controlador no determina por sí sola la responsabilidad del módulo. `FichaClienteController`, ubicado en Servicios, compone la ficha del cliente con el historial. Los diagramas de módulos, capas, actores y datos responden preguntas distintas y no necesitan tener el mismo número de cajas.

El Taller 1 representa la supervisión en Consulta y seguimiento y las seis dependencias de consumo entre módulos. La creación de cuentas usa el registro de técnicos desde el controlador. Consulta pública obtiene el computador a través de Servicios. El controlador de supervisión consulta el padrón de técnicos para el filtro.

El Taller 2 se revisó para indicar varios controladores por módulo y nombrar al modelo `Trabajo`. Sus cinco capas se conservan. Los códigos se generan durante el registro. Los observers de avances emiten eventos después de confirmar la transacción. La petición que guarda redirige al detalle; las otras pantallas ven los cambios al consultarse de nuevo, sin prometer actualización automática en tiempo real.

En los diseños de datos, la entidad «Mantenimiento y reparación» corresponde al modelo `Trabajo` y a la tabla `trabajo`, con el atributo `tipo`. El servicio guarda `id_equipo` y obtiene el cliente a través del computador. El dominio conserva ocho entidades. `sessions` pertenece a infraestructura y la vista de validación añade caché compartida en PostgreSQL.

## Reglas que deben coincidir en todas las entregas

- El cliente no crea una cuenta; utiliza el código de seguimiento.
- Administrador y técnico utilizan el mismo formulario de ingreso. Registrar una persona como técnico no crea su cuenta.
- Un técnico puede atender varios servicios. Solo opera los asignados y lee el historial de actividades anteriores completadas del mismo computador.
- Completar requiere un diagnóstico; no exige una reparación ni repuestos.
- Reasignar conserva estado, diagnósticos, trabajos y repuestos; el técnico anterior pierde el acceso operativo.
- La consulta pública muestra estado y un resumen general, sin datos personales ni descripciones técnicas.
- Los registros de avance se agregan; la interfaz no ofrece editarlos o borrarlos.

## Requisitos no funcionales y evidencia

| ERS | Implementación o verificación |
| --- | --- |
| RNF01 | HTTPS, activación con mínimo de ocho caracteres, al menos una letra, un número y un carácter especial, y bcrypt con sal incorporada. |
| RNF02 | Middleware de autenticación y rol, además de comprobación del técnico asignado en las operaciones del servicio. |
| RNF03 | Claves y restricciones PostgreSQL, transacciones y procedimiento de copia y restauración en una base aislada. |
| RNF04 | Navegación por rol, validación de formularios y mensajes en español. |
| RNF05 | La ERS establece dos segundos para consultas simples y contempla 15 usuarios simultáneos. La prueba académica adicional de 200 solicitudes tuvo picos en Vercel. |
| RNF06 | Cinco capas del diseño MVC, módulos documentados y verificación de instalación en CI. |
| RNF07 | Evidencias históricas de Chrome y Firefox. En Vercel se verificaron las pantallas públicas. |
| RNF08 | Evidencias en 1366 × 768 y 1920 × 1080. La revisión en Vercel cubrió las pantallas públicas en ambas resoluciones. |
| RNF09 | El reinicio con restauración se comprobó en PostgreSQL local. La recuperación de Neon queda fuera de esa ejecución. |

El ciclo 3 histórico registra 79/79 casos exitosos y 408 pruebas automáticas con 912 aserciones. En el repositorio nuevo, sobre `a60d061`, la verificación de GitHub Actions ejecutó 409 pruebas con 918 aserciones. La vista previa de Vercel tuvo una comprobación funcional y de rendimiento propia con alcance parcial respecto de la matriz. Consulta [Estado y evidencias](../pruebas/estado-y-evidencias.md).

## Documentos de referencia

La [ERS y los talleres de diseño](https://github.com/meneses1111/Valtraza/tree/main/documentacion) se conservan en `documentacion`. La [arquitectura](../arquitectura/README.md), el [modelo de datos](../base-de-datos/modelo.md) y el [análisis de GitDiagram](../arquitectura/analisis-gitdiagram.md) explican su correspondencia con la implementación.
