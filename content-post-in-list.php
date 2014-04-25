<?php
/**
 *
 * Display a post template in a list (archive, category...)
 * 
 * @package GeoProjects
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-post-in-list' ); ?>>

	<header class="entry-header">

		<?php if ( has_post_thumbnail() ) : ?>

			<a href="<?php the_permalink(); ?>" class="entry-fimg" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'lang_geoprojects' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">

				<?php the_post_thumbnail( 'gp-post-thumb-in-list' ); ?>

			</a>

		<?php endif; ?>

		<h1 class="entry-title">
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'lang_geoprojects' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
				<?php the_title(); ?>
			</a>
		</h1>

		<div class="entry-meta">

			<p class="entry-date"><?php gp_posted_on(); ?></p>

			<p class="entry-categories">
				<?php _e( 'In', 'lang_geoprojects' ); ?> :
				<span><?php echo get_the_category_list( ', ' ); ?></span>
			</p>

		</div>

	</header>
	
	<div class="entry-summary">
		<p><?php gp_get_custom_excerpt(); ?></p>
	</div>

</article>
