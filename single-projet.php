<?php get_header(); ?>

<?php
$hero_img    = get_field('project_hero_image');
$hero_url    = $hero_img ? esc_url($hero_img['url']) : get_the_post_thumbnail_url(get_the_ID(), 'full');
$hero_alt    = $hero_img ? esc_attr($hero_img['alt']) : esc_attr(get_the_title());
$year        = get_field('project_year') ?: date('Y');
$model       = get_field('project_model');
$category    = get_field('project_category');
$desc        = get_field('project_description');
$intro_title = get_field('project_intro_title');
$mood_img    = get_field('project_mood_image');
$creative_img= get_field('project_creative_image');
$quote_text  = get_field('project_quote');
$quote_author= get_field('project_quote_author');
$gallery     = get_field('project_gallery');
$credits     = get_field('project_credits');
?>

<main id="main-content">

<!-- LIGHTBOX OVERLAY -->
<div id="lightbox-overlay" role="dialog" aria-modal="true" aria-label="Aper&ccedil;u image">
    <button id="lb-close" aria-label="Fermer">&times;</button>
    <button id="lb-prev" aria-label="Pr&eacute;c&eacute;dent">&#8592;</button>
    <button id="lb-next" aria-label="Suivant">&#8594;</button>
    <img src="" alt="" id="lightbox-img" draggable="false">
    <span class="lb-counter" id="lb-counter"></span>
</div>

<!-- HERO -->
<section class="col-hero">
    <div class="col-hero-bg">
        <?php if ($hero_url) : ?>
        <img class="lightbox-trigger" data-full="<?php echo $hero_url; ?>"
             src="<?php echo $hero_url; ?>" alt="<?php echo $hero_alt; ?>"
             loading="eager" fetchpriority="high">
        <?php endif; ?>
    </div>
    <div class="col-hero-content">
        <p class="col-hero-label">Collection <?php echo esc_html($year); ?></p>
        <h1 class="col-hero-title"><?php the_title(); ?></h1>
        <?php if ($model) : ?>
        <p class="col-hero-sub"><?php echo esc_html($model); ?> &nbsp;&nbsp; <?php echo esc_html(get_the_author_meta('display_name')); ?></p>
        <?php endif; ?>
    </div>
    <div class="col-hero-scroll" aria-hidden="true">
        <span>Scroll</span>
        <div class="scroll-line"></div>
    </div>
</section>

<!-- INTRO -->
<section class="section-intro reveal">
    <div class="intro-meta">
        <?php if ($year) : ?>
        <div class="meta-block">
            <p class="meta-label">Ann&eacute;e</p>
            <p class="meta-value"><?php echo esc_html($year); ?></p>
        </div>
        <?php endif; ?>
        <?php if ($model) : ?>
        <div class="meta-block">
            <p class="meta-label">Mod&egrave;le</p>
            <p class="meta-value"><?php echo esc_html($model); ?></p>
        </div>
        <?php endif; ?>
        <div class="meta-block">
            <p class="meta-label">Styliste</p>
            <p class="meta-value">Julien Terence Tegnan</p>
        </div>
        <?php if ($category) : ?>
        <div class="meta-block">
            <p class="meta-label">Cat&eacute;gorie</p>
            <p class="meta-value"><?php echo esc_html($category); ?></p>
        </div>
        <?php endif; ?>
    </div>
    <div class="intro-text reveal">
        <?php if ($intro_title) : ?>
        <h2 class="intro-title"><?php echo esc_html($intro_title); ?></h2>
        <?php endif; ?>
        <?php if ($desc) : ?>
        <div class="intro-body"><?php echo wp_kses_post($desc); ?></div>
        <?php else : the_content(); endif; ?>
    </div>
</section>

<?php if ($mood_img) : ?>
<!-- MOOD BOARD -->
<div class="section-label"><div class="section-label-line"></div><span class="section-label-text">Mood Board</span><div class="section-label-line"></div></div>
<div class="mood-single reveal-img lightbox-trigger" data-full="<?php echo esc_url($mood_img['url']); ?>">
    <img src="<?php echo esc_url($mood_img['url']); ?>" alt="<?php echo esc_attr($mood_img['alt']); ?>" loading="lazy">
</div>
<?php endif; ?>

<?php if ($creative_img) : ?>
<!-- CREATIVE DIRECTION -->
<div class="section-label"><div class="section-label-line"></div><span class="section-label-text">Creative Direction</span><div class="section-label-line"></div></div>
<div class="creative-single reveal-img lightbox-trigger" data-full="<?php echo esc_url($creative_img['url']); ?>">
    <img src="<?php echo esc_url($creative_img['url']); ?>" alt="<?php echo esc_attr($creative_img['alt']); ?>" loading="lazy">
</div>
<?php endif; ?>

<?php if ($quote_text) : ?>
<!-- QUOTE -->
<div class="quote-divider reveal">
    <span class="quote-mark">&ldquo;</span>
    <p class="quote-text"><?php echo esc_html($quote_text); ?></p>
    <?php if ($quote_author) : ?><p class="quote-author"><?php echo esc_html($quote_author); ?></p><?php endif; ?>
</div>
<?php endif; ?>

<?php if ($gallery) : ?>
<!-- SHOOTING -->
<div class="section-label"><div class="section-label-line"></div><span class="section-label-text">Shooting</span><div class="section-label-line"></div></div>
<div class="shooting-grid">
    <?php foreach ($gallery as $i => $img) : ?>
    <div class="shoot-item <?php echo $i === 0 ? 'featured' : ''; ?> reveal-img lightbox-trigger"
         data-full="<?php echo esc_url($img['url']); ?>">
        <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" loading="lazy">
        <span class="shoot-num"><?php echo str_pad($i+1, 2, '0', STR_PAD_LEFT); ?></span>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php if ($credits) : ?>
<!-- CREDITS -->
<div class="section-label"><div class="section-label-line"></div><span class="section-label-text">Cr&eacute;dits</span><div class="section-label-line"></div></div>
<div class="section-credits reveal">
    <?php foreach ($credits as $credit) : ?>
    <div class="credit-block">
        <p class="credit-role"><?php echo esc_html($credit['role']); ?></p>
        <p class="credit-name"><?php echo esc_html($credit['name']); ?></p>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- NEXT COLLECTIONS -->
<?php
$others = jtt_get_other_projets(get_the_ID(), 3);
if ($others->have_posts()) :
?>
<div class="next-header reveal">
    <p class="next-header-text">Autres collections</p>
</div>
<div class="next-collections">
    <?php while ($others->have_posts()) : $others->the_post();
        $nimg = get_field('project_hero_image');
        $nurl = $nimg ? esc_url($nimg['url']) : get_the_post_thumbnail_url(get_the_ID(), 'large');
        $nyear= get_field('project_year') ?: date('Y');
    ?>
    <a href="<?php the_permalink(); ?>" class="next-item">
        <?php if ($nurl) : ?>
        <img src="<?php echo $nurl; ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
        <?php endif; ?>
        <div class="next-overlay">
            <span class="next-label">Collection <?php echo esc_html($nyear); ?></span>
            <span class="next-title"><?php the_title(); ?></span>
            <div class="next-arrow"></div>
        </div>
    </a>
    <?php endwhile; wp_reset_postdata(); ?>
</div>
<?php endif; ?>

</main>

<?php get_footer(); ?>
