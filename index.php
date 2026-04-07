<?php
// Fallback WordPress obligatoire
get_header();
?>
<main style="padding:200px 60px;text-align:center;color:var(--text);min-height:60vh;display:flex;flex-direction:column;align-items:center;justify-content:center;">
    <p style="font-family:'Cormorant Garamond',serif;font-size:2rem;margin-bottom:2rem;">Page introuvable.</p>
    <a href="<?php echo esc_url(home_url('/')); ?>" style="font-size:10px;letter-spacing:.3em;text-transform:uppercase;color:var(--grey);text-decoration:none;">
        &larr; Retour &agrave; l'accueil
    </a>
</main>
<?php
get_footer();
