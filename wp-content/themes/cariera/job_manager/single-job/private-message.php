<?php
/**
 *
 * @package Cariera
 *
 * @since    1.6.0
 * @version  1.6.0
 *
 * ========================
 * SINGLE JOB - PRIVATE MESSAGE TEMPLATE
 * ========================
 **/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


global $job_preview;

if ( $job_preview ) {
	return;
}

if ( cariera_core_is_activated() && get_option( 'cariera_company_manager_integration', false ) ) {
	$company = cariera_get_the_company( $post->ID );
	$logo    = get_the_company_logo( $company, apply_filters( 'cariera_company_logo_size', 'thumbnail' ) );
} else {
	$logo = get_the_company_logo( $post->ID, apply_filters( 'cariera_company_logo_size', 'thumbnail' ) );
}

if ( ! empty( $logo ) ) {
	$logo_img = $logo;
} else {
	$logo_img = apply_filters( 'job_manager_default_company_logo', get_template_directory_uri() . '/assets/images/company.png' );
} ?>


<div class="job-private-message">
	<?php if ( is_user_logged_in() ) { ?>
		<a href="#private-messages" class="popup-with-zoom-anim btn btn-main listing-btn" 
		<?php echo ( get_the_author_meta( 'ID' ) === get_current_user_id() ) ? 'data-disabled="true"' : ''; ?> 
		data-id="<?php echo esc_attr( get_the_ID() ); ?>" data-title="<?php echo esc_attr( get_the_title() ); ?>" 
		data-image="<?php echo esc_url( $logo_img ); ?>" 
		data-author="<?php echo get_the_author_meta( 'ID' ); ?>" 
		data-user-id="1">
			<?php esc_html_e( 'Direct message', 'cariera' ); ?>
		</a>
		<?php
	} else {
		$login_registration = get_option( 'cariera_login_register_layout' );

		if ( 'popup' === $login_registration ) {
			$login_registration_page_url = '#login-register-popup';
		} else {
			$login_registration_page     = get_option( 'cariera_login_register_page' );
			$login_registration_page_url = get_permalink( $login_registration_page );
		}
		?>

		<a href="<?php echo esc_url( $login_registration_page_url ); ?>" class="popup-with-zoom-anim btn btn-main listing-btn">
			<?php esc_html_e( 'Direct message', 'cariera' ); ?>
		</a>
	<?php } ?>
</div>
