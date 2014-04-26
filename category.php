<?php
/**
 * The template for displaying a Term in the default post category taxonomy
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package GeoProjects
 */

get_header(); ?>

	<section id="primary" class="site-content">
		<div id="content" role="main">

		<?php if ( have_posts() ) : ?>

			<h1 class="archive-title txt-on-bg">
				<?php echo single_cat_title( '', false ); ?>
			</h1>

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'content', 'post-in-list' );

			endwhile;

			gp_content_nav( 'nav-below' );
			?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</div>
	</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>