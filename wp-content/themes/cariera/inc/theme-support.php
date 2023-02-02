<?php
/**
 *
 * @package Cariera
 *
 * @since   1.0.0
 * @version 1.5.4
 *
 * ========================
 * THEME SUPPORT OPTIONS
 * ========================
 **/

/**
 * Main menu fallback function when no menu exists
 *
 * @since  1.0.0
 */
function cariera_menu_fallback() {
	if ( current_user_can( 'administrator' ) ) {
		echo( '
        <ul id="menu-main-menu" class="main-menu main-nav">
        <li class="menu-item"><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Add a menu', 'cariera' ) . '</a></li>
        </ul>' );
	} else {
		echo( '
        <ul id="menu-main-menu" class="main-menu main-nav">
        <li class="menu-item"></li>
        </ul>' );
	}
}



/*
=====================================================
	PAGING NAVIGATION
=====================================================
*/

/**
 * Navigation function for pagination.
 *
 * @since  1.0.0
 */
if ( ! function_exists( 'cariera_paging_nav' ) ) {
	function cariera_paging_nav() {

		$pagination = cariera_get_option( 'cariera_blog_pagination' );

		if ( 'numeric' === $pagination ) {
			cariera_numeric_pagination();
		} else {
			cariera_posts_navigation(
				[
					'prev_text' => ' ',
					'next_text' => ' ',
				]
			);
		}
	}
}



/**
 * Plain Pagination
 *
 * @since  1.0.0
 */
if ( ! function_exists( 'cariera_posts_navigation' ) ) {
	// Display navigation to next/previous set of posts when applicable.
	function cariera_posts_navigation() {
		require_once get_template_directory() . '/templates/extra/pagination.php';
	}
}



/**
 * Numeric Pagination
 *
 * @since  1.2.7
 */
if ( ! function_exists( 'cariera_numeric_pagination' ) ) {
	function cariera_numeric_pagination() {
		global $wp_query;

		if ( $wp_query->max_num_pages < 2 ) {
			return;
		} ?>

		<div class="col-md-12 pagination">
			<?php
			$big  = 999999999;
			$args = [
				'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'total'     => $wp_query->max_num_pages,
				'current'   => max( 1, get_query_var( 'paged' ) ),
				'prev_text' => esc_html__( 'Previous', 'cariera' ),
				'next_text' => esc_html__( 'Next', 'cariera' ),
				'type'      => 'list',
			];

			echo paginate_links( $args );
			?>
		</div>
		<?php
	}
}



/*
=====================================================
	BLOG POST THUMBNAIL
=====================================================
*/

/**
 * Post Thumbnail
 *
 * @since   1.3.3
 * @version 1.5.4
 */
if ( ! function_exists( 'cariera_post_thumb' ) ) {
	function cariera_post_thumb( $args = [] ) {
		global $post;

		$defaults = [
			'size'  => 'large',
			'class' => 'post-image',
		];

		$args        = wp_parse_args( $args, $defaults );
		$post_format = get_post_format();

		// Standard or Image Post.
		if ( false === $post_format || 'standard' === $post_format || 'image' === $post_format ) {
			if ( has_post_thumbnail() ) {
				?>
				<div class="blog-thumbnail mb40">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<?php the_post_thumbnail(); ?>
					</a>
				</div>
				<?php
			}
		}

		// Gallery Post.
		if ( 'gallery' === $post_format ) {
			$images = get_post_meta( $post->ID, 'cariera_blog_gallery', true );

			if ( ! empty( $images ) ) {
				?>
				<div class="gallery-post-wrapper">
					<div class="gallery-post mb40">
						<?php
						foreach ( $images as $image ) {
							echo '<div class="item"><img src="' . esc_url( $image ) . '"/></div>';
						}
						?>
					</div>
				</div>
				<?php
			}
		}

		// Video Post.
		if ( 'video' === $post_format ) {
			$video = get_post_meta( $post->ID, 'cariera_blog_video_embed', true );
			if ( ! empty( $video ) ) {
				?>
				<div class="embed-responsive embed-responsive-16by9 mb40">
					<?php
					if ( wp_oembed_get( $video ) ) {
						echo wp_oembed_get( $video );
					} else {
						$allowed_tags = wp_kses_allowed_html( 'post' );
						echo wp_kses( $video, $allowed_tags );
					}
					?>
				</div>
				<?php
			}
		}

		// Audio Post.
		if ( 'audio' === $post_format ) {
			$audio = get_post_meta( $post->ID, 'cariera_blog_audio', true );
			if ( ! empty( $audio ) ) {
				?>
				<div class="audio-wrapper mb40">
					<?php
					if ( wp_oembed_get( $audio ) ) {
						echo wp_oembed_get( $audio );
					} else {
						$allowed_tags = wp_kses_allowed_html( 'post' );
						echo wp_kses( $audio, $allowed_tags );
					}
					?>
				</div>
				<?php
			}
		}

	}
}



/**
 * Single Post Thumbnail
 *
 * @since   1.3.3
 * @version 1.5.3
 */
if ( ! function_exists( 'cariera_single_post_thumb' ) ) {
	function cariera_single_post_thumb() {
		global $post;

		$post_format = get_post_format();

		// Standard or Image Post.
		if ( false === $post_format || 'image' === $post_format ) {
			if ( has_post_thumbnail() ) {
				?>
				<div class="blog-thumbnail">
					<?php the_post_thumbnail(); ?>
				</div>
				<?php
			}
		}

		// Gallery Post.
		if ( 'gallery' === $post_format ) {
			$images = get_post_meta( $post->ID, 'cariera_blog_gallery', true );

			if ( ! empty( $images ) ) {
				?>
				<div class="gallery-post mb40">
					<?php
					foreach ( $images as $image ) {
						echo '<div class="item"><img src="' . esc_url( $image ) . '"/></div>';
					}
					?>
				</div>
				<?php
			}
		}

		// Quote Post.
		if ( 'quote' === $post_format ) {
			$quote_content = get_post_meta( $post->ID, 'cariera_blog_quote_content', true );
			$quote_author  = get_post_meta( $post->ID, 'cariera_blog_quote_author', true );
			$quote_source  = get_post_meta( $post->ID, 'cariera_blog_quote_source', true );
			$allowed_tags  = wp_kses_allowed_html( 'post' );

			if ( ! empty( $quote_content ) && ! empty( $quote_author ) ) {
				?>
				<figure class="post-quote mb40">
					<span class="icon"></span>
					<blockquote>
						<h4><?php echo esc_html( $quote_content ); ?></h4>

						<?php if ( ! empty( $quote_source ) ) { ?>
							<a href="<?php echo esc_url( $quote_source ); ?>">
						<?php } ?>
								<h6 class="pt20">
								<?php
								echo esc_html( '- ' );
								echo wp_kses( $quote_author, $allowed_tags );
								?>
								</h6>
						<?php if ( ! empty( $quote_source ) ) { ?>
							</a> 
						<?php } ?>
					</blockquote>
				</figure>
				<?php
			}
		}

		// Audio Post.
		if ( 'audio' === $post_format ) {
			$audio = get_post_meta( $post->ID, 'cariera_blog_audio', true );
			if ( ! empty( $audio ) ) {
				?>
				<div class="audio-wrapper mb40">
					<?php
					if ( wp_oembed_get( $audio ) ) {
						echo wp_oembed_get( $audio );
					} else {
						$allowed_tags = wp_kses_allowed_html( 'post' );
						echo wp_kses( $audio, $allowed_tags );
					}
					?>
				</div>
				<?php
			}
		}

		// Video Post.
		if ( 'video' === $post_format ) {
			$video_embed = get_post_meta( $post->ID, 'cariera_blog_video_embed', true );
			if ( ! empty( $video_embed ) ) {
				?>
				<div class="embed-responsive embed-responsive-16by9 mb40">
					<?php
					if ( wp_oembed_get( $video_embed ) ) {
						echo wp_oembed_get( $video_embed );
					} else {
						$allowed_tags = wp_kses_allowed_html( 'post' );
						echo wp_kses( $video_embed, $allowed_tags );
					}
					?>
				</div>

				<?php
			}
		}

	}
}



/*
=====================================================
	BLOG LOOP CUSTOM FUNCTION
=====================================================
*/

/**
 *  Meta informations for blog posts
 *
 * @since  1.0.0
 */
function cariera_posted_meta() {
	echo '<div class="meta-tags">';

	if ( is_single() ) {
		$metas = cariera_get_option( 'cariera_meta_single' );

		if ( in_array( 'author', $metas, true ) ) {
			echo '<span class="author"><i class="far fa-keyboard"></i>';
			echo esc_html__( 'By', 'cariera' ) . ' <a class="author-link" rel="author" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">';
			the_author_meta( 'display_name' );
			echo '</a>';
			echo '</span>';
		}
		if ( in_array( 'date', $metas, true ) ) {
			$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
			}

			$time_string = sprintf(
				$time_string,
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() ),
				esc_attr( get_the_modified_date( 'c' ) ),
				esc_html( get_the_modified_date() )
			);

			echo '<span class="published"><i class="far fa-clock"></i>' . $time_string . '</span>';

		}
		if ( in_array( 'cat', $metas, true ) ) {
			if ( has_category() ) {
				echo '<span class="category"><i class="far fa-folder-open"></i>';
				the_category( ', ' );
				echo '</span>'; }
		}
		if ( in_array( 'tags', $metas, true ) ) {
			if ( has_tag() ) {
				echo '<span class="tags"><i class="fas fa-tags"></i>';
				the_tags( '', ', ' );
				echo '</span>'; }
		}
		if ( in_array( 'com', $metas, true ) ) {
			echo '<span class="comments"><i class="far fa-comment"></i>';
			comments_popup_link( esc_html__( '0 comments', 'cariera' ), esc_html__( '1 comment', 'cariera' ), esc_html__( '% comments', 'cariera' ), 'comments-link', esc_html__( 'Comments are off', 'cariera' ) );
			echo '</span>';
		}
	} else {
		$metas = cariera_get_option( 'cariera_blog_meta' );

		if ( in_array( 'author', $metas, true ) ) {
			echo '<span class="author"><i class="far fa-keyboard"></i>';
			echo esc_html__( 'By', 'cariera' ) . ' <a class="author-link" rel="author" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">';
			the_author_meta( 'display_name' );
			echo '</a>';
			echo '</span>';
		}
		if ( in_array( 'date', $metas, true ) ) {
			$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
			}

			$time_string = sprintf(
				$time_string,
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() ),
				esc_attr( get_the_modified_date( 'c' ) ),
				esc_html( get_the_modified_date() )
			);

			echo '<span class="published"><i class="far fa-clock"></i>' . $time_string . '</span>';

		}
		if ( in_array( 'cat', $metas, true ) ) {
			if ( has_category() ) {
				echo '<span class="category"><i class="far fa-folder-open"></i>';
				the_category( ', ' );
				echo '</span>'; }
		}
		if ( in_array( 'tags', $metas, true ) ) {
			if ( has_tag() ) {
				echo '<span class="tags"><i class="fas fa-tags"></i>';
				the_tags( '', ', ' );
				echo '</span>'; }
		}
		if ( in_array( 'com', $metas, true ) ) {
			echo '<span class="comments"><i class="far fa-comment"></i>';
			comments_popup_link( esc_html__( '0 comments', 'cariera' ), esc_html__( '1 comment', 'cariera' ), esc_html__( '% comments', 'cariera' ), 'comments-link', esc_html__( 'Comments are off', 'cariera' ) );
			echo '</span>';
		}
	}
	echo '</div>';
}



/*
=====================================================
	SINGLE POST CUSTOM FUNCTIONS
=====================================================
*/

/**
 *  Display navigation to next/previous set of posts when applicable.
 *
 * @since  1.0.0
 */
function cariera_get_post_navigation() {
	require_once get_template_directory() . '/templates/extra/post-nav.php';
}



/**
 *  Display comment navigation.
 *
 * @since  1.0.0
 */
function cariera_get_comment_navigation() {
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
		require_once get_template_directory() . '/templates/comments/comment-nav.php';
	endif;
}



/**
 *  Add support for Vertical Featured Images.
 *
 * @since  1.0.0
 */
if ( ! function_exists( 'cariera_vertical_featured_image' ) ) {
	function cariera_vertical_featured_image( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
		$image_data = wp_get_attachment_image_src( $post_thumbnail_id, 'large' );

		// Get the image width and height from the data provided by wp_get_attachment_image_src().
		$width  = $image_data[1];
		$height = $image_data[2];

		if ( $height > $width ) {
			$html = str_replace( 'attachment-', 'vertical-image attachment-', $html );
		}
		return $html;
	}

	add_filter( 'post_thumbnail_html', 'cariera_vertical_featured_image', 10, 5 );
}



/*
=====================================================
	COMMENT FUNCTIONS
=====================================================
*/

/**
 * Comment Callback Function.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'cariera_comment' ) ) {
	require_once get_template_directory() . '/templates/comments/comments.php';
}



/**
 * Comment Form.
 *
 * @since   1.0.0
 * @version 1.5.1
 */
function cariera_comment_form( $args ) {

	$commenter    = wp_get_current_commenter();
	$current_user = wp_get_current_user();
	$req          = get_option( 'require_name_email' );
	$aria_req     = ( $req ? " aria-required='true'" : '' );

	$comment_author       = esc_attr( $commenter['comment_author'] );
	$comment_author_email = esc_attr( $commenter['comment_author_email'] );
	$comment_author_url   = esc_attr( $commenter['comment_author_url'] );

	$name    = ( $comment_author ) ? '' : esc_html__( 'Name *', 'cariera' );
	$email   = ( $comment_author_email ) ? '' : esc_html__( 'Email *', 'cariera' );
	$website = ( $comment_author_url ) ? '' : esc_html__( 'Website', 'cariera' );

	$fields = [
		'author' => '<div class="col-md-6 form-group"><input id="author" name="author" type="text" class="form-control" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="' . esc_attr__( 'Your Name', 'cariera' ) . '" required="required" /></div>',

		'email'  => '<div class="col-md-6 form-group"><input id="email" name="email" class="form-control" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" placeholder="' . esc_attr__( 'Your Email', 'cariera' ) . '" required="required" /></div>',
	];

	$args = [
		'class_form'           => esc_attr( 'comment-form row' ),
		'title_reply'          => esc_html__( 'Leave a Comment', 'cariera' ),
		'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'cariera' ),
		'title_reply_before'   => '<h4 id="reply-title" class="comment-reply-title nomargin">',
		'title_reply_after'    => '</h4>',
		'submit_button'        => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
		'submit_field'         => '<div class="col-md-12">%1$s %2$s</div>',
		'class_submit'         => esc_attr( 'btn btn-main btn-effect' ),
		'label_submit'         => esc_attr__( 'send comment', 'cariera' ),
		'comment_field'        => '<div class="col-md-12 form-group"><textarea id="comment" class="form-control" name="comment" rows="8" placeholder="' . esc_attr__( 'Type your comment...', 'cariera' ) . '" required="required"></textarea></div>',
		'comment_notes_before' => '<div class="col-md-12 mb10"><p class="mtb10"><em>' . esc_html__( 'Your email address will not be published.', 'cariera' ) . '</em></p></div>',
		'logged_in_as'         => '<div class="col-md-12"><p class="logged-in-as">' .
			sprintf(
				esc_html__( 'Logged in as ', 'cariera' ) . '<a href="%1$s">%2$s</a>. <a href="%3$s" title="' . esc_html__( 'Log out of this account', 'cariera' ) . '">' . esc_html__( 'Log out?', 'cariera' ) . '</a>',
				esc_url( admin_url( 'profile.php' ) ),
				$current_user->user_login,
				wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) )
			) . '</p></div>',
		'cancel_reply_link'    => esc_html__( 'Cancel Reply', 'cariera' ),
		'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
	];

	return $args;
}

add_filter( 'comment_form_defaults', 'cariera_comment_form' );



/**
 * Nav Menu Role workaround.
 *
 * @since 1.2.3
 */
function cariera_navmenu_role_nmr( $walker ) {
	if ( function_exists( 'Nav_Menu_Roles' ) ) {
		$walker = 'Walker_Nav_Menu_Edit_Roles';
	}

	return $walker;
}

add_filter( 'wp_edit_nav_menu_walker', 'cariera_navmenu_role_nmr', 999999 );



/**
 * Redirect on logout.
 *
 * @since 1.2.7
 */
function cariera_logout_redirect() {
	wp_safe_redirect( home_url() );

	exit;
}

add_action( 'wp_logout', 'cariera_logout_redirect' );



/*
=====================================================
	ACTIVATION FUNCTIONS
=====================================================
*/

/**
 * Check if Cariera Core plugin is activated or not.
 *
 * @since 1.3.5
 */
if ( ! function_exists( 'cariera_core_is_activated' ) ) {
	function cariera_core_is_activated() {
		return class_exists( 'Cariera_Plugin' ) ? true : false;
	}
}



/**
 * Check if WooCommerce is activated or not.
 *
 * @since 1.3.0
 */
if ( ! function_exists( 'cariera_wc_is_activated' ) ) {
	function cariera_wc_is_activated() {
		return class_exists( 'WooCommerce' ) ? true : false;
	}
}



/**
 * Check if WP Job Manager is activated or not.
 *
 * @since 1.3.0
 */
if ( ! function_exists( 'cariera_wp_job_manager_is_activated' ) ) {
	function cariera_wp_job_manager_is_activated() {
		return class_exists( 'WP_Job_Manager' ) ? true : false;
	}
}



/**
 * Check if WP Resume Manager is activated or not.
 *
 * @since 1.3.0
 */
if ( ! function_exists( 'cariera_wp_resume_manager_is_activated' ) ) {
	function cariera_wp_resume_manager_is_activated() {
		return class_exists( 'WP_Resume_Manager' ) ? true : false;
	}
}



/**
 * Check if Cariera Company Manager is activated or not.
 *
 * @since 1.3.0
 */
if ( ! function_exists( 'cariera_wp_company_manager_is_activated' ) ) {
	function cariera_wp_company_manager_is_activated() {
		return class_exists( 'Cariera_Company_Manager' ) ? true : false;
	}
}



/*
=====================================================
	PAGE HEADER
=====================================================
*/

/**
 * Fetching the pages titles.
 *
 * @since 1.3.3
 */
if ( ! function_exists( 'cariera_get_the_title' ) ) {
	function cariera_get_the_title() {

		// Blog Page.
		if ( is_home() ) {
			$blog_title = cariera_get_option( 'cariera_blog_title' );

			return $blog_title;
		}

		// WooCommerce Page.
		if ( cariera_wc_is_activated() ) {
			if ( is_woocommerce() ) {
				if ( is_single() && ! is_attachment() ) {
					echo get_the_title();
				} elseif ( ! is_single() ) {
					woocommerce_page_title();
				}

				return;
			}
		}

		// 404 Page.
		if ( is_404() ) {
			return esc_html__( 'Error 404', 'cariera' );
		}

		// Homepage and Single Page.
		if ( is_home() || is_single() || is_404() ) {
			return get_the_title();
		}

		// Search Page.
		if ( is_search() ) {
			return sprintf( esc_html__( 'Search Results for: %s', 'cariera' ), '<span>' . get_search_query() . '</span>' );
		}

		// Archive Pages.
		if ( is_archive() ) {
			if ( is_author() ) {
				return sprintf( esc_html__( 'All posts by %s', 'cariera' ), get_the_author() );
			} elseif ( is_day() ) {
				return sprintf( esc_html__( 'Day: %s', 'cariera' ), get_the_date() );
			} elseif ( is_month() ) {
				return sprintf( esc_html__( 'Month: %s', 'cariera' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'cariera' ) ) );
			} elseif ( is_year() ) {
				return sprintf( esc_html__( 'Year: %s', 'cariera' ), get_the_date( _x( 'Y', 'yearly archives date format', 'cariera' ) ) );
			} elseif ( is_tag() ) {
				return sprintf( esc_html__( 'Tag: %s', 'cariera' ), single_tag_title( '', false ) );
			} elseif ( is_category() ) {
				return sprintf( esc_html__( 'Category: %s', 'cariera' ), single_cat_title( '', false ) );
			} elseif ( is_tax( 'post_format', 'post-format-aside' ) ) {
				return esc_html__( 'Asides', 'cariera' );
			} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
				return esc_html__( 'Videos', 'cariera' );
			} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
				return esc_html__( 'Audio', 'cariera' );
			} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
				return esc_html__( 'Quotes', 'cariera' );
			} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
				return esc_html__( 'Galleries', 'cariera' );
			} else {
				return esc_html__( 'Archives', 'cariera' );
			}
		}

		return get_the_title();
	}
}



/*
=====================================================
	COOKIE BAR - LAW INFO
=====================================================
*/

/**
 * Cookie Law Info
 *
 * @since  1.3.0
 */
if ( ! function_exists( 'cariera_cookie_bar' ) ) {
	function cariera_cookie_bar() {

		if ( false === cariera_get_option( 'cariera_cookie_notice' ) ) {
			return;
		}

		$text_msg    = cariera_get_option( 'cariera_notice_message' );
		$policy_page = cariera_get_option( 'cariera_policy_page' );
		?>

		<div class="cariera-cookies-bar">
			<div class="cariera-cookies-inner">
				<div class="cookies-info-text">
					<?php echo esc_html( $text_msg ); ?>
				</div>
				<div class="cookies-buttons">
					<a href="#" class="btn btn-main cookies-accept-btn"><?php esc_html_e( 'Accept', 'cariera' ); ?></a>
					<?php if ( $policy_page ) { ?>
						<a href="<?php echo esc_url( get_page_link( $policy_page ) ); ?>" class="cariera-more-btn" target="_blank">
							<?php esc_html_e( 'More info', 'cariera' ); ?>
						</a>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php
	}

	add_action( 'wp_footer', 'cariera_cookie_bar' );
}



/*
=====================================================
	EXTRA FUNCTIONS
=====================================================
*/

/**
 * Clean variables using sanitize_text_field
 *
 * @since  1.3.0
 */
if ( ! function_exists( 'cariera_clean' ) ) {
	function cariera_clean( $var ) {
		if ( is_array( $var ) ) {
			return array_map( 'cariera_clean', $var );
		} else {
			return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
		}
	}
}



/**
 * Disable WooCommerce page creation on first activate
 *
 * @since 1.5.0
 */
function cariera_disable_wc_page_creation() {
	$pages = [];

	return $pages;
}

add_filter( 'woocommerce_create_pages', 'cariera_disable_wc_page_creation' );



/**
 * Login Register modal
 *
 * @since   1.4.0
 * @version 1.5.4
 */
function cariera_login_register_modal() {
	$login_registration = get_option( 'cariera_login_register_layout' );

	if ( is_user_logged_in() || 'page' === $login_registration || is_page_template( 'templates/login-register.php' ) ) {
		return;
	}
	?>

	<!-- Start of Login & Register Popup -->
	<div id="login-register-popup" class="small-dialog zoom-anim-dialog mfp-hide">

		<!-- Start of Signin wrapper -->
		<div class="signin-wrapper">
			<div class="small-dialog-headline">
				<h3 class="title"><?php esc_html_e( 'Sign in', 'cariera' ); ?></h3>
			</div>

			<div class="small-dialog-content">
				<?php echo do_shortcode( '[cariera_login_form]' ); // Add login form. ?>

				<div class="bottom-links">
					<a href="#" class="signup-trigger"><i class="fas fa-user"></i><?php esc_html_e( 'Don\'t have an account?', 'cariera' ); ?></a>
					<a href="#" class="forget-password-trigger"><i class="fas fa-lock"></i><?php esc_html_e( 'Forgot Password?', 'cariera' ); ?></a>
				</div>

				<?php do_action( 'cariera_social_login' ); ?>
			</div>    
		</div>
		<!-- End of Signin wrapper -->


		<!-- Start of Signup wrapper -->
		<div class="signup-wrapper">
			<div class="small-dialog-headline">
				<h3 class="title"><?php esc_html_e( 'Sign Up', 'cariera' ); ?></h3>
			</div>

			<div class="small-dialog-content">
				<?php echo do_shortcode( '[cariera_registration_form]' ); // Add registration form. ?>

				<div class="bottom-links">
					<a href="#" class="signin-trigger"><i class="fas fa-user"></i><?php esc_html_e( 'Already registered?', 'cariera' ); ?></a>
					<a href="#" class="forget-password-trigger"><i class="fas fa-lock"></i><?php esc_html_e( 'Forgot Password?', 'cariera' ); ?></a>
				</div>

				<?php do_action( 'cariera_social_login' ); ?>
			</div>
		</div>
		<!-- End of Signup wrapper -->


		<!-- Start of Forget Password wrapper -->
		<div class="forgetpassword-wrapper">
			<div class="small-dialog-headline">
				<h3 class="title"><?php esc_html_e( 'Forgotten Password', 'cariera' ); ?></h3>
			</div>

			<div class="small-dialog-content">
				<?php echo do_shortcode( '[cariera_forgetpass_form]' ); // Add forget password form. ?>

				<div class="bottom-links">
					<a href="#" class="signin-trigger"><i class="fas fa-arrow-left"></i><?php esc_html_e( 'Go back', 'cariera' ); ?></a>
				</div>
			</div>

		</div>
		<!-- End of Forget Password wrapper -->

	</div>
	<?php
}

add_action( 'wp_footer', 'cariera_login_register_modal' );



/**
 * General Search
 *
 * @since   1.4.0
 * @version 1.5.2
 */
function cariera_fullscreen_search() {

	if ( false === cariera_get_option( 'header_quick_search' ) ) {
		return;
	}
	?>

	<!-- ===== Quick Search Modal ===== -->
	<div id="quick-search-modal" class="small-dialog zoom-anim-dialog mfp-hide">
		<div class="small-dialog-headline">
			<h4 class="title"><?php esc_html_e( 'Job Quick Search', 'cariera' ); ?></h4>
		</div>

		<div class="small-dialog-content">
			<form method="GET" action="<?php echo esc_url( get_permalink( get_option( 'job_manager_jobs_page_id' ) ) ); ?>" class="job-search-form">
				<div class="col-md-12 quick-search-keywords">
					<input type="text" id="quick_search_keywords" name="search_keywords" placeholder="<?php esc_html_e( 'Keywords', 'cariera' ); ?>" autocomplete="off">
				</div>
				<div class="col-md-12 quick-search-location mt25">
					<input type="text" id="quick_search_location" name="search_location" placeholder="<?php esc_html_e( 'Location', 'cariera' ); ?>" autocomplete="off">
				</div>
				<div class="col-md-12">
					<input type="submit" class="btn btn-main btn-effect" value="<?php esc_html_e( 'Search', 'cariera' ); ?>">
				</div>
			</form>
		</div>
	</div>
	<?php
}

add_action( 'wp_footer', 'cariera_fullscreen_search' );



/**
 * Shopping Cart modal
 *
 * @since   1.4.0
 * @version 1.5.2
 */
function cariera_shopping_cart_modal() {
	if ( ! cariera_wc_is_activated() ) {
		return;
	}

	if ( false === cariera_get_option( 'header_cart' ) ) {
		return;
	}

	if ( apply_filters( 'woocommerce_widget_cart_is_hidden', is_cart() || is_checkout() ) ) {
		return;
	}
	?>

	<div id="shopping-cart-modal" class="small-dialog zoom-anim-dialog mfp-hide">
		<div class="small-dialog-headline">
			<h3 class="title"><?php esc_html_e( 'Cart', 'cariera' ); ?></h3>
		</div>

		<div class="small-dialog-content">
			<?php the_widget( 'WC_Widget_Cart' ); ?>
		</div>
	</div>

	<?php
}

add_action( 'wp_footer', 'cariera_shopping_cart_modal' );
