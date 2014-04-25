<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package GeoProjects
 * @since GeoProjects 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<article id="post-0" class="post error404 not-found hentry">

				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'lang_geoprojects' ); ?></h1>
				</header>

				<div class="entry-content">
					
					<p><?php _e( 'It looks like nothing was found at this location.', 'lang_geoprojects' ); ?></p>

				</div>

			</article>

		</div>
	</div>

	<?php get_sidebar(); ?>

	<?php get_footer(); ?>