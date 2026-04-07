<?php
/**
 * Template : Page projet individuel (single-projet.php)
 *
 * Gère un nombre variable de sections par projet :
 * Moodboard, Editorial, Squetches, Tech Pack, Shooting,
 * Creative Direction, Figures of Influence, One Size System,
 * Toiles, In Fabric, etc.
 *
 * Chaque section est stockée dans un repeater ACF "project_sections".
 * Si ACF n'est pas actif, affiche le contenu natif WordPress.
 *
 * @package jtt-portfolio
 */

get_header();

if ( ! have_posts() ) {
  wp_redirect( home_url() );
  exit;
}

the_post();

// ── Champs de base ────────────────────────────────────────────────
$annee      = get_post_meta( get_the_ID(), 'projet_annee',       true );
$sous_titre = get_post_meta( get_the_ID(), 'projet_sous_titre',  true ); // ex. "ORANGE IS THE NEW BLACK - 2025"
$editorial  = get_post_meta( get_the_ID(), 'projet_editorial',   true ); // texte éditorial
$en_prod    = get_post_meta( get_the_ID(), 'projet_en_production', true ); // true/false

// ── Sections dynamiques ───────────────────────────────────────────
// Stockées dans un meta JSON : tableau de {titre, type, images[], texte}
$sections_raw = get_post_meta( get_the_ID(), 'projet_sections_json', true );
$sections     = $sections_raw ? json_decode( $sections_raw, true ) : array();

// Fallback : si aucune section, on affiche le contenu natif
$has_sections = ! empty( $sections );

// ── Image hero = featured image ───────────────────────────────────
$hero_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
$hero_alt = get_the_title();

// ── Projets similaires ────────────────────────────────────────────
$cats = get_the_terms( get_the_ID(), 'categorie_projet' );
$related_args = array(
  'post_type'      => 'projet',
  'posts_per_page' => 3,
  'post__not_in'   => array( get_the_ID() ),
  'post_status'    => 'publish',
  'orderby'        => 'rand',
);
if ( $cats && ! is_wp_error( $cats ) ) {
  $related_args['tax_query'] = array(
    array(
      'taxonomy' => 'categorie_projet',
      'field'    => 'term_id',
      'terms'    => wp_list_pluck( $cats, 'term_id' ),
    ),
  );
}
$related = new WP_Query( $related_args );
?>

<main id="main" class="site-main projet-single" role="main">

  <!-- ════════════════════════════════
       HERO DU PROJET
  ════════════════════════════════ -->
  <section class="projet-hero reveal">

    <div class="projet-hero-texte">
      <h1 class="projet-titre"><?php the_title(); ?></h1>

      <?php if ( $sous_titre ) : ?>
        <p class="projet-sous-titre"><?php echo esc_html( $sous_titre ); ?></p>
      <?php elseif ( $annee ) : ?>
        <p class="projet-sous-titre"><?php echo esc_html( $annee ); ?></p>
      <?php endif; ?>
    </div>

    <?php if ( $hero_url ) : ?>
      <div class="projet-hero-img">
        <img src="<?php echo esc_url( $hero_url ); ?>" alt="<?php echo esc_attr( $hero_alt ); ?>" loading="eager">
      </div>
    <?php endif; ?>

  </section>

  <!-- ════════════════════════════════
       ÉDITORIAL (texte intro)
  ════════════════════════════════ -->
  <?php if ( $editorial || get_the_content() ) : ?>
  <section class="projet-editorial reveal" aria-labelledby="editorial-titre">
    <div class="section-inner projet-editorial-inner">
      <h2 class="sr-only" id="editorial-titre"><?php esc_html_e( 'Editorial', 'jtt-portfolio' ); ?></h2>
      <div class="projet-editorial-texte">
        <?php
        if ( $editorial ) {
          echo wp_kses_post( wpautop( $editorial ) );
        } else {
          the_content();
        }
        ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- ════════════════════════════════
       SECTIONS DYNAMIQUES
       (Moodboard, Squetches, Tech Pack,
        Shooting, Toiles, etc.)
  ════════════════════════════════ -->
  <?php if ( $has_sections ) : ?>

    <?php foreach ( $sections as $index => $section ) :
      $s_titre  = isset( $section['titre']  ) ? sanitize_text_field( $section['titre']  ) : '';
      $s_type   = isset( $section['type']   ) ? sanitize_key(        $section['type']   ) : 'galerie'; // galerie | texte | galerie-texte | pdf
      $s_texte  = isset( $section['texte']  ) ? wp_kses_post(        $section['texte']  ) : '';
      $s_images = isset( $section['images'] ) ? (array)              $section['images']   : array();
      $s_id     = 'section-' . sanitize_title( $s_titre ?: $index );
    ?>

    <section
      id="<?php echo esc_attr( $s_id ); ?>"
      class="projet-section projet-section--<?php echo esc_attr( $s_type ); ?> reveal"
      aria-labelledby="<?php echo esc_attr( $s_id ); ?>-titre"
    >
      <div class="section-inner">

        <?php if ( $s_titre ) : ?>
          <h2 class="projet-section-titre" id="<?php echo esc_attr( $s_id ); ?>-titre">
            <?php echo esc_html( $s_titre ); ?>
          </h2>
        <?php endif; ?>

        <?php if ( $s_texte ) : ?>
          <div class="projet-section-texte">
            <?php echo wpautop( $s_texte ); ?>
          </div>
        <?php endif; ?>

        <?php if ( ! empty( $s_images ) ) : ?>
          <div class="projet-section-galerie" data-count="<?php echo count( $s_images ); ?>">
            <?php foreach ( $s_images as $img ) :
              $img_url = is_array( $img ) ? ( $img['url'] ?? '' ) : $img;
              $img_alt = is_array( $img ) ? ( $img['alt'] ?? $s_titre ) : $s_titre;
              if ( ! $img_url ) continue;
            ?>
              <figure class="projet-img-figure">
                <a href="<?php echo esc_url( $img_url ); ?>" class="projet-img-link" data-lightbox="<?php echo esc_attr( $s_id ); ?>">
                  <img
                    src="<?php echo esc_url( $img_url ); ?>"
                    alt="<?php echo esc_attr( $img_alt ); ?>"
                    loading="lazy"
                  >
                </a>
              </figure>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

      </div>
    </section>

    <?php endforeach; ?>

  <?php else : ?>
    <!-- Pas de sections JSON : affichage du contenu natif WordPress -->
    <?php if ( has_post_thumbnail() ) : ?>
    <section class="projet-section projet-section--galerie reveal">
      <div class="section-inner">
        <div class="projet-section-galerie">
          <figure class="projet-img-figure">
            <?php the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) ); ?>
          </figure>
        </div>
      </div>
    </section>
    <?php endif; ?>
  <?php endif; ?>

  <!-- ════════════════════════════════
       MENTION "COLLECTION EN PRODUCTION"
  ════════════════════════════════ -->
  <?php if ( $en_prod ) : ?>
  <section class="projet-en-production reveal">
    <div class="section-inner">
      <p class="production-notice">
        <?php esc_html_e( 'This collection is currently in production. New developments will be revealed soon.', 'jtt-portfolio' ); ?>
      </p>
    </div>
  </section>
  <?php endif; ?>

  <!-- ════════════════════════════════
       NAVIGATION ENTRE PROJETS
  ════════════════════════════════ -->
  <nav class="projet-nav reveal" aria-label="<?php esc_attr_e( 'Navigation entre projets', 'jtt-portfolio' ); ?>">
    <?php
    $prev = get_previous_post( true, '', 'categorie_projet' );
    $next = get_next_post(     true, '', 'categorie_projet' );
    ?>
    <?php if ( $prev ) : ?>
      <a href="<?php echo esc_url( get_permalink( $prev ) ); ?>" class="projet-nav-lien projet-nav-prev">
        <span class="projet-nav-label"><?php esc_html_e( 'Projet précédent', 'jtt-portfolio' ); ?></span>
        <span class="projet-nav-titre"><?php echo esc_html( get_the_title( $prev ) ); ?></span>
      </a>
    <?php else : ?>
      <span class="projet-nav-vide"></span>
    <?php endif; ?>
    <?php if ( $next ) : ?>
      <a href="<?php echo esc_url( get_permalink( $next ) ); ?>" class="projet-nav-lien projet-nav-next">
        <span class="projet-nav-label"><?php esc_html_e( 'Projet suivant', 'jtt-portfolio' ); ?></span>
        <span class="projet-nav-titre"><?php echo esc_html( get_the_title( $next ) ); ?></span>
      </a>
    <?php endif; ?>
  </nav>

  <!-- ════════════════════════════════
       VOUS AIMEREZ AUSSI
  ════════════════════════════════ -->
  <?php if ( $related->have_posts() ) : ?>
  <section class="projets-similaires reveal" aria-labelledby="similaires-titre">
    <div class="section-inner">
      <h2 class="section-title" id="similaires-titre">
        <?php esc_html_e( 'You may also like', 'jtt-portfolio' ); ?>
      </h2>
      <ul class="projets-grille projets-grille--3" role="list">
        <?php while ( $related->have_posts() ) : $related->the_post(); ?>
          <li class="projet-card">
            <a href="<?php the_permalink(); ?>" class="projet-card-inner">
              <?php if ( has_post_thumbnail() ) : ?>
                <div class="projet-card-img">
                  <?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy', 'alt' => get_the_title() ) ); ?>
                </div>
              <?php endif; ?>
              <div class="projet-card-body">
                <h3 class="projet-card-titre"><?php the_title(); ?></h3>
                <?php
                $r_annee = get_post_meta( get_the_ID(), 'projet_annee', true );
                if ( $r_annee ) echo '<p class="projet-card-cat">' . esc_html( $r_annee ) . '</p>';
                ?>
              </div>
            </a>
          </li>
        <?php endwhile; wp_reset_postdata(); ?>
      </ul>
    </div>
  </section>
  <?php endif; ?>

</main>

<?php get_footer(); ?>
