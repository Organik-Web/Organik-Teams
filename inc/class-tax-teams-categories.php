<?php
/**
 * Define constant variables
 */
define( 'ORGNK_TEAMS_CATEGORIES_TAX_NAME', 'team-category' );

/**
 * Main Organik_Teams class
 */
class Organik_Teams_Categories {

	/**
     * Constructor function
     */
	public function __construct() {

		// Register taxonomies
		add_action( 'init', array( $this, 'orgnk_teams_categories_register_taxonomy') );
	}

	/**
	 * Register taxonomy
	 */
	public function orgnk_teams_categories_register_taxonomy() {

		$labels = array(
			'name'                       	=> 'Team Category',
			'singular_name'              	=> 'Team Category',
			'menu_name'                  	=> 'Team categories',
			'all_items'                  	=> 'All team categories',
			'parent_item'                	=> 'Parent team category',
			'parent_item_colon'          	=> 'Parent team category:',
			'new_item_name'              	=> 'New Team Category Name',
			'add_new_item'               	=> 'Add New Category',
			'edit_item'                  	=> 'Edit Category',
			'update_item'                	=> 'Update Category',
			'view_item'                  	=> 'View Category',
			'separate_items_with_commas' 	=> 'Separate categories with commas',
			'add_or_remove_items'        	=> 'Add or remove categories',
			'choose_from_most_used'      	=> 'Choose from the most used',
			'popular_items'              	=> 'Popular categories',
			'search_items'               	=> 'Search categories',
			'not_found'                  	=> 'Not Found',
			'no_terms'                   	=> 'No categories',
			'items_list'                 	=> 'Categories list',
			'items_list_navigation'      	=> 'Categories list navigation'
		);
	
		$rewrite = array(
			'slug'                  		=> ORGNK_TEAMS_REWRITE_SLUG . '/category',
			'with_front'            		=> false,
			'hierarchical'					=> true
		);
	
		$args = array(
			'labels'                     	=> $labels,
			'hierarchical'               	=> true,
			'public'                     	=> true,
			'show_ui'                    	=> true,
			'show_admin_column'          	=> true,
			'show_in_nav_menus'          	=> true,
			'show_tagcloud'              	=> true,
			'rewrite'						=> $rewrite
		);
		register_taxonomy( ORGNK_TEAMS_CATEGORIES_TAX_NAME, array( ORGNK_TEAMS_CPT_NAME ), $args );
	}
}
