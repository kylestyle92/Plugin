<?php
	/*
	* Plugin Name: locations
	* Description: A Custom Post Type for Locations
	* Author: Alex - Kyle - Saad
	* Version: 2.0
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
	
?>