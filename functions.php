<?php
/**
 * JTT Portfolio - functions.php
 * Enregistre styles, scripts, menus, CPT Projets
 */

// SETUP
function jtt_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption']);
    register_nav_menus(['primary' => 'Navigation principale']);
}
add_action('after_setup_theme', 'jtt_setup');


// STYLES & SCRIPTS
function jtt_enqueue_assets() {
    $v   = '1.0.0';
    $uri = get_template_directory_uri();

    wp_enqueue_style('jtt-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Inter:wght@200;300;400&display=swap',
        [], null
    );
    wp_enqueue_style('jtt-global',  $uri.'/assets/css/global.css',  ['jtt-fonts'], $v);
    wp_enqueue_style('jtt-mobile',  $uri.'/assets/css/mobile.css',  ['jtt-global'], $v);

    if (is_front_page()) {
        wp_enqueue_style('jtt-home', $uri.'/assets/css/home.css', ['jtt-global'], $v);
    }
    if (is_singular('projet')) {
        wp_enqueue_style('jtt-project', $uri.'/assets/css/project.css', ['jtt-global'], $v);
    }

    wp_enqueue_script('jtt-loader',   $uri.'/assets/js/loader.js',   [], $v, true);
    wp_enqueue_script('jtt-cursor',   $uri.'/assets/js/cursor.js',   ['jtt-loader'], $v, true);
    wp_enqueue_script('jtt-menu',     $uri.'/assets/js/menu.js',     ['jtt-loader'], $v, true);
    wp_enqueue_script('jtt-reveal',   $uri.'/assets/js/reveal.js',   ['jtt-loader'], $v, true);

    if (is_singular('projet')) {
        wp_enqueue_script('jtt-lightbox', $uri.'/assets/js/lightbox.js', ['jtt-loader'], $v, true);
    }

    wp_localize_script('jtt-loader', 'JTT', [
        'homeUrl'  => esc_url(home_url('/')),
        'themeUri' => esc_url($uri),
    ]);
}
add_action('wp_enqueue_scripts', 'jtt_enqueue_assets');


// CUSTOM POST TYPE : PROJET
function jtt_register_cpt() {
    register_post_type('projet', [
        'labels' => [
            'name'          => 'Projets',
            'singular_name' => 'Projet',
            'add_new_item'  => 'Ajouter un projet',
            'edit_item'     => 'Modifier le projet',
            'view_item'     => 'Voir le projet',
            'not_found'     => 'Aucun projet trouvé',
        ],
        'public'        => true,
        'has_archive'   => false,
        'supports'      => ['title', 'editor', 'thumbnail', 'page-attributes'],
        'menu_icon'     => 'dashicons-portfolio',
        'show_in_rest'  => true,
        'rewrite'       => ['slug' => 'projet'],
        'menu_position' => 5,
    ]);
}
add_action('init', 'jtt_register_cpt');


// ALERTE SI ACF MANQUANT
function jtt_check_acf() {
    if (!function_exists('get_field') && current_user_can('manage_options')) {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-warning is-dismissible"><p>'
               . '<strong>JTT Portfolio :</strong> Installez le plugin '
               . '<a href="https://wordpress.org/plugins/advanced-custom-fields/" target="_blank">'
               . 'Advanced Custom Fields (ACF)</a> pour activer tous les champs personnalisés.'
               . '</p></div>';
        });
    }
}
add_action('after_setup_theme', 'jtt_check_acf');


// HELPERS
function jtt_get_projets($limit = -1) {
    return new WP_Query([
        'post_type'      => 'projet',
        'posts_per_page' => $limit,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'post_status'    => 'publish',
    ]);
}

function jtt_get_other_projets($exclude_id, $limit = 3) {
    return new WP_Query([
        'post_type'      => 'projet',
        'posts_per_page' => $limit,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'post_status'    => 'publish',
        'post__not_in'   => [$exclude_id],
    ]);
}

// TITRE DES ONGLETS
add_filter('pre_get_document_title', function($t) {
    if (is_front_page()) return 'Julien Terence Tegnan — Styliste de Mode';
    return $t . ' — Julien Terence Tegnan';
});
