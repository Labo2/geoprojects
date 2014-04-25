<?php
/**
 * The Template for displaying all single projects.
 *
 * @package GeoProjects
 */

get_header(); ?>

<div id="primary" class="content-area">
	<div id="content" class="site-content clearfix" role="main">

	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'content', 'single-project' ); ?>

		<?php get_template_part( 'content', 'project-contents-list' ); ?>

		<?php
			// If comments are open or we have at least one comment, load up the comment template
			if ( comments_open() || '0' != get_comments_number() )
				comments_template( '', true );
		?>

	<?php endwhile; ?>

	</div>
</div>

<?php get_footer(); ?>