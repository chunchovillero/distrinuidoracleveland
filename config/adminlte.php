<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'Sistema POS',
    'title_prefix' => '',
    'title_postfix' => ' - Admin',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>Sistema</b>POS',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'POS Logo',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration. Currently, two
    | modes are supported: 'fullscreen' for a fullscreen preloader animation
    | and 'cwrapper' to attach the preloader animation into the content-wrapper
    | element and avoid overlapping it with the sidebars and the top navbar.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'admin',
    'logout_url' => 'admin/logout',
    'login_url' => 'admin/login',
    'register_url' => 'admin/register',
    'password_reset_url' => 'admin/password/reset',
    'password_email_url' => 'admin/password/email',
    'profile_url' => false,
    'disable_darkmode_routes' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Asset Bundling
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Asset Bundling option for the admin panel.
    | Currently, the next modes are supported: 'mix', 'vite' and 'vite_js_only'.
    | When using 'vite_js_only', it's expected that your CSS is imported using
    | JavaScript. Typically, in your application's 'resources/js/app.js' file.
    | If you are not using any of these, leave it as 'false'.
    |
    | For detailed instructions you can look the asset bundling section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'laravel_asset_bundling' => false,
    'laravel_css_path' => 'css/app.css',
    'laravel_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'type' => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        [
            'text' => 'Dashboard',
            'route' => 'admin.dashboard',
            'icon' => 'fas fa-fw fa-tachometer-alt',
            'can' => 'view-dashboard',
            'class' => 'text-yellow',
        ],

        ['header' => 'ACCESOS RÁPIDOS'],
        [
            'text' => 'Nueva Venta',
            'route' => 'admin.sales.create',
            'icon' => 'fas fa-fw fa-plus-circle',
            'class' => 'text-success',
            'can' => 'create-sales',
        ],
        [
            'text' => 'Ver Ventas',
            'route' => 'admin.sales.index',
            'icon' => 'fas fa-fw fa-shopping-cart',
            'class' => 'text-info',
            'can' => 'view-sales',
        ],
        [
            'text' => 'Tipos de Despacho',
            'route' => 'admin.dispatch-types.index',
            'icon' => 'fas fa-fw fa-truck',
            'class' => 'text-info',
            'can' => 'view-categories',
        ],
        [
            'text' => 'Nuevo Producto',
            'route' => 'admin.products.create',
            'icon' => 'fas fa-fw fa-plus-square',
            'class' => 'text-primary',
            'can' => 'create-products',
        ],

        ['header' => 'CATÁLOGO Y PRODUCTOS'],
        [
            'text' => 'Gestión de Productos',
            'icon' => 'fas fa-fw fa-cube',
            'class' => 'text-primary',
            'can' => 'view-products',
            'submenu' => [
                [
                    'text' => 'Todos los Productos',
                    'route' => 'admin.products.index',
                    'icon' => 'fas fa-fw fa-boxes',
                ],
                [
                    'text' => 'Nuevo Producto',
                    'route' => 'admin.products.create',
                    'icon' => 'fas fa-fw fa-plus',
                    'can' => 'create-products',
                ],
                [
                    'text' => 'Categorías',
                    'route' => 'admin.categories.index',
                    'icon' => 'fas fa-fw fa-tags',
                    'can' => 'view-categories',
                ],
                [
                    'text' => 'Calidad',
                    'route' => 'admin.calidad.index',
                    'icon' => 'fas fa-fw fa-star',
                    'can' => 'view-categories',
                ],
            ],
        ],

        ['header' => 'RELACIONES COMERCIALES'],
        [
            'text' => 'Clientes',
            'route' => 'admin.customers.index',
            'icon' => 'fas fa-fw fa-users',
            'class' => 'text-info',
            'can' => 'view-customers',
        ],
        [
            'text' => 'Proveedores',
            'route' => 'admin.proveedores.index',
            'icon' => 'fas fa-fw fa-truck',
            'class' => 'text-warning',
            'can' => 'view-customers',
        ],
        [
            'text' => 'Vendedores',
            'route' => 'admin.sellers.index',
            'icon' => 'fas fa-fw fa-user-tie',
            'class' => 'text-success',
            'can' => 'view-sellers',
        ],

        ['header' => 'ANÁLISIS Y REPORTES'],
        [
            'text' => 'Reportes Ejecutivos',
            'icon' => 'fas fa-fw fa-chart-line',
            'class' => 'text-warning',
            'submenu' => [
                [
                    'text' => 'Reporte Mensual',
                    'route' => 'admin.reports.monthly',
                    'icon' => 'fas fa-fw fa-calendar-alt',
                    'can' => 'view-reports-monthly',
                ],
                [
                    'text' => 'Análisis de Ventas',
                    'route' => 'admin.reports.sales',
                    'icon' => 'fas fa-fw fa-chart-bar',
                    'can' => 'view-reports-sales',
                ],
                [
                    'text' => 'Estado de Inventario',
                    'route' => 'admin.reports.inventory',
                    'icon' => 'fas fa-fw fa-warehouse',
                    'can' => 'view-reports-inventory',
                ],
            ],
        ],
        [
            'text' => 'Reportes Financieros',
            'icon' => 'fas fa-fw fa-dollar-sign',
            'class' => 'text-success',
            'submenu' => [
                [
                    'text' => 'Comisiones',
                    'route' => 'admin.reports.commissions',
                    'icon' => 'fas fa-fw fa-percentage',
                    'can' => 'view-reports-commissions',
                ],
                [
                    'text' => 'Clientes Top',
                    'route' => 'admin.reports.customers',
                    'icon' => 'fas fa-fw fa-star',
                    'can' => 'view-reports-customers',
                ],
                [
                    'text' => 'Calidad de Productos',
                    'route' => 'admin.reports.calidad',
                    'icon' => 'fas fa-fw fa-chart-pie',
                    'can' => 'view-reports-calidad',
                ],
            ],
        ],

        ['header' => 'ADMINISTRACIÓN DEL SISTEMA', 'can' => 'manage-users'],
        [
            'text' => 'Gestión de Usuarios',
            'icon' => 'fas fa-fw fa-users-cog',
            'class' => 'text-danger',
            'can' => 'manage-users',
            'submenu' => [
                [
                    'text' => 'Todos los Usuarios',
                    'route' => 'admin.users.index',
                    'icon' => 'fas fa-fw fa-list',
                ],
                [
                    'text' => 'Crear Usuario',
                    'route' => 'admin.users.create',
                    'icon' => 'fas fa-fw fa-user-plus',
                    'can' => 'manage-admin',
                ],
                [
                    'text' => 'Administradores',
                    'url' => 'admin/users/role/admin',
                    'icon' => 'fas fa-fw fa-crown',
                ],
                [
                    'text' => 'Usuarios Regulares',
                    'url' => 'admin/users/role/user',
                    'icon' => 'fas fa-fw fa-user',
                ],
            ],
        ],

        ['header' => 'HERRAMIENTAS'],
        [
            'text' => 'Configuración',
            'route' => 'admin.configuration.index',
            'icon' => 'fas fa-fw fa-cogs',
            'class' => 'text-warning',
            'can' => 'manage-system',
        ],
        [
            'text' => 'Manual del Sistema',
            'route' => 'admin.manual.index',
            'icon' => 'fas fa-fw fa-book',
            'class' => 'text-success',
        ],
        [
            'text' => 'Catálogo Público',
            'url' => '/',
            'icon' => 'fas fa-fw fa-external-link-alt',
            'target' => '_blank',
            'class' => 'text-secondary',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'css/custom.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
