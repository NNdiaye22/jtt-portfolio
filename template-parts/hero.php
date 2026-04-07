<?php
/**
 * Template Part : Hero (section d'accueil)
 *
 * Variables optionnelles transmises via get_template_part() ou set_query_var() :
 *   $titre   - Titre principal (default : option du thème)
 *   $sous    - Sous-titre / accroche
 *   $cta_url - URL du bouton CTA
 *   $cta_txt - Texte du bouton CTA
 */

$titre   = get_theme_mod( 'jtt_hero_titre',    __( 'Journaliste • Photographe • Vidéaste', 'jtt-portfolio' ) );
$sous    = get_theme_mod( 'jtt_hero_sous',     __( 'Je raconte des histoires qui comptent.', 'jtt-portfolio' ) );
$cta_url = get_theme_mod( 'jtt_hero_cta_url', get_permalink( get_page_by_path( 'projets' ) ) );
$cta_txt = get_theme_mod( 'jtt_hero_cta_txt', __( 'Voir mes projets', 'jtt-portfolio' ) );
?>

<section class="hero reveal" id="hero" aria-label="<?php esc_attr_e( 'Présentation', 'jtt-portfolio' ); ?>">

  <div class="hero-inner">

    <h1 class="hero-title">
      <?php echo wp_kses_post( $titre ); ?>
    </h1>

    <?php if ( $sous ) : ?>
      <p class="hero-sub"><?php echo esc_html( $sous ); ?></p>
    <?php endif; ?>

    <?php if ( $cta_url && $cta_txt ) : ?>
      <a href="<?php echo esc_url( $cta_url ); ?>" class="btn btn-primary hero-cta">
        <?php echo esc_html( $cta_txt ); ?>
      </a>
    <?php endif; ?>

  </div>

  <!-- Flèche de défilement -->
  <a href="#projets" class="hero-scroll" aria-label="<?php esc_attr_e( 'Défiler vers le bas', 'jtt-portfolio' ); ?>">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
         width="24" height="24" aria-hidden="true">
      <polyline points="6 9 12 15 18 9"/>
    </svg>
  </a>

</section>
