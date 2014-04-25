	<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to gp_comment() which is
 * located in the functions.php file.
 *
 * @package GeoProjects
 */
?>

<?php
	/*
	 * If the current post is protected by a password and
	 * the visitor has not yet entered the password we will
	 * return early without loading the comments.
	 */
	if ( post_password_required() )
		return;
?>

	<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title txt-on-bg">
			<?php _e( 'Comments', 'lang_geoprojects' ); ?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav role="navigation" id="comment-nav-above" class="site-navigation comment-navigation">
			<h1 class="assistive-text"><?php _e( 'Comment navigation', 'lang_geoprojects' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'lang_geoprojects' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'lang_geoprojects' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

		<ol class="commentlist">
			<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use gp_comment() to format the comments.
				 * If you want to overload this in a child theme then you can
				 * define gp_comment() and that will be used instead.
				 * See gp_comment() in inc/template-tags.php for more.
				 */
				wp_list_comments( array( 'callback' => 'gp_comment' ) );
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav role="navigation" id="comment-nav-below" class="site-navigation comment-navigation">
			<h1 class="assistive-text"><?php _e( 'Comment navigation', 'lang_geoprojects' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'lang_geoprojects' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'lang_geoprojects' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :	?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'lang_geoprojects' ); ?></p>
	<?php endif; ?>

	<?php
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$html5 = 'html5';

	comment_form( array(
		'logged_in_as'			=> '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a> - <a href="%3$s" title="Log out of this account">Log out?</a>', 'lang_geoprojects' ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ) ) . '</p>',
		'fields' 				=> apply_filters( 'comment_form_default_fields', array(
										'author' 	=> '<div class="comment-form-text-fields clearfix"><p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'lang_geoprojects' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
		            									'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
										'email' 	=> '<p class="comment-form-email"><label for="email">' . __( 'Email', 'lang_geoprojects' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
		            									'<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
										'url' 		=> '<p class="comment-form-url"><label for="url">' . __( 'Website', 'lang_geoprojects' ) . '</label> ' .
		            									'<input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p></div>'
								   )),
		'comment_notes_after'	=> ''
	));
	?>

</div>
