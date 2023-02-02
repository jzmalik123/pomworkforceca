<?php
/**
 *
 * @package Cariera
 *
 * @since    1.6.0
 * @version  1.6.0
 *
 * ========================
 * HEADER EXTRA NAV - MESSAGES
 * ========================
 **/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! cariera_core_is_activated() ) {
	return;
}

if ( ! get_option( 'cariera_private_messages' ) ) {
	return;
}
?>

<div class="extra-menu-item extra-messages">
	<a href="#private-messages" class="popup-with-zoom-anim private-messages-trigger" aria-label="<?php esc_attr_e( 'Messages modal trigger', 'cariera' ); ?>">
		<i class="icon-envelope"></i>

		<span class="notification-count d-none"><?php echo esc_html( '0' ); ?></span>
	</a>
</div>
