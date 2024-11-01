<?php

add_action( 'init', 'sgm_cp_init' );

function sgm_cp_init() {
	$labels = array(
		'name'               => _x( 'Smart Google Map', 'post type general name', 'smart-google-map' ),
		'singular_name'      => _x( 'Marker', 'post type singular name', 'smart-google-map' ),
		'menu_name'          => _x( 'Smart Google Map', 'admin menu', 'smart-google-map' ),
		'name_admin_bar'     => _x( 'Smart Google Map', 'add new on admin bar', 'smart-google-map' ),
		'add_new'            => _x( 'Add New', 'smart-google-map', 'smart-google-map' ),
		'add_new_item'       => __( 'Add New Marker', 'smart-google-map' ),
		'new_item'           => __( 'New Marker', 'smart-google-map' ),
		'edit_item'          => __( 'Edit Marker', 'smart-google-map' ),
		'view_item'          => __( 'View Marker', 'smart-google-map' ),
		'all_items'          => __( 'All Markers', 'smart-google-map' ),
		'search_items'       => __( 'Search Markers', 'smart-google-map' ),
		'parent_item_colon'  => __( 'Parent Markers:', 'smart-google-map' ),
		'not_found'          => __( 'No markers found.', 'smart-google-map' ),
		'not_found_in_trash' => __( 'No markers found in Trash.', 'smart-google-map' )
	);

	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'smart-google-map' ),
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_icon'			 => 'dashicons-location',
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail')
	);

	register_post_type( 'smart-google-map', $args );

	$labels = array(
		'name'              => _x( 'Categories', 'taxonomy general name', 'smart-google-map' ),
		'singular_name'     => _x( 'Category', 'taxonomy singular name', 'smart-google-map' ),
		'search_items'      => __( 'Search Categories', 'smart-google-map' ),
		'all_items'         => __( 'All Categories', 'smart-google-map' ),
		'parent_item'       => __( 'Parent Category', 'smart-google-map' ),
		'parent_item_colon' => __( 'Parent Category:', 'smart-google-map' ),
		'edit_item'         => __( 'Edit Category', 'smart-google-map' ),
		'update_item'       => __( 'Update Category', 'smart-google-map' ),
		'add_new_item'      => __( 'Add New Category', 'smart-google-map' ),
		'new_item_name'     => __( 'New Category Name', 'smart-google-map' ),
		'menu_name'         => __( 'Category', 'smart-google-map' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'public'			=> false,
		'show_admin_column' => true,
		'query_var'         => true
	);

	register_taxonomy( 'marker-category', 'smart-google-map', $args );

}

?>