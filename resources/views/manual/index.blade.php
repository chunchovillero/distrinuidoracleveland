@extends('adminlte::page')

@section('title', 'Manual del Sistema')

@section('content_header')
    <h1>
        <i class="fas fa-book"></i> Manual del Sistema POS
        <small>Guía completa de uso</small>
    </h1>
@stop

@section('content')
<div class="container-fluid">
    <!-- Tabla de Contenidos -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-list"></i> Tabla de Contenidos</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <ul class="list-unstyled">
                                <li><a href="#introduccion" class="btn btn-link"><i class="fas fa-info-circle"></i> 1. Introducción</a></li>
                                <li><a href="#acceso" class="btn btn-link"><i class="fas fa-sign-in-alt"></i> 2. Acceso al Sistema</a></li>
                                <li><a href="#dashboard" class="btn btn-link"><i class="fas fa-tachometer-alt"></i> 3. Panel Principal</a></li>
                                <li><a href="#productos" class="btn btn-link"><i class="fas fa-box"></i> 4. Gestión de Productos</a></li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <ul class="list-unstyled">
                                <li><a href="#ventas" class="btn btn-link"><i class="fas fa-shopping-cart"></i> 5. Gestión de Ventas</a></li>
                                <li><a href="#clientes" class="btn btn-link"><i class="fas fa-users"></i> 6. Gestión de Clientes</a></li>
                                <li><a href="#categorias" class="btn btn-link"><i class="fas fa-tags"></i> 7. Gestión de Categorías</a></li>
                                <li><a href="#calidades" class="btn btn-link"><i class="fas fa-star"></i> 8. Gestión de Calidades</a></li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <ul class="list-unstyled">
                                <li><a href="#exportar" class="btn btn-link"><i class="fas fa-download"></i> 11. Exportar/Importar</a></li>
                                <li><a href="#permisos" class="btn btn-link"><i class="fas fa-key"></i> 12. Sistema de Permisos</a></li>
                                <li><a href="#configuracion" class="btn btn-link"><i class="fas fa-cog"></i> 13. Configuración</a></li>
                                <li><a href="#soporte" class="btn btn-link"><i class="fas fa-life-ring"></i> 14. Soporte Técnico</a></li>
                                <li><a href="#faq" class="btn btn-link"><i class="fas fa-question-circle"></i> 15. Preguntas Frecuentes</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 1. Introducción -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info" id="introduccion">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle"></i> 1. Introducción</h3>
                </div>
                <div class="card-body">
                    <h4>¿Qué es el Sistema POS?</h4>
                    <p>El Sistema POS (Point of Sale) es una aplicación web completa para la gestión de ventas, inventario y clientes. Desarrollado con Laravel y AdminLTE, ofrece una interfaz moderna y funcional para administrar tu negocio.</p>
                    
                    <h4>Características Principales:</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <ul>
                                <li>✅ Gestión completa de productos</li>
                                <li>✅ Sistema de ventas integrado</li>
                                <li>✅ Administración de clientes</li>
                                <li>✅ Control de inventario</li>
                                <li>✅ Reportes detallados</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul>
                                <li>✅ Exportación/Importación CSV</li>
                                <li>✅ Sistema de permisos</li>
                                <li>✅ Catálogo público</li>
                                <li>✅ Integración WhatsApp</li>
                                <li>✅ Panel administrativo completo</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Acceso al Sistema -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-success" id="acceso">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-sign-in-alt"></i> 2. Acceso al Sistema</h3>
                </div>
                <div class="card-body">
                    <h4>Iniciar Sesión:</h4>
                    <ol>
                        <li>Navegar a: <code>http://pos.local.cl/login</code></li>
                        <li>Ingresar credenciales de usuario</li>
                        <li>Hacer clic en "Iniciar Sesión"</li>
                    </ol>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        <strong>Credenciales por defecto:</strong><br>
                        Email: admin@pos.com<br>
                        Contraseña: (configurada durante instalación)
                    </div>

                    <h4>Recuperar Contraseña:</h4>
                    <p>Si olvidas tu contraseña, utiliza el enlace "Olvidé mi contraseña" en la pantalla de login.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Panel Principal -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning" id="dashboard">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-tachometer-alt"></i> 3. Panel Principal (Dashboard)</h3>
                </div>
                <div class="card-body">
                    <p>El dashboard es tu página principal donde verás:</p>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Estadísticas Generales:</h5>
                            <ul>
                                <li>Total de productos</li>
                                <li>Ventas del día</li>
                                <li>Clientes registrados</li>
                                <li>Stock bajo</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Accesos Rápidos:</h5>
                            <ul>
                                <li>Nueva venta</li>
                                <li>Agregar producto</li>
                                <li>Registrar cliente</li>
                                <li>Ver reportes</li>
                            </ul>
                        </div>
                    </div>

                    <div class="alert alert-success">
                        <i class="fas fa-lightbulb"></i> 
                        <strong>Tip:</strong> Utiliza el menú lateral para navegar entre las diferentes secciones del sistema.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. Gestión de Productos -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary" id="productos">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-box"></i> 4. Gestión de Productos</h3>
                </div>
                <div class="card-body">
                    <h4>Agregar Nuevo Producto:</h4>
                    <ol>
                        <li>Ir a <strong>Productos → Crear Producto</strong></li>
                        <li>Completar información requerida:
                            <ul>
                                <li>Nombre del producto</li>
                                <li>SKU/Código (opcional)</li>
                                <li>Descripción</li>
                                <li><strong>Categoría:</strong> Seleccionar de las creadas previamente</li>
                                <li><strong>Calidad:</strong> Nivel/grado del producto</li>
                                <li><strong>Proveedor:</strong> Empresa suministradora</li>
                                <li>Precio</li>
                                <li>Stock inicial</li>
                                <li>Comisión (%)</li>
                            </ul>
                        </li>
                        <li>Hacer clic en "Guardar"</li>
                    </ol>

                    <h4>Gestionar Productos Existentes:</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Acciones Disponibles:</h5>
                            <ul>
                                <li>✏️ <strong>Editar:</strong> Modificar información</li>
                                <li>👁️ <strong>Ver:</strong> Detalles del producto</li>
                                <li>🔄 <strong>Toggle:</strong> Activar/Desactivar</li>
                                <li>🗑️ <strong>Eliminar:</strong> Borrar producto</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Filtros Disponibles:</h5>
                            <ul>
                                <li>Por categoría</li>
                                <li>Por calidad</li>
                                <li>Por proveedor</li>
                                <li>Por estado (activo/inactivo)</li>
                                <li>Por nivel de stock</li>
                            </ul>
                        </div>
                    </div>

                    <div class="alert alert-primary">
                        <i class="fas fa-download"></i> 
                        <strong>Función Especial:</strong> Puedes exportar todos los productos a CSV y luego importar cambios masivos usando el botón "Exportar Productos" e "Importar Productos".
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> 
                        <strong>Prerequisito:</strong> Antes de crear productos, asegúrate de tener configuradas las Categorías, Calidades y Proveedores necesarios en sus respectivas secciones.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. Gestión de Ventas -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-success" id="ventas">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-shopping-cart"></i> 5. Gestión de Ventas</h3>
                </div>
                <div class="card-body">
                    <h4>Crear Nueva Venta:</h4>
                    <ol>
                        <li>Ir a <strong>Ventas → Crear Venta</strong></li>
                        <li>Seleccionar cliente</li>
                        <li>Elegir vendedor</li>
                        <li>Agregar productos:
                            <ul>
                                <li>Buscar producto</li>
                                <li>Especificar cantidad</li>
                                <li>Confirmar precio</li>
                            </ul>
                        </li>
                        <li>Revisar totales</li>
                        <li>Procesar venta</li>
                    </ol>

                    <h4>Gestionar Ventas:</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Acciones:</h5>
                            <ul>
                                <li>👁️ Ver detalles de venta</li>
                                <li>📋 Duplicar venta</li>
                                <li>❌ Cancelar venta</li>
                                <li>🗑️ Eliminar venta</li>
                                <li>📊 Exportar ventas</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Información Mostrada:</h5>
                            <ul>
                                <li>Fecha y hora</li>
                                <li>Cliente y vendedor</li>
                                <li>Productos vendidos</li>
                                <li>Total de la venta</li>
                                <li>Estado de la venta</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 6. Gestión de Clientes -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info" id="clientes">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-users"></i> 6. Gestión de Clientes</h3>
                </div>
                <div class="card-body">
                    <h4>Registrar Nuevo Cliente:</h4>
                    <ol>
                        <li>Ir a <strong>Clientes → Crear Cliente</strong></li>
                        <li>Completar información:
                            <ul>
                                <li>Nombre completo</li>
                                <li>Email</li>
                                <li>Teléfono</li>
                                <li>Dirección</li>
                                <li>RUT (opcional)</li>
                            </ul>
                        </li>
                        <li>Guardar cliente</li>
                    </ol>

                    <h4>Gestionar Clientes:</h4>
                    <ul>
                        <li>📝 Editar información del cliente</li>
                        <li>👁️ Ver historial de compras</li>
                        <li>🔄 Activar/Desactivar cliente</li>
                        <li>🔍 Buscar clientes rápidamente</li>
                    </ul>

                    <div class="alert alert-info">
                        <i class="fas fa-search"></i> 
                        <strong>Búsqueda:</strong> Utiliza la función de búsqueda para encontrar clientes rápidamente por nombre, email o teléfono.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 7. Gestión de Categorías -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary" id="categorias">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-tags"></i> 7. Gestión de Categorías</h3>
                </div>
                <div class="card-body">
                    <h4>¿Qué son las Categorías?</h4>
                    <p>Las categorías son clasificaciones que te permiten organizar tus productos en grupos lógicos. Por ejemplo: "Electrónicos", "Ropa", "Alimentación", etc.</p>
                    
                    <h4>Crear Nueva Categoría:</h4>
                    <ol>
                        <li>Ir a <strong>Categorías → Crear Categoría</strong></li>
                        <li>Completar información:
                            <ul>
                                <li><strong>Nombre:</strong> Nombre descriptivo de la categoría</li>
                                <li><strong>Descripción:</strong> Detalles adicionales (opcional)</li>
                                <li><strong>Estado:</strong> Activo/Inactivo</li>
                            </ul>
                        </li>
                        <li>Hacer clic en "Guardar"</li>
                    </ol>

                    <h4>Gestionar Categorías Existentes:</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Acciones Disponibles:</h5>
                            <ul>
                                <li>✏️ <strong>Editar:</strong> Modificar nombre y descripción</li>
                                <li>👁️ <strong>Ver:</strong> Detalles y productos asociados</li>
                                <li>🔄 <strong>Toggle:</strong> Activar/Desactivar categoría</li>
                                <li>🗑️ <strong>Eliminar:</strong> Borrar categoría (solo si no tiene productos)</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Información Mostrada:</h5>
                            <ul>
                                <li>Nombre de la categoría</li>
                                <li>Descripción</li>
                                <li>Cantidad de productos asociados</li>
                                <li>Estado (Activo/Inactivo)</li>
                                <li>Fecha de creación</li>
                            </ul>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        <strong>Tip:</strong> Organiza tus categorías de forma lógica. Esto facilita la búsqueda de productos y la generación de reportes por categoría.
                    </div>

                    <h4>Ejemplos de Categorías:</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <ul>
                                <li>📱 Electrónicos</li>
                                <li>👕 Ropa y Accesorios</li>
                                <li>🍎 Alimentación</li>
                                <li>🏠 Hogar y Decoración</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul>
                                <li>📚 Libros y Papelería</li>
                                <li>⚽ Deportes</li>
                                <li>🚗 Automóvil</li>
                                <li>💄 Belleza y Cuidado</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 8. Gestión de Calidades -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning" id="calidades">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-star"></i> 8. Gestión de Calidades</h3>
                </div>
                <div class="card-body">
                    <h4>¿Qué son las Calidades?</h4>
                    <p>Las calidades son clasificaciones que te permiten categorizar tus productos según su nivel de calidad, grado o tipo. Por ejemplo: "Premium", "Estándar", "Económico", "Primera", "Segunda", etc.</p>
                    
                    <h4>Crear Nueva Calidad:</h4>
                    <ol>
                        <li>Ir a <strong>Calidades → Crear Calidad</strong></li>
                        <li>Completar información:
                            <ul>
                                <li><strong>Nombre:</strong> Nombre de la calidad (ej: "Premium", "Primera")</li>
                                <li><strong>Descripción:</strong> Características de esta calidad</li>
                                <li><strong>Estado:</strong> Activo/Inactivo</li>
                            </ul>
                        </li>
                        <li>Hacer clic en "Guardar"</li>
                    </ol>

                    <h4>Gestionar Calidades:</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Acciones Disponibles:</h5>
                            <ul>
                                <li>✏️ <strong>Editar:</strong> Modificar información</li>
                                <li>👁️ <strong>Ver:</strong> Detalles y productos con esta calidad</li>
                                <li>🔄 <strong>Toggle:</strong> Activar/Desactivar</li>
                                <li>🗑️ <strong>Eliminar:</strong> Borrar (solo si no hay productos asociados)</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Usos Comunes:</h5>
                            <ul>
                                <li>Clasificar productos por nivel de calidad</li>
                                <li>Diferenciación de precios</li>
                                <li>Reportes por tipo de calidad</li>
                                <li>Control de inventario por grado</li>
                            </ul>
                        </div>
                    </div>

                    <div class="alert alert-success">
                        <i class="fas fa-lightbulb"></i> 
                        <strong>Ejemplo Práctico:</strong> Si vendes frutas, puedes crear calidades como "Extra", "Primera", "Segunda" para clasificar según el estado y precio de los productos.
                    </div>

                    <h4>Ejemplos de Calidades por Sector:</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>🍎 Alimentación:</h5>
                            <ul>
                                <li>Extra</li>
                                <li>Primera</li>
                                <li>Segunda</li>
                                <li>Comercial</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>📱 Electrónicos:</h5>
                            <ul>
                                <li>Premium</li>
                                <li>Estándar</li>
                                <li>Básico</li>
                                <li>Refurbished</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 9. Gestión de Proveedores -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info" id="proveedores">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-truck"></i> 9. Gestión de Proveedores</h3>
                </div>
                <div class="card-body">
                    <h4>¿Qué son los Proveedores?</h4>
                    <p>Los proveedores son las empresas o personas que te suministran productos para tu inventario. Mantener un registro de proveedores te ayuda a controlar costos, tiempos de entrega y calidad.</p>
                    
                    <h4>Registrar Nuevo Proveedor:</h4>
                    <ol>
                        <li>Ir a <strong>Proveedores → Crear Proveedor</strong></li>
                        <li>Completar información completa:
                            <ul>
                                <li><strong>Nombre/Razón Social:</strong> Nombre del proveedor</li>
                                <li><strong>RUT/ID:</strong> Identificación fiscal</li>
                                <li><strong>Email:</strong> Contacto electrónico</li>
                                <li><strong>Teléfono:</strong> Número de contacto</li>
                                <li><strong>Dirección:</strong> Ubicación física</li>
                                <li><strong>Contacto:</strong> Persona de contacto</li>
                                <li><strong>Condiciones de Pago:</strong> Términos comerciales</li>
                                <li><strong>Estado:</strong> Activo/Inactivo</li>
                            </ul>
                        </li>
                        <li>Guardar proveedor</li>
                    </ol>

                    <h4>Gestionar Proveedores:</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Acciones Disponibles:</h5>
                            <ul>
                                <li>✏️ <strong>Editar:</strong> Actualizar información de contacto</li>
                                <li>👁️ <strong>Ver:</strong> Detalles y productos suministrados</li>
                                <li>🔄 <strong>Toggle:</strong> Activar/Desactivar proveedor</li>
                                <li>🗑️ <strong>Eliminar:</strong> Borrar (solo si no tiene productos)</li>
                                <li>📊 <strong>Reportes:</strong> Análisis de compras por proveedor</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Beneficios del Control:</h5>
                            <ul>
                                <li>Trazabilidad de productos</li>
                                <li>Control de costos</li>
                                <li>Evaluación de desempeño</li>
                                <li>Gestión de pagos</li>
                                <li>Reportes de compras</li>
                            </ul>
                        </div>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> 
                        <strong>Importante:</strong> Mantén actualizada la información de contacto de tus proveedores. Esto es crucial para la gestión de pedidos y resolución de problemas.
                    </div>

                    <h4>Información Clave a Registrar:</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>📋 Datos Básicos:</h5>
                            <ul>
                                <li>Nombre completo</li>
                                <li>RUT o identificación</li>
                                <li>Giro o actividad</li>
                                <li>Dirección completa</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>📞 Datos de Contacto:</h5>
                            <ul>
                                <li>Teléfono principal</li>
                                <li>Email de contacto</li>
                                <li>Persona responsable</li>
                                <li>Horarios de atención</li>
                            </ul>
                        </div>
                    </div>

                    <h4>Condiciones Comerciales:</h4>
                    <ul>
                        <li>💰 <strong>Forma de Pago:</strong> Contado, 30 días, 60 días, etc.</li>
                        <li>🚚 <strong>Condiciones de Entrega:</strong> Tiempo, lugar, costos</li>
                        <li>📦 <strong>Cantidad Mínima:</strong> Pedidos mínimos</li>
                        <li>💯 <strong>Descuentos:</strong> Por volumen, pronto pago, etc.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- 10. Reportes -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning" id="reportes">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-bar"></i> 10. Reportes</h3>
                </div>
                <div class="card-body">
                    <h4>Tipos de Reportes Disponibles:</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <ul>
                                <li>📊 <strong>Reporte de Ventas:</strong> Análisis de ventas por período</li>
                                <li>📦 <strong>Reporte de Inventario:</strong> Estado del stock</li>
                                <li>👥 <strong>Reporte de Clientes:</strong> Análisis de clientes</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul>
                                <li>📅 <strong>Reporte Mensual:</strong> Resumen mensual</li>
                                <li>💰 <strong>Reporte de Comisiones:</strong> Comisiones de vendedores</li>
                                <li>⭐ <strong>Reporte de Calidad:</strong> Análisis por calidad</li>
                            </ul>
                        </div>
                    </div>

                    <h4>Generar Reportes:</h4>
                    <ol>
                        <li>Ir a <strong>Reportes</strong> en el menú</li>
                        <li>Seleccionar tipo de reporte</li>
                        <li>Configurar filtros:
                            <ul>
                                <li>Rango de fechas</li>
                                <li>Cliente específico</li>
                                <li>Vendedor específico</li>
                                <li>Categoría de producto</li>
                            </ul>
                        </li>
                        <li>Generar y descargar reporte</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- 11. Exportar/Importar -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary" id="exportar">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-download"></i> 11. Exportar/Importar Datos</h3>
                </div>
                <div class="card-body">
                    <h4>Exportar Productos:</h4>
                    <ol>
                        <li>Ir a <strong>Productos</strong></li>
                        <li>Hacer clic en "Exportar Productos"</li>
                        <li>Configurar campos a exportar</li>
                        <li>Aplicar filtros si es necesario</li>
                        <li>Descargar archivo CSV</li>
                    </ol>

                    <h4>Importar Productos (Actualización Masiva):</h4>
                    <ol>
                        <li>Exportar productos actuales</li>
                        <li>Abrir archivo CSV en Excel:
                            <ul>
                                <li>Ir a <strong>Datos → Texto en columnas</strong></li>
                                <li>Seleccionar <strong>Delimitado</strong></li>
                                <li>Marcar <strong>Punto y coma (;)</strong></li>
                                <li>Finalizar</li>
                            </ul>
                        </li>
                        <li>Realizar cambios necesarios</li>
                        <li>Guardar como CSV (UTF-8)</li>
                        <li>En el sistema, hacer clic "Importar Productos"</li>
                        <li>Seleccionar archivo y confirmar</li>
                    </ol>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> 
                        <strong>Importante:</strong> Siempre hacer respaldo antes de importar cambios masivos. La importación actualizará los productos existentes basándose en el ID.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 12. Sistema de Permisos -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-danger" id="permisos">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-key"></i> 12. Sistema de Permisos</h3>
                </div>
                <div class="card-body">
                    <h4>Roles de Usuario:</h4>
                    <ul>
                        <li>👑 <strong>Administrador:</strong> Acceso completo al sistema</li>
                        <li>👤 <strong>Vendedor:</strong> Acceso limitado a ventas y consultas</li>
                        <li>📊 <strong>Supervisor:</strong> Acceso a reportes y gestión básica</li>
                    </ul>

                    <h4>Categorías de Permisos:</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Permisos de Vista:</h5>
                            <ul>
                                <li>view_dashboard</li>
                                <li>view_products</li>
                                <li>view_sales</li>
                                <li>view_customers</li>
                                <li>view_reports_*</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Permisos de Acción:</h5>
                            <ul>
                                <li>create_* (crear)</li>
                                <li>edit_* (editar)</li>
                                <li>delete_* (eliminar)</li>
                                <li>toggle_* (activar/desactivar)</li>
                                <li>export_* (exportar)</li>
                            </ul>
                        </div>
                    </div>

                    <h4>Gestionar Permisos (Solo Administradores):</h4>
                    <ol>
                        <li>Ir a <strong>Usuarios</strong></li>
                        <li>Seleccionar usuario</li>
                        <li>Hacer clic en "Gestionar Permisos"</li>
                        <li>Asignar/Revocar permisos específicos</li>
                        <li>Guardar cambios</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- 13. Configuración -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-secondary" id="configuracion">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-cog"></i> 13. Configuración del Sistema</h3>
                </div>
                <div class="card-body">
                    <h4>Configuraciones Principales:</h4>
                    <ul>
                        <li>🏢 <strong>Información de la Empresa:</strong> Nombre, dirección, teléfono</li>
                        <li>💰 <strong>Moneda y Formato:</strong> Configuración regional</li>
                        <li>📧 <strong>Notificaciones:</strong> Emails automáticos</li>
                        <li>🔧 <strong>Parámetros del Sistema:</strong> Límites y configuraciones</li>
                    </ul>

                    <h4>Mantenimiento:</h4>
                    <ul>
                        <li>🧹 <strong>Limpiar Caché:</strong> <code>php artisan cache:clear</code></li>
                        <li>🔄 <strong>Limpiar Rutas:</strong> <code>php artisan route:clear</code></li>
                        <li>📝 <strong>Ver Logs:</strong> storage/logs/laravel.log</li>
                        <li>💾 <strong>Respaldos:</strong> Base de datos y archivos</li>
                    </ul>

                    <div class="alert alert-info">
                        <i class="fas fa-tools"></i> 
                        <strong>Mantenimiento Regular:</strong> Se recomienda limpiar caché semanalmente y hacer respaldos diarios.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 14. Soporte Técnico -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-success" id="soporte">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-life-ring"></i> 14. Soporte Técnico</h3>
                </div>
                <div class="card-body">
                    <h4>Información del Sistema:</h4>
                    <ul>
                        <li>🖥️ <strong>Framework:</strong> Laravel 12.x</li>
                        <li>🐘 <strong>PHP:</strong> 8.3.14</li>
                        <li>🗄️ <strong>Base de Datos:</strong> MySQL</li>
                        <li>🎨 <strong>Interfaz:</strong> AdminLTE 3.x</li>
                        <li>📊 <strong>Archivos:</strong> PhpSpreadsheet 5.1</li>
                    </ul>

                    <h4>Recursos de Ayuda:</h4>
                    <ul>
                        <li>📖 Este manual integrado</li>
                        <li>📋 Logs del sistema en storage/logs/</li>
                        <li>🔍 Herramientas de desarrollador del navegador (F12)</li>
                        <li>📧 Contacto con el desarrollador</li>
                    </ul>

                    <h4>Reportar Problemas:</h4>
                    <p>Al reportar un problema, incluir:</p>
                    <ul>
                        <li>Descripción detallada del problema</li>
                        <li>Pasos para reproducir el error</li>
                        <li>Capturas de pantalla si es necesario</li>
                        <li>Mensaje de error específico</li>
                        <li>Navegador y versión utilizada</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- 15. Preguntas Frecuentes -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning" id="faq">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-question-circle"></i> 15. Preguntas Frecuentes (FAQ)</h3>
                </div>
                <div class="card-body">
                    <div class="accordion" id="faqAccordion">
                        <!-- FAQ 1 -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#faq1">
                                        ❓ ¿Cómo cambio mi contraseña?
                                    </button>
                                </h5>
                            </div>
                            <div id="faq1" class="collapse" data-parent="#faqAccordion">
                                <div class="card-body">
                                    Ve a tu perfil (esquina superior derecha) → Configuración → Cambiar Contraseña. Ingresa tu contraseña actual y la nueva contraseña dos veces.
                                </div>
                            </div>
                        </div>

                        <!-- FAQ 2 -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#faq2">
                                        ❓ ¿Por qué aparece "Sin permisos" en algunas secciones?
                                    </button>
                                </h5>
                            </div>
                            <div id="faq2" class="collapse" data-parent="#faqAccordion">
                                <div class="card-body">
                                    Tu usuario no tiene los permisos necesarios para esa sección. Contacta al administrador para que te asigne los permisos correspondientes.
                                </div>
                            </div>
                        </div>

                        <!-- FAQ 3 -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#faq3">
                                        ❓ ¿Cómo actualizo muchos productos a la vez?
                                    </button>
                                </h5>
                            </div>
                            <div id="faq3" class="collapse" data-parent="#faqAccordion">
                                <div class="card-body">
                                    Utiliza la función Exportar → Editar en Excel → Importar. Exporta los productos, modifica los datos en Excel y luego importa el archivo actualizado.
                                </div>
                            </div>
                        </div>

                        <!-- FAQ 4 -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#faq4">
                                        ❓ ¿Puedo deshacer una venta procesada?
                                    </button>
                                </h5>
                            </div>
                            <div id="faq4" class="collapse" data-parent="#faqAccordion">
                                <div class="card-body">
                                    Sí, puedes cancelar una venta desde la lista de ventas usando el botón "Cancelar". Esto revertirá el stock y marcará la venta como cancelada.
                                </div>
                            </div>
                        </div>

                        <!-- FAQ 5 -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#faq5">
                                        ❓ ¿Cómo configuro las categorías y calidades?
                                    </button>
                                </h5>
                            </div>
                            <div id="faq5" class="collapse" data-parent="#faqAccordion">
                                <div class="card-body">
                                    Ve a Categorías o Calidades en el menú lateral. Puedes crear, editar y gestionar estas clasificaciones. Los productos se asocian automáticamente a estas categorías.
                                </div>
                            </div>
                        </div>

                        <!-- FAQ 6 -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#faq6">
                                        ❓ ¿Cuál es la diferencia entre categoría, calidad y proveedor?
                                    </button>
                                </h5>
                            </div>
                            <div id="faq6" class="collapse" data-parent="#faqAccordion">
                                <div class="card-body">
                                    <strong>Categoría:</strong> Tipo de producto (ej: Electrónicos, Ropa)<br>
                                    <strong>Calidad:</strong> Nivel o grado del producto (ej: Premium, Estándar)<br>
                                    <strong>Proveedor:</strong> Empresa que suministra el producto
                                </div>
                            </div>
                        </div>

                        <!-- FAQ 7 -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#faq7">
                                        ❓ ¿Puedo eliminar una categoría que tiene productos?
                                    </button>
                                </h5>
                            </div>
                            <div id="faq7" class="collapse" data-parent="#faqAccordion">
                                <div class="card-body">
                                    No, el sistema no permite eliminar categorías, calidades o proveedores que tienen productos asociados. Primero debes reasignar o eliminar los productos.
                                </div>
                            </div>
                        </div>

                        <!-- FAQ 8 -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#faq8">
                                        ❓ ¿Cómo cambio el proveedor de varios productos a la vez?
                                    </button>
                                </h5>
                            </div>
                            <div id="faq8" class="collapse" data-parent="#faqAccordion">
                                <div class="card-body">
                                    Usa la función Exportar → Editar en Excel → Importar. Exporta los productos, cambia la columna "Proveedor" en Excel y reimporta el archivo.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botón volver arriba -->
    <div class="row">
        <div class="col-md-12 text-center">
            <a href="#" class="btn btn-primary btn-lg">
                <i class="fas fa-arrow-up"></i> Volver Arriba
            </a>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .card {
        margin-bottom: 20px;
    }
    
    .btn-link {
        text-decoration: none;
        color: #007bff;
    }
    
    .btn-link:hover {
        text-decoration: underline;
    }
    
    html {
        scroll-behavior: smooth;
    }
    
    .card-header h3 {
        font-weight: bold;
    }
    
    .alert {
        border-left: 4px solid;
    }
    
    .alert-info {
        border-left-color: #17a2b8;
    }
    
    .alert-success {
        border-left-color: #28a745;
    }
    
    .alert-warning {
        border-left-color: #ffc107;
    }
    
    code {
        background: #f8f9fa;
        padding: 2px 6px;
        border-radius: 3px;
        font-family: 'Courier New', monospace;
    }
    
    .accordion .card {
        margin-bottom: 0;
    }
    
    .accordion .card-header {
        padding: 0;
    }
    
    .accordion .btn-link {
        padding: 15px;
        text-align: left;
        width: 100%;
        color: #333;
    }
</style>
@stop

@section('js')
<script>
$(document).ready(function() {
    // Smooth scrolling para enlaces internos
    $('a[href^="#"]').on('click', function(event) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top - 100
            }, 1000);
        }
    });
});
</script>
@stop