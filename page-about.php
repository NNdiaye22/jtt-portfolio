<?php
/**
 * Template Name: About Me
 * Description: Page About avec biographie complète et liens réseaux sociaux
 */

get_header();
?>

<main class="page-about">
	<div class="container">
		
		<?php while (have_posts()) : the_post(); ?>
		
		<!-- Section Hero : Titre + Photo -->
		<section class="about-hero">
			<div class="about-hero__content">
				<div class="about-hero__text">
					<h1 class="about-hero__title"><?php the_title(); ?></h1>
				</div>
				
				<div class="about-hero__image">
					<?php if (has_post_thumbnail()) : ?>
						<?php the_post_thumbnail('large', array('class' => 'about-photo')); ?>
					<?php endif; ?>
				</div>
			</div>
		</section>
		
		<!-- Section Biographie -->
		<section class="about-bio">
			<div class="about-bio__text">
				<?php the_content(); ?>
			</div>
		</section>
		
		<!-- Section Moodboard/Image artistique (optionnel) -->
		<?php 
		// Custom field pour une image moodboard
		$moodboard_image = get_post_meta(get_the_ID(), 'moodboard_image', true);
		if ($moodboard_image) :
		?>
		<section class="about-moodboard">
			<img src="<?php echo esc_url($moodboard_image); ?>" alt="Moodboard" class="about-moodboard__image">
		</section>
		<?php endif; ?>
		
		<!-- Section Réseaux sociaux -->
		<section class="about-social">
			<div class="about-social__links">
				<?php 
				// Récupérer les liens depuis les custom fields
				$linkedin = get_post_meta(get_the_ID(), 'linkedin_url', true);
				$instagram = get_post_meta(get_the_ID(), 'instagram_url', true);
				$spotify = get_post_meta(get_the_ID(), 'spotify_url', true);
				$email = get_post_meta(get_the_ID(), 'email_contact', true);
				?>
				
				<?php if ($linkedin) : ?>
					<a href="<?php echo esc_url($linkedin); ?>" target="_blank" rel="noopener" class="social-link social-link--linkedin">
						<i class="fab fa-linkedin"></i>
						<span class="sr-only">LinkedIn</span>
					</a>
				<?php endif; ?>
				
				<?php if ($instagram) : ?>
					<a href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener" class="social-link social-link--instagram">
						<i class="fab fa-instagram"></i>
						<span class="sr-only">Instagram</span>
					</a>
				<?php endif; ?>
				
				<?php if ($spotify) : ?>
					<a href="<?php echo esc_url($spotify); ?>" target="_blank" rel="noopener" class="social-link social-link--spotify">
						<i class="fab fa-spotify"></i>
						<span class="sr-only">Spotify</span>
					</a>
				<?php endif; ?>
				
				<?php if ($email) : ?>
					<a href="mailto:<?php echo esc_attr($email); ?>" class="social-link social-link--email">
						<i class="fas fa-envelope"></i>
						<span class="sr-only">Email</span>
					</a>
				<?php endif; ?>
			</div>
		</section>
		
		<?php endwhile; ?>
		
	</div>
</main>

<style>
/* Styles spécifiques pour la page About */
.page-about {
	padding: 60px 0;
}

/* Section Hero */
.about-hero__content {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 60px;
	align-items: center;
	margin-bottom: 60px;
}

.about-hero__title {
	font-size: 4rem;
	font-family: 'Libre Baskerville', serif;
	font-weight: bold;
	text-transform: uppercase;
	line-height: 1.1;
	margin: 0;
}

.about-hero__image {
	width: 100%;
}

.about-photo {
	width: 100%;
	height: auto;
	object-fit: cover;
	border-radius: 4px;
}

/* Section Biographie */
.about-bio {
	max-width: 800px;
	margin: 0 auto 80px;
}

.about-bio__text {
	font-size: 1.1rem;
	line-height: 1.8;
	font-family: 'Montserrat', sans-serif;
	color: var(--couleur-texte-principal);
}

.about-bio__text p {
	margin-bottom: 1.5rem;
}

/* Section Moodboard */
.about-moodboard {
	margin: 80px 0;
	text-align: center;
}

.about-moodboard__image {
	max-width: 100%;
	height: auto;
	border-radius: 4px;
}

/* Section Réseaux sociaux */
.about-social {
	text-align: center;
	margin-top: 60px;
	padding-top: 60px;
	border-top: 1px solid var(--couleur-gris-moyen);
}

.about-social__links {
	display: flex;
	justify-content: center;
	gap: 30px;
}

.social-link {
	display: flex;
	align-items: center;
	justify-content: center;
	width: 50px;
	height: 50px;
	border-radius: 50%;
	background-color: rgba(255, 255, 255, 0.1);
	color: var(--couleur-texte-principal);
	transition: all 0.3s ease;
	font-size: 1.5rem;
}

.social-link:hover {
	background-color: var(--couleur-accent);
	color: var(--couleur-fond-principal);
	transform: translateY(-3px);
}

.sr-only {
	position: absolute;
	width: 1px;
	height: 1px;
	padding: 0;
	margin: -1px;
	overflow: hidden;
	clip: rect(0,0,0,0);
	border: 0;
}

/* Responsive */
@media (max-width: 768px) {
	.about-hero__content {
		grid-template-columns: 1fr;
		gap: 40px;
	}
	
	.about-hero__title {
		font-size: 2.5rem;
	}
	
	.about-bio__text {
		font-size: 1rem;
	}
	
	.about-social__links {
		gap: 20px;
	}
	
	.social-link {
		width: 45px;
		height: 45px;
		font-size: 1.3rem;
	}
}
</style>

<?php get_footer(); ?>
