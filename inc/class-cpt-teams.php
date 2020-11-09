<?php
/**
 * Define constant variables
 */
define( 'ORGNK_TEAMS_CPT_NAME', 'team' );
define( 'ORGNK_TEAMS_SINGLE_NAME', 'Team Member' );
define( 'ORGNK_TEAMS_PLURAL_NAME', 'Team Members' );

/**
 * Main Organik_Teams class
 */
class Organik_Teams {

	/**
     * The single instance of Organik_Teams
     */
	private static $instance = null;

	/**
     * Main class instance
     * Ensures only one instance of this class is loaded or can be loaded
     */
    public static function instance() {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new self;
        }
        return self::$instance;
	}
	
	/**
     * Constructor function
     */
	public function __construct() {

		// Define the CPT rewrite variable on init - required here because we need to use get_permalink() which isn't available when plugins are initialised
		add_action( 'init', array( $this, 'orgnk_teams_cpt_rewrite_slug' ) );

		// Register taxonomies
		new Organik_Teams_Categories();

		// Hook into the 'init' action to add the Custom Post Type
		add_action( 'init', array( $this, 'orgnk_teams_cpt_register' ) );

        // Change the title placeholder
		add_filter( 'enter_title_here', array( $this, 'orgnk_teams_cpt_title_placeholder' ) );

		// Switch the default editor to use Teeny MCE
		add_filter( 'wp_editor_settings', array( $this, 'orgnk_teams_cpt_enable_teeny_editor' ) );

		// Remove unneccessary buttons from the Teeny MCE
		add_filter( 'teeny_mce_buttons', array( $this, 'orgnk_teams_cpt_remove_teeny_editor_buttons' ) );

		// Add post meta to the admin list view for this CPT
		add_filter( 'manage_' . ORGNK_FAQS_CPT_NAME . '_posts_columns', array( $this, 'orgnk_teams_cpt_admin_table_column' ) );
		add_action( 'manage_' . ORGNK_FAQS_CPT_NAME . '_posts_custom_column', array( $this, 'orgnk_teams_cpt_admin_table_content' ), 10, 2 );
		add_filter( 'manage_edit-' . ORGNK_FAQS_CPT_NAME . '_sortable_columns', array( $this, 'orgnk_teams_cpt_admin_table_sortable' ) );

		// Add post meta to the admin list view for default posts
		add_filter( 'manage_post_posts_columns', array( $this, 'orgnk_teams_cpt_posts_admin_table_column' ) );
		add_action( 'manage_post_posts_custom_column', array( $this, 'orgnk_teams_cpt_posts_admin_table_content', 10, 2 ) );

		// Modify the archive query
		add_filter( 'pre_get_posts', array( $this, 'orgnk_teams_cpt_archive_query' ) );

		// Add schema for this post type to the document head
		add_action( 'wp_head', array( $this, 'orgnk_teams_cpt_schema_head' ) );
	}
	
	/**
	 * orgnk_teams_cpt_register()
	 * Register the custom post type
	 */
	public function orgnk_teams_cpt_register() {

		$labels = array(
			'name'                      	=> ORGNK_TEAMS_PLURAL_NAME,
			'singular_name'             	=> ORGNK_TEAMS_SINGLE_NAME,
			'menu_name'                 	=> ORGNK_TEAMS_PLURAL_NAME,
			'name_admin_bar'            	=> ORGNK_TEAMS_SINGLE_NAME,
			'archives'              		=> 'Team member archives',
			'attributes'            		=> 'Team Member Attributes',
			'parent_item_colon'     		=> 'Parent team member:',
			'all_items'             		=> 'All team members',
			'add_new_item'          		=> 'Add new team member',
			'add_new'               		=> 'Add new team member',
			'new_item'              		=> 'New team member',
			'edit_item'             		=> 'Edit team member',
			'update_item'           		=> 'Update team member',
			'view_item'             		=> 'View team member',
			'view_items'            		=> 'View team members',
			'search_items'          		=> 'Search team member',
			'not_found'             		=> 'Not found',
			'not_found_in_trash'    		=> 'Not found in Trash',
			'featured_image'        		=> 'Profile Image',
			'set_featured_image'    		=> 'Set profile image',
			'remove_featured_image' 		=> 'Remove profile image',
			'use_featured_image'    		=> 'Use as profile image',
			'insert_into_item'      		=> 'Insert into team member',
			'uploaded_to_this_item' 		=> 'Uploaded to this team member',
			'items_list'            		=> 'Team members list',
			'items_list_navigation' 		=> 'Team members list navigation',
			'filter_items_list'     		=> 'Filter team members list'
		);
	
		$rewrite = array(
			'slug'                  		=> ORGNK_TEAMS_REWRITE_SLUG, // The slug for single posts
			'with_front'            		=> false,
			'pages'                 		=> true,
			'feeds'                 		=> false
		);
	
		$args = array(
			'label'                 		=> ORGNK_TEAMS_SINGLE_NAME,
			'description'           		=> 'Manage and display team members',
			'labels'                		=> $labels,
			'supports'              		=> array( 'title', 'thumbnail', 'editor', 'page-attributes' ),
			'taxonomies'            		=> array(),
			'hierarchical'          		=> false,
			'public'                		=> true,
			'show_ui'               		=> true,
			'show_in_menu'          		=> true,
			'menu_position'         		=> 25,
			'menu_icon'             		=> 'dashicons-groups',
			'show_in_admin_bar'     		=> true,
			'show_in_nav_menus'     		=> true,
			'can_export'            		=> true,
			'has_archive'           		=> true, // The slug for archive, bool toggle archive on/off
			'publicly_queryable'    		=> true, // Bool toggle single on/off
			'exclude_from_search'   		=> true,
			'capability_type'       		=> 'page',
			'rewrite'						=> $rewrite
		);
		register_post_type( ORGNK_TEAMS_CPT_NAME, $args );
	}

	/**
	 * orgnk_teams_cpt_rewrite_slug()
	 * Conditionally define the CPT archive permalink based on the pages for CPT functionality in Organik themes
	 * Includes a fallback string to use as the slug if the option isn't set
	 */
	public function orgnk_teams_cpt_rewrite_slug() {
		$default_slug = 'team';
		$archive_page_id = get_option( 'page_for_' . ORGNK_TEAMS_CPT_NAME );
		$archive_page_slug = str_replace( home_url(), '', get_permalink( $archive_page_id ) );
		$archive_permalink = ( $archive_page_id ? $archive_page_slug : $default_slug );
		$archive_permalink = ltrim( $archive_permalink, '/' );
		$archive_permalink = rtrim( $archive_permalink, '/' );

		define( 'ORGNK_TEAMS_REWRITE_SLUG', $archive_permalink );
	}

	/** 
	 * orgnk_teams_cpt_title_placeholder()
	 * Change CPT title placeholder on edit screen
	 */
	public function orgnk_teams_cpt_title_placeholder( $title ) {

		$screen = get_current_screen();

		if ( $screen->post_type == ORGNK_TEAMS_CPT_NAME ) {
			return 'Add name';
		}

		return $title;
	}

	/**
	 * orgnk_teams_cpt_enable_teeny_editor()
	 * Convert the default editor to Teeny MCE for this CPT
	 */
	public function orgnk_teams_cpt_enable_teeny_editor( $settings ) {

		$screen = get_current_screen();

		if ( $screen->post_type == ORGNK_FAQS_CPT_NAME ) {
			$settings['teeny'] = true;
			$settings['media_buttons'] = false;
		}

		return $settings;
	}

	/**
	 * orgnk_teams_cpt_remove_teeny_editor_buttons()
	 * Remove some options/buttons from the editor
	 */
	public function orgnk_teams_cpt_remove_teeny_editor_buttons( $buttons ) {

		$screen = get_current_screen();

		if ( $screen->post_type == ORGNK_FAQS_CPT_NAME ) {
			$remove_buttons = array(
				'blockquote',
				'alignleft',
				'aligncenter',
				'alignright',
				'fullscreen'
			);

			foreach ( $buttons as $button_key => $button_value ) {
				if ( in_array( $button_value, $remove_buttons ) ) {
					unset( $buttons[ $button_key ] );
				}
			}
		}
		return $buttons;
	}

	/**
	 * orgnk_teams_cpt_admin_table_column()
	 * Register new column(s) in admin list view
	 */
	public function orgnk_teams_cpt_admin_table_column( $defaults ) {
		
		$new_order = array();

		foreach( $defaults as $key => $value ) {
			// When we find the date column, slip in the new column before it
			if ( $key == 'date' ) {
				$new_order['menu_order'] = 'Order';
			}
			$new_order[$key] = $value;
		}

		return $new_order;
	}

	/**
	 * orgnk_teams_cpt_admin_table_content()
	 * Return the content for the new admin list view columns for each post
	 */
	public function orgnk_teams_cpt_admin_table_content( $column_name, $post_id ) {
			
		global $post;
			
		if ( $column_name == 'menu_order' ) {
			echo $post->menu_order;
		}
	}

	/**
	 * orgnk_teams_cpt_admin_table_sortable()
	 * Make the new admin list view columns sortable
	 */
	public function orgnk_teams_cpt_admin_table_sortable( $columns ) {
		$columns['menu_order'] = 'menu_order';
		return $columns;
	}

	/**
	 * orgnk_teams_cpt_posts_admin_table_column()
	 * Register new author column in admin list view and remove the default one
	 */
	function orgnk_teams_cpt_posts_admin_table_column( $defaults ) {
			
		$columns = array();

		foreach( $defaults as $key => $value ) {
			// When we find the date column, slip in the new column before it
			if ( $key == 'author' ) {
				$columns['staff_author'] = 'Author';
			}
			$columns[$key] = $value;
		}
		unset($columns['author']); // Remove the default author column
		return $columns;
	}

	/**
	 * orgnk_teams_cpt_posts_admin_table_content()
	 * Return the author meta for the new admin list view column for each post
	 */
	function orgnk_teams_cpt_posts_admin_table_content( $column_name, $post_id ) {
				
		global $post;
		$author_id = esc_html( get_post_meta( $post_id, 'post_team_author', true ) );

		if ( $column_name == 'staff_author' ) {
			if ( $author_id ) {
				echo esc_html( get_the_title( $author_id ) );
			} else {
				echo '—';
			}
		}
	}

	/**
	 * orgnk_teams_cpt_archive_query()
	 * Change the number of 'posts per page' for the CPT archive
	 */
	public function orgnk_teams_cpt_archive_query( $query ) {

		if ( $query->is_post_type_archive( ORGNK_TEAMS_CPT_NAME ) && ! is_admin() && $query->is_main_query() ) {
			$query->set( 'posts_per_page', '-1' ); // No limit so display all
		}

		return $query;
	}

	/**
	 * orgnk_teams_cpt_schema_head()
	 * Add Event schema to the document head if viewing a single event post
	 */
	public function orgnk_teams_cpt_schema_head() {

		$schema_script = NULL;

		// Prevent the schema function from running on every page
		if ( is_singular( ORGNK_TEAMS_CPT_NAME ) ) {
			$schema_script = orgnk_single_team_schema();
		}

		echo $schema_script;
	}
}
