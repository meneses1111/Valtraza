# Git, GitHub y publicación

El repositorio Valtraza utiliza cinco ramas permanentes.

| Rama | Uso |
| --- | --- |
| `main` | Versión estable revisada para la entrega. |
| `develop` | Desarrollo e integración de código, pruebas y documentación. |
| `pruebas` | Casos, automatización y evidencias mantenidos por Luis. |
| `documentacion` | Fuentes editables del GitBook en `docs`. |
| `gh-pages` | Salida generada del libro, gestionada por GitHub Actions. |

Luis identifica el commit de `develop` que evaluó y entrega su trabajo desde `pruebas` mediante un pull request. Los cambios del libro se revisan en un pull request de `documentacion` a `develop`. Cuando la versión integrada queda aprobada, pasa de `develop` a `main` mediante otro pull request. La opción **Create a merge commit** conserva los commits individuales.

Cada commit reúne un cambio que se puede revisar por separado. Los mensajes se escriben en español y describen el cambio real, por ejemplo, `Agrego los filtros de supervisión`. Antes de subir, revisar los archivos seleccionados, la autoría y las pruebas correspondientes. Las credenciales, el contexto privado y los entregables de Moodle se conservan fuera del repositorio público.

El equipo reutiliza las cinco ramas y mantiene desactivada la eliminación automática al integrar un pull request. Las reglas de `main` deben exigir revisión y las comprobaciones correspondientes. En `main` y `develop`, conviene bloquear la eliminación y los cambios de historial mediante force push.

El [estado de los ciclos](../pruebas/estado-y-evidencias.md) reúne los resultados históricos de Luis y señala la versión evaluada.

## Construcción del GitBook

Las fuentes están en `docs`. `SUMMARY.md` define la navegación y `book.json` configura el contenido. El generador es HonKit 6.2.5, fijado en `herramientas/gitbook/package-lock.json`, compatible con la estructura de GitBook. El Node de esta herramienta está separado del entorno PHP de la aplicación.

### Comprobación automática

El workflow **Revisar GitBook** comprueba fuentes y enlaces internos, compila el libro con HonKit 6.2.5 y Node 24 LTS y revisa el HTML generado. Después abre las páginas con Chrome en 1366 × 768 y 1920 × 1080, tanto en la raíz como bajo `/Valtraza/`, y guarda el informe de navegación. Se comprueba también el acceso directo a `index.html` sin depender de redirecciones del servidor.

Si termina correctamente, en la ejecución de GitHub Actions aparece el artefacto **gitbook-vista-previa-SHA**, que contiene el sitio estático, y el artefacto de validación. Para abrir la vista previa, extraer el sitio en una carpeta y servirla con un servidor HTTP local; la búsqueda y la navegación del tema no deben evaluarse mediante `file://`.

### Construcción local en un entorno aislado

Con Node 24 LTS y npm disponibles para esta herramienta:

```text
npm ci --prefix herramientas/gitbook --ignore-scripts --no-fund
node herramientas/gitbook/compilar.cjs
python herramientas/gitbook/verificar.py --html _book
```

La comprobación de las fuentes se puede ejecutar sin instalar GitBook:

```text
python herramientas/gitbook/verificar.py
```

Se conserva el nombre GitBook para el libro y su estructura de capítulos; la compilación utiliza HonKit en lugar del generador Legacy 3.2.2. Las dependencias se auditan en CI y no se instalan de forma global. `_book` es salida generada y se mantiene fuera de las ramas de desarrollo. Los PR y los cambios de `develop` generan solo vistas previas. El despliegue se habilita únicamente para `main`; no modifica la base de datos.

### Publicación de la entrega

Después de integrar a `main`, **Revisar GitBook** conserva únicamente el sitio generado en `gh-pages` y prepara el artefacto oficial de Pages. Excluye los iniciadores locales y añade `.nojekyll`. No se publican el código PHP, `.env`, dependencias ni archivos de contexto.

La primera vez, un administrador debe abrir **Settings → Pages → Build and deployment → Source** y seleccionar **GitHub Actions**. Esta activación necesita permisos de administración; no se sustituye añadiendo permisos al token del workflow. Después, abrir **Actions → Revisar GitBook → Run workflow**, seleccionar `main` y ejecutar. El workflow despliega el libro comprobado mediante las acciones oficiales de Pages. `gh-pages` conserva la salida generada; el despliegue utiliza el artefacto de Actions para que las actualizaciones no dependan de que un push del token automático active otro workflow.

Si Pages no está activado, se conserva el libro y se muestra la instrucción pendiente; una compilación correcta no se anuncia como sitio publicado. Tras desplegar, comprobar la URL indicada, el índice, la búsqueda, imágenes y enlaces internos, y solo entonces añadir el enlace público al README. La vista previa y los archivos de `docs` no equivalen a una publicación estable.

## GitDiagram

El análisis de GitDiagram se produce sobre la versión final del repositorio. Comparar el grafo con los seis módulos y sus dependencias, registrar la rama y el SHA analizados y explicar cualquier diferencia. No presentar la vista documental de módulos como una ejecución de GitDiagram.
