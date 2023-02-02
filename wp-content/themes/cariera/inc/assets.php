<?php
/**
 *
 * @package Cariera
 *
 * @since    1.5.2
 * @version  1.5.2
 *
 * ========================
 * THEME ASSETS
 * ========================
 **/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



class Cariera_Assets {

	/**
	 * The single instance of Cariera_Setup.
	 *
	 * @since 1.5.2
	 */
	private static $instance = null;


	/**
	 * Allows for accessing single instance of class. Class should only be constructed once per call.
	 *
	 * @since  1.5.2
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}





	/**
	 * Constructor function.
	 *
	 * @since 1.5.2
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'frontend_enqueue' ] );
		add_action( 'comment_form_before', [ $this, 'enqueue_comments_reply' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_assets' ] );
	}





	/**
	 * Enqueue Frontend scripts and styles
	 *
	 * @since 1.5.2
	 */
	public function frontend_enqueue() {
		$this->enqueue_scripts();
		$this->enqueue_styles();
	}





	/**
	 * Frontend scripts
	 *
	 * @since 1.5.2
	 */
	public function enqueue_scripts() {
		// Vendors.
		wp_enqueue_script( 'imagesloaded' );
		wp_enqueue_script( 'select2', get_template_directory_uri() . '/assets/vendors/select2/select2.min.js', [ 'jquery' ], false, true );

		// Main Theme JS File.
		wp_enqueue_script( 'cariera-main', get_template_directory_uri() . '/assets/dist/js/frontend.js', [ 'jquery' ], CARIERA_VERSION, true );
		wp_register_script( 'cariera-dashboard', get_template_directory_uri() . '/assets/dist/js/dashboard.js', [ 'jquery' ], CARIERA_VERSION, true );

		$ajax_url = admin_url( 'admin-ajax.php', 'relative' );

		$translations = [
			'ajax_url'              => esc_url( $ajax_url ),
			'nonce'                 => wp_create_nonce( '_cariera_nonce' ),
			'theme_url'             => get_template_directory_uri(),
			'ajax_job_search'       => intval( cariera_get_option( 'cariera_job_ajax_search' ) ),
			'cookie_notice'         => intval( cariera_get_option( 'cariera_cookie_notice' ) ),
			'gdpr_check'            => intval( cariera_get_option( 'cariera_register_gdpr' ) ),
			'delete_account_text'   => esc_html__( 'Are you sure you want to delete your account?', 'cariera' ),
			'views_chart_label'     => esc_html__( 'Views', 'cariera' ),
			'views_statistics'      => intval( cariera_get_option( 'cariera_dashboard_views_statistics' ) ),
			'statistics_border'     => cariera_get_option( 'cariera_dashboard_statistics_border' ),
			'statistics_background' => cariera_get_option( 'cariera_dashboard_statistics_background' ),
			'mmenu_text'            => esc_html__( 'Main Menu', 'cariera' ),
			'company_data_loading'  => esc_html__( 'Data Loading', 'cariera' ),
			'company_data_loaded'   => esc_html__( 'Company Data Loaded', 'cariera' ),
			'map_provider'          => cariera_get_option( 'cariera_map_provider' ),
			'gmap_api_key'          => cariera_get_option( 'cariera_gmap_api_key' ),
		];

		wp_localize_script( 'cariera-main', 'cariera_settings', $translations );
	}





	/**
	 * Frontend styles
	 *
	 * @since 1.5.2
	 */
	public function enqueue_styles() {
		// Vendors.
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/vendors/bootstrap/bootstrap.min.css' );
		wp_enqueue_style( 'cariera-select2', get_template_directory_uri() . '/assets/vendors/select2/select2.min.css' );

		// Icons.
		wp_enqueue_style( 'font-awesome-5', get_template_directory_uri() . '/assets/vendors/font-icons/all.min.css' );
		wp_enqueue_style( 'simple-line-icons', get_template_directory_uri() . '/assets/vendors/font-icons/simple-line-icons.min.css' );
		if ( get_option( 'cariera_font_iconsmind' ) ) {
			wp_enqueue_style( 'iconsmind', get_template_directory_uri() . '/assets/vendors/font-icons/iconsmind.min.css' );
		}

		// Main Styles.
		wp_enqueue_style( 'cariera-style', get_template_directory_uri() . '/style.css', [], CARIERA_VERSION );
		wp_enqueue_style( 'cariera-frontend', get_template_directory_uri() . '/assets/dist/css/frontend.css', [], CARIERA_VERSION );
		wp_add_inline_style( 'cariera-frontend', $this->dynamic_styles() );
	}





	/**
	 * Comment reply script
	 *
	 * @since 1.5.2
	 */
	public function enqueue_comments_reply() {
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}





	/**
	 * Admin enqueue assets
	 *
	 * @since 1.5.2
	 */
	public function admin_assets( $hook ) {

		if ( $hook == 'edit-tags.php' || $hook == 'term.php' || $hook == 'post.php' ) {
			wp_enqueue_style( 'font-icon-picker', get_template_directory_uri() . '/assets/vendors/fonticon-picker/fonticonpicker.css' );
			wp_enqueue_script( 'font-icon-picker', get_template_directory_uri() . '/assets/vendors/fonticon-picker/jquery.fonticonpicker.js', [ 'jquery' ], false, true );

			wp_enqueue_style( 'font-awesome-5', get_template_directory_uri() . '/assets/vendors/font-icons/all.min.css' );
			wp_enqueue_style( 'simple-line-icons', get_template_directory_uri() . '/assets/vendors/font-icons/simple-line-icons.min.css' );
			if ( get_option( 'cariera_font_iconsmind' ) ) {
				wp_enqueue_style( 'iconsmind', get_template_directory_uri() . '/assets/vendors/font-icons/iconsmind.min.css' );
			}
		}

		wp_enqueue_script( 'cariera-admin', get_template_directory_uri() . '/assets/dist/js/admin.js', [ 'jquery' ], CARIERA_VERSION, true );
	}





	/**
	 * Dynamic CSS styles
	 *
	 * @since 1.5.2
	 */
	public function dynamic_styles() {
		$maincolor   = cariera_get_option( 'cariera_main_color' );
		$secondcolor = cariera_get_option( 'cariera_secondary_color' ); ?>

		<style type="text/css">
			:root {
				--cariera-primary: <?php echo esc_attr( $maincolor ); ?>;
				--cariera-secondary: <?php echo esc_attr( $secondcolor ); ?>;
				--cariera-body-bg: <?php echo esc_attr( cariera_get_option( 'cariera_body_color' ) ); ?>;
				--cariera-body-wrapper: <?php echo esc_attr( cariera_get_option( 'cariera_wrapper_color' ) ); ?>;
				--cariera-header-bg: <?php echo esc_attr( cariera_get_option( 'cariera_navbar_bg' ) ); ?>;
				--cariera-menu-hover: <?php echo esc_attr( cariera_get_option( 'cariera_menu_hover_color' ) ); ?>;
				--cariera-footer-bg: <?php echo esc_attr( cariera_get_option( 'cariera_footer_bg' ) ); ?>;
				--cariera-footer-title: <?php echo esc_attr( cariera_get_option( 'cariera_footer_title_color' ) ); ?>;
				--cariera-footer-color: <?php echo esc_attr( cariera_get_option( 'cariera_footer_text_color' ) ); ?>;
			}
			<?php

			// Logo.
			$logo_size_width = intval( cariera_get_option( 'logo_width' ) );
			$logo_css        = $logo_size_width ? 'width:' . $logo_size_width . 'px; ' : '';

			$logo_size_height = intval( cariera_get_option( 'logo_height' ) );
			$logo_css        .= $logo_size_height ? 'height:' . $logo_size_height . 'px; ' : '';

			$logo_margin = cariera_get_option( 'logo_margins' );
			$logo_css   .= $logo_margin['top'] ? 'margin-top:' . $logo_margin['top'] . ' !important; ' : '';
			$logo_css   .= $logo_margin['right'] ? 'margin-right:' . $logo_margin['right'] . ' !important; ' : '';
			$logo_css   .= $logo_margin['bottom'] ? 'margin-bottom:' . $logo_margin['bottom'] . ' !important; ' : '';
			$logo_css   .= $logo_margin['left'] ? 'margin-left:' . $logo_margin['left'] . ' !important; ' : '';

			if ( ! empty( $logo_css ) ) {
				?>
				header .navbar-brand img {<?php echo esc_html( $logo_css ); ?>}
				<?php
			}

			// Home Page Background Image.
			$home_image  = cariera_get_option( 'home_page_image' );
			$home2_image = cariera_get_option( 'home_page2_image' );

			if ( ! empty( $home_image ) ) {
				echo 'section.home-search { background-image: url("' . esc_url( $home_image ) . '"); }';
			}

			if ( ! empty( $home2_image ) ) {
				echo 'section.home-search2 { background-image: url("' . esc_url( $home2_image ) . '"); }';
			}

			// Body boxed style.
			if ( cariera_get_option( 'cariera_body_style' ) === 'boxed' ) {
				$body_bg = cariera_get_option( 'cariera_body_bg' );

				if ( ! empty( $body_bg ) ) {
					$bg_horizontal  = cariera_get_option( 'cariera_body_bg_horizontal' );
					$bg_vertical    = cariera_get_option( 'cariera_body_bg_vertical' );
					$bg_repeats     = cariera_get_option( 'cariera_body_bg_repeats' );
					$bg_attachments = cariera_get_option( 'cariera_body_bg_attachments' );
					$bg_size        = cariera_get_option( 'cariera_body_bg_size' );

					echo 'body {
                        background-image: url(' . $body_bg . '); 
                        background-position:' . $bg_horizontal . ' ' . $bg_vertical . ';
                        background-repeat:' . $bg_repeats . ';
                        background-attachment:' . $bg_attachments . ';
                        background-size:' . $bg_size . ';
                    }';
				}
			}

			/* JOB & RESUME */
			if ( cariera_get_option( 'cariera_job_auto_location' ) == false ) {
				echo '.geolocation { 
                    display: none !important;
                }';
			}

			// Radius Scale.
			if ( cariera_get_option( 'cariera_search_radius' ) ) {
				$radius_scale = cariera_get_option( 'cariera_radius_unit' );
				echo ".range-output:after {
                    content: '$radius_scale';
                }";
			}
			?>
		</style>
		<?php
	}

}

Cariera_Assets::instance();
