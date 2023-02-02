<?php
/**
 *
 * @package Cariera
 *
 * @since    1.3.4
 * @version  1.6.2
 *
 * ========================
 * DASHBOARD FUNCTIONS
 * ========================
 **/



/**
 * Dashboard Navigation - Profile Box
 *
 * @since   1.4.0
 * @version 1.5.2
 */
function cariera_dashboard_profile() { ?>

	<div class="dashboard-profile-box">
		<?php
		$current_user = wp_get_current_user();
		$user_id      = get_current_user_id();
		$user_img     = get_avatar( get_the_author_meta( 'ID', $user_id ), 80 );
		?>

		<span class="avatar-img">
			<div class="login-status"></div>
			<?php echo wp_kses_post( $user_img ); ?>
		</span>
		<span class="fullname">
			<?php echo esc_html( $current_user->first_name ) . ' ' . esc_html( $current_user->last_name ); ?>
		</span>
		<span class="user-role">
			<?php
			if ( $current_user->roles[0] == 'administrator' ) {
				esc_html_e( 'Administrator', 'cariera' );
			} elseif ( $current_user->roles[0] == 'employer' ) {
				esc_html_e( 'Employer', 'cariera' );
			} elseif ( $current_user->roles[0] == 'candidate' ) {
				esc_html_e( 'Candidate', 'cariera' );
			} else {
				echo esc_html( $current_user->roles[0] );
			}
			?>
		</span>

	</div>

	<?php
}

add_action( 'cariera_dashboard_nav_inner_start', 'cariera_dashboard_profile', 10 );





/**
 * Dashboard Main Menu
 *
 * @since   1.3.4
 * @version 1.5.4
 */
function cariera_dashboard_main_menu() {
	global $post;

	$user = wp_get_current_user();

	// Pages for the Dashboard Main Menu.
	$dashboard_page      = apply_filters( 'cariera_dashboard_main_dashboard_page', get_option( 'cariera_dashboard_page' ) );
	$employer_dashboard  = apply_filters( 'cariera_dashboard_employer_dashboard_page', get_option( 'job_manager_job_dashboard_page_id' ) );
	$company_dashboard   = apply_filters( 'cariera_dashboard_company_dashboard_page', get_option( 'cariera_company_dashboard_page' ) );
	$candidate_dashboard = apply_filters( 'cariera_dashboard_candidate_dashboard_page', get_option( 'resume_manager_candidate_dashboard_page_id' ) );
	$job_alerts          = apply_filters( 'cariera_dashboard_job_alerts_page', get_option( 'job_manager_alerts_page_id' ) );
	$resume_alerts       = apply_filters( 'cariera_dashboard_resume_alerts_page', get_option( 'job_manager_resume_alerts_page_id' ) );
	$bookmarks           = apply_filters( 'cariera_dashboard_bookmarks_page', get_option( 'cariera_bookmarks_page' ) );
	$applied_jobs        = apply_filters( 'cariera_dashboard_past_applications_page', get_option( 'cariera_past_applications_page' ) );
	$listing_reports     = apply_filters( 'cariera_dashboard_listing_reports_page', get_option( 'cariera_listing_reports_page' ) );
	$user_packages       = apply_filters( 'cariera_dashboard_user_packages_page', get_option( 'cariera_user_packages_page' ) );

	if ( cariera_wc_is_activated() ) {
		$orders = wc_get_endpoint_url( 'orders', '', wc_get_page_permalink( 'myaccount' ) );
	}
	?>

	<ul class="dashboard-nav-main" data-submenu-title="<?php esc_html_e( 'Main', 'cariera' ); ?>">    

		<?php if ( cariera_get_option( 'cariera_dashboard_page_enable' ) ) { ?>
			<li class="dashboard-menu-item_dashboard <?php echo $post->ID == $dashboard_page ? esc_attr( 'active' ) : ''; ?>">
				<a href="<?php echo esc_url( get_permalink( $dashboard_page ) ); ?>">
					<i class="icon-settings"></i><?php esc_html_e( 'Dashboard', 'cariera' ); ?>
				</a>
			</li>
		<?php } ?>


		<?php
		// Employer Dashboard Link.
		if ( cariera_wp_job_manager_is_activated() ) {
			if ( in_array( 'employer', (array) $user->roles, true ) || in_array( 'administrator', (array) $user->roles, true ) ) {
				?>
				<li class="dashboard-menu-item_jobs <?php echo $post->ID == $employer_dashboard ? esc_attr( 'active' ) : ''; ?>">
					<a href="<?php echo esc_url( get_permalink( $employer_dashboard ) ); ?>">
						<i class="icon-briefcase"></i><?php esc_html_e( 'My Jobs', 'cariera' ); ?>
					</a>
				</li>
				<?php
			}
		}

		// Company Dashboard Link.
		if ( cariera_wp_job_manager_is_activated() && cariera_wp_company_manager_is_activated() ) {
			if ( in_array( 'employer', (array) $user->roles, true ) || in_array( 'administrator', (array) $user->roles, true ) ) {
				?>
				<li class="dashboard-menu-item_companies <?php echo $post->ID == $company_dashboard ? esc_attr( 'active' ) : ''; ?>">
					<a href="<?php echo esc_url( get_permalink( $company_dashboard ) ); ?>">
						<i class="far fa-building"></i><?php esc_html_e( 'My Companies', 'cariera' ); ?>
					</a>
				</li>
				<?php
			}
		}

		// Candidate Dashboard Link.
		if ( cariera_wp_job_manager_is_activated() && cariera_wp_resume_manager_is_activated() ) {
			if ( in_array( 'candidate', (array) $user->roles, true ) || in_array( 'administrator', (array) $user->roles, true ) ) {
				?>
				<li class="dashboard-menu-item_resumes <?php echo $post->ID == $candidate_dashboard ? esc_attr( 'active' ) : ''; ?>">
					<a href="<?php echo esc_url( get_permalink( $candidate_dashboard ) ); ?>">
						<i class="icon-layers"></i><?php esc_html_e( 'My Resumes', 'cariera' ); ?>
					</a>
				</li>
				<?php
			}
		}

		// Job Alerts Link.
		if ( cariera_wp_job_manager_is_activated() && class_exists( 'WP_Job_Manager_Alerts' ) ) {
			if ( in_array( 'candidate', (array) $user->roles, true ) || in_array( 'administrator', (array) $user->roles, true ) ) {
				if ( cariera_get_option( 'cariera_dashboard_job_alerts_page_enable' ) ) {
					?>
					<li class="dashboard-menu-item_job-alerts <?php echo $post->ID == $job_alerts ? esc_attr( 'active' ) : ''; ?>">
						<a href="<?php echo esc_url( get_permalink( $job_alerts ) ); ?>">
							<i class="icon-bell"></i><?php esc_html_e( 'Job Alerts', 'cariera' ); ?>
						</a>
					</li>
					<?php
				}
			}
		}

		// Resume Alerts Link.
		if ( cariera_wp_job_manager_is_activated() && class_exists( 'WP_Job_Manager_Resume_Alerts' ) ) {
			if ( in_array( 'employer', (array) $user->roles, true ) || in_array( 'administrator', (array) $user->roles, true ) ) {
				?>
				<li class="dashboard-menu-item_resume-alerts <?php echo $post->ID == $resume_alerts ? esc_attr( 'active' ) : ''; ?>">
					<a href="<?php echo esc_url( get_permalink( $resume_alerts ) ); ?>">
						<i class="icon-bell"></i><?php esc_html_e( 'Resume Alerts', 'cariera' ); ?>
					</a>
				</li>
				<?php
			}
		}

		// Bookmarks Link.
		if ( cariera_wp_job_manager_is_activated() && class_exists( 'WP_Job_Manager_Bookmarks' ) ) {
			if ( cariera_get_option( 'cariera_dashboard_bookmark_page_enable' ) ) {
				?>
				<li class="dashboard-menu-item_bookmarks <?php echo $post->ID == $bookmarks ? esc_attr( 'active' ) : ''; ?>">
					<a href="<?php echo esc_url( get_permalink( $bookmarks ) ); ?>">
						<i class="icon-heart"></i><?php esc_html_e( 'My Bookmarks', 'cariera' ); ?>
					</a>
				</li>
				<?php
			}
		}

		// Applied Jobs Link.
		if ( cariera_wp_job_manager_is_activated() && class_exists( 'WP_Job_Manager_Applications' ) ) {
			if ( in_array( 'candidate', (array) $user->roles, true ) || in_array( 'administrator', (array) $user->roles, true ) ) {
				if ( cariera_get_option( 'cariera_dashboard_applied_jobs_page_enable' ) ) {
					?>
					<li class="dashboard-menu-item_applied-jobs <?php echo $post->ID == $applied_jobs ? esc_attr( 'active' ) : ''; ?>">
						<a href="<?php echo esc_url( get_permalink( $applied_jobs ) ); ?>">
							<i class="icon-pencil"></i><?php esc_html_e( 'Applied Jobs', 'cariera' ); ?>
						</a>
					</li>
					<?php
				}
			}
		}

		// Reports.
		if ( cariera_wp_job_manager_is_activated() && cariera_get_option( 'cariera_dashboard_listing_reports_page_enable' ) ) {
			?>
			<li class="dashboard-menu-item_listing-reports <?php echo $post->ID == $listing_reports ? esc_attr( 'active' ) : ''; ?>">
				<a href="<?php echo esc_url( get_permalink( $listing_reports ) ); ?>">
					<i class="icon-chart"></i><?php esc_html_e( 'Listing Reports', 'cariera' ); ?>
				</a>
			</li>
			<?php
		}

		// User Packages.
		if ( cariera_wp_job_manager_is_activated() && class_exists( 'WC_Paid_Listings' ) && cariera_get_option( 'cariera_dashboard_user_packages_page_enable' ) ) {
			?>
			<li class="dashboard-menu-item_user-packages <?php echo $post->ID == $user_packages ? esc_attr( 'active' ) : ''; ?>">
				<a href="<?php echo esc_url( get_permalink( $user_packages ) ); ?>">
					<i class="icon-social-dropbox"></i><?php esc_html_e( 'Packages', 'cariera' ); ?>
				</a>
			</li>
			<?php
		}

		// Orders Link.
		if ( cariera_wc_is_activated() && cariera_get_option( 'cariera_dashboard_orders_page_enable' ) ) {
			?>
			<li class="dashboard-menu-item_orders <?php echo is_wc_endpoint_url( 'orders' ) ? esc_attr( 'active' ) : ''; ?>">
				<a href="<?php echo esc_url( $orders ); ?>">
					<i class="icon-credit-card"></i><?php esc_html_e( 'Orders', 'cariera' ); ?>
				</a>
			</li>
		<?php } ?>

		<?php do_action( 'cariera_dashboard_main_nav_end' ); ?>
	</ul>


	<?php
	// Extra Dashboard Menu for Employers.
	if ( in_array( 'employer', (array) $user->roles, true ) ) {
		wp_nav_menu(
			[
				'theme_location' => 'employer-dash',
				'container'      => false,
				'menu_class'     => 'dashboard-nav-employer-extra',
				'walker'         => new Cariera_Mega_Menu_Walker(),
				'fallback_cb'    => '__return_false',
			]
		);
	}

	// Extra Dashboard Menu for Candidates.
	if ( in_array( 'candidate', (array) $user->roles, true ) ) {
		wp_nav_menu(
			[
				'theme_location' => 'candidate-dash',
				'container'      => false,
				'menu_class'     => 'dashboard-nav-candidate-extra',
				'walker'         => new Cariera_Mega_Menu_Walker(),
				'fallback_cb'    => '__return_false',
			]
		);
	}
}

add_action( 'cariera_dashboard_menu', 'cariera_dashboard_main_menu', 10 );





/**
 * Dashboard Listing Menu
 *
 * @since  	1.3.4
 * @version 1.6.2
 */
function cariera_dashboard_listing_menu() {
	global $post;

	$user = wp_get_current_user();

	// Pages for the Dashboard Listing Menu.
	$post_job     = apply_filters( 'cariera_dashboard_job_submit_page', get_option( 'job_manager_submit_job_form_page_id' ) );
	$post_company = apply_filters( 'cariera_dashboard_company_submit_page', get_option( 'cariera_submit_company_page' ) );
	$post_resume  = apply_filters( 'cariera_dashboard_resume_submit_page', get_option( 'resume_manager_submit_resume_form_page_id' ) );
	?>

	<ul class="dashboard-nav-listing" data-submenu-title="<?php esc_html_e( 'Listing', 'cariera' ); ?>">

		<?php
		// Post Job Link.
		if ( cariera_wp_job_manager_is_activated() && cariera_get_option( 'cariera_dashboard_job_submission_page_enable' ) ) {
			if ( in_array( 'employer', (array) $user->roles, true ) || in_array( 'administrator', (array) $user->roles, true ) ) {
				?>
				<li class="dashboard-menu-item_post-job <?php echo $post->ID == $post_job ? esc_attr( 'active' ) : ''; ?>">
					<a href="<?php echo esc_url( get_permalink( $post_job ) ); ?>">
						<i class="icon-plus"></i><?php esc_html_e( 'Post Job', 'cariera' ); ?>
					</a>
				</li>
				<?php
			}
		}

		// Submit Company Link.
		if ( cariera_wp_job_manager_is_activated() && cariera_wp_company_manager_is_activated() && cariera_get_option( 'cariera_dashboard_company_submission_page_enable' ) ) {
			if ( in_array( 'employer', (array) $user->roles, true ) || in_array( 'administrator', (array) $user->roles, true ) ) {
				?>
				<li class="dashboard-menu-item_submit-company <?php echo $post->ID == $post_company ? esc_attr( 'active' ) : ''; ?>">
					<a href="<?php echo esc_url( get_permalink( $post_company ) ); ?>">
						<i class="icon-plus"></i><?php esc_html_e( 'Submit Company', 'cariera' ); ?>
					</a>
				</li>
				<?php
			}
		}

		// Submit Resume Link.
		if ( cariera_wp_job_manager_is_activated() && cariera_wp_resume_manager_is_activated() && cariera_get_option( 'cariera_dashboard_resume_submission_page_enable' ) ) {
			if ( in_array( 'candidate', (array) $user->roles, true ) || in_array( 'administrator', (array) $user->roles, true ) ) {
				?>
				<li class="dashboard-menu-item_submit-resume <?php echo $post->ID == $post_resume ? esc_attr( 'active' ) : ''; ?>">
					<a href="<?php echo esc_url( get_permalink( $post_resume ) ); ?>">
						<i class="icon-plus"></i><?php esc_html_e( 'Submit Resume', 'cariera' ); ?>
					</a>
				</li>
				<?php
			}
		}

		do_action( 'cariera_dashboard_listing_nav_end' );
		?>
	</ul>

	<?php
}

add_action( 'cariera_dashboard_menu', 'cariera_dashboard_listing_menu', 11 );





/**
 * Dashboard Account Menu
 *
 * @since  1.3.4
 */
function cariera_dashboard_account_menu() {
	global $post;

	// Pages for the Dashboard Listing Menu.
	$profile = apply_filters( 'cariera_dashboard_user_profile_page', get_option( 'cariera_dashboard_profile_page' ) );
	?>

	<ul class="dashboard-nav-account" data-submenu-title="<?php esc_html_e( 'Account', 'cariera' ); ?>">
		<?php if ( cariera_get_option( 'cariera_dashboard_profile_page_enable' ) ) { ?>
			<li class="dashboard-menu-item_my-profile <?php echo $post->ID == $profile ? esc_attr( 'active' ) : ''; ?>">
				<a href="<?php echo esc_url( get_permalink( $profile ) ); ?>">
					<i class="icon-user"></i><?php esc_html_e( 'My Profile', 'cariera' ); ?>
				</a>
			</li>
		<?php } ?>

		<li>
			<a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>"><i class="icon-power"></i><?php esc_html_e( 'Logout', 'cariera' ); ?></a>
		</li>
	</ul>

	<?php
}

add_action( 'cariera_dashboard_menu', 'cariera_dashboard_account_menu', 12 );





/**
 * Dashboard Title Bar
 *
 * @since  1.3.4
 */
function cariera_dashboard_titlebar() {
	global $post;
	$current_user = wp_get_current_user();

	if ( ! empty( $current_user->user_firstname ) ) {
		$name = $current_user->user_firstname;
	} else {
		$name = $current_user->display_name;
	}
	?>
	<div class="title-bar">
		<div class="row">
			<div class="col-md-12">
				<?php
				$dashboard_page = cariera_get_option( 'cariera_dashboard_page' );

				if ( $dashboard_page == $post->ID ) {
					?>
					<h2><?php printf( esc_html__( 'Welcome, %s!', 'cariera' ), esc_html( $name ) ); ?></h2>
				<?php } else { ?>
					<h1><?php the_title(); ?></h1>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php
}

add_action( 'cariera_dashboard_content_start', 'cariera_dashboard_titlebar', 10 );





/**
 * Dashboard Copyright Footer
 *
 * @since  1.3.4
 */
function cariera_dashboard_copyright() {
	?>
	<!-- Copyrights -->
	<div class="row">
		<div class="col-md-12">
			<div class="copyrights">
				<?php
				$copyright = cariera_get_option( 'cariera_copyrights' );
				echo wp_kses_post( $copyright );
				?>
			</div>
		</div>
	</div>
	<?php
}

add_action( 'cariera_dashboard_content_end', 'cariera_dashboard_copyright', 10 );





/**
 * Remove WooCommerce Nav on User Dashboard Template
 *
 * @since  1.3.5
 */
function cariera_remove_wc_nav_on_dash() {
	if ( is_page_template( 'templates/user-dashboard.php' ) ) {
		remove_action( 'woocommerce_account_navigation', 'woocommerce_account_navigation' );
	}
}

add_action( 'wp', 'cariera_remove_wc_nav_on_dash' );
