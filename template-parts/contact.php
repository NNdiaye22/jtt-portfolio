<?php
/**
 * Template Part : Contact
 *
 * Affiche les informations de contact + formulaire natif WordPress (via shortcode)
 * ou un formulaire HTML simple si Contact Form 7 n'est pas installé.
 */

$email    = get_theme_mod( 'jtt_contact_email', get_option( 'admin_email' ) );
$titre    = get_theme_mod( 'jtt_contact_titre', __( 'Me contacter', 'jtt-portfolio' ) );
$sous     = get_theme_mod( 'jtt_contact_sous',  __( 'Un projet, une collaboration, une question ? Écrivez-moi !', 'jtt-portfolio' ) );
$cf7_id   = get_theme_mod( 'jtt_contact_cf7_id', 0 );

// Réseaux sociaux
$socials = array(
  'instagram' => array(
    'label' => 'Instagram',
    'url'   => get_theme_mod( 'jtt_social_instagram', '' ),
    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1.5" fill="currentColor" stroke="none"/></svg>',
  ),
  'linkedin' => array(
    'label' => 'LinkedIn',
    'url'   => get_theme_mod( 'jtt_social_linkedin', '' ),
    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20" aria-hidden="true"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>',
  ),
  'twitter' => array(
    'label' => 'X (Twitter)',
    'url'   => get_theme_mod( 'jtt_social_twitter', '' ),
    'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.402 6.231H2.744l7.737-8.858L1.254 2.25H8.08l4.252 5.621L18.244 2.25zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
  ),
);
?>

<section class="contact reveal" id="contact" aria-labelledby="contact-titre">

  <div class="section-inner contact-inner">

    <div class="contact-info">

      <h2 class="section-title" id="contact-titre">
        <?php echo esc_html( $titre ); ?>
      </h2>

      <?php if ( $sous ) : ?>
        <p class="contact-sous"><?php echo esc_html( $sous ); ?></p>
      <?php endif; ?>

      <?php if ( $email ) : ?>
        <a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>" class="contact-email">
          <?php echo esc_html( antispambot( $email ) ); ?>
        </a>
      <?php endif; ?>

      <?php
      $active_socials = array_filter( $socials, function( $s ) { return ! empty( $s['url'] ); } );
      if ( ! empty( $active_socials ) ) : ?>
        <ul class="contact-socials" aria-label="<?php esc_attr_e( 'Réseaux sociaux', 'jtt-portfolio' ); ?>">
          <?php foreach ( $active_socials as $s ) : ?>
            <li>
              <a href="<?php echo esc_url( $s['url'] ); ?>" target="_blank" rel="noopener noreferrer"
                 aria-label="<?php echo esc_attr( $s['label'] ); ?>">
                <?php echo $s['icon']; // SVG sécurisé ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

    </div>

    <div class="contact-form">
      <?php
      if ( $cf7_id && function_exists( 'wpcf7_contact_form' ) ) {
        echo do_shortcode( '[contact-form-7 id="' . intval( $cf7_id ) . '"]' );
      } else {
        // Formulaire HTML de secours
        ?>
        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="form-contact" novalidate>
          <?php wp_nonce_field( 'jtt_contact_form', 'jtt_contact_nonce' ); ?>
          <input type="hidden" name="action" value="jtt_contact_form">

          <div class="form-group">
            <label for="contact-nom"><?php esc_html_e( 'Nom', 'jtt-portfolio' ); ?> <span aria-hidden="true">*</span></label>
            <input type="text" id="contact-nom" name="nom" required autocomplete="name" placeholder="<?php esc_attr_e( 'Votre nom', 'jtt-portfolio' ); ?>">
          </div>

          <div class="form-group">
            <label for="contact-email"><?php esc_html_e( 'Email', 'jtt-portfolio' ); ?> <span aria-hidden="true">*</span></label>
            <input type="email" id="contact-email" name="email" required autocomplete="email" placeholder="<?php esc_attr_e( 'votre@email.com', 'jtt-portfolio' ); ?>">
          </div>

          <div class="form-group">
            <label for="contact-message"><?php esc_html_e( 'Message', 'jtt-portfolio' ); ?> <span aria-hidden="true">*</span></label>
            <textarea id="contact-message" name="message" required rows="5" placeholder="<?php esc_attr_e( 'Votre message...', 'jtt-portfolio' ); ?>"></textarea>
          </div>

          <button type="submit" class="btn btn-primary">
            <?php esc_html_e( 'Envoyer', 'jtt-portfolio' ); ?>
          </button>
        </form>
        <?php
      }
      ?>
    </div>

  </div>

</section>
