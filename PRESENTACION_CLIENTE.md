# Guion para presentar el Sistema de Gestión Cleveland

## Objetivo de la presentación

Mostrar al cliente cómo el sistema ayuda a centralizar el catálogo, las ventas, el inventario, los clientes y los reportes, evitando comenzar con detalles técnicos. La presentación recomendada dura entre 25 y 35 minutos.

## Antes de la reunión

Realizar estas comprobaciones al menos 30 minutos antes:

- Confirmar que el sitio abre correctamente.
- Probar el acceso con una cuenta `admin` y una `superadmin`.
- Tener productos con imágenes, precios, stock y comisiones.
- Tener al menos un cliente, un vendedor y algunas ventas de demostración.
- Revisar que los reportes tengan información visible.
- Preparar un producto con poco stock para mostrar la gestión de inventario.
- Cerrar pestañas, notificaciones y aplicaciones personales.
- Usar una ventana limpia del navegador y un nivel de zoom legible.
- No mostrar contraseñas, archivos `.env`, código fuente ni información privada.
- Tener un respaldo o capturas de pantalla por si falla Internet.

## 1. Apertura — 2 minutos

### Qué decir

> Hoy les presentaré el nuevo sistema de gestión de Distribuidora Cleveland. Su objetivo es concentrar en un solo lugar el catálogo, los productos, clientes, vendedores, ventas, comisiones y reportes, entregando más control sobre la operación diaria.

Explicar brevemente el problema que resuelve:

- Información dispersa o duplicada.
- Dificultad para conocer el stock disponible.
- Cálculo manual de ventas y comisiones.
- Poca visibilidad sobre resultados y clientes.
- Riesgo de que personas no autorizadas modifiquen la configuración.

No comenzar hablando de Laravel, PHP, base de datos o servidor. Primero se presenta el valor para el negocio.

## 2. Catálogo público — 3 minutos

Abrir la página principal sin iniciar sesión.

### Mostrar

1. Catálogo disponible para cualquier cliente.
2. Búsqueda de productos.
3. Categorías, imágenes, precios y disponibilidad.
4. Detalle de un producto.
5. Contacto mediante WhatsApp.

### Qué decir

> El catálogo permite que los clientes consulten los productos sin entrar al sistema administrativo. Solo se muestran productos activos, publicados y con stock disponible.

Destacar que el catálogo sirve como vitrina comercial y no expone herramientas internas.

## 3. Acceso y seguridad — 3 minutos

Abrir `/admin/login` e ingresar primero como `admin`.

### Mostrar

- Formulario de inicio de sesión.
- Panel administrativo.
- Menú correspondiente al administrador.
- Que la configuración y la gestión de usuarios no aparecen para este rol.

### Qué decir

> El sistema separa las funciones según el nivel de responsabilidad. Un administrador trabaja con la operación comercial, pero no puede cambiar la configuración general ni administrar cuentas.

Explicar los roles actuales:

| Rol | Acceso |
| --- | --- |
| Superadmin | Control total, configuración y gestión de cuentas |
| Admin | Operación comercial, ventas, inventario y reportes |
| Otros roles | Sin acceso al panel administrativo por el momento |

No mostrar las contraseñas durante la presentación.

## 4. Panel principal — 2 minutos

### Mostrar

- Bienvenida e identificación de la cuenta.
- Accesos rápidos.
- Estado general del sistema.

### Qué decir

> Desde este panel se accede a las tareas habituales. El menú cambia según los permisos para que cada persona vea únicamente las funciones que necesita.

## 5. Productos e inventario — 5 minutos

Entrar al módulo de productos.

### Mostrar

1. Listado y búsqueda.
2. Filtros por categoría, calidad, proveedor o estado.
3. Ficha de un producto.
4. Precio, stock, kilos y porcentaje de comisión.
5. Imagen y visibilidad en el catálogo público.
6. Creación o edición de un producto de demostración.
7. Activación y desactivación.
8. Importación o exportación, si corresponde al flujo del cliente.

### Qué decir

> Cada producto reúne su información comercial y de inventario. Puede desactivarse sin perder el historial, y se puede decidir si aparecerá o no en el catálogo público.

Evitar eliminar productos reales durante la demostración. Usar un registro preparado específicamente para pruebas.

## 6. Clientes, proveedores y vendedores — 4 minutos

### Mostrar

- Registro y búsqueda de clientes.
- Información de contacto, dirección, localidad y transporte.
- Gestión de proveedores.
- Gestión de vendedores.

### Qué decir

> Estos registros evitan volver a escribir la misma información en cada venta y permiten mantener trazabilidad sobre quién vendió, quién compró y qué proveedor está relacionado con cada producto.

## 7. Crear una venta completa — 6 minutos

Esta debe ser la parte central de la demostración.

### Flujo recomendado

1. Entrar en **Nueva venta**.
2. Seleccionar un cliente.
3. Seleccionar un vendedor.
4. Agregar uno o dos productos.
5. Cambiar cantidades y mostrar la validación de stock.
6. Seleccionar el método de pago.
7. Guardar la venta.
8. Mostrar el número automático de venta.
9. Revisar subtotales, total y comisión.
10. Volver al producto y comprobar que el stock disminuyó.

### Qué decir

> Al registrar la venta, el sistema calcula automáticamente los totales y las comisiones, guarda el detalle y descuenta las unidades del inventario. Esto reduce cálculos manuales y mantiene la información conectada.

También se puede mostrar cómo consultar o duplicar una venta. La anulación debe demostrarse solo con datos preparados para ello.

## 8. Reportes y comisiones — 4 minutos

### Mostrar

- Reporte de ventas por período.
- Inventario y productos con stock bajo.
- Ventas mensuales.
- Comisiones por vendedor.
- Clientes con mayor actividad.
- Exportación a Excel cuando corresponda.

### Qué decir

> Los reportes permiten pasar de registrar información a tomar decisiones: conocer qué se vende, cuánto stock queda, cuánto corresponde pagar en comisiones y cómo evoluciona la operación.

Usar un rango de fechas que contenga datos para evitar mostrar reportes vacíos.

## 9. Superadministración — 3 minutos

Cerrar la sesión de `admin` e ingresar como `superadmin`.

### Mostrar

- Aparición del módulo de gestión de usuarios.
- Creación, edición, activación y desactivación de cuentas.
- Configuración del sitio.
- Datos de empresa, logotipo, colores y opciones generales.

### Qué decir

> Estas opciones están reservadas para la persona responsable del sistema. El administrador operativo no puede verlas ni acceder escribiendo directamente la dirección; el servidor responde con un error 403 de acceso denegado.

No cambiar la configuración real durante la reunión. Si se necesita demostrarla, anotar previamente los valores originales.

## 10. Resumen de beneficios — 2 minutos

Cerrar la demostración resumiendo resultados, no pantallas:

- Una sola fuente de información comercial.
- Inventario actualizado con cada venta.
- Menos cálculos manuales y menos errores.
- Seguimiento de comisiones.
- Catálogo público conectado con los productos activos.
- Reportes para apoyar decisiones.
- Acceso protegido por roles.
- Historial centralizado y disponible para consulta.

### Frase sugerida

> En resumen, el sistema conecta la vitrina comercial con la operación interna: desde lo que ve el cliente hasta el registro de la venta, el descuento de stock, la comisión y el reporte final.

## 11. Preguntas y validación — 5 minutos

Preguntar directamente:

1. ¿El flujo de venta coincide con el proceso real de la empresa?
2. ¿Falta algún dato importante en clientes, productos o ventas?
3. ¿Los reportes muestran la información que necesitan para decidir?
4. ¿Qué personas usarán el sistema y qué funciones necesita cada una?
5. ¿Qué cambios consideran indispensables antes de comenzar a usarlo?

No prometer modificaciones inmediatamente. Registrar cada solicitud y clasificarla después como corrección, mejora o nueva funcionalidad.

## 12. Cierre y próximos pasos

Finalizar acordando acciones concretas:

- Responsable de validar el sistema.
- Lista priorizada de ajustes.
- Fecha límite para observaciones.
- Fecha de capacitación.
- Fecha estimada de puesta en marcha.
- Responsable de productos, usuarios y carga inicial de información.
- Política de respaldos y soporte.

### Frase sugerida

> Si el flujo presentado queda validado, el siguiente paso es recibir sus observaciones finales, realizar los ajustes acordados, capacitar a los usuarios autorizados y definir la fecha de puesta en marcha.

## Lista rápida para usar durante la presentación

```text
[ ] Presentar el objetivo y el problema que resuelve
[ ] Mostrar catálogo público y WhatsApp
[ ] Ingresar como admin y explicar seguridad
[ ] Mostrar productos e inventario
[ ] Mostrar clientes, proveedores y vendedores
[ ] Crear una venta completa
[ ] Verificar descuento de stock y comisión
[ ] Mostrar reportes
[ ] Ingresar como superadmin
[ ] Mostrar usuarios y configuración
[ ] Resumir beneficios
[ ] Recoger preguntas y acuerdos
[ ] Definir próximos pasos y responsables
```

## Recomendaciones para una buena presentación

- Hablar en términos del negocio, no del código.
- Mostrar un flujo completo en lugar de abrir todas las pantallas.
- Utilizar datos realistas, pero no información personal sensible.
- Mantener la demostración dentro de 35 minutos.
- Evitar improvisar eliminaciones o cambios masivos.
- Si aparece un error, anotarlo y continuar con otra sección.
- Confirmar al final qué quedó aprobado y qué requiere cambios.
