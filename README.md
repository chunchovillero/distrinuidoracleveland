# Sistema POS — Distribuidora Cleveland

Aplicación web de gestión comercial desarrollada con Laravel. Centraliza el catálogo público, inventario, clientes, proveedores, vendedores, ventas, comisiones, reportes y administración de usuarios.

## Funcionalidades

- Catálogo público de productos con búsqueda y contacto por WhatsApp.
- Panel administrativo con indicadores generales.
- Gestión de productos, stock, categorías, calidades y proveedores.
- Importación y exportación de productos.
- Gestión de clientes y vendedores.
- Registro, consulta, duplicación y anulación de ventas.
- Cálculo de subtotales y comisiones por producto y vendedor.
- Exportación configurable de ventas.
- Reportes de ventas, inventario, clientes, períodos mensuales, comisiones y calidad.
- Administración de usuarios, roles y permisos individuales.
- Configuración de identidad visual, datos de la empresa y opciones del sistema.
- Protección del historial al verificar si un producto tiene ventas asociadas antes de eliminarlo.

## Tecnologías

- PHP 8.2 o superior.
- Laravel 12.
- Laravel UI y AdminLTE 3.
- MySQL/MariaDB o SQLite.
- Vite 7, Bootstrap 5, Sass y Tailwind CSS 4.
- PhpSpreadsheet para importaciones y exportaciones.
- PHPUnit 11 para pruebas automatizadas.

## Requisitos

- PHP `>= 8.2` con las extensiones requeridas por Laravel y PhpSpreadsheet.
- Composer.
- Node.js y npm.
- Una base de datos compatible. El archivo de ejemplo usa SQLite; algunas tareas administrativas del proyecto están escritas específicamente para MySQL.

## Instalación rápida

Desde la carpeta `laravel`:

```bash
composer setup
```

Ese comando instala las dependencias, crea `.env`, genera la clave de la aplicación, ejecuta las migraciones e instala y compila los recursos del frontend.

Para iniciar el entorno completo de desarrollo:

```bash
composer dev
```

Esto levanta el servidor web, el trabajador de colas, el visor de logs y Vite. El catálogo estará normalmente en `http://127.0.0.1:8000` y el acceso administrativo en `http://127.0.0.1:8000/admin/login`.

## Instalación manual

```bash
composer install
cp .env.example .env
php artisan key:generate
npm install
npm run build
php artisan migrate
php artisan storage:link
php artisan system:init-config
```

Si se usa la configuración SQLite predeterminada, crear primero el archivo de base de datos:

```bash
touch database/database.sqlite
```

Para MySQL, cambiar en `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_base_de_datos
DB_USERNAME=usuario
DB_PASSWORD=contraseña
```

Después, iniciar el servidor:

```bash
php artisan serve
npm run dev
```

## Datos iniciales

Para cargar las categorías, calidades, vendedores, clientes, productos y ventas de demostración registrados en el seeder principal:

```bash
php artisan db:seed
```

Para crear específicamente los usuarios de prueba:

```bash
php artisan db:seed --class=UserSeeder
```

Para crear únicamente la cuenta superadministradora sin modificar las demás cuentas:

```bash
php artisan db:seed --class=SuperAdminSeeder
```

| Rol de prueba | Correo | Contraseña |
| --- | --- | --- |
| Superadministrador | `superadmin@pos.com` | `superadmin123` |
| Administrador | `admin@pos.com` | `admin123` |
| Gerente (sin acceso al panel) | `gerente@pos.com` | `gerente123` |
| Vendedor (sin acceso al panel) | `vendedor@pos.com` | `vendedor123` |
| Usuario (sin acceso al panel) | `usuario@pos.com` | `usuario123` |
| Vendedor adicional (sin acceso al panel) | `carlos@pos.com` | `carlos123` |

> Estas credenciales son únicamente para desarrollo. Deben cambiarse o eliminarse antes de publicar el sistema.

El `DatabaseSeeder` ejecuta `UserSeeder`, por lo que una carga completa de datos deja disponible la cuenta administrativa indicada. Ejecutar el seeder específico vuelve a sincronizar las cuentas de prueba y sus roles.

Para reconstruir completamente la base de datos y cargar los datos de demostración:

```bash
php artisan migrate:fresh --seed
php artisan system:init-config
```

`migrate:fresh` elimina todas las tablas existentes. No debe utilizarse en producción ni sobre una base de datos que contenga información necesaria.

## Módulos y acceso

| Módulo | Ruta principal | Acceso |
| --- | --- | --- |
| Catálogo | `/` | Público |
| Inicio de sesión | `/admin/login` | Público |
| Panel | `/admin` | Usuario autenticado con permiso |
| Ventas | `/admin/sales` | Permisos de ventas |
| Productos | `/admin/products` | Permisos de productos |
| Clientes | `/admin/customers` | Permisos de clientes |
| Vendedores | `/admin/sellers` | Permisos de vendedores |
| Categorías | `/admin/categories` | Permisos de categorías |
| Calidades | `/admin/calidad` | Permisos de categorías |
| Proveedores | `/admin/proveedores` | Permisos asociados a clientes |
| Reportes | `/admin/reports/*` | Permiso específico por reporte |
| Usuarios | `/admin/users` | Solo administrador |
| Configuración | `/admin/configuration` | Solo administrador |
| Manual | `/admin/manual` | Cualquier usuario autenticado |

Actualmente, solo las cuentas activas con rol `superadmin` o `admin` pueden iniciar sesión y acceder al panel. Los vendedores, gerentes y usuarios normales no tienen acceso administrativo, aunque existan como datos de prueba. El registro público está deshabilitado y las cuentas se crean desde la administración.

- El `superadmin` tiene control total, puede configurar el sitio y administrar cualquier cuenta.
- El `admin` puede operar los módulos comerciales y crear ventas, pero no puede configurar el sitio ni ver o utilizar ninguna función de gestión de usuarios.

## Modelo de datos

- `users`: cuentas, rol, estado, contacto y último acceso.
- `user_permissions`: permisos concedidos o revocados por usuario.
- `products`: productos, SKU, precio, stock, kilos, comisión, imagen y visibilidad.
- `categories`, `calidad` y `proveedores`: clasificación y procedencia de productos.
- `customers`: identificación, contacto, dirección, localidad y transporte del cliente.
- `sellers`: vendedores relacionados con sus ventas.
- `sales`: cabecera de venta, cliente, vendedor, impuestos, total, comisión, estado y fecha.
- `sale_details`: productos, cantidades, precios, comisión y subtotal por línea.
- `system_configurations`: marca, apariencia y opciones configurables.
- `export_configurations`: preferencias de exportación.

Relaciones principales:

```text
Categoría ─┐
Calidad ───┼── Producto ── Detalle de venta ── Venta ── Cliente
Proveedor ─┘                                  └─────── Vendedor

Usuario ── Permisos
```

## Flujo de una venta

1. Seleccionar o crear un cliente.
2. Seleccionar un vendedor.
3. Agregar productos y cantidades disponibles.
4. El sistema calcula subtotales y comisiones.
5. Se guarda la venta con un número del tipo `VTA-000001`.
6. El inventario se descuenta según las cantidades vendidas.
7. Una venta puede consultarse, duplicarse o anularse conforme a los permisos del usuario.

## Comandos útiles

```bash
# Ejecutar pruebas
composer test

# Aplicar formato al código PHP
./vendor/bin/pint

# Limpiar cachés de Laravel
php artisan optimize:clear

# Inicializar la configuración visual y general
php artisan system:init-config

# Revisar qué productos se pueden eliminar sin afectar ventas
php artisan products:verify-deletion-safety
php artisan products:verify-deletion-safety --show-safe
php artisan products:verify-deletion-safety --show-unsafe

# Crear 100 ventas variadas de demostración
php artisan db:seed --class=DemoSalesSeeder
```

Existe además este comando destructivo:

```bash
php artisan data:clear-sales-products
```

Elimina todas las ventas, sus detalles y todos los productos; también elimina las imágenes salvo que se agregue `--keep-images`. Está implementado con instrucciones SQL de MySQL y la operación no se puede deshacer. Se recomienda realizar una copia de seguridad antes de usarlo y no añadir `--force` salvo en procesos controlados.

## Archivos y almacenamiento

Las imágenes subidas se guardan en el disco público de Laravel. Para servirlas desde el navegador debe existir el enlace simbólico:

```bash
php artisan storage:link
```

Laravel debe tener permisos de escritura sobre `storage` y `bootstrap/cache`.

## Pruebas

```bash
composer test
```

La base actual incluye las pruebas de ejemplo de Laravel. Antes de desplegar cambios críticos conviene agregar pruebas funcionales para ventas, actualización de stock, permisos, importaciones y exportaciones.

## Despliegue en producción

1. Configurar `.env` con `APP_ENV=production`, `APP_DEBUG=false`, la URL real y credenciales seguras.
2. Instalar dependencias optimizadas con `composer install --no-dev --optimize-autoloader`.
3. Compilar recursos con `npm ci && npm run build`.
4. Ejecutar `php artisan migrate --force`.
5. Crear el enlace de almacenamiento con `php artisan storage:link`.
6. Inicializar la configuración con `php artisan system:init-config` si aún no existe.
7. Ejecutar `php artisan optimize`.
8. Configurar el servidor web para que su raíz pública apunte a `laravel/public`.
9. Configurar un trabajador de colas persistente cuando `QUEUE_CONNECTION` no sea `sync`.
10. Programar copias de seguridad de la base de datos y de `storage/app/public`.

No se deben versionar `.env`, claves privadas, copias de bases de datos ni credenciales reales.

## Estructura principal

```text
app/
├── Console/Commands/       Comandos administrativos
├── Http/Controllers/       Lógica de catálogo, CRUD, ventas y reportes
├── Http/Middleware/        Validación de roles y permisos
└── Models/                 Modelos y relaciones Eloquent
database/
├── migrations/             Esquema de la base de datos
└── seeders/                Datos iniciales y de demostración
resources/
├── css/ y sass/            Estilos
├── js/                     JavaScript del frontend
└── views/                  Vistas Blade
routes/web.php              Rutas públicas, autenticación y administración
storage/app/public/         Archivos públicos subidos
tests/                      Pruebas automatizadas
```

## Solución de problemas

**Las imágenes no aparecen**

Ejecutar `php artisan storage:link` y verificar permisos sobre `storage`.

**Los cambios de `.env` no se reflejan**

```bash
php artisan optimize:clear
```

**Un usuario recibe un error 403**

Comprobar que esté activo y que tenga el permiso solicitado. Los permisos se administran desde `/admin/users/{usuario}/permissions` con una cuenta administradora.

**No se cargan estilos o scripts**

Ejecutar `npm install` y `npm run build`; durante desarrollo usar `npm run dev`.

**Falla el comando para borrar ventas y productos con SQLite**

Ese comando contiene instrucciones propias de MySQL (`FOREIGN_KEY_CHECKS` y `AUTO_INCREMENT`). Debe usarse con MySQL/MariaDB o adaptarse antes de ejecutarlo con SQLite.

## Seguridad

- Cambiar todas las contraseñas de demostración.
- Mantener `APP_DEBUG=false` en producción.
- Usar HTTPS y una clave `APP_KEY` única.
- Restringir el acceso al panel administrativo.
- Conceder a cada usuario solo los permisos necesarios.
- Respaldar los datos antes de migraciones o tareas destructivas.

## Licencia

El proyecto se basa en Laravel, distribuido bajo licencia MIT. Definir la licencia aplicable al código específico de este sistema antes de redistribuirlo.
