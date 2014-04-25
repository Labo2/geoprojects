<?php
/**
 * Content for a single projects
 * 
 * @package GeoProjects
 * @since GeoProjects 1.0
 */
?>

<article class="type-projects clearfix <?php if ( has_post_thumbnail() ) { echo 'project-with-thumbnail'; } ?>">

	<header class="project-header">

		<h1 class="project-title">
			<?php the_title(); ?>
		</h1>

		<?php
		$project_date = get_post_meta( get_the_ID(), 'gp_date', true );

		if ( $project_date != '' ) : ?>

			<p class="project-date">
				<span><?php _e( 'Started on', 'lang_geoprojects' ); ?> : </span>
				<?php echo $project_date; ?>
			</p>

		<?php endif; ?>

		<?php
		$project_owner = get_post_meta( get_the_ID(), 'gp_owner', true );
		$project_website = get_post_meta( get_the_ID(), 'gp_website', true );

		if ( $project_owner != '' ) : ?>

			<p class="project-owner">
				<span><?php _e( 'Initiated by', 'lang_geoprojects' ); ?> : </span>
				
				<?php if ( $project_website != '' ) : ?>
				
					<a href="<?php echo $project_website; ?>" target="_blank">
						<?php echo $project_owner; ?>
					</a>

				<?php else : ?>
	
					<?php echo $project_owner; ?>

				<?php endif; ?>

			</p>

		<?php endif; ?>


	</header>

	<?php
	// Has featured Image ?
	if ( has_post_thumbnail() ) {
		the_post_thumbnail( 'gp-project-thumb' );
	}
	?>

	<div class="project-content">

		<?php the_content(); ?>

	</div>

	<footer class="project-meta">
		
		<?php
		$project_twitter = get_post_meta( get_the_ID(), 'gp_twitter', true );
		$project_facebook = get_post_meta( get_the_ID(), 'gp_facebook', true );

		if ( $project_twitter != '' || $project_facebook != '' ) : ?>

			<p class="project-follow">
				
				<?php _e( 'Follow this project on', 'lang_geoprojects' ); ?> :
	
				<span>
					<?php if ( $project_twitter != '' ) : ?>
						<a href="<?php echo $project_twitter; ?>" target="_blank" title="<?php _e( 'Go to the Twitter account dedicated to this project', 'lang_geoprojects' ); ?>">Twitter</a>
					<?php endif; ?>

					<?php if ( $project_facebook != '' ) : ?>
						<?php if ( $project_twitter != '' ) { echo ' - '; } ?>
						<a href="<?php echo $project_facebook; ?>" target="_blank" title="<?php _e( 'Go to the Facebook page dedicated to this project', 'lang_geoprojects' ); ?>">Facebook</a>
					<?php endif; ?>
				</span>

			</p>

		<?php endif; ?>

		<?php $project_file = get_post_meta( get_the_ID(), 'gp_file', true ); ?>

		<?php if ( $project_file != '' ) : ?>

			<p class="project-file">
				<?php _e( 'Attached file', 'lang_geoprojects' ); ?> : 
				<span><?php echo wp_get_attachment_link( $project_file, '' ); ?></span>
			</p>

		<?php endif; ?>

	</footer>

</article>
