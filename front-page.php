<?php get_header(); ?>

<main id="main-content">

<!-- HERO -->
<section id="hero">
    <div class="hero-bg">
        <img src="https://cdn.myportfolio.com/4b129293-66fb-48ba-b250-1e6e7c44c8e2/120ebdea-6fc0-40ad-acb7-7f7bd166ad34,rw_1200.jpeg?h=7e9e9292dafa2ba8a6a7daf28675aad2"
             alt="" aria-hidden="true" loading="eager" fetchpriority="high">
    </div>
    <div class="hero-content">
        <svg class="monogram" viewBox="0 0 100 100" fill="none" aria-hidden="true">
            <circle cx="50" cy="50" r="47" stroke="rgba(240,236,228,0.2)" stroke-width="0.5"/>
            <circle cx="50" cy="50" r="42" stroke="rgba(240,236,228,0.07)" stroke-width="0.5"/>
            <text x="50%" y="52%" text-anchor="middle" dominant-baseline="central"
                  font-family="Cormorant Garamond,serif" font-size="28" font-weight="300"
                  fill="#f0ece4" letter-spacing="3">JTT</text>
        </svg>
        <h1 class="hero-name" aria-label="Julien Terence Tegnan"></h1>
        <p class="hero-subtitle">Styliste de Mode &nbsp;&bull;&nbsp; Paris</p>
        <blockquote class="hero-quote">
            La mode est ce que l'on porte.<br>
            Ce qui est d&eacute;mod&eacute;, c'est ce que portent les autres.
            <em>&mdash; Oscar Wilde</em>
        </blockquote>
        <div class="hero-buttons">
            <a href="#work" class="btn filled">D&eacute;couvrir mes projets</a>
            <a href="#about" class="btn">&Agrave; propos</a>
        </div>
        <div class="hero-socials">
            <a href="https://www.instagram.com/j.tegnan" target="_blank" rel="noopener" aria-label="Instagram">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="2" y="2" width="20" height="20" rx="5"/>
                    <circle cx="12" cy="12" r="5"/>
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
    <div class="scroll-hint" id="scrollHint" aria-hidden="true">
        <span>Scroll</span>
        <div class="scroll-line"></div>
    </div>
</section>

<div class="section-divider" data-divider></div>

<!-- WORK -->
<section id="work">
    <div class="work-header">
        <p class="section-label">Portfolio 2021&ndash;2026</p>
        <h2 class="section-title">
            <span class="reveal-mask"><span class="reveal-inner">Discover</span></span>
            <span class="reveal-mask"><span class="reveal-inner">My Work</span></span>
        </h2>
        <?php
        $total = wp_count_posts('projet')->publish;
        $total_fmt = str_pad($total, 2, '0', STR_PAD_LEFT);
        ?>
        <p class="work-count"><?php echo esc_html($total_fmt); ?> Collections</p>
    </div>
    <div class="work-grid">
        <?php
        $projets = jtt_get_projets();
        $i = 1;
        if ($projets->have_posts()) :
            while ($projets->have_posts()) : $projets->the_post();
                $num      = str_pad($i, 2, '0', STR_PAD_LEFT);
                // Priorité : miniature WP locale → URL externe stockée en meta
                $img_url  = get_the_post_thumbnail_url(get_the_ID(), 'large')
                            ?: get_post_meta(get_the_ID(), '_thumbnail_external', true);
                $img_url  = $img_url ? esc_url($img_url) : '';
                $img_alt  = esc_attr(get_the_title());
                $year     = get_post_meta(get_the_ID(), 'projet_annee', true) ?: date('Y');
        ?>
        <a href="<?php the_permalink(); ?>" class="work-item" aria-label="<?php the_title(); ?>">
            <div class="work-film-edge" aria-hidden="true"></div>
            <span class="work-num"><?php echo $num; ?></span>
            <?php if ($img_url) : ?>
            <img src="<?php echo $img_url; ?>" alt="<?php echo $img_alt; ?>"
                 loading="<?php echo $i === 1 ? 'eager' : 'lazy'; ?>">
            <?php endif; ?>
            <div class="work-overlay" aria-hidden="true"></div>
            <span class="work-title"><?php the_title(); ?></span>
            <span class="work-year">Collection <?php echo esc_html($year); ?></span>
        </a>
        <?php
            $i++;
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>
</section>

<div class="section-divider" data-divider></div>

<!-- MANIFESTO -->
<section id="manifesto">
    <p class="manifesto-text">
        Chaque v&ecirc;tement est une <em>d&eacute;claration</em>,<br>
        chaque tissu une <em>langue</em>,<br>
        chaque silhouette une <em>histoire</em>.
    </p>
</section>

<div class="section-divider" data-divider></div>

<!-- ABOUT -->
<section id="about">
    <div class="about-inner">
        <div class="about-image-wrap">
            <img src="https://cdn.myportfolio.com/4b129293-66fb-48ba-b250-1e6e7c44c8e2/2fbe3839-7309-4d05-aef5-fcfc84aadb16,rw_1200.jpeg?h=83c4acf4c9aa74751eb5e78ed4715d02"
                 alt="Portrait Julien Terence Tegnan" loading="lazy">
        </div>
        <div class="about-text">
            <p class="section-label">&Agrave; Propos</p>
            <h2 class="section-title">
                <span class="reveal-mask"><span class="reveal-inner">Julien</span></span>
                <span class="reveal-mask"><span class="reveal-inner">Terence</span></span>
                <span class="reveal-mask"><span class="reveal-inner">Tegnan</span></span>
            </h2>
            <p class="about-bio"><strong>Julien Terence Tegnan</strong> est un styliste de mode parisien n&eacute; au c&oelig;ur de deux cultures&nbsp;: la rigueur du continent africain et l'&eacute;l&eacute;gance du Paris couture. Diplom&eacute; de l'ESMOD Paris avec les f&eacute;licitations du jury, il construit depuis 2018 un langage visuel qui r&eacute;concilie la <strong>modernit&eacute; afropolitaine</strong> avec les codes du luxe europ&eacute;en.</p>
            <p class="about-bio">Ses collections explorent les textures de la m&eacute;moire, les g&eacute;ographies du corps et la <strong>po&eacute;sie du quotidien</strong>. Travaillant &agrave; l'intersection du pr&ecirc;t-&agrave;-porter et de la haute couture, Julien collabore avec des photographes, des danseurs et des architectes pour faire de chaque d&eacute;fil&eacute; une exp&eacute;rience sensorielle totale.</p>
            <div class="about-meta">
                <div class="about-meta-item">
                    <span class="about-meta-label">Formation</span>
                    <span class="about-meta-value">ESMOD Paris &mdash; Dipl&ocirc;me Sup&eacute;rieur</span>
                </div>
                <div class="about-meta-item">
                    <span class="about-meta-label">Bas&eacute;</span>
                    <span class="about-meta-value">Paris, France</span>
                </div>
                <div class="about-meta-item">
                    <span class="about-meta-label">Sp&eacute;cialit&eacute;s</span>
                    <span class="about-meta-value">Mode afro-contemporaine, Styling &eacute;ditorial</span>
                </div>
                <div class="about-meta-item">
                    <span class="about-meta-label">Contact</span>
                    <span class="about-meta-value"><a href="mailto:julien.tegnan@fr.esmod.net">julien.tegnan@fr.esmod.net</a></span>
                </div>
            </div>
        </div>
    </div>
</section>

</main>

<?php get_footer(); ?>
