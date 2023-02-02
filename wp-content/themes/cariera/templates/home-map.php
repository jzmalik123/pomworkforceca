<?php
/**
 *
 * @package Cariera
 *
 * @since    1.2.0
 * @version  1.5.3
 *
 * ========================
 * Template Name: Home Page - Map Background
 * ========================
 **/

get_header(); ?>


<section class="home-search-map">
	<?php echo do_shortcode( '[cariera-map type="job_listing" class="home-map" height="400px"]' ); ?>

	<div class="form-wrapper">
		<div class="container">
			<div class="job-search-form-wrapper">
				<?php echo do_shortcode( '[search_form location="yes"]' ); ?>
			</div>
		</div>
	</div>
</section>


<?php
while ( have_posts() ) :
	the_post();
	?>
	<main <?php post_class(); ?>>
		<div class="container">
			<?php the_content(); ?>
		</div>
	</main>
	<?php
endwhile;


get_footer();
