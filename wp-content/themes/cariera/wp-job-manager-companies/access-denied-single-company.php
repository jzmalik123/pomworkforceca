<?php
/**
 *
 * @package Cariera
 *
 * @since    1.4.7
 * @version  1.5.3
 *
 * ========================
 * COMPANY - ACCESS DENIED SINGLE COMPANY
 * ========================
 **/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
} ?>


<main class="ptb80">
	<div class="container">
		<p class="job-manager-error"><?php esc_html_e( 'Sorry, you do not have permission to view this company.', 'cariera' ); ?></p>
	</div>
</main>
