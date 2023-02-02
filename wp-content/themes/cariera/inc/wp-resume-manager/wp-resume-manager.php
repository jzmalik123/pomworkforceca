<?php
/**
 *
 * @package Cariera
 *
 * @since    1.3.0
 * @version  1.6.0
 *
 * ========================
 * ALL WP RESUME MANAGER FUNCTIONS
 * ========================
 **/

/**
 * Candidate Socials
 *
 * @since  1.3.1
 */

// Facebook.
if ( ! function_exists( 'cariera_get_the_candidate_fb' ) ) {
	function cariera_get_the_candidate_fb( $post = null ) {
		$post = get_post( $post );
		if ( 'resume' !== $post->post_type ) {
			return;
		}

		if ( $post->_facebook && ! strstr( $post->_facebook, 'http:' ) && ! strstr( $post->_facebook, 'https:' ) ) {
			$post->_facebook = 'https://' . $post->_facebook;
		}

		return apply_filters( 'cariera_candidate_fb_output', $post->_facebook, $post );
	}
}

if ( ! function_exists( 'cariera_candidate_fb_output' ) ) {
	function cariera_candidate_fb_output( $post = null ) {
		if ( ! empty( cariera_get_the_candidate_fb( $post ) ) ) {
			echo '<a href="' . esc_url( cariera_get_the_candidate_fb( $post ) ) . '" class="candidate-facebook"><i class="fab fa-facebook-f"></i></a>';
		}
	}
}

// Twitter.
if ( ! function_exists( 'cariera_get_the_candidate_twitter' ) ) {
	function cariera_get_the_candidate_twitter( $post = null ) {
		$post = get_post( $post );
		if ( 'resume' !== $post->post_type ) {
			return;
		}

		if ( $post->_twitter && ! strstr( $post->_twitter, 'http:' ) && ! strstr( $post->_twitter, 'https:' ) ) {
			$post->_twitter = 'https://' . $post->_twitter;
		}

		return apply_filters( 'cariera_candidate_twitter_output', $post->_twitter, $post );
	}
}

if ( ! function_exists( 'cariera_candidate_twitter_output' ) ) {
	function cariera_candidate_twitter_output( $post = null ) {
		if ( ! empty( cariera_get_the_candidate_twitter( $post ) ) ) {
			echo '<a href="' . esc_url( cariera_get_the_candidate_twitter( $post ) ) . '" class="candidate-twitter"><i class="fab fa-twitter"></i></a>';
		}
	}
}

// LinkedIn.
if ( ! function_exists( 'cariera_get_the_candidate_linkedin' ) ) {
	function cariera_get_the_candidate_linkedin( $post = null ) {
		$post = get_post( $post );
		if ( 'resume' !== $post->post_type ) {
			return;
		}

		if ( $post->_linkedin && ! strstr( $post->_linkedin, 'http:' ) && ! strstr( $post->_linkedin, 'https:' ) ) {
			$post->_linkedin = 'https://' . $post->_linkedin;
		}

		return apply_filters( 'cariera_candidate_linkedin_output', $post->_linkedin, $post );
	}
}

if ( ! function_exists( 'cariera_candidate_linkedin_output' ) ) {
	function cariera_candidate_linkedin_output( $post = null ) {
		if ( ! empty( cariera_get_the_candidate_linkedin( $post ) ) ) {
			echo '<a href="' . esc_url( cariera_get_the_candidate_linkedin( $post ) ) . '" class="candidate-linkedin"><i class="fab fa-linkedin-in"></i></a>';
		}
	}
}

// Instagram.
if ( ! function_exists( 'cariera_get_the_candidate_instagram' ) ) {
	function cariera_get_the_candidate_instagram( $post = null ) {
		$post = get_post( $post );
		if ( 'resume' !== $post->post_type ) {
			return;
		}

		if ( $post->_instagram && ! strstr( $post->_instagram, 'http:' ) && ! strstr( $post->_instagram, 'https:' ) ) {
			$post->_instagram = 'https://' . $post->_instagram;
		}

		return apply_filters( 'cariera_candidate_instagram_output', $post->_instagram, $post );
	}
}

if ( ! function_exists( 'cariera_candidate_instagram_output' ) ) {
	function cariera_candidate_instagram_output( $post = null ) {
		if ( ! empty( cariera_get_the_candidate_instagram( $post ) ) ) {
			echo '<a href="' . esc_url( cariera_get_the_candidate_instagram( $post ) ) . '" class="candidate-instagram"><i class="fab fa-instagram"></i></a>';
		}
	}
}

// Youtube.
if ( ! function_exists( 'cariera_get_the_candidate_youtube' ) ) {
	function cariera_get_the_candidate_youtube( $post = null ) {
		$post = get_post( $post );
		if ( 'resume' !== $post->post_type ) {
			return;
		}

		if ( $post->_youtube && ! strstr( $post->_youtube, 'http:' ) && ! strstr( $post->_youtube, 'https:' ) ) {
			$post->_youtube = 'https://' . $post->_youtube;
		}

		return apply_filters( 'cariera_candidate_youtube_output', $post->_youtube, $post );
	}
}

if ( ! function_exists( 'cariera_candidate_youtube_output' ) ) {
	function cariera_candidate_youtube_output( $post = null ) {
		if ( ! empty( cariera_get_the_candidate_youtube( $post ) ) ) {
			echo '<a href="' . esc_url( cariera_get_the_candidate_youtube( $post ) ) . '" class="candidate-youtube"><i class="fab fa-youtube"></i></a>';
		}
	}
}





/*
 * Output the resume's rate if there is any
 *
 * @since 1.4.1
 */
function cariera_resume_rate() {
	global $post;

	$currency_position = get_option( 'cariera_currency_position', 'before' );
	$rate              = get_post_meta( $post->ID, '_rate', true );

	if ( ! empty( $rate ) ) {
		// Currency Symbol Before.
		if ( 'before' === $currency_position ) {
			echo cariera_currency_symbol();
		}
		echo esc_html( $rate );
		// Currency Symbol After.
		if ( 'after' === $currency_position ) {
			echo cariera_currency_symbol();
		}
		esc_html_e( '/hour', 'cariera' );
	}
}





/**
 * Hide Contact button for resume author
 *
 * @since   1.4.7
 * @version 1.4.8
 */
function cariera_hide_contact_button_for_resume_author( $can_view, $resume_id ) {
	$contact = get_option( 'cariera_resume_manager_contact_owner' );
	$resume  = get_post( $resume_id );

	if ( $resume && isset( $resume->post_author ) && ! empty( $resume->post_author ) && $contact ) {
		if ( $resume->post_author == get_current_user_id() ) {
			return false;
		}
	}

	return $can_view;
}

add_filter( 'resume_manager_user_can_view_contact_details', 'cariera_hide_contact_button_for_resume_author', 10, 2 );



/**
 * Outputting a resume listing in the map
 *
 * @since   1.5.5
 * @version 1.6.0
 */
function cariera_resume_map() {
	global $post;

	$resume_map = cariera_get_option( 'cariera_resume_map' );
	$lng        = $post->geolocation_long;
	$logo       = get_the_candidate_photo();

	if ( ! $resume_map || empty( $lng ) ) {
		return;
	}

	if ( ! empty( $logo ) ) {
		$logo_img = $logo;
	} else {
		$logo_img = apply_filters( 'resume_manager_default_candidate_photo', get_template_directory_uri() . '/assets/images/candidate.png' );
	}

	echo '<div id="resume-map" data-longitude="' . esc_attr( $post->geolocation_long ) . '" data-latitude="' . esc_attr( $post->geolocation_lat ) . '" data-thumbnail="' . esc_attr( $logo_img ) . '" data-id="listing-id-' . get_the_ID() . '"></div>';
}



/**
 * Returning the single resume layout option
 *
 * @since   1.5.5
 * @version 1.5.5
 */
function cariera_single_resume_layout() {
	$layout = apply_filters( 'cariera_resume_manager_single_resume_layout', get_option( 'cariera_resume_manager_single_resume_layout' ) );

	if ( empty( $layout ) ) {
		$layout = 'v1';
	}

	return $layout;
}
