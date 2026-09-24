<style>
:root {
    --primary-color: {{ $systemConfig['primary_color'] ?? '#007bff' }};
    --secondary-color: {{ $systemConfig['secondary_color'] ?? '#6c757d' }};
    --accent-color: {{ $systemConfig['accent_color'] ?? '#28a745' }};
}

/* AdminLTE Theme Override */
.main-header .navbar-light {
    background-color: var(--primary-color) !important;
}

.main-sidebar .sidebar-dark-primary {
    background-color: var(--primary-color) !important;
}

.btn-primary {
    background-color: var(--primary-color) !important;
    border-color: var(--primary-color) !important;
}

.btn-primary:hover,
.btn-primary:focus,
.btn-primary:active {
    background-color: var(--accent-color) !important;
    border-color: var(--accent-color) !important;
}

.card-primary.card-outline {
    border-top: 3px solid var(--primary-color) !important;
}

/* Enlaces y elementos de navegación */
.main-sidebar .nav-link:hover {
    background-color: var(--accent-color) !important;
}

.main-sidebar .nav-link.active {
    background-color: var(--accent-color) !important;
}

/* Botones secundarios */
.btn-secondary {
    background-color: var(--secondary-color) !important;
    border-color: var(--secondary-color) !important;
}

/* Alertas y notificaciones */
.alert-success {
    background-color: var(--accent-color) !important;
    border-color: var(--accent-color) !important;
}

/* DataTables personalización */
.table thead th {
    background-color: var(--primary-color) !important;
    color: white !important;
}

/* Paginación */
.page-item.active .page-link {
    background-color: var(--primary-color) !important;
    border-color: var(--primary-color) !important;
}

.page-link {
    color: var(--primary-color) !important;
}

.page-link:hover {
    color: var(--accent-color) !important;
}

/* Logos personalizados */
.brand-image {
    max-height: 40px !important;
    width: auto !important;
}

.catalog-logo {
    max-height: 60px !important;
    width: auto !important;
}

/* Dark mode styles */
@if(($systemConfig['enable_dark_mode'] ?? 'false') === 'true')
body {
    background-color: #2c3e50 !important;
    color: #ecf0f1 !important;
}

.card {
    background-color: #34495e !important;
    color: #ecf0f1 !important;
}

.card-header {
    background-color: #2c3e50 !important;
}

.table {
    color: #ecf0f1 !important;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(255, 255, 255, 0.05) !important;
}
@endif
</style>
<style>
.flash-alert {
    position: fixed !important;
    top: 75px;
    right: 24px;
    z-index: 9999;
    min-width: 320px;
    max-width: 480px;
    box-shadow: 0 4px 14px rgba(0,0,0,.2);
}
</style>
