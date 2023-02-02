<?php
/**
 *
 * @package Cariera
 *
 * @since    1.5.0
 * @version  1.5.4
 *
 * ========================
 * TEMPLATE FOR HEADER EXTRA
 * ========================
 **/


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$login_registration = get_option( 'cariera_login_register_layout' ); ?>


<div class="extra-menu">
	<?php
	$current_user = wp_get_current_user();

	// HEADER CART.
	if ( cariera_get_option( 'header_cart' ) ) {
		if ( cariera_wc_is_activated() ) {
			$cart_count = WC()->cart->get_cart_contents_count();
			$cart_class = $cart_count < 1 ? 'counter-hidden' : '';
			?>

			<div class="extra-menu-item extra-shop mini-cart woocommerce">
				<a href="#shopping-cart-modal" class="cart-contents popup-with-zoom-anim">
					<i class="icon-bag"></i>
					<span class="notification-count cart-count <?php echo esc_html( $cart_class ); ?>"><?php echo number_format_i18n( $cart_count ); ?></span>
				</a>
			</div>
			<?php
		}
	}


	// HEADER QUICK SEARCH.
	if ( cariera_get_option( 'header_quick_search' ) ) {
		?>
		<div class="extra-menu-item extra-search">
			<a href="#quick-search-modal" class="header-search-btn popup-with-zoom-anim">
				<i class="icon-magnifier" aria-hidden="true"></i>
			</a>
		</div>
		<?php
	}


	// HEADER LOGIN & ACCOUNT.
	if ( cariera_get_option( 'header_account' ) ) {
		if ( ! is_user_logged_in() ) {
			?>
			<div class="extra-menu-item extra-user">

				<?php
				if ( $login_registration == 'popup' ) {
					if ( is_page_template( 'templates/login-register.php' ) ) {
						?>
						<a href="#">
					<?php } else { ?>
						<a href="#login-register-popup" class="popup-with-zoom-anim">
						<?php
					}
				} else {
					$login_registration_page     = get_option( 'cariera_login_register_page' );
					$login_registration_page_url = get_permalink( $login_registration_page );
					?>

					<a href="<?php echo esc_url( $login_registration_page_url ); ?>">
				<?php } ?>
					<i class="icon-user"></i>
				</a>
			</div>
			<?php
		} else {
			get_template_part( 'templates/header/messages' );
			get_template_part( 'templates/header/notifications' );
			get_template_part( 'templates/header/user-menu' );
		}
	}

	get_template_part( 'templates/header/header-cta' );
	?>
</div>
