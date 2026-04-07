<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- LOADER -->
<div id="loader" aria-hidden="true">
    <svg class="loader-monogram" width="60" height="60" viewBox="0 0 60 60" fill="none">
        <circle cx="30" cy="30" r="28" stroke="rgba(240,236,228,0.18)" stroke-width="0.5"/>
        <text x="50%" y="53%" text-anchor="middle" dominant-baseline="central"
              font-family="Cormorant Garamond,serif" font-size="22" font-weight="300"
              fill="#f0ece4" letter-spacing="3">JTT</text>
    </svg>
    <div class="loader-bar-wrap">
        <div class="loader-bar" id="loaderBar"></div>
    </div>
    <div class="loader-pct" id="loaderPct">0</div>
</div>

<!-- CURSEUR CUSTOM -->
<div id="cursor" aria-hidden="true"></div>

<?php get_template_part('template-parts/nav'); ?>
