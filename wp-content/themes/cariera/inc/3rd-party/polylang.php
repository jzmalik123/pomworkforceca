<?php
/**
 *
 * @package Cariera
 *
 * @since    1.6.3
 * @version  1.6.4
 *
 * ========================
 * 3RD PARTY - POLYLANG COMPATIBILITY
 * ========================
 **/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Cariera_Polylang {

	private static $instance = null;

	/**
	 * Allows for accessing single instance of class. Class should only be constructed once per call.
	 *
	 * @since  1.6.3
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
	 * @since  	1.6.3
	 * @version 1.6.4
	 */
	public function __construct() {

		// Dashboard Pages.
		add_filter( 'cariera_dashboard_main_dashboard_page', [ $this, 'polylang_page_id' ] );
		add_filter( 'cariera_dashboard_employer_dashboard_page', [ $this, 'polylang_page_id' ] );
		add_filter( 'cariera_dashboard_company_dashboard_page', [ $this, 'polylang_page_id' ] );
		add_filter( 'cariera_dashboard_candidate_dashboard_page', [ $this, 'polylang_page_id' ] );
		add_filter( 'cariera_dashboard_job_alerts_page', [ $this, 'polylang_page_id' ] );
		add_filter( 'cariera_dashboard_resume_alerts_page', [ $this, 'polylang_page_id' ] );
		add_filter( 'cariera_dashboard_bookmarks_page', [ $this, 'polylang_page_id' ] );
		add_filter( 'cariera_dashboard_past_applications_page', [ $this, 'polylang_page_id' ] );
		add_filter( 'cariera_dashboard_listing_reports_page', [ $this, 'polylang_page_id' ] );
		add_filter( 'cariera_dashboard_user_packages_page', [ $this, 'polylang_page_id' ] );
		add_filter( 'cariera_dashboard_job_submit_page', [ $this, 'polylang_page_id' ] );
		add_filter( 'cariera_dashboard_company_submit_page', [ $this, 'polylang_page_id' ] );
		add_filter( 'cariera_dashboard_resume_submit_page', [ $this, 'polylang_page_id' ] );
		add_filter( 'cariera_dashboard_user_profile_page', [ $this, 'polylang_page_id' ] );

		// Edit single listing button page ids.
		add_filter( 'cariera_edit_single_resume_dashboard_id', [ $this, 'polylang_page_id' ] );
		add_filter( 'cariera_edit_single_company_dashboard_id', [ $this, 'polylang_page_id' ] );
		add_filter( 'cariera_edit_single_job_listing_dashboard_id', [ $this, 'polylang_page_id' ] );

		// User Menu items.
		add_filter( 'cariera_user_menu_dashboard_page_id', [ $this, 'polylang_page_id' ] );
		add_filter( 'cariera_user_menu_employer_dashboard_page_id', [ $this, 'polylang_page_id' ] );
		add_filter( 'cariera_user_menu_company_dashboard_page_id', [ $this, 'polylang_page_id' ] );
		add_filter( 'cariera_user_menu_candidate_dashboard_page_id', [ $this, 'polylang_page_id' ] );
		add_filter( 'cariera_user_menu_user_packages_page_id', [ $this, 'polylang_page_id' ] );
		add_filter( 'cariera_user_menu_profile_dashboard_page_id', [ $this, 'polylang_page_id' ] );

		// Header CTA.
		add_filter( 'cariera_header_job_link', [ $this, 'polylang_page_id' ] );
		add_filter( 'cariera_header_resume_link', [ $this, 'polylang_page_id' ] );

		// Extras.
		add_filter( 'cariera_login_register_page', [ $this, 'polylang_page_id' ] );
		add_filter( 'cariera_register_privacy_policy_page', [ $this, 'polylang_page_id' ] );
		add_filter( 'cariera_login_redirection', [ $this, 'polylang_page_id' ] );
		add_filter( 'cariera_login_redirection_candidate', [ $this, 'polylang_page_id' ] );
		add_filter( 'cariera_login_redirection_page', [ $this, 'polylang_page_id' ] );
		add_filter( 'cariera_login_candi_redirection_page', [ $this, 'polylang_page_id' ] );
		add_filter( 'cariera_dashboard_page', [ $this, 'polylang_page_id' ] );
	}

	/**
	 * Post translate function.
	 *
	 * @since  1.6.3
	 */
	public function polylang_page_id( $page_id ) {
		if ( function_exists( 'pll_get_post' ) ) {
			$page_id = pll_get_post( $page_id );
		}

		return absint( $page_id );
	}

}

Cariera_Polylang::instance();
