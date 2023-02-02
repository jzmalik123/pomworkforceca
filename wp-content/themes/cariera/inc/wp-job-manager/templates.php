<?php
/**
 *
 * @package Cariera
 *
 * @since    1.3.0
 * @version  1.6.2
 *
 * ========================
 * ALL WP JOB MANAGER TEMPLATE HOOKS
 * ========================
 **/

/**
 * Job Listing status badges
 *
 * @since 1.4.8
 */
function cariera_job_listing_status_title() {
	global $post;

	if ( is_position_filled() ) {
		echo '<span class="job-listing-status-badge filled">' . esc_html__( 'filled', 'cariera' ) . '</span>';
	}

	if ( 'expired' === $post->post_status ) {
		echo '<span class="job-listing-status-badge expired">' . esc_html__( 'expired', 'cariera' ) . '</span>';
	}
}

add_action( 'cariera_job_listing_status', 'cariera_job_listing_status_title' );



/**
 * Remove WPJM action to handle certain templates
 *
 * @since   1.3.0
 * @version 1.5.5
 */
function cariera_wpjm_remove_actions() {
	$layout = cariera_single_job_layout();

	remove_action( 'single_job_listing_start', 'job_listing_meta_display', 20 );

	if ( 'v1' !== $layout ) {
		remove_action( 'single_job_listing_start', 'job_listing_company_display', 30 );
	}
}

add_action( 'init', 'cariera_wpjm_remove_actions' );


/*
=====================================================
	SINGLE JOB PAGE
=====================================================
*/

/**
 * Adding Application message to Single Job Listing
 *
 * @since   1.3.0
 * @version 1.5.0
 */
if ( ! function_exists( 'cariera_single_job_application_msg' ) ) {
	function cariera_single_job_application_msg() {
		if ( ! class_exists( 'WP_Job_Manager_Applications' ) ) {
			return;
		}

		if ( is_position_filled() ) { ?>
			<div class="job-manager-message success position-filled">
				<?php esc_html_e( 'This position has been filled', 'cariera' ); ?>
			</div>
		<?php } elseif ( ! candidates_can_apply() ) { ?>
			<div class="job-manager-message error applications-closed">
				<?php esc_html_e( 'Applications have closed', 'cariera' ); ?>
			</div>
			<?php
		}
	}
}

add_action( 'single_job_listing_start', 'cariera_single_job_application_msg', 20 );



/**
 * Adding Share buttons to Single Job Listing
 *
 * @since   1.3.0
 * @version 1.5.5
 */
if ( ! function_exists( 'cariera_single_job_share' ) ) {
	function cariera_single_job_share() {
		if ( ! cariera_get_option( 'cariera_job_share' ) || ! function_exists( 'cariera_share_media' ) ) {
			return;
		}

		echo cariera_share_media();
	}
}

add_action( 'single_job_listing_end', 'cariera_single_job_share' );



/**
 * Adding Related Jobs to Single Job Listing
 *
 * @since   1.3.0
 * @version 1.5.5
 */
if ( ! function_exists( 'cariera_single_job_related_jobs' ) ) {
	function cariera_single_job_related_jobs() {
		if ( ! cariera_get_option( 'cariera_related_jobs' ) ) {
			return;
		}

		get_job_manager_template_part( 'single-job/related-jobs' );
	}
}

add_action( 'cariera_single_job_listing_after', 'cariera_single_job_related_jobs', 20 );



/**
 * Edit single job listing button
 *
 * @since  	1.5.5
 * @version 1.6.2
 */
function cariera_edit_single_job_listing() {
	global $post, $job_preview;

	if ( $job_preview ) {
		return;
	};

	if ( ! job_manager_user_can_edit_job( $post->ID ) ) {
		return;
	}

	$dashboard_id = apply_filters( 'cariera_edit_single_job_listing_dashboard_id', get_option( 'job_manager_job_dashboard_page_id' ) );

	$edit_link = add_query_arg(
		[
			'action' => 'edit',
			'job_id' => $post->ID,
		],
		get_permalink( $dashboard_id )
	);
	?>

	<a href="<?php echo esc_url( $edit_link ); ?>" class="edit-listing btn-main"><?php esc_html_e( 'Edit Job', 'cariera' ); ?></a>
	<?php
}

add_action( 'cariera_single_job_listing_after', 'cariera_edit_single_job_listing', 21 );



/**
 * Adding Job Overview to the sidebar
 *
 * @since   1.5.5
 * @version 1.5.5
 */
function cariera_single_job_sidebar_overview() {
	get_job_manager_template_part( 'single-job/single-job-listing-overview' );
}

add_action( 'cariera_single_job_listing_sidebar', 'cariera_single_job_sidebar_overview', 10 );



/**
 * Adding Map to the job sidebar
 *
 * @since   1.5.5
 * @version 1.5.5
 */
function cariera_single_job_sidebar_map() {
	echo '<aside class="mt40">';
	cariera_job_map();
	echo '</aside>';
}

add_action( 'cariera_single_job_listing_sidebar', 'cariera_single_job_sidebar_map', 20 );



/**
 * Adding Sidebar widget area to the job sidebar
 *
 * @since   1.5.5
 * @version 1.5.5
 */
function cariera_single_job_sidebar() {
	dynamic_sidebar( 'sidebar-single-job' );
}

add_action( 'cariera_single_job_listing_sidebar', 'cariera_single_job_sidebar', 30 );



/**
 * Adding job application to the job-overview
 *
 * @since   1.5.5
 * @version 1.5.5
 */
function cariera_single_job_application() {
	$layout = cariera_single_job_layout();

	if ( 'v1' !== $layout ) {
		return;
	}

	get_job_manager_template_part( 'single-job/single-job-application' );
}

add_action( 'single_job_listing_meta_end', 'cariera_single_job_application', 999 );



/*
=====================================================
	SINGLE JOB PAGE V.2
=====================================================
*/

/**
 * Adding Job overview to the single page
 *
 * @since   1.5.5
 * @version 1.5.5
 */
function cariera_single_job_v2_overview() {
	$layout = cariera_single_job_layout();

	if ( 'v1' === $layout ) {
		return;
	}

	echo '<div class="job-overview">';
	get_job_manager_template_part( 'single-job/single-job-listing-overview' );
	echo '</div>';
}

add_action( 'single_job_listing_end', 'cariera_single_job_v2_overview', 7 );



/**
 * Adding Job overview to the single page
 *
 * @since   1.5.5
 * @version 1.5.6
 */
function cariera_single_job_v2_map() {
	global $post;

	$layout  = cariera_single_job_layout();
	$job_map = cariera_get_option( 'cariera_job_map' );
	$lng     = $post->geolocation_long;

	if ( 'v1' === $layout ) {
		return;
	}

	if ( ! $job_map || empty( $lng ) ) {
		return;
	}

	echo '<div class="job-map">';
	echo '<h5 class="mt-0">' . esc_html__( 'Job Location', 'cariera' ) . '</h5>';
	cariera_job_map();
	echo '</div>';
}

add_action( 'single_job_listing_end', 'cariera_single_job_v2_map', 8 );



/**
 * Adding Job overview to the single page
 *
 * @since   1.5.5
 * @version 1.5.5
 */
function cariera_single_job_v2_application() {
	get_job_manager_template_part( 'single-job/single-job-application' );
}

add_action( 'cariera_job_listing_actions', 'cariera_single_job_v2_application', 10 );



/**
 * Adding Job expiration date under the listing actions
 *
 * @since   1.5.5
 * @version 1.5.6
 */
function cariera_single_job_v2_expire() {
	global $post;

	$expired_date = get_post_meta( $post->ID, '_job_expires', true );

	if ( empty( $expired_date ) ) {
		return;
	}
	?>

	<div class="job-expiration">
		<span><?php esc_html_e( 'Expiration Date:', 'cariera' ); ?></span>
		<span class="expiration-date"><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $expired_date ) ) ); ?></span>
	</div>
	<?php
}

add_action( 'cariera_job_listing_actions', 'cariera_single_job_v2_expire', 11 );

/*
=====================================================
	JOB SUBMISSION HTML MARKUP
=====================================================
*/

/**
 * Job Submission Flow
 *
 * @since   1.3.2
 * @version 1.6.4
 */
function cariera_job_submission_flow() {
	// Temporary variables.
	$is_packages_enabled = false;

	// Get page IDs.
	$current_page_id     = get_queried_object_id();
	$job_submission_page = apply_filters( 'cariera_dashboard_job_submit_page', get_option( 'job_manager_submit_job_form_page_id', false ) );

	// Get job packages.
	if ( function_exists( 'wc_get_products' ) ) {
		$job_packages        = wc_get_products( [ 'type' => 'job_package' ] );
		$job_subscriptions   = wc_get_products( [ 'type' => 'job_package_subscription' ] );
		$is_packages_enabled = class_exists( 'WC_Paid_Listings' ) && ( ! empty( $job_packages ) || ! empty( $job_subscriptions ) );
	}

	// Display submission flow.
	if ( ! empty( $job_submission_page ) && ( absint( $job_submission_page ) === $current_page_id ) ) {
		?>
		<div class="submission-flow job-submission-flow">
			<ul>
				<?php if ( get_option( 'job_manager_paid_listings_flow' ) === 'before' && $is_packages_enabled ) { ?>
					<li class="choose-package"><?php esc_html_e( 'Choose Package', 'cariera' ); ?></li>
				<?php } ?>
				<li class="listing-details"><?php esc_html_e( 'Listing Details', 'cariera' ); ?></li>
				<li class="preview-listing"><?php esc_html_e( 'Preview Listing', 'cariera' ); ?></li>
				<?php if ( get_option( 'job_manager_paid_listings_flow' ) !== 'before' && $is_packages_enabled ) { ?>
					<li class="choose-package"><?php esc_html_e( 'Choose Package', 'cariera' ); ?></li>
				<?php } ?>
				<?php if ( $is_packages_enabled ) { ?>
					<li class="checkout"><?php esc_html_e( 'Checkout', 'cariera' ); ?></li>
				<?php } ?>
			</ul>
		</div>
		<?php
	}
}

add_action( 'cariera_job_submission_steps', 'cariera_job_submission_flow' );




/**
 * Job submission fields
 *
 * @since 1.4.0
 */
function cariera_submit_job_fields_start() {
	echo '<div class="submit-job-box submit-job_job-info">';
		echo '<h3 class="title">' . esc_html__( 'Job Details', 'cariera' ) . '</h3>';
		echo '<div class="form-fields">';
}

add_action( 'submit_job_form_job_fields_start', 'cariera_submit_job_fields_start' );

function cariera_submit_job_fields_end() {
	echo '</div></div>';
}

add_action( 'submit_job_form_job_fields_end', 'cariera_submit_job_fields_end' );



/**
 * Company submission fields
 *
 * @since 1.4.0
 */
function cariera_submit_company_fields_start() {
	echo '<div class="submit-job-box submit-job_company-info">';
		echo '<h3 class="title">' . esc_html__( 'Company Details', 'cariera' ) . '</h3>';
		echo '<div class="form-fields">';
}

add_action( 'submit_job_form_company_fields_start', 'cariera_submit_company_fields_start' );
add_action( 'submit_company_form_company_fields_start', 'cariera_submit_company_fields_start' );


function cariera_submit_company_fields_end() {
	echo '</div></div>';
}

add_action( 'submit_job_form_company_fields_end', 'cariera_submit_company_fields_end', 20 );
add_action( 'submit_company_form_company_fields_end', 'cariera_submit_company_fields_end' );



/**
 * Company selection
 *
 * @since 1.4.0
 */
function cariera_submit_job_form_button_text( $text ) {
	return esc_html__( 'Preview Listing', 'cariera' );
}

add_filter( 'submit_job_form_submit_button_text', 'cariera_submit_job_form_button_text' );
