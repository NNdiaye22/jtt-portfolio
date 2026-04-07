<nav id="site-nav" role="navigation" aria-label="Navigation principale">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-logo" aria-label="Accueil">JTT Styliste</a>
    <ul class="nav-links" role="list">
        <li><a href="<?php echo esc_url(home_url('/#work')); ?>">Travaux</a></li>
        <li><a href="<?php echo esc_url(home_url('/#about')); ?>">&Agrave; propos</a></li>
        <li><a href="mailto:julien.tegnan@fr.esmod.net">Contact</a></li>
    </ul>
    <button class="nav-burger" id="navBurger" aria-expanded="false" aria-controls="navMobile" aria-label="Ouvrir le menu">
        <span class="burger-line"></span>
        <span class="burger-line"></span>
        <span class="burger-line"></span>
    </button>
</nav>

<div class="nav-mobile-overlay" id="navMobile" aria-hidden="true" role="dialog">
    <button class="nav-mobile-close" id="navMobileClose" aria-label="Fermer le menu">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
            <line x1="1" y1="1" x2="17" y2="17" stroke="currentColor" stroke-width="1"/>
            <line x1="17" y1="1" x2="1" y2="17" stroke="currentColor" stroke-width="1"/>
        </svg>
    </button>
    <ul class="nav-mobile-links" role="list">
        <li><a href="<?php echo esc_url(home_url('/')); ?>">Accueil</a></li>
        <li><a href="<?php echo esc_url(home_url('/#work')); ?>">Travaux</a></li>
        <li><a href="<?php echo esc_url(home_url('/#about')); ?>">&Agrave; propos</a></li>
        <li><a href="mailto:julien.tegnan@fr.esmod.net">Contact</a></li>
        <?php
        $projets = jtt_get_projets();
        if ($projets->have_posts()) :
            echo '<li class="nav-mobile-sep">&mdash; Collections &mdash;</li>';
            while ($projets->have_posts()) : $projets->the_post(); ?>
                <li class="nav-mobile-project"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
            <?php endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </ul>
    <div class="nav-mobile-socials">
        <a href="https://www.instagram.com/j.tegnan" target="_blank" rel="noopener" aria-label="Instagram">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="5"/>
                <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
            </svg>
        </a>
        <a href="mailto:julien.tegnan@fr.esmod.net" aria-label="Email">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <rect x="2" y="4" width="20" height="16" rx="2"/>
                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
            </svg>
        </a>
    </div>
</div>
