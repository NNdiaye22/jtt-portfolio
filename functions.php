<?php
/**
 * JTT Portfolio - functions.php
 * Enregistre styles, scripts, menus, CPT Projets, taxonomie catégories
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
    $v   = '1.0.1';
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

    wp_enqueue_script('jtt-loader',  $uri.'/assets/js/loader.js',  [], $v, true);
    wp_enqueue_script('jtt-cursor',  $uri.'/assets/js/cursor.js',  ['jtt-loader'], $v, true);
    wp_enqueue_script('jtt-menu',    $uri.'/assets/js/menu.js',    ['jtt-loader'], $v, true);
    wp_enqueue_script('jtt-reveal',  $uri.'/assets/js/reveal.js',  ['jtt-loader'], $v, true);

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


// TAXONOMIE : CATÉGORIE DE PROJET
function jtt_register_taxonomies() {
    register_taxonomy('categorie_projet', 'projet', [
        'labels' => [
            'name'              => 'Catégories de projet',
            'singular_name'     => 'Catégorie de projet',
            'search_items'      => 'Rechercher une catégorie',
            'all_items'         => 'Toutes les catégories',
            'edit_item'         => 'Modifier la catégorie',
            'update_item'       => 'Mettre à jour la catégorie',
            'add_new_item'      => 'Ajouter une catégorie',
            'new_item_name'     => 'Nom de la nouvelle catégorie',
            'menu_name'         => 'Catégories',
        ],
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'rewrite'           => ['slug' => 'categorie-projet'],
    ]);
}
add_action('init', 'jtt_register_taxonomies');


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


// ────────────────────────────────────────────────────────────
// META BOX PROJETS — Sections dynamiques JSON
// ────────────────────────────────────────────────────────────

// Enregistrement de la meta box
function jtt_projet_meta_box() {
    add_meta_box(
        'jtt_projet_details',
        __('Détails du projet', 'jtt-portfolio'),
        'jtt_projet_meta_box_html',
        'projet',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'jtt_projet_meta_box');

// Affichage de la meta box
function jtt_projet_meta_box_html($post) {
    wp_nonce_field('jtt_projet_save', 'jtt_projet_nonce');

    $annee      = get_post_meta($post->ID, 'projet_annee',          true);
    $sous_titre = get_post_meta($post->ID, 'projet_sous_titre',     true);
    $editorial  = get_post_meta($post->ID, 'projet_editorial',      true);
    $sections   = get_post_meta($post->ID, 'projet_sections_json',  true);
    $en_prod    = get_post_meta($post->ID, 'projet_en_production',  true);
    ?>
    <style>
        .jtt-meta-row { margin-bottom: 1.5em; }
        .jtt-meta-row label { display: block; font-weight: 600; margin-bottom: 0.4em; }
        .jtt-meta-row input[type=text],
        .jtt-meta-row textarea { width: 100%; padding: 0.5em; }
        .jtt-meta-row textarea { min-height: 120px; }
    </style>

    <div class="jtt-meta-row">
        <label for="projet_annee"><?php _e('Année (ex. 2025, 2026)', 'jtt-portfolio'); ?></label>
        <input type="text" id="projet_annee" name="projet_annee" value="<?php echo esc_attr($annee); ?>" />
    </div>

    <div class="jtt-meta-row">
        <label for="projet_sous_titre"><?php _e('Sous-titre (ex. ORANGE IS THE NEW BLACK - 2025)', 'jtt-portfolio'); ?></label>
        <input type="text" id="projet_sous_titre" name="projet_sous_titre" value="<?php echo esc_attr($sous_titre); ?>" />
    </div>

    <div class="jtt-meta-row">
        <label for="projet_editorial"><?php _e('Texte éditorial (description du projet)', 'jtt-portfolio'); ?></label>
        <textarea id="projet_editorial" name="projet_editorial" rows="8"><?php echo esc_textarea($editorial); ?></textarea>
    </div>

    <div class="jtt-meta-row">
        <label for="projet_en_production">
            <input type="checkbox" id="projet_en_production" name="projet_en_production" value="1" <?php checked($en_prod, '1'); ?> />
            <?php _e('Collection en production (afficher la mention "This collection is currently in production...")', 'jtt-portfolio'); ?>
        </label>
    </div>

    <hr>

    <div class="jtt-meta-row">
        <h3><?php _e('Sections du projet (JSON)', 'jtt-portfolio'); ?></h3>
        <p style="color:#666; font-size:0.9em;">
            <?php _e('Collez ici le JSON généré par le guide. Exemple :', 'jtt-portfolio'); ?><br>
            <code style="display:inline-block; background:#e8e8e8; padding:0.5em; margin-top:0.5em;">
                [{"titre":"Moodboard","type":"galerie","images":[{"url":"...","alt":"..."}]}]
            </code>
        </p>
        <textarea id="projet_sections_json" name="projet_sections_json" rows="10" style="font-family:monospace;"><?php echo esc_textarea($sections); ?></textarea>
    </div>
    <?php
}

// Sauvegarde
function jtt_projet_save_meta($post_id) {
    if (!isset($_POST['jtt_projet_nonce']) || !wp_verify_nonce($_POST['jtt_projet_nonce'], 'jtt_projet_save')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['projet_annee'])) {
        update_post_meta($post_id, 'projet_annee', sanitize_text_field($_POST['projet_annee']));
    }
    if (isset($_POST['projet_sous_titre'])) {
        update_post_meta($post_id, 'projet_sous_titre', sanitize_text_field($_POST['projet_sous_titre']));
    }
    if (isset($_POST['projet_editorial'])) {
        update_post_meta($post_id, 'projet_editorial', wp_kses_post($_POST['projet_editorial']));
    }
    if (isset($_POST['projet_sections_json'])) {
        $json    = stripslashes($_POST['projet_sections_json']);
        $decoded = json_decode($json, true);
        if (json_last_error() === JSON_ERROR_NONE || empty(trim($json))) {
            update_post_meta($post_id, 'projet_sections_json', wp_kses_post($json));
        } else {
            add_action('admin_notices', function() {
                echo '<div class="error"><p>' . __('Erreur : JSON des sections invalide, non sauvegardé.', 'jtt-portfolio') . '</p></div>';
            });
        }
    }
    $en_prod = isset($_POST['projet_en_production']) ? '1' : '0';
    update_post_meta($post_id, 'projet_en_production', $en_prod);
}
add_action('save_post_projet', 'jtt_projet_save_meta');
