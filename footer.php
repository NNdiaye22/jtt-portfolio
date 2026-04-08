<footer>
    <div class="footer-inner">
        <div class="footer-brand">
            <div class="footer-logo">J.T. Tegnan</div>
            <div class="footer-tagline">Styliste de Mode &mdash; Paris</div>
        </div>
        <div class="footer-monogram" aria-hidden="true">
            <svg width="70" height="70" viewBox="0 0 80 80" fill="none">
                <circle cx="40" cy="40" r="38" stroke="rgba(240,236,228,0.1)" stroke-width="0.5"/>
                <text x="50%" y="54%" text-anchor="middle" dominant-baseline="central"
                      font-family="Cormorant Garamond,serif" font-size="22" font-weight="300"
                      fill="rgba(240,236,228,0.3)" letter-spacing="3">JTT</text>
            </svg>
        </div>
        <div class="footer-right">
            <ul class="footer-nav">
                <li><a href="<?php echo esc_url(home_url('/#work')); ?>">Collections</a></li>
                <li><a href="<?php echo esc_url(home_url('/#about')); ?>">Biographie</a></li>
                <li><a href="<?php echo esc_url(home_url('/#contact')); ?>">Contact</a></li>
            </ul>
            <div class="footer-socials">
                <?php $linkedin = jtt_opt('linkedin_url'); if ($linkedin) : ?>
                <a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn" class="footer-social-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <rect x="2" y="2" width="20" height="20" rx="3"/>
                        <path d="M7 10v7"/>
                        <path d="M11 10v7"/>
                        <path d="M11 13.5a3.5 3.5 0 0 1 7 0V17"/>
                        <circle cx="7" cy="7.5" r="1" fill="currentColor" stroke="none"/>
                    </svg>
                </a>
                <?php endif; ?>
                <?php $instagram = jtt_opt('instagram_url'); if ($instagram) : ?>
                <a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram" class="footer-social-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <rect x="2" y="2" width="20" height="20" rx="5"/>
                        <circle cx="12" cy="12" r="5"/>
                        <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
                    </svg>
                </a>
                <?php endif; ?>
                <?php $spotify = jtt_opt('spotify_url'); if ($spotify) : ?>
                <a href="<?php echo esc_url($spotify); ?>" target="_blank" rel="noopener noreferrer" aria-label="Spotify" class="footer-social-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M8 15.5c2.3-1.2 5.5-1.2 8 0"/>
                        <path d="M7 12c2.8-1.5 6.5-1.5 10 0"/>
                        <path d="M6.5 8.5c3.2-1.7 7.8-1.7 11 0"/>
                    </svg>
                </a>
                <?php endif; ?>
                <?php $email = jtt_opt('email_contact'); if ($email) : ?>
                <a href="mailto:<?php echo esc_attr($email); ?>" aria-label="Envoyer un e-mail" class="footer-social-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <rect x="2" y="4" width="20" height="16" rx="2"/>
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                    </svg>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p class="footer-copy">&copy; <?php echo date('Y'); ?> Julien Terence Tegnan. Tous droits r&eacute;serv&eacute;s.</p>
        <p class="footer-made">Con&ccedil;u avec intention &mdash; Paris</p>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
