<?php
/**
 *
 * @package Cariera
 *
 * @since    1.0.0
 * @version  1.5.3
 *
 * ========================
 * TEMPLATE FOR DISPLAYING 404 PAGES
 * ========================
 **/

get_header(); ?>


<main class="ptb160 page-not-found">    
	<div class="container">
		<div class="col-md-12">
			<h2 class="nomargin"><?php esc_html_e( '404', 'cariera' ); ?></h2>
			<h3 class="capitalize nomargin"><?php esc_attr_e( 'page not found', 'cariera' ); ?></h3>
			<a href="<?php echo esc_url( home_url() ); ?>" class="btn btn-main btn-effect mt20"><?php esc_attr_e( 'back home', 'cariera' ); ?></a>
		</div>
	</div>
</main>


<?php
get_footer();
