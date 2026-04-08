<?php
/**
 * Page d'accueil JTT Portfolio
 * Tous les textes et images viennent de Réglages → JTT Options
 */
get_header();

// Récupération des options (valeurs par défaut si vide)
$hero_bg       = jtt_opt('hero_bg_image', 'https://cdn.myportfolio.com/4b129293-66fb-48ba-b250-1e6e7c44c8e2/120ebdea-6fc0-40ad-acb7-7f7bd166ad34,rw_1200.jpeg?h=7e9e9292dafa2ba8a6a7daf28675aad2');
$hero_sub      = jtt_opt('hero_subtitle', 'Styliste de Mode &nbsp;&bull;&nbsp; Paris');
$hero_quote    = jtt_opt('hero_quote', "La mode est ce que l'on porte. Ce qui est démodé, c'est ce que portent les autres.");
$hero_author   = jtt_opt('hero_quote_author', 'Oscar Wilde');
$hero_btn1     = jtt_opt('hero_btn_1_label', 'Découvrir mes projets');
$hero_btn2     = jtt_opt('hero_btn_2_label', 'À propos');
$instagram_url = jtt_opt('instagram_url', 'https://www.instagram.com/j.tegnan');
$email         = jtt_opt('email_contact', 'julien.tegnan@fr.esmod.net');

$work_label    = jtt_opt('work_label', 'Portfolio 2021–2026');
$work_line1    = jtt_opt('work_title_line1', 'Discover');
$work_line2    = jtt_opt('work_title_line2', 'My Work');

$mani_1        = jtt_opt('manifesto_line1', 'Chaque vêtement est une <em>déclaration</em>,');
$mani_2        = jtt_opt('manifesto_line2', 'chaque tissu une <em>langue</em>,');
$mani_3        = jtt_opt('manifesto_line3', 'chaque silhouette une <em>histoire</em>.');

$about_img     = jtt_opt('about_image', 'https://cdn.myportfolio.com/4b129293-66fb-48ba-b250-1e6e7c44c8e2/2fbe3839-7309-4d05-aef5-fcfc84aadb16,rw_1200.jpeg?h=83c4acf4c9aa74751eb5e78ed4715d02');
$about_label   = jtt_opt('about_label', 'À Propos');
$about_name    = jtt_opt('about_name', 'Julien Terence Tegnan');
$about_bio1    = jtt_opt('about_bio_1', '<strong>Julien Terence Tegnan</strong> est un styliste de mode parisien né au cœur de deux cultures : la rigueur du continent africain et l’élégance du Paris couture. Diplomé de l’ESMOD Paris avec les félicitations du jury, il construit depuis 2018 un langage visuel qui réconcilie la <strong>modernité afropolitaine</strong> avec les codes du luxe européen.');
$about_bio2    = jtt_opt('about_bio_2', 'Ses collections explorent les textures de la mémoire, les géographies du corps et la <strong>poésie du quotidien</strong>. Travaillant à l’intersection du prêt-à-porter et de la haute couture, Julien collabore avec des photographes, des danseurs et des architectes pour faire de chaque défilé une expérience sensorielle totale.');
$meta_form     = jtt_opt('about_meta_formation', 'ESMOD Paris — Diplôme Supérieur');
$meta_base     = jtt_opt('about_meta_base', 'Paris, France');
$meta_spec     = jtt_opt('about_meta_specialites', 'Mode afro-contemporaine, Styling éditorial');
$meta_contact  = jtt_opt('about_meta_contact', 'julien.tegnan@fr.esmod.net');
?>

<main id="main-content">

<!-- HERO -->
<section id="hero">
    <div class="hero-bg">
        <img src="<?php echo esc_url($hero_bg); ?>"
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
        <h1 class="hero-name" aria-label="<?php echo esc_attr($about_name); ?>"></h1>
        <p class="hero-subtitle"><?php echo $hero_sub; ?></p>
        <blockquote class="hero-quote">
            <?php echo esc_html($hero_quote); ?>
            <em>&mdash; <?php echo esc_html($hero_author); ?></em>
        </blockquote>
        <div class="hero-buttons">
            <a href="#work" class="btn filled"><?php echo esc_html($hero_btn1); ?></a>
            <a href="#about" class="btn"><?php echo esc_html($hero_btn2); ?></a>
        </div>
        <div class="hero-socials">
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
    <div class="scroll-hint" id="scrollHint" aria-hidden="true">
        <span>Scroll</span>
        <div class="scroll-line"></div>
    </div>
</section>

<div class="section-divider" data-divider></div>

<!-- WORK -->
<section id="work">
    <div class="work-header">
        <p class="section-label"><?php echo esc_html($work_label); ?></p>
        <h2 class="section-title">
            <span class="reveal-mask"><span class="reveal-inner"><?php echo esc_html($work_line1); ?></span></span>
            <span class="reveal-mask"><span class="reveal-inner"><?php echo esc_html($work_line2); ?></span></span>
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
                $num     = str_pad($i, 2, '0', STR_PAD_LEFT);
                $img_url = get_the_post_thumbnail_url(get_the_ID(), 'large')
                           ?: get_post_meta(get_the_ID(), '_thumbnail_external', true);
                $img_url = $img_url ? esc_url($img_url) : '';
                $img_alt = esc_attr(get_the_title());
                $year    = get_post_meta(get_the_ID(), 'projet_annee', true) ?: date('Y');
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
        <?php echo wp_kses($mani_1, ['em'=>[]]); ?><br>
        <?php echo wp_kses($mani_2, ['em'=>[]]); ?><br>
        <?php echo wp_kses($mani_3, ['em'=>[]]); ?>
    </p>
</section>

<div class="section-divider" data-divider></div>

<!-- ABOUT -->
<section id="about">
    <div class="about-inner">
        <div class="about-image-wrap">
            <img src="<?php echo esc_url($about_img); ?>"
                 alt="Portrait <?php echo esc_attr($about_name); ?>" loading="lazy">
        </div>
        <div class="about-text">
            <p class="section-label"><?php echo esc_html($about_label); ?></p>
            <h2 class="section-title">
                <?php foreach (explode(' ', $about_name) as $word) : ?>
                <span class="reveal-mask"><span class="reveal-inner"><?php echo esc_html($word); ?></span></span>
                <?php endforeach; ?>
            </h2>
            <p class="about-bio"><?php echo wp_kses_post($about_bio1); ?></p>
            <p class="about-bio"><?php echo wp_kses_post($about_bio2); ?></p>
            <div class="about-meta">
                <div class="about-meta-item">
                    <span class="about-meta-label">Formation</span>
                    <span class="about-meta-value"><?php echo esc_html($meta_form); ?></span>
                </div>
                <div class="about-meta-item">
                    <span class="about-meta-label">Basé</span>
                    <span class="about-meta-value"><?php echo esc_html($meta_base); ?></span>
                </div>
                <div class="about-meta-item">
                    <span class="about-meta-label">Spécialités</span>
                    <span class="about-meta-value"><?php echo esc_html($meta_spec); ?></span>
                </div>
                <div class="about-meta-item">
                    <span class="about-meta-label">Contact</span>
                    <span class="about-meta-value"><a href="mailto:<?php echo esc_attr($meta_contact); ?>"><?php echo esc_html($meta_contact); ?></a></span>
                </div>
            </div>
        </div>
    </div>
</section>

</main>

<?php get_footer(); ?>
