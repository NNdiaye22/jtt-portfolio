<?php
/**
 * Template Part : À propos
 *
 * Section biographique avec photo, texte et compétences.
 * Le contenu est modifiable via le Customizer WordPress.
 */

$photo_id  = get_theme_mod( 'jtt_about_photo', 0 );
$photo_url = $photo_id ? wp_get_attachment_image_url( $photo_id, 'large' ) : '';
$photo_alt = $photo_id ? get_post_meta( $photo_id, '_wp_attachment_image_alt', true ) : '';
$titre     = get_theme_mod( 'jtt_about_titre', __( 'À propos', 'jtt-portfolio' ) );
$texte     = get_theme_mod( 'jtt_about_texte', '' );
?>

<section class="about reveal" id="about" aria-labelledby="about-titre">

  <div class="section-inner about-inner">

    <?php if ( $photo_url ) : ?>
      <div class="about-photo">
        <img
          src="<?php echo esc_url( $photo_url ); ?>"
          alt="<?php echo esc_attr( $photo_alt ); ?>"
          loading="lazy"
          width="480"
          height="480"
        />
      </div>
    <?php endif; ?>

    <div class="about-content">

      <h2 class="section-title" id="about-titre">
        <?php echo esc_html( $titre ); ?>
      </h2>

      <?php if ( $texte ) : ?>
        <div class="about-texte">
          <?php echo wp_kses_post( wpautop( $texte ) ); ?>
        </div>
      <?php endif; ?>

      <?php
      // Compétences : récupérées depuis un champ texte séparé par des virgules
      $competences_raw = get_theme_mod( 'jtt_about_competences', '' );
      $competences     = array_filter( array_map( 'trim', explode( ',', $competences_raw ) ) );

      if ( ! empty( $competences ) ) : ?>
        <ul class="about-competences" aria-label="<?php esc_attr_e( 'Compétences', 'jtt-portfolio' ); ?>">
          <?php foreach ( $competences as $comp ) : ?>
            <li><?php echo esc_html( $comp ); ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <?php
      // Lien CV optionnel
      $cv_url = get_theme_mod( 'jtt_about_cv_url', '' );
      $cv_txt = get_theme_mod( 'jtt_about_cv_txt', __( 'Télécharger mon CV', 'jtt-portfolio' ) );

      if ( $cv_url ) : ?>
        <a href="<?php echo esc_url( $cv_url ); ?>" class="btn btn-secondary" target="_blank" rel="noopener noreferrer">
          <?php echo esc_html( $cv_txt ); ?>
        </a>
      <?php endif; ?>

    </div>

  </div>

</section>
