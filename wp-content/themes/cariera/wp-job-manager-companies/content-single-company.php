<?php
/**
 *
 * @package Cariera
 *
 * @since 	1.3.0
 * @version	1.5.5
 *
 * ========================
 * TEMPLATE FOR SINGLE COMPANY POST
 * ========================
 **/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;

$layout = cariera_single_company_layout();


if ( cariera_user_can_view_company( $post->ID ) ) {
	get_job_manager_template_part( 'single-company/single', 'company-'. $layout, 'wp-job-manager-companies' );
} else {
	get_job_manager_template_part( 'access-denied', 'single-company', 'wp-job-manager-companies' );
}
