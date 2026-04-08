<?php
/**
 * Navigation principale
 * Menu desktop + overlay mobile — tout géré depuis Apparence → Menus dans WP
 *
 * Pour personnaliser les liens sociaux dans le menu mobile,
 * va dans Réglages → JTT Options.
 */

$instagram_url = jtt_opt('instagram_url', 'https://www.instagram.com/j.tegnan');
$email         = jtt_opt('email_contact', 'julien.tegnan@fr.esmod.net');
$nav_logo      = jtt_opt('nav_logo_label', 'JTT');
?>

<nav id="site-nav" role="navigation" aria-label="Navigation principale">

    <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-logo" aria-label="Accueil">
        <?php echo esc_html($nav_logo); ?>
    </a>

    <!-- MENU DESKTOP : lu depuis Apparence → Menus → "Navigation principale" -->
    <?php
    wp_nav_menu([
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'nav-links',
        'items_wrap'     => '<ul id="%1$s" class="%2$s" role="list">%3$s</ul>',
        'depth'          => 2,
        'fallback_cb'    => 'jtt_nav_fallback',
    ]);
    ?>

    <button class="nav-burger" id="navBurger"
            aria-expanded="false" aria-controls="navMobile"
            aria-label="Ouvrir le menu">
        <span class="burger-line"></span>
        <span class="burger-line"></span>
        <span class="burger-line"></span>
    </button>
</nav>

<!-- MENU MOBILE OVERLAY -->
<div class="nav-mobile-overlay" id="navMobile" aria-hidden="true" role="dialog"
     aria-label="Menu mobile">

    <button class="nav-mobile-close" id="navMobileClose" aria-label="Fermer le menu">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
            <line x1="1" y1="1" x2="17" y2="17" stroke="currentColor" stroke-width="1"/>
            <line x1="17" y1="1" x2="1" y2="17" stroke="currentColor" stroke-width="1"/>
        </svg>
    </button>

    <!-- Même menu WordPress, classe différente pour les styles mobile -->
    <?php
    wp_nav_menu([
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'nav-mobile-links',
        'items_wrap'     => '<ul id="%1$s" class="%2$s" role="list">%3$s</ul>',
        'depth'          => 2,
        'fallback_cb'    => 'jtt_nav_mobile_fallback',
    ]);
    ?>

    <!-- Collections (toujours affichées dynamiquement en mobile) -->
    <?php
    $projets = jtt_get_projets();
    if ($projets->have_posts()) :
        echo '<p class="nav-mobile-sep">&mdash; Collections &mdash;</p>';
        echo '<ul class="nav-mobile-projects" role="list">';
        while ($projets->have_posts()) : $projets->the_post(); ?>
            <li class="nav-mobile-project">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </li>
        <?php endwhile;
        echo '</ul>';
        wp_reset_postdata();
    endif;
    ?>

    <div class="nav-mobile-socials">
        <?php if ($instagram_url) : ?>
        <a href="<?php echo esc_url($instagram_url); ?>" target="_blank" rel="noopener" aria-label="Instagram">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <rect x="2" y="2" width="20" height="20" rx="5"/>
                <circle cx="12" cy="12" r="5"/>
                <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
            </svg>
        </a>
        <?php endif; ?>
        <?php if ($email) : ?>
        <a href="mailto:<?php echo esc_attr($email); ?>" aria-label="Email">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <rect x="2" y="4" width="20" height="16" rx="2"/>
                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
            </svg>
        </a>
        <?php endif; ?>
    </div>
</div>
