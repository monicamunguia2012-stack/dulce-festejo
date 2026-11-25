
## Dulce Festejo - Catálogo y Gestión de Dulcería

Aplicación web dinámica para la gestión y visualización de un catálogo de productos de dulcería. Desarrollada con **PHP**, **SQLite** y **Bootstrap 5**, incluye un sistema CRUD completo protegido por autenticación de administrador, búsqueda en tiempo real y diseño responsivo.

## Funcionalidades Principales
**Página de Inicio (`index.php`):** Muestra el carrusel promocional y los últimos 6 productos agregados dinámicamente desde la base de datos, con botón para pedir por WhatsApp.
**Catálogo Completo (`productos.php`):** Lista todos los productos en una tabla con buscador en tiempo real (JavaScript).
**Acceso Administrativo (`login.php` y `logout.php`):** Inicio y cierre de sesión con PHP para restringir la creación, edición y eliminación de productos.
**Operaciones CRUD:**
**Crear y Editar (`formulario.php`):** Formulario con validación de precio en JavaScript, subida de imágenes y vista previa instantánea.
**Leer (`index.php` y `productos.php`):** Consulta dinámica desde SQLite usando PDO.
**Eliminar (`productos.php`):** Eliminación segura con ventana de confirmación (solo visible para el administrador).

## Tecnologías Utilizadas
**Frontend:** HTML5 semántico, CSS3, Bootstrap 5.3.3, JavaScript.
**Backend:** PHP (PDO y manejo de sesiones).
**Base de Datos:** SQLite (`dulceria.db`).

## Estructura del Proyecto
`index.php` - Página principal
`productos.php` - Catálogo completo y eliminación
`formulario.php` - Registro y edición de productos
`login.php` / `logout.php` - Control de acceso (contraseña: Dulce2026)
`footer.php` - Pie de página reutilizable
`db.php` / `dulceria.db` - Conexión y base de datos SQLite
`css/styles.css` - Estilos personalizados
`js/scripts.js` - Validaciones e interactividad
`assets/` - Logo, banners e imágenes de productos

## Cómo usar el sitio
**Vista de cliente:** Al abrir `index.php` puedes ver el carrusel y los últimos productos agregados, o hacer clic en **Catálogo** (`productos.php`) para ver todos los dulces y filtrarlos usando el buscador.
**Vista de administrador:** Haz clic en **Agregar Producto** (o entra a `login.php`) e ingresa la contraseña `Dulce2026`.
**Gestión (CRUD):** Una vez iniciada la sesión, podrás registrar nuevos productos con imagen en `formulario.php`, y en `productos.php` aparecerán los botones de **Editar** y **Eliminar** en cada fila.
**Salir:** Usa la opción **Cerrar Sesión** en el menú para volver al modo cliente.

## Instrucciones de Ejecución
1. Clonar o descargar este repositorio.
2. Abrir la carpeta en un entorno con PHP.
3. Si usas el servidor integrado, ejecuta en la terminal dentro de la carpeta del proyecto:
   ```bash
   php -S localhost:8000