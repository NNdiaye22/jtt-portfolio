<?php
/**
 * Template Part : Grille de projets (accueil + page projets)
 *
 * Affiche les projets de type "projet" avec filtre par catégorie.
 * Appelé depuis front-page.php et page-projets.php.
 */

$categories = get_terms( array(
  'taxonomy'   => 'categorie_projet',
  'hide_empty' => true,
) );

$args = array(
  'post_type'      => 'projet',
  'posts_per_page' => -1,
  'post_status'    => 'publish',
  'orderby'        => 'menu_order',
  'order'          => 'ASC',
);

$projets = new WP_Query( $args );
?>

<section class="projets reveal" id="projets" aria-labelledby="projets-titre">

  <div class="section-inner">

    <h2 class="section-title" id="projets-titre">
      <?php esc_html_e( 'Mes projets', 'jtt-portfolio' ); ?>
    </h2>

    <?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
    <nav class="projets-filtres" aria-label="<?php esc_attr_e( 'Filtrer par catégorie', 'jtt-portfolio' ); ?>">
      <button class="filtre-btn active" data-filtre="*">
        <?php esc_html_e( 'Tous', 'jtt-portfolio' ); ?>
      </button>
      <?php foreach ( $categories as $cat ) : ?>
        <button class="filtre-btn" data-filtre="<?php echo esc_attr( $cat->slug ); ?>">
          <?php echo esc_html( $cat->name ); ?>
        </button>
      <?php endforeach; ?>
    </nav>
    <?php endif; ?>

    <?php if ( $projets->have_posts() ) : ?>

      <ul class="projets-grille" role="list">

        <?php while ( $projets->have_posts() ) : $projets->the_post();
          $cats     = get_the_terms( get_the_ID(), 'categorie_projet' );
          $cat_slug = ( $cats && ! is_wp_error( $cats ) ) ? implode( ' ', wp_list_pluck( $cats, 'slug' ) ) : '';
        ?>

          <li class="projet-card <?php echo esc_attr( $cat_slug ); ?>" data-categorie="<?php echo esc_attr( $cat_slug ); ?>">
            <a href="<?php the_permalink(); ?>" class="projet-card-inner">

              <?php if ( has_post_thumbnail() ) : ?>
                <div class="projet-card-img">
                  <?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy', 'alt' => get_the_title() ) ); ?>
                </div>
              <?php endif; ?>

              <div class="projet-card-body">
                <h3 class="projet-card-titre"><?php the_title(); ?></h3>

                <?php if ( $cats && ! is_wp_error( $cats ) ) : ?>
                  <p class="projet-card-cat"><?php echo esc_html( $cats[0]->name ); ?></p>
                <?php endif; ?>

                <?php if ( get_the_excerpt() ) : ?>
                  <p class="projet-card-excerpt"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
                <?php endif; ?>
              </div>

            </a>
          </li>

        <?php endwhile; wp_reset_postdata(); ?>

      </ul>

    <?php else : ?>
      <p class="projets-vide"><?php esc_html_e( 'Aucun projet publié pour le moment.', 'jtt-portfolio' ); ?></p>
    <?php endif; ?>

  </div>

</section>
