<?php
/**
 * @package GeoProjects
 * @since GeoProjects 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">

		<h1 class="entry-title">
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'lang_geoprojects' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
				<?php the_title(); ?>
			</a>
		</h1>

		<?php if ( 'post' == get_post_type() ) : ?>

			<div class="entry-meta clearfix">

				<p class="entry-date"><?php gp_posted_on(); ?></p>

				<p class="entry-categories">
					<?php _e( 'In', 'lang_geoprojects' ); ?> :
					<span><?php echo get_the_category_list( ', ' ); ?></span>
				</p>

			</div>

		<?php endif; ?>

	</header>
	
	<div class="entry-summary">
		<p><?php gp_get_custom_excerpt(); ?></p>
	</div>

</article>
