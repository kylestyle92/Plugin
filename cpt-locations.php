<?php
	/*
	* Plugin Name: locationscct490
	* Description: A Custom Post Type for Locations
	* Author: Alex - Kyle - Saad
	* Version: 1.0
	*/
	
	function custom_post_type() 
	{

		// Set User Interface labels for Custom Post Type that appear in WP dashboard 
		$labels = array(
			'name'                => __( 'Locations', 'Post Type General Name' ),
			'singular_name'       => __( 'Location', 'Post Type Singular Name', 'clickture' ),
			'menu_name'           => __( 'Locations', 'clickture' ),
			'all_items'           => __( 'All Locations', 'clickture' ),
			'view_item'           => __( 'View Location', 'clickture' ),
			'add_new_item'        => __( 'Add New Location', 'clickture' ),
			'add_new'             => __( 'Add New Location', 'clickture' ),
			'edit_item'           => __( 'Edit Location', 'clickture' ),
			'update_item'         => __( 'Update Location', 'clickture' ),
			'search_items'        => __( 'Search Location', 'clickture' ),
			'not_found'           => __( 'Not Found', 'clickture' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'clickture' ),
		);
		
		// Set other options for Custom Post Type
		$args = array(
			'label'               => __( 'locations', 'clickture' ),
			'description'         => __( 'Interesting Locations in the GTA', 'clickture' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', ), // Features of the CPT supports in Post Editor 
			'taxonomies'          => array( 'category', 'post_tag'), // uses the regular WP categories and tags as taxonomy CPT 
			'hierarchical'        => true,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);
		register_post_type( 'locations', $args ); // Registering your Custom Post Type as defined above
	}
	add_action( 'init', 'custom_post_type', 0 );	// Hook into the 'init' action to generate the custom post 
	
// end custom post type creation ------------------------------------------------------------------------------------------------------------
	
	add_action( 'widgets_init', function(){register_widget( 'locations_widget' );});
	
	class locations_widget extends WP_Widget
	{
		function __construct() 
		{
			parent::__construct(
				'locations_widget', // Base ID
				'Locations Widget', // Name
				array('description' => __( 'Displays your latest locations. Outputs the post thumbnail and title'))
			   );
		}
		
		function update($new_instance, $old_instance) 
		{
				$instance = $old_instance;
				$instance['title'] = strip_tags($new_instance['title']);
				$instance['numberOfLocations'] = strip_tags($new_instance['numberOfLocations']);
				return $instance;
		}
		
		function form($instance) 
		{
			if( $instance) 
			{
				$title = esc_attr($instance['title']);
				$numberOfLocations = esc_attr($instance['numberOfLocations']);
			} 
			else 
			{
				$title = '';
				$numberOfLocations = '';
			}
			?>
			<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'locations_widget'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
			<p>
			<label for="<?php echo $this->get_field_id('numberOfLocations'); ?>"><?php _e('Number of locations:', 'locations_widget'); ?></label>
			<select id="<?php echo $this->get_field_id('numberOfLocations'); ?>"  name="<?php echo $this->get_field_name('numberOfLocations'); ?>">
				<?php for($x=1;$x<=10;$x++): ?>
				<option <?php echo $x == $numberOfLocations ? 'selected="selected"' : '';?> value="<?php echo $x;?>"><?php echo $x; ?></option>
				<?php endfor;?>
			</select>
			</p>
		<?php
		}
		
		function widget($args, $instance) 
		{
			extract( $args );
			$title = apply_filters('widget_title', $instance['title']);
			$numberOfLocations = $instance['numberOfLocations'];
			echo $before_widget;
			if ( $title ) {
				echo $before_title . $title . $after_title;
			}
			$this->getLocations($numberOfLocations);
			echo $after_widget;
		}	
		
		function getLocations($numberOfLocations) 
		{ //html
			global $post;
			add_image_size( 'locations_widget_size', 85, 45, false );
			$locations = new WP_Query();
			$locations->query('post_type=locations&posts_per_page=' . $numberOfLocations );
		if($locations->found_posts > 0) 
		{
			echo '<ul class="locations_widget">';
				while ($locations->have_posts()) {
					$locations->the_post();
					$image = (has_post_thumbnail($post->ID)) ? get_the_post_thumbnail($post->ID, 'locations_widget_size') : '<div class="noThumb"></div>';
					$listItem = '<li>' . $image;
					$listItem .= '<a href="' . get_permalink() . '">';
					$listItem .= get_the_title() . '</a>';
					$listItem .= '<span>Added ' . get_the_date() . '</span></li>';
					echo $listItem;
				}
			echo '</ul>';
			wp_reset_postdata();
		}
		else
		{
			echo '<p>No listing found</p>';
		}
		
		}
	}
?>