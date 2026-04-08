<?php
/**
 * JTT Portfolio - functions.php
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
    $v   = '1.0.3';
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


// IMAGES EXTERNES
add_filter('post_thumbnail_url', function($url, $post_id, $size) {
    if (!$url) {
        $ext = get_post_meta($post_id, '_thumbnail_external', true);
        if ($ext) return $ext;
    }
    return $url;
}, 10, 3);


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


// ============================================================
// PANNEAU D'OPTIONS JTT — Réglages → JTT Options
// ============================================================

function jtt_options_menu() {
    add_options_page(
        'JTT Portfolio Options',
        'JTT Options',
        'manage_options',
        'jtt-options',
        'jtt_options_page_html'
    );
}
add_action('admin_menu', 'jtt_options_menu');

function jtt_options_register() {
    register_setting('jtt_options_group', 'jtt_options', [
        'sanitize_callback' => 'jtt_sanitize_options',
    ]);
}
add_action('admin_init', 'jtt_options_register');

function jtt_sanitize_options($input) {
    $clean = [];
    $text_fields = [
        'hero_subtitle', 'hero_quote', 'hero_quote_author',
        'hero_btn_1_label', 'hero_btn_2_label',
        'hero_instagram_url', 'hero_email',
        'work_label', 'work_title_line1', 'work_title_line2',
        'manifesto_line1', 'manifesto_line2', 'manifesto_line3',
        'about_label', 'about_name',
        'about_bio_1', 'about_bio_2',
        'about_meta_formation', 'about_meta_base',
        'about_meta_specialites', 'about_meta_contact',
        'footer_tagline', 'footer_copy',
        'instagram_url', 'linkedin_url', 'email_contact',
    ];
    foreach ($text_fields as $field) {
        $clean[$field] = isset($input[$field]) ? sanitize_text_field($input[$field]) : '';
    }
    // URL fields
    $url_fields = ['hero_bg_image', 'about_image'];
    foreach ($url_fields as $field) {
        $clean[$field] = isset($input[$field]) ? esc_url_raw($input[$field]) : '';
    }
    return $clean;
}

function jtt_opt($key, $fallback = '') {
    $opts = get_option('jtt_options', []);
    return isset($opts[$key]) && $opts[$key] !== '' ? $opts[$key] : $fallback;
}

function jtt_options_page_html() {
    if (!current_user_can('manage_options')) return;
    if (isset($_GET['settings-updated'])) {
        add_settings_error('jtt_options', 'jtt_saved', 'Options enregistrées avec succès.', 'updated');
    }
    settings_errors('jtt_options');
    $o = get_option('jtt_options', []);
    function v($o, $k, $d = '') { return esc_attr(isset($o[$k]) && $o[$k] !== '' ? $o[$k] : $d); }
    ?>
    <div class="wrap">
    <h1>🎨 JTT Portfolio — Options du thème</h1>
    <form method="post" action="options.php">
    <?php settings_fields('jtt_options_group'); ?>

    <style>
        .jtt-section { background:#fff; border:1px solid #ddd; border-radius:6px; padding:24px 28px; margin-bottom:28px; }
        .jtt-section h2 { margin-top:0; font-size:15px; text-transform:uppercase; letter-spacing:.08em; color:#555; border-bottom:1px solid #eee; padding-bottom:12px; }
        .jtt-row { display:grid; grid-template-columns:200px 1fr; gap:12px 20px; align-items:center; margin-bottom:14px; }
        .jtt-row label { font-weight:600; font-size:13px; }
        .jtt-row input[type=text], .jtt-row textarea { width:100%; padding:6px 10px; border:1px solid #ccc; border-radius:4px; font-size:13px; }
        .jtt-row textarea { min-height:80px; resize:vertical; }
        .jtt-hint { color:#888; font-size:11px; grid-column:2; margin-top:-8px; }
        .jtt-img-preview { max-width:200px; max-height:120px; border-radius:4px; margin-top:6px; display:block; }
    </style>

    <!-- SECTION HERO -->
    <div class="jtt-section">
        <h2>🖼️ Section Hero (page d'accueil)</h2>

        <div class="jtt-row">
            <label>Image de fond (URL)</label>
            <div>
                <input type="text" name="jtt_options[hero_bg_image]" value="<?php echo v($o,'hero_bg_image','https://cdn.myportfolio.com/4b129293-66fb-48ba-b250-1e6e7c44c8e2/120ebdea-6fc0-40ad-acb7-7f7bd166ad34,rw_1200.jpeg?h=7e9e9292dafa2ba8a6a7daf28675aad2'); ?>" />
                <?php $bg = isset($o['hero_bg_image']) && $o['hero_bg_image'] ? $o['hero_bg_image'] : ''; if ($bg): ?>
                <img src="<?php echo esc_url($bg); ?>" class="jtt-img-preview" alt="">
                <?php endif; ?>
            </div>
        </div>
        <p class="jtt-hint" style="grid-column:2;margin-left:220px;">Colle l'URL de l'image ou uploade via Médiathèque puis copie l'URL.</p>

        <div class="jtt-row">
            <label>Sous-titre hero</label>
            <input type="text" name="jtt_options[hero_subtitle]" value="<?php echo v($o,'hero_subtitle','Styliste de Mode &nbsp;&bull;&nbsp; Paris'); ?>" />
        </div>

        <div class="jtt-row">
            <label>Citation</label>
            <input type="text" name="jtt_options[hero_quote]" value="<?php echo v($o,'hero_quote',"La mode est ce que l'on porte. Ce qui est démodé, c'est ce que portent les autres."); ?>" />
        </div>

        <div class="jtt-row">
            <label>Auteur de la citation</label>
            <input type="text" name="jtt_options[hero_quote_author]" value="<?php echo v($o,'hero_quote_author','Oscar Wilde'); ?>" />
        </div>

        <div class="jtt-row">
            <label>Bouton 1 (label)</label>
            <input type="text" name="jtt_options[hero_btn_1_label]" value="<?php echo v($o,'hero_btn_1_label','Découvrir mes projets'); ?>" />
        </div>

        <div class="jtt-row">
            <label>Bouton 2 (label)</label>
            <input type="text" name="jtt_options[hero_btn_2_label]" value="<?php echo v($o,'hero_btn_2_label','À propos'); ?>" />
        </div>
    </div>

    <!-- SECTION WORK -->
    <div class="jtt-section">
        <h2>💼 Section Travaux</h2>

        <div class="jtt-row">
            <label>Label section</label>
            <input type="text" name="jtt_options[work_label]" value="<?php echo v($o,'work_label','Portfolio 2021–2026'); ?>" />
        </div>

        <div class="jtt-row">
            <label>Titre ligne 1</label>
            <input type="text" name="jtt_options[work_title_line1]" value="<?php echo v($o,'work_title_line1','Discover'); ?>" />
        </div>

        <div class="jtt-row">
            <label>Titre ligne 2</label>
            <input type="text" name="jtt_options[work_title_line2]" value="<?php echo v($o,'work_title_line2','My Work'); ?>" />
        </div>
    </div>

    <!-- SECTION MANIFESTO -->
    <div class="jtt-section">
        <h2>✏️ Section Manifesto</h2>

        <div class="jtt-row">
            <label>Ligne 1</label>
            <input type="text" name="jtt_options[manifesto_line1]" value="<?php echo v($o,'manifesto_line1','Chaque vêtement est une déclaration,'); ?>" />
        </div>
        <div class="jtt-row">
            <label>Ligne 2</label>
            <input type="text" name="jtt_options[manifesto_line2]" value="<?php echo v($o,'manifesto_line2','chaque tissu une langue,'); ?>" />
        </div>
        <div class="jtt-row">
            <label>Ligne 3</label>
            <input type="text" name="jtt_options[manifesto_line3]" value="<?php echo v($o,'manifesto_line3','chaque silhouette une histoire.'); ?>" />
        </div>
    </div>

    <!-- SECTION ABOUT -->
    <div class="jtt-section">
        <h2>👤 Section About (page d'accueil)</h2>

        <div class="jtt-row">
            <label>Photo about (URL)</label>
            <div>
                <input type="text" name="jtt_options[about_image]" value="<?php echo v($o,'about_image','https://cdn.myportfolio.com/4b129293-66fb-48ba-b250-1e6e7c44c8e2/2fbe3839-7309-4d05-aef5-fcfc84aadb16,rw_1200.jpeg?h=83c4acf4c9aa74751eb5e78ed4715d02'); ?>" />
                <?php $ai = isset($o['about_image']) && $o['about_image'] ? $o['about_image'] : ''; if ($ai): ?>
                <img src="<?php echo esc_url($ai); ?>" class="jtt-img-preview" alt="">
                <?php endif; ?>
            </div>
        </div>

        <div class="jtt-row">
            <label>Label section</label>
            <input type="text" name="jtt_options[about_label]" value="<?php echo v($o,'about_label','À Propos'); ?>" />
        </div>

        <div class="jtt-row">
            <label>Nom complet</label>
            <input type="text" name="jtt_options[about_name]" value="<?php echo v($o,'about_name','Julien Terence Tegnan'); ?>" />
        </div>

        <div class="jtt-row">
            <label>Bio paragraphe 1</label>
            <textarea name="jtt_options[about_bio_1]"><?php echo esc_textarea(isset($o['about_bio_1']) ? $o['about_bio_1'] : 'Julien Terence Tegnan est un styliste de mode parisien né au cœur de deux cultures : la rigueur du continent africain et l’élégance du Paris couture. Diplomé de l’ESMOD Paris avec les félicitations du jury, il construit depuis 2018 un langage visuel qui réconcilie la modernité afropolitaine avec les codes du luxe européen.'); ?></textarea>
        </div>

        <div class="jtt-row">
            <label>Bio paragraphe 2</label>
            <textarea name="jtt_options[about_bio_2]"><?php echo esc_textarea(isset($o['about_bio_2']) ? $o['about_bio_2'] : 'Ses collections explorent les textures de la mémoire, les géographies du corps et la poésie du quotidien. Travaillant à l’intersection du prêt-à-porter et de la haute couture, Julien collabore avec des photographes, des danseurs et des architectes pour faire de chaque défilé une expérience sensorielle totale.'); ?></textarea>
        </div>

        <div class="jtt-row">
            <label>Méta : Formation</label>
            <input type="text" name="jtt_options[about_meta_formation]" value="<?php echo v($o,'about_meta_formation','ESMOD Paris — Diplôme Supérieur'); ?>" />
        </div>
        <div class="jtt-row">
            <label>Méta : Basé</label>
            <input type="text" name="jtt_options[about_meta_base]" value="<?php echo v($o,'about_meta_base','Paris, France'); ?>" />
        </div>
        <div class="jtt-row">
            <label>Méta : Spécialités</label>
            <input type="text" name="jtt_options[about_meta_specialites]" value="<?php echo v($o,'about_meta_specialites','Mode afro-contemporaine, Styling éditorial'); ?>" />
        </div>
        <div class="jtt-row">
            <label>Méta : Contact</label>
            <input type="text" name="jtt_options[about_meta_contact]" value="<?php echo v($o,'about_meta_contact','julien.tegnan@fr.esmod.net'); ?>" />
        </div>
    </div>

    <!-- SECTION CONTACTS & RÉSEAUX -->
    <div class="jtt-section">
        <h2>🔗 Contacts &amp; Réseaux sociaux</h2>

        <div class="jtt-row">
            <label>Instagram URL</label>
            <input type="text" name="jtt_options[instagram_url]" value="<?php echo v($o,'instagram_url','https://www.instagram.com/j.tegnan'); ?>" />
        </div>
        <div class="jtt-row">
            <label>LinkedIn URL</label>
            <input type="text" name="jtt_options[linkedin_url]" value="<?php echo v($o,'linkedin_url',''); ?>" />
        </div>
        <div class="jtt-row">
            <label>Email de contact</label>
            <input type="text" name="jtt_options[email_contact]" value="<?php echo v($o,'email_contact','julien.tegnan@fr.esmod.net'); ?>" />
        </div>
    </div>

    <!-- FOOTER -->
    <div class="jtt-section">
        <h2>📌 Footer</h2>

        <div class="jtt-row">
            <label>Tagline footer</label>
            <input type="text" name="jtt_options[footer_tagline]" value="<?php echo v($o,'footer_tagline','Styliste de Mode — Paris'); ?>" />
        </div>
        <div class="jtt-row">
            <label>Mention copyright</label>
            <input type="text" name="jtt_options[footer_copy]" value="<?php echo v($o,'footer_copy','© 2026 Julien Terence Tegnan. Tous droits réservés.'); ?>" />
        </div>
    </div>

    <?php submit_button('Enregistrer les options'); ?>
    </form>
    </div>
    <?php
}


// ============================================================
// META BOX PROJETS
// ============================================================

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

function jtt_projet_meta_box_html($post) {
    wp_nonce_field('jtt_projet_save', 'jtt_projet_nonce');

    $annee      = get_post_meta($post->ID, 'projet_annee',          true);
    $sous_titre = get_post_meta($post->ID, 'projet_sous_titre',     true);
    $editorial  = get_post_meta($post->ID, 'projet_editorial',      true);
    $sections   = get_post_meta($post->ID, 'projet_sections_json',  true);
    $en_prod    = get_post_meta($post->ID, 'projet_en_production',  true);
    $ext_thumb  = get_post_meta($post->ID, '_thumbnail_external',   true);
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
        <label for="projet_sous_titre"><?php _e('Sous-titre', 'jtt-portfolio'); ?></label>
        <input type="text" id="projet_sous_titre" name="projet_sous_titre" value="<?php echo esc_attr($sous_titre); ?>" />
    </div>

    <div class="jtt-meta-row">
        <label for="projet_editorial"><?php _e('Texte éditorial', 'jtt-portfolio'); ?></label>
        <textarea id="projet_editorial" name="projet_editorial" rows="8"><?php echo esc_textarea($editorial); ?></textarea>
    </div>

    <div class="jtt-meta-row">
        <label for="_thumbnail_external"><?php _e('URL image miniature externe (remplacée dès qu\'une image WP est assignée)', 'jtt-portfolio'); ?></label>
        <input type="text" id="_thumbnail_external" name="_thumbnail_external" value="<?php echo esc_url($ext_thumb); ?>" placeholder="https://cdn.example.com/image.jpg" />
    </div>

    <div class="jtt-meta-row">
        <label for="projet_en_production">
            <input type="checkbox" id="projet_en_production" name="projet_en_production" value="1" <?php checked($en_prod, '1'); ?> />
            <?php _e('Collection en production', 'jtt-portfolio'); ?>
        </label>
    </div>

    <hr>

    <div class="jtt-meta-row">
        <h3><?php _e('Sections du projet (JSON)', 'jtt-portfolio'); ?></h3>
        <p style="color:#666; font-size:0.9em;">
            <?php _e('Collez ici le JSON des sections. Exemple :', 'jtt-portfolio'); ?><br>
            <code style="display:inline-block; background:#e8e8e8; padding:0.5em; margin-top:0.5em;">
                [{"titre":"Moodboard","type":"galerie","images":[{"url":"...","alt":"..."}]}]
            </code>
        </p>
        <textarea id="projet_sections_json" name="projet_sections_json" rows="10" style="font-family:monospace;"><?php echo esc_textarea($sections); ?></textarea>
    </div>
    <?php
}

function jtt_projet_save_meta($post_id) {
    if (!isset($_POST['jtt_projet_nonce']) || !wp_verify_nonce($_POST['jtt_projet_nonce'], 'jtt_projet_save')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['projet_annee']))
        update_post_meta($post_id, 'projet_annee', sanitize_text_field($_POST['projet_annee']));
    if (isset($_POST['projet_sous_titre']))
        update_post_meta($post_id, 'projet_sous_titre', sanitize_text_field($_POST['projet_sous_titre']));
    if (isset($_POST['projet_editorial']))
        update_post_meta($post_id, 'projet_editorial', wp_kses_post($_POST['projet_editorial']));
    if (isset($_POST['_thumbnail_external']))
        update_post_meta($post_id, '_thumbnail_external', esc_url_raw($_POST['_thumbnail_external']));
    if (isset($_POST['projet_sections_json'])) {
        $json = stripslashes($_POST['projet_sections_json']);
        if (json_last_error() === JSON_ERROR_NONE || empty(trim($json)))
            update_post_meta($post_id, 'projet_sections_json', wp_kses_post($json));
    }
    $en_prod = isset($_POST['projet_en_production']) ? '1' : '0';
    update_post_meta($post_id, 'projet_en_production', $en_prod);
}
add_action('save_post_projet', 'jtt_projet_save_meta');
