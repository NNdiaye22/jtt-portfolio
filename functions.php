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
    $v   = '1.0.4';
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

// Script médiathèque WP dans l'admin (pour les meta boxes)
function jtt_enqueue_admin_assets($hook) {
    if (!in_array($hook, ['post.php','post-new.php'])) return;
    wp_enqueue_media();
    wp_enqueue_script(
        'jtt-admin-meta',
        get_template_directory_uri() . '/assets/js/admin-meta.js',
        ['jquery'],
        '1.0.4',
        true
    );
}
add_action('admin_enqueue_scripts', 'jtt_enqueue_admin_assets');


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
            'name'               => 'Projets',
            'singular_name'      => 'Projet',
            'add_new_item'       => 'Ajouter un projet',
            'edit_item'          => 'Modifier le projet',
            'view_item'          => 'Voir le projet',
            'not_found'          => 'Aucun projet trouvé',
            'menu_name'          => 'Projets',
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


// TAXONOMIE
function jtt_register_taxonomies() {
    register_taxonomy('categorie_projet', 'projet', [
        'labels' => [
            'name'          => 'Catégories',
            'singular_name' => 'Catégorie',
            'add_new_item'  => 'Ajouter une catégorie',
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
// PANNEAU D'OPTIONS JTT
// ============================================================

function jtt_options_menu() {
    add_options_page('JTT Portfolio Options', 'JTT Options', 'manage_options', 'jtt-options', 'jtt_options_page_html');
}
add_action('admin_menu', 'jtt_options_menu');

function jtt_options_register() {
    register_setting('jtt_options_group', 'jtt_options', ['sanitize_callback' => 'jtt_sanitize_options']);
}
add_action('admin_init', 'jtt_options_register');

function jtt_sanitize_options($input) {
    $clean = [];
    $text_fields = [
        'hero_subtitle','hero_quote','hero_quote_author',
        'hero_btn_1_label','hero_btn_2_label',
        'hero_instagram_url','hero_email',
        'work_label','work_title_line1','work_title_line2',
        'manifesto_line1','manifesto_line2','manifesto_line3',
        'about_label','about_name',
        'about_bio_1','about_bio_2',
        'about_meta_formation','about_meta_base',
        'about_meta_specialites','about_meta_contact',
        'footer_tagline','footer_copy',
        'instagram_url','linkedin_url','email_contact','nav_logo_label',
    ];
    foreach ($text_fields as $field) {
        $clean[$field] = isset($input[$field]) ? sanitize_text_field($input[$field]) : '';
    }
    $url_fields = ['hero_bg_image','about_image'];
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
    if (isset($_GET['settings-updated']))
        add_settings_error('jtt_options', 'jtt_saved', 'Options enregistrées.', 'updated');
    settings_errors('jtt_options');
    $o = get_option('jtt_options', []);
    function v($o,$k,$d=''){return esc_attr(isset($o[$k])&&$o[$k]!==''?$o[$k]:$d);}
    ?>
    <div class="wrap">
    <h1>🎨 JTT Portfolio — Options du thème</h1>
    <form method="post" action="options.php">
    <?php settings_fields('jtt_options_group'); ?>
    <style>
        .jtt-section{background:#fff;border:1px solid #ddd;border-radius:6px;padding:24px 28px;margin-bottom:28px}
        .jtt-section h2{margin-top:0;font-size:15px;text-transform:uppercase;letter-spacing:.08em;color:#555;border-bottom:1px solid #eee;padding-bottom:12px}
        .jtt-row{display:grid;grid-template-columns:200px 1fr;gap:12px 20px;align-items:center;margin-bottom:14px}
        .jtt-row label{font-weight:600;font-size:13px}
        .jtt-row input[type=text],.jtt-row textarea{width:100%;padding:6px 10px;border:1px solid #ccc;border-radius:4px;font-size:13px}
        .jtt-row textarea{min-height:80px;resize:vertical}
        .jtt-hint{color:#888;font-size:11px;margin-top:4px}
        .jtt-img-preview{max-width:200px;max-height:120px;border-radius:4px;margin-top:6px;display:block}
    </style>
    <div class="jtt-section">
        <h2>🖼️ Hero</h2>
        <div class="jtt-row"><label>Image de fond (URL)</label><div>
            <input type="text" name="jtt_options[hero_bg_image]" value="<?php echo v($o,'hero_bg_image','https://cdn.myportfolio.com/4b129293-66fb-48ba-b250-1e6e7c44c8e2/120ebdea-6fc0-40ad-acb7-7f7bd166ad34,rw_1200.jpeg?h=7e9e9292dafa2ba8a6a7daf28675aad2'); ?>" />
            <?php $bg=isset($o['hero_bg_image'])&&$o['hero_bg_image']?$o['hero_bg_image']:'';if($bg):?><img src="<?php echo esc_url($bg);?>" class="jtt-img-preview" alt=""><?php endif;?>
        </div></div>
        <div class="jtt-row"><label>Sous-titre</label><input type="text" name="jtt_options[hero_subtitle]" value="<?php echo v($o,'hero_subtitle','Styliste de Mode &nbsp;&bull;&nbsp; Paris');?>" /></div>
        <div class="jtt-row"><label>Citation</label><input type="text" name="jtt_options[hero_quote]" value="<?php echo v($o,'hero_quote',"La mode est ce que l'on porte.");?>" /></div>
        <div class="jtt-row"><label>Auteur citation</label><input type="text" name="jtt_options[hero_quote_author]" value="<?php echo v($o,'hero_quote_author','Oscar Wilde');?>" /></div>
        <div class="jtt-row"><label>Bouton 1</label><input type="text" name="jtt_options[hero_btn_1_label]" value="<?php echo v($o,'hero_btn_1_label','Découvrir mes projets');?>" /></div>
        <div class="jtt-row"><label>Bouton 2</label><input type="text" name="jtt_options[hero_btn_2_label]" value="<?php echo v($o,'hero_btn_2_label','À propos');?>" /></div>
    </div>
    <div class="jtt-section">
        <h2>💼 Section My Work</h2>
        <p style="color:#666;font-size:13px;margin-bottom:16px;">Les cartes projets (images, titres, liens) se gèrent directement dans <strong>Projets</strong> (menu de gauche). L'ordre se définit via le champ "Ordre" dans chaque projet (Attributs de la page).</p>
        <div class="jtt-row"><label>Label section</label><input type="text" name="jtt_options[work_label]" value="<?php echo v($o,'work_label','Portfolio 2021–2026');?>" /></div>
        <div class="jtt-row"><label>Titre ligne 1</label><input type="text" name="jtt_options[work_title_line1]" value="<?php echo v($o,'work_title_line1','Discover');?>" /></div>
        <div class="jtt-row"><label>Titre ligne 2</label><input type="text" name="jtt_options[work_title_line2]" value="<?php echo v($o,'work_title_line2','My Work');?>" /></div>
    </div>
    <div class="jtt-section">
        <h2>✏️ Manifesto</h2>
        <div class="jtt-row"><label>Ligne 1</label><input type="text" name="jtt_options[manifesto_line1]" value="<?php echo v($o,'manifesto_line1','Chaque vêtement est une déclaration,');?>" /></div>
        <div class="jtt-row"><label>Ligne 2</label><input type="text" name="jtt_options[manifesto_line2]" value="<?php echo v($o,'manifesto_line2','chaque tissu une langue,');?>" /></div>
        <div class="jtt-row"><label>Ligne 3</label><input type="text" name="jtt_options[manifesto_line3]" value="<?php echo v($o,'manifesto_line3','chaque silhouette une histoire.');?>" /></div>
    </div>
    <div class="jtt-section">
        <h2>👤 About</h2>
        <div class="jtt-row"><label>Photo (URL)</label><div>
            <input type="text" name="jtt_options[about_image]" value="<?php echo v($o,'about_image','https://cdn.myportfolio.com/4b129293-66fb-48ba-b250-1e6e7c44c8e2/2fbe3839-7309-4d05-aef5-fcfc84aadb16,rw_1200.jpeg?h=83c4acf4c9aa74751eb5e78ed4715d02');?>" />
            <?php $ai=isset($o['about_image'])&&$o['about_image']?$o['about_image']:'';if($ai):?><img src="<?php echo esc_url($ai);?>" class="jtt-img-preview" alt=""><?php endif;?>
        </div></div>
        <div class="jtt-row"><label>Label</label><input type="text" name="jtt_options[about_label]" value="<?php echo v($o,'about_label','À Propos');?>" /></div>
        <div class="jtt-row"><label>Nom complet</label><input type="text" name="jtt_options[about_name]" value="<?php echo v($o,'about_name','Julien Terence Tegnan');?>" /></div>
        <div class="jtt-row"><label>Bio §1</label><textarea name="jtt_options[about_bio_1]"><?php echo esc_textarea(isset($o['about_bio_1'])?$o['about_bio_1']:'Julien Terence Tegnan est un styliste de mode parisien…');?></textarea></div>
        <div class="jtt-row"><label>Bio §2</label><textarea name="jtt_options[about_bio_2]"><?php echo esc_textarea(isset($o['about_bio_2'])?$o['about_bio_2']:'Ses collections explorent les textures de la mémoire…');?></textarea></div>
        <div class="jtt-row"><label>Formation</label><input type="text" name="jtt_options[about_meta_formation]" value="<?php echo v($o,'about_meta_formation','ESMOD Paris — Diplôme Supérieur');?>" /></div>
        <div class="jtt-row"><label>Basé</label><input type="text" name="jtt_options[about_meta_base]" value="<?php echo v($o,'about_meta_base','Paris, France');?>" /></div>
        <div class="jtt-row"><label>Spécialités</label><input type="text" name="jtt_options[about_meta_specialites]" value="<?php echo v($o,'about_meta_specialites','Mode afro-contemporaine');?>" /></div>
        <div class="jtt-row"><label>Email contact</label><input type="text" name="jtt_options[about_meta_contact]" value="<?php echo v($o,'about_meta_contact','julien.tegnan@fr.esmod.net');?>" /></div>
    </div>
    <div class="jtt-section">
        <h2>🔗 Contacts &amp; Réseaux</h2>
        <div class="jtt-row"><label>Instagram URL</label><input type="text" name="jtt_options[instagram_url]" value="<?php echo v($o,'instagram_url','https://www.instagram.com/j.tegnan');?>" /></div>
        <div class="jtt-row"><label>LinkedIn URL</label><input type="text" name="jtt_options[linkedin_url]" value="<?php echo v($o,'linkedin_url','');?>" /></div>
        <div class="jtt-row"><label>Email</label><input type="text" name="jtt_options[email_contact]" value="<?php echo v($o,'email_contact','julien.tegnan@fr.esmod.net');?>" /></div>
        <div class="jtt-row"><label>Logo nav (texte)</label><input type="text" name="jtt_options[nav_logo_label]" value="<?php echo v($o,'nav_logo_label','JTT');?>" /></div>
    </div>
    <div class="jtt-section">
        <h2>📌 Footer</h2>
        <div class="jtt-row"><label>Tagline</label><input type="text" name="jtt_options[footer_tagline]" value="<?php echo v($o,'footer_tagline','Styliste de Mode — Paris');?>" /></div>
        <div class="jtt-row"><label>Copyright</label><input type="text" name="jtt_options[footer_copy]" value="<?php echo v($o,'footer_copy','© 2026 Julien Terence Tegnan. Tous droits réservés.');?>" /></div>
    </div>
    <?php submit_button('Enregistrer les options'); ?>
    </form></div>
    <?php
}


// ============================================================
// META BOX PROJETS — Interface visuelle complète
// ============================================================

function jtt_projet_meta_boxes() {
    add_meta_box('jtt_infos',    'Informations du projet',  'jtt_mb_infos',    'projet', 'normal', 'high');
    add_meta_box('jtt_cover',   'Image de couverture (grille accueil)', 'jtt_mb_cover', 'projet', 'side',   'high');
    add_meta_box('jtt_sections','Sections de la page projet', 'jtt_mb_sections', 'projet', 'normal', 'default');
}
add_action('add_meta_boxes', 'jtt_projet_meta_boxes');

// --- MB : Informations de base ---
function jtt_mb_infos($post) {
    wp_nonce_field('jtt_projet_save', 'jtt_projet_nonce');
    $annee      = get_post_meta($post->ID, 'projet_annee',         true);
    $sous_titre = get_post_meta($post->ID, 'projet_sous_titre',    true);
    $editorial  = get_post_meta($post->ID, 'projet_editorial',     true);
    $en_prod    = get_post_meta($post->ID, 'projet_en_production', true);
    ?>
    <style>
        .jtt-mb{margin-bottom:18px}.jtt-mb label{display:block;font-weight:600;font-size:12px;text-transform:uppercase;letter-spacing:.06em;margin-bottom:6px;color:#444}
        .jtt-mb input[type=text],.jtt-mb textarea{width:100%;padding:7px 10px;border:1px solid #ddd;border-radius:4px;font-size:13px}
        .jtt-mb textarea{min-height:110px;resize:vertical}
        .jtt-mb-hint{font-size:11px;color:#888;margin-top:4px}
    </style>
    <div class="jtt-mb"><label>Année</label><input type="text" name="projet_annee" value="<?php echo esc_attr($annee);?>" placeholder="2025" /></div>
    <div class="jtt-mb"><label>Sous-titre <span class="jtt-mb-hint">(ex. ORANGE IS THE NEW BLACK — 2025)</span></label>
        <input type="text" name="projet_sous_titre" value="<?php echo esc_attr($sous_titre);?>" /></div>
    <div class="jtt-mb"><label>Texte éditorial <span class="jtt-mb-hint">(intro affichée en haut de la page projet)</span></label>
        <textarea name="projet_editorial"><?php echo esc_textarea($editorial);?></textarea></div>
    <div class="jtt-mb"><label><input type="checkbox" name="projet_en_production" value="1" <?php checked($en_prod,'1');?> /> Collection en production</label></div>
    <?php
}

// --- MB : Image de couverture externe ---
function jtt_mb_cover($post) {
    $ext = get_post_meta($post->ID, '_thumbnail_external', true);
    ?>
    <style>
        #jtt-cover-preview{max-width:100%;border-radius:4px;margin-top:8px;display:<?php echo $ext?'block':'none';?>}
        .jtt-cover-btn{margin-top:8px;font-size:12px}
    </style>
    <p style="font-size:12px;color:#666;margin-bottom:8px;">
        Assigne d'abord l'<strong>Image mise en avant</strong> WP (panneau de droite).<br>
        Ou colle ici une URL externe (utilisée uniquement si pas d'image WP).
    </p>
    <input type="text" name="_thumbnail_external" id="jtt-ext-url" value="<?php echo esc_url($ext);?>" placeholder="https://cdn.example.com/image.jpg" style="width:100%;font-size:12px;" />
    <img id="jtt-cover-preview" src="<?php echo esc_url($ext);?>" alt="" />
    <button type="button" class="button jtt-cover-btn" id="jtt-pick-cover">Choisir depuis la médiathèque</button>
    <?php
}

// --- MB : Sections de la page projet ---
function jtt_mb_sections($post) {
    $sections_raw = get_post_meta($post->ID, 'projet_sections_json', true);
    $sections = $sections_raw ? json_decode($sections_raw, true) : [];
    if (!is_array($sections)) $sections = [];
    ?>
    <style>
        .jtt-sections-wrap{}
        .jtt-section-item{background:#f9f9f9;border:1px solid #ddd;border-radius:6px;padding:16px;margin-bottom:12px;position:relative}
        .jtt-section-item h4{margin:0 0 12px;font-size:13px;display:flex;align-items:center;gap:8px}
        .jtt-section-item h4 .jtt-section-num{background:#555;color:#fff;border-radius:3px;padding:1px 6px;font-size:11px}
        .jtt-si-row{margin-bottom:10px}
        .jtt-si-row label{display:block;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.05em;color:#666;margin-bottom:4px}
        .jtt-si-row input[type=text],.jtt-si-row select,.jtt-si-row textarea{width:100%;padding:6px 8px;border:1px solid #ccc;border-radius:4px;font-size:12px}
        .jtt-si-row textarea{min-height:80px;resize:vertical}
        .jtt-images-list{display:flex;flex-wrap:wrap;gap:8px;margin-top:8px}
        .jtt-img-thumb{position:relative;width:80px;height:80px}
        .jtt-img-thumb img{width:80px;height:80px;object-fit:cover;border-radius:4px;display:block}
        .jtt-img-thumb .jtt-img-rm{position:absolute;top:2px;right:2px;background:rgba(0,0,0,.6);color:#fff;border:none;border-radius:50%;width:18px;height:18px;font-size:11px;cursor:pointer;line-height:18px;text-align:center;padding:0}
        .jtt-section-rm{position:absolute;top:12px;right:12px;background:#c00;color:#fff;border:none;border-radius:4px;padding:3px 8px;font-size:11px;cursor:pointer}
        .jtt-add-section{margin-top:4px}
        .jtt-section-handle{cursor:move;margin-right:6px;color:#999}
    </style>

    <p style="font-size:12px;color:#666;margin-bottom:12px;">
        Ajoute autant de sections que tu veux (Moodboard, Shooting, Tech Pack…). Chaque section peut avoir un titre, un texte et/ou des images.
    </p>

    <div id="jtt-sections-list" class="jtt-sections-wrap">
        <?php foreach ($sections as $i => $s) :
            $s_titre  = esc_attr($s['titre']  ?? '');
            $s_type   = esc_attr($s['type']   ?? 'galerie');
            $s_texte  = esc_textarea($s['texte'] ?? '');
            $s_images = $s['images'] ?? [];
        ?>
        <div class="jtt-section-item" data-index="<?php echo $i;?>">
            <h4><span class="jtt-section-handle">☰</span><span class="jtt-section-num"><?php echo $i+1;?></span> Section</h4>
            <button type="button" class="jtt-section-rm" data-action="remove-section">&times; Supprimer</button>
            <div class="jtt-si-row"><label>Titre de la section</label>
                <input type="text" class="jtt-s-titre" value="<?php echo $s_titre;?>" placeholder="ex. Moodboard, Shooting…" /></div>
            <div class="jtt-si-row"><label>Type</label>
                <select class="jtt-s-type">
                    <option value="galerie"       <?php selected($s_type,'galerie');?>>Galerie d'images uniquement</option>
                    <option value="texte"         <?php selected($s_type,'texte');?>>Texte uniquement</option>
                    <option value="galerie-texte" <?php selected($s_type,'galerie-texte');?>>Images + Texte</option>
                </select>
            </div>
            <div class="jtt-si-row"><label>Texte (optionnel)</label>
                <textarea class="jtt-s-texte"><?php echo $s_texte;?></textarea></div>
            <div class="jtt-si-row">
                <label>Images</label>
                <div class="jtt-images-list">
                    <?php foreach ($s_images as $img) :
                        $url = is_array($img) ? ($img['url']??'') : $img;
                        $alt = is_array($img) ? ($img['alt']??'') : '';
                        if (!$url) continue;
                    ?>
                    <div class="jtt-img-thumb">
                        <img src="<?php echo esc_url($url);?>" alt="<?php echo esc_attr($alt);?>" />
                        <input type="hidden" class="jtt-img-url" value="<?php echo esc_url($url);?>" />
                        <input type="hidden" class="jtt-img-alt" value="<?php echo esc_attr($alt);?>" />
                        <button type="button" class="jtt-img-rm" data-action="remove-img" title="Supprimer">&times;</button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="button jtt-add-imgs" style="margin-top:8px;font-size:12px;">+ Ajouter des images</button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <button type="button" class="button button-primary jtt-add-section">+ Ajouter une section</button>
    <input type="hidden" name="projet_sections_json" id="jtt-sections-json" value="<?php echo esc_attr($sections_raw);?>" />
    <?php
}


// SAUVEGARDE META
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
        $decoded = json_decode($json, true);
        if (json_last_error() === JSON_ERROR_NONE)
            update_post_meta($post_id, 'projet_sections_json', wp_slash($json));
        elseif (trim($json) === '' || $json === '[]')
            update_post_meta($post_id, 'projet_sections_json', '[]');
    }
    $en_prod = isset($_POST['projet_en_production']) ? '1' : '0';
    update_post_meta($post_id, 'projet_en_production', $en_prod);
}
add_action('save_post_projet', 'jtt_projet_save_meta');


// FALLBACK MENU (si aucun menu assigné)
function jtt_nav_fallback() {
    echo '<ul class="nav-links" role="list">';
    echo '<li><a href="'.esc_url(home_url('/#work')).'">Travaux</a></li>';
    echo '<li><a href="'.esc_url(home_url('/#about')).'">'."&Agrave; propos".'</a></li>';
    echo '<li><a href="mailto:'.esc_attr(jtt_opt('email_contact','julien.tegnan@fr.esmod.net')).'">Contact</a></li>';
    echo '</ul>';
}
function jtt_nav_mobile_fallback() {
    echo '<ul class="nav-mobile-links" role="list">';
    echo '<li><a href="'.esc_url(home_url('/')).'">Accueil</a></li>';
    echo '<li><a href="'.esc_url(home_url('/#work')).'">Travaux</a></li>';
    echo '<li><a href="'.esc_url(home_url('/#about')).'">'."&Agrave; propos".'</a></li>';
    echo '<li><a href="mailto:'.esc_attr(jtt_opt('email_contact','julien.tegnan@fr.esmod.net')).'">Contact</a></li>';
    echo '</ul>';
}
