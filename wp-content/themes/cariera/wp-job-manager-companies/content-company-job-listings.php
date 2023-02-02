<?php
/**
 *
 * @package Cariera
 *
 * @since   1.5.5
 * @version 1.5.5
 *
 * ========================
 * COMPANY'S ACTIVE JOB LISTINGS
 * ========================
 **/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $company_preview;

if ( $company_preview ) {
	return;
}

$show_active = get_option( 'cariera_companies_per_page' );
$companies   = cariera_get_the_company_job_listing( $post->ID, [ 'posts_per_page' => $show_active ] );


if ( $companies->have_posts() ) {
	do_action( 'cariera_company_job_listings_before' ); ?>

	<div id="company-job-listings" class="company-job-listings">
		<h5><?php esc_html_e( 'Job Positions', 'cariera' ); ?></h5>

		<ul class="job_listings job-listings-main job_list row">
			<?php
			while ( $companies->have_posts() ) :
				$companies->the_post();
				?>
				<?php get_job_manager_template_part( 'job-templates/content', 'job_listing_list1' ); ?>
			<?php endwhile; ?>
		</ul>
	</div>

	<?php
	do_action( 'cariera_company_job_listings_after' );
}

wp_reset_postdata();
