<?php
/**
 * Widget "Posts in a category"
 * 
 * Display a list of posts titles in the given category
 *
 * @package GeoProjects
 * @since GeoProjects 1.0
 */


class gp_widget_posts_in_category extends WP_Widget {

	function __construct() {
		parent::__construct(
			'gp_wdg_posts_in_category', // Base ID
			__( 'Recents Posts in a category', 'lang_geoprojects' ), // Widget name that appears in UI
			array(
				'description' => __( 'Display the titles of the recents posts in the choosen category', 'lang_geoprojects' )
			) // Widget description 
		);
	}

	// Widget Frontend
	public function widget( $args, $instance ) {
	
		$category_term = get_term( $instance['category'], 'category' );

		$category_title = apply_filters( 'widget_title', $category_term->name );

		// Before and After widget arguments are defined by themes
		echo $args['before_widget'];
		
		echo $args['before_title'] . $category_title . $args['after_title'];

		// Get list of last posts in this category
		$last_posts = gp_query_get_posts_in_category( $category_term->term_id, array( 'posts_per_page' => $instance['nb_posts'] ) );

		if ( count( $last_posts ) > 0 ) : ?>

			<ul>

				<?php foreach ( $last_posts as $p ) : ?>

					<li>
						<a href="<?php echo get_permalink( $p ); ?>" title="<?php _e( 'Click to see this post', 'lang_geoprojects' ); ?>">
							<?php echo $p->post_title; ?>
						</a>
					</li>

				<?php endforeach; ?>

			</ul>

			<p class="widget-posts-in-list-more clearfix">
				<a href="<?php echo get_term_link( $category_term, 'category' ) ?>" title="<?php _e( 'See all', 'lang_geoprojects' ); ?>">
					<?php _e( 'See all', 'lang_geoprojects' ); ?>
				</a>
			</p>

		<?php endif;

		echo $args['after_widget'];


	}
		
	// Widget Backend 
	public function form( $instance ) {

		if ( isset( $instance['category'] ) ) {
			$category = $instance['category'];
			$nb_posts = $instance['nb_posts'];
		} else {
			$category = 1;
			$nb_posts = GP_WIDGET_POSTS_IN_CATEGORY_NB_POSTS;
		}
		
		// Get list of terms
		$terms = get_terms( 'category', array( 'get' => 'all') );
		?>
		
		<p class="widget-posts-in-category">
		
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Category' ); ?></label> 
			<select id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>">
				
				<?php foreach ( $terms as $term ) : ?>

					<option value="<?php echo $term->term_id; ?>" <?php echo ( $category == $term->term_id ) ? 'selected="selected"' : ''; ?>>
						<?php echo $term->name; ?>
					</option>

				<?php endforeach; ?>

			</select>

		</p>

		<p class="widget-posts-in-category">

			<label for="<?php echo $this->get_field_id( 'nb_posts' ); ?>"><?php _e( 'Number of Posts max' ); ?></label> 
			<select id="<?php echo $this->get_field_id( 'nb_posts' ); ?>" name="<?php echo $this->get_field_name( 'nb_posts' ); ?>">

				<?php for ( $i = 1; $i <= GP_WIDGET_POSTS_IN_CATEGORY_NB_POSTS;  $i++ ) : ?>
					<option value="<?php echo $i; ?>" <?php echo ( $i == $nb_posts ) ? 'selected="selected"' : ''; ?>>
						<?php echo $i; ?>
					</option>
				<?php endfor; ?>
				
			</select>

		</p>

		<?php 
	}
	
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['category'] = ( ! empty( $new_instance['category'] ) ) ? strip_tags( $new_instance['category'] ) : '';
		$instance['nb_posts'] = ( ! empty( $new_instance['nb_posts'] ) ) ? strip_tags( $new_instance['nb_posts'] ) : '';
		return $instance;
	}

}