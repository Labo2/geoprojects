<?php
/**
 * @package GeoProjects
 * @since GeoProjects 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<header class="entry-header">
	
		<h1 class="entry-title">
			<?php the_title(); ?>
		</h1>

		<div class="entry-meta clearfix">

			<p class="entry-date"><?php gp_posted_on(); ?></p>

			<p class="entry-categories">
				<?php _e( 'In', 'lang_geoprojects' ); ?> :
				<span><?php echo get_the_category_list( ', ' ); ?></span>
			</p>

		</div>
	
	</header>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>

</article>
