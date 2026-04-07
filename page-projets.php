<?php
/**
 * Template Name: Page Projets
 *
 * Page dédiée à l'affichage de tous les projets.
 * Assigner ce template à la page "Projets" dans l'administration WordPress.
 *
 * @package jtt-portfolio
 */

get_header();
?>

<main id="main" class="site-main" role="main">

  <!-- En-tête de page -->
  <section class="page-header reveal" aria-labelledby="page-titre">
    <div class="section-inner">
      <h1 class="page-titre" id="page-titre">
        <?php the_title(); ?>
      </h1>
      <?php if ( get_the_excerpt() ) : ?>
        <p class="page-intro"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
      <?php endif; ?>
    </div>
  </section>

  <?php
  // Affichage de la grille de projets (réutilise le template part)
  get_template_part( 'template-parts/projets' );
  ?>

</main>

<?php get_footer(); ?>
