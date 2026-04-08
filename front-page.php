<?php
/**
 * Page d'accueil JTT Portfolio
 * Tous les textes et images viennent de Réglages → JTT Options
 * Chaque bloc n'est affiché QUE si son contenu est renseigné
 */
get_header();

$hero_bg       = jtt_opt('hero_bg_image');
$hero_sub      = jtt_opt('hero_subtitle');
$hero_quote    = jtt_opt('hero_quote');
$hero_author   = jtt_opt('hero_quote_author');
$hero_btn1     = jtt_opt('hero_btn_1_label');
$hero_btn1_url = jtt_opt('hero_btn_1_url', '#work');
$hero_btn2     = jtt_opt('hero_btn_2_label');
$hero_btn2_url = jtt_opt('hero_btn_2_url', '#about');
$instagram_url = jtt_opt('instagram_url');
$email         = jtt_opt('email_contact');

$work_label    = jtt_opt('work_label',       'Portfolio 2021–2026');
$work_line1    = jtt_opt('work_title_line1', 'Discover');
$work_line2    = jtt_opt('work_title_line2', 'My Work');

$mani_1        = jtt_opt('manifesto_line1');
$mani_2        = jtt_opt('manifesto_line2');
$mani_3        = jtt_opt('manifesto_line3');
/* strlen() : vrai même si la valeur est "0" ou un chiffre seul */
$show_manifesto = strlen($mani_1) || strlen($mani_2) || strlen($mani_3);

$about_img     = jtt_opt('about_image');
$about_label   = jtt_opt('about_label',  'À Propos');
$about_name    = jtt_opt('about_name',   'Julien Terence Tegnan');
$about_bio1    = jtt_opt('about_bio_1');
$about_bio2    = jtt_opt('about_bio_2');
$meta_form     = jtt_opt('about_meta_formation');
$meta_base     = jtt_opt('about_meta_base');
$meta_spec     = jtt_opt('about_meta_specialites');
$meta_contact  = jtt_opt('about_meta_contact');
?>

<main id="main-content">

<!-- ═══ HERO ════════════════════════════════════════════════════════════════════ -->
<section id="hero">

    <?php if ($hero_bg) : ?>
    <div class="hero-bg">
        <img src="<?php echo esc_url($hero_bg); ?>"
             alt="" aria-hidden="true" loading="eager" fetchpriority="high">
    </div>
    <?php endif; ?>

    <div class="hero-content">
        <svg class="monogram" viewBox="0 0 100 100" fill="none" aria-hidden="true">
            <circle cx="50" cy="50" r="47" stroke="rgba(240,236,228,0.2)" stroke-width="0.5"/>
            <circle cx="50" cy="50" r="42" stroke="rgba(240,236,228,0.07)" stroke-width="0.5"/>
            <text x="50%" y="52%" text-anchor="middle" dominant-baseline="central"
                  font-family="Cormorant Garamond,serif" font-size="28" font-weight="300"
                  fill="#f0ece4" letter-spacing="3">JTT</text>
        </svg>

        <h1 class="hero-name" aria-label="<?php echo esc_attr($about_name); ?>"></h1>

        <?php if ($hero_sub) : ?>
        <p class="hero-subtitle"><?php echo $hero_sub; ?></p>
        <?php endif; ?>

        <?php if ($hero_quote) : ?>
        <blockquote class="hero-quote">
            <?php echo esc_html($hero_quote); ?>
            <?php if ($hero_author) : ?>
            <em>&mdash; <?php echo esc_html($hero_author); ?></em>
            <?php endif; ?>
        </blockquote>
        <?php endif; ?>

        <?php if ($hero_btn1 || $hero_btn2) : ?>
        <div class="hero-buttons">
            <?php if ($hero_btn1) : ?>
            <a href="<?php echo esc_url($hero_btn1_url); ?>" class="btn filled">
                <?php echo esc_html($hero_btn1); ?>
            </a>
            <?php endif; ?>
            <?php if ($hero_btn2) : ?>
            <a href="<?php echo esc_url($hero_btn2_url); ?>" class="btn">
                <?php echo esc_html($hero_btn2); ?>
            </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if ($instagram_url || $email) : ?>
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
        <?php endif; ?>
    </div>

    <div class="scroll-hint" id="scrollHint" aria-hidden="true">
        <span>Scroll</span>
        <div class="scroll-line"></div>
    </div>
</section>

<div class="section-divider" data-divider></div>

<!-- ═══ WORK ══════════════════════════════════════════════════════════════════════ -->
<section id="work">
    <div class="work-header">
        <?php if ($work_label) : ?>
        <p class="section-label"><?php echo esc_html($work_label); ?></p>
        <?php endif; ?>
        <h2 class="section-title">
            <?php if ($work_line1) : ?>
            <span class="reveal-mask"><span class="reveal-inner"><?php echo esc_html($work_line1); ?></span></span>
            <?php endif; ?>
            <?php if ($work_line2) : ?>
            <span class="reveal-mask"><span class="reveal-inner"><?php echo esc_html($work_line2); ?></span></span>
            <?php endif; ?>
        </h2>
        <?php
        $total     = wp_count_posts('projet')->publish;
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

<?php if ($show_manifesto) : ?>
<div class="section-divider" data-divider></div>
<!-- ═══ MANIFESTO ═══════════════════════════════════════════════════════════════════════ -->
<section id="manifesto">
    <p class="manifesto-text">
        <?php if (strlen($mani_1)) echo wp_kses($mani_1, ['em'=>[],'strong'=>[]]); ?>
        <?php if (strlen($mani_1) && (strlen($mani_2) || strlen($mani_3))) echo '<br>'; ?>
        <?php if (strlen($mani_2)) echo wp_kses($mani_2, ['em'=>[],'strong'=>[]]); ?>
        <?php if (strlen($mani_2) && strlen($mani_3)) echo '<br>'; ?>
        <?php if (strlen($mani_3)) echo wp_kses($mani_3, ['em'=>[],'strong'=>[]]); ?>
    </p>
</section>
<?php endif; ?>

<div class="section-divider" data-divider></div>

<!-- ═══ ABOUT ═══════════════════════════════════════════════════════════════════════ -->
<section id="about">
    <div class="about-inner">

        <?php if ($about_img) : ?>
        <div class="about-image-wrap">
            <img src="<?php echo esc_url($about_img); ?>"
                 alt="Portrait <?php echo esc_attr($about_name); ?>" loading="lazy">
        </div>
        <?php endif; ?>

        <div class="about-text">
            <?php if ($about_label) : ?>
            <p class="section-label"><?php echo esc_html($about_label); ?></p>
            <?php endif; ?>

            <?php if ($about_name) : ?>
            <h2 class="section-title">
                <?php foreach (explode(' ', $about_name) as $word) : ?>
                <span class="reveal-mask"><span class="reveal-inner"><?php echo esc_html($word); ?></span></span>
                <?php endforeach; ?>
            </h2>
            <?php endif; ?>

            <?php if ($about_bio1) : ?>
            <p class="about-bio"><?php echo wp_kses_post($about_bio1); ?></p>
            <?php endif; ?>

            <?php if ($about_bio2) : ?>
            <p class="about-bio"><?php echo wp_kses_post($about_bio2); ?></p>
            <?php endif; ?>

            <?php if ($meta_form || $meta_base || $meta_spec || $meta_contact) : ?>
            <div class="about-meta">
                <?php if ($meta_form) : ?>
                <div class="about-meta-item">
                    <span class="about-meta-label">Formation</span>
                    <span class="about-meta-value"><?php echo esc_html($meta_form); ?></span>
                </div>
                <?php endif; ?>
                <?php if ($meta_base) : ?>
                <div class="about-meta-item">
                    <span class="about-meta-label">Basé</span>
                    <span class="about-meta-value"><?php echo esc_html($meta_base); ?></span>
                </div>
                <?php endif; ?>
                <?php if ($meta_spec) : ?>
                <div class="about-meta-item">
                    <span class="about-meta-label">Spécialités</span>
                    <span class="about-meta-value"><?php echo esc_html($meta_spec); ?></span>
                </div>
                <?php endif; ?>
                <?php if ($meta_contact) : ?>
                <div class="about-meta-item">
                    <span class="about-meta-label">Contact</span>
                    <span class="about-meta-value">
                        <a href="mailto:<?php echo esc_attr($meta_contact); ?>">
                            <?php echo esc_html($meta_contact); ?>
                        </a>
                    </span>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

</main>

<?php get_footer(); ?>
