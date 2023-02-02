<?php
/**
 *
 * @package Cariera
 *
 * @since    1.0.0
 * @version  1.5.5
 *
 * ========================
 * SINGLE POST CONTENT
 * ========================
 **/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$blog_layout = cariera_get_option( 'cariera_blog_layout' );

if ( 'fullwidth' === $blog_layout ) {
	$layout = 'col-lg-12';
} else {
	$layout = 'col-lg-8';
} ?>



<?php if ( cariera_get_option( 'cariera_blog_page_header', 'true' ) ) { ?>
	<section class="page-header">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<h1 class="title"><?php echo cariera_get_the_title(); ?></h1>
					<?php
					if ( function_exists( 'cariera_breadcrumbs' ) ) {
						echo cariera_breadcrumbs();
					}
					?>
				</div>
			</div>
		</div>
	</section>
<?php } ?>


<main class="ptb80">
	<div class="container">
		<div class="row">
			<div class="<?php echo esc_attr( $layout ); ?>">
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-post-content' ); ?>>

					<?php cariera_single_post_thumb(); ?>

					<!-- Blog Post Content -->
					<div class="blog-desc">
						<?php
						$page_header = cariera_get_option( 'cariera_blog_page_header' );
						if ( false == $page_header ) {
							?>
							<h3 class="blog-title"><?php the_title(); ?></h3>
							<?php
						}

						// Post Meta Info.
						echo cariera_posted_meta();

						the_content();

						wp_link_pages();

						// Get sharing options.
						if ( cariera_get_option( 'cariera_post_share' ) && function_exists( 'cariera_share_media' ) ) {
							echo cariera_share_media();
						}
						?>
					</div>
				</article>

				<?php
				// Show Post Nav only if there are more posts than 1.
				if ( true === cariera_get_option( 'cariera_blog_post_nav' ) ) :
					cariera_get_post_navigation();
				endif;

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
				?>
			</div>

			<?php 
			if ( 'fullwidth' !== $blog_layout ) {
				get_sidebar();
			} ?>
		</div>
	</div>
</main>
