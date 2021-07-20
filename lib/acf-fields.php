<?php
/**
 * Main Organik_Teams_ACF_Fields class
 */
class Organik_Teams_ACF_Fields {

	/**
     * Constructor function
     */
	public function __construct() {

		// Hook into the 'init' action to add the ACF fields
		add_filter( 'init', array( $this, 'orgnk_teams_cpt_acf_fields' ) );
	}

	/**
	 * orgnk_teams_cpt_acf_fields()
	 * Manually insert ACF fields for this CPT
	 */
	public function orgnk_teams_cpt_acf_fields() {

		// Return early if ACF or the CPT isn't active
		if ( ! class_exists( 'ACF' ) || ! function_exists( 'acf_add_local_field_group' ) || ! defined( 'ORGNK_TEAMS_CPT_NAME' ) || ! is_admin() ) return;

		// Field Group - Single Team Member Settings
		acf_add_local_field_group( array(
			'key'				=> 'group_5f7ae0980dfb1',
			'title'				=> 'Single Team Member Settings',
			'fields'			=> array(

				// Field - Team Member Position - Text
				array(
					'key'				=> 'field_5f7ae0e04d71a',
					'label'				=> 'Position',
					'name'				=> 'team_member_position',
					'type'				=> 'text',
					'instructions'		=> '',
					'required'			=> 0,
					'conditional_logic'	=> 0,
					'wrapper'			=> array(
						'width'				=> '',
						'class'				=> '',
						'id'				=> '',
					),
					'default_value'		=> '',
					'placeholder'		=> '',
					'prepend'			=> '',
					'append'			=> '',
					'maxlength'			=> '',
				),

				// Field - Team Member Department - Text
				array(
					'key'				=> 'field_5fa26c77d626f',
					'label'				=> 'Department',
					'name'				=> 'team_member_department',
					'type'				=> 'text',
					'instructions'		=> '',
					'required'			=> 0,
					'conditional_logic'	=> 0,
					'wrapper'			=> array(
						'width'				=> '',
						'class'				=> '',
						'id'				=> '',
					),
					'default_value'		=> '',
					'placeholder'		=> '',
					'prepend'			=> '',
					'append'			=> '',
					'maxlength'			=> '',
				),

				// Field - Team Member Phone - Text
				array(
					'key'				=> 'field_5f7ae0ed4d71b',
					'label'				=> 'Phone',
					'name'				=> 'team_member_phone',
					'type'				=> 'text',
					'instructions'		=> '',
					'required'			=> 0,
					'conditional_logic'	=> 0,
					'wrapper'				=> array(
						'width'				=> '',
						'class'				=> '',
						'id'				=> '',
					),
					'default_value'		=> '',
					'placeholder'		=> '',
					'prepend'			=> '',
					'append'			=> '',
					'maxlength'			=> '',
				),

				// Field - Team Member Email - Text
				array(
					'key'				=> 'field_5f7ae1294d71d',
					'label'				=> 'Email',
					'name'				=> 'team_member_email',
					'type'				=> 'email',
					'instructions'		=> '',
					'required'			=> 0,
					'conditional_logic'	=> 0,
					'wrapper'				=> array(
						'width'				=> '',
						'class'				=> '',
						'id'				=> '',
					),
					'default_value'		=> '',
					'placeholder'		=> '',
					'prepend'			=> '',
					'append'			=> '',
				),
			),

			// Location Rules - Single Team Member
			'location'					=> array(
				array(
					array(
						'param'					=> 'post_type',
						'operator'				=> '==',
						'value'					=> ORGNK_TEAMS_CPT_NAME,
					),
				),
			),
			'menu_order'				=> 0,
			'position'					=> 'acf_after_title',
			'style'						=> 'default',
			'label_placement'			=> 'left',
			'instruction_placement'		=> 'label',
			'hide_on_screen'			=> '',
			'active'					=> true,
			'description'				=> '',
		));

		// Field Group - Team Memnber Settings
		acf_add_local_field_group( array(
			'key' 				=> 'group_6007c87692eed',
			'title' 			=> 'Team Members Settings',
			'fields' 			=> array(

				// Field - Enable Archive - True/False
				array(
					'key'				=> 'field_6007c8fffa51e',
					'label'				=> 'Enable Archive',
					'name'				=> 'team_members_enable_archive',
					'type'				=> 'true_false',
					'instructions'		=> 'Turning off this setting will disable both the archive and single for this post type. <strong>Flush permalinks when changing this setting.</strong>',
					'required'			=> 0,
					'conditional_logic'	=> 0,
					'wrapper'			=> array(
						'width'				=> '',
						'class'				=> '',
						'id'				=> '',
					),
					'message' 			=> '',
					'default_value'		=> 1,
					'ui'				=> 1,
					'ui_on_text'		=> 'On',
					'ui_off_text'		=> 'Off',
				),
			),

			// Location Rules - Team Members Settings Page
			'location' => array(
				array(
					array(
						'param'					=> 'options_page',
						'operator'				=> '==',
						'value'					=> ORGNK_TEAMS_CPT_NAME . '-settings',
					),
				),
			),

			// Field Group Settings
			'menu_order'				=> 0,
			'position'					=> 'normal',
			'style'						=> 'seamless',
			'label_placement'			=> 'left',
			'instruction_placement'		=> 'label',
			'hide_on_screen'			=> '',
			'active'					=> true,
			'description'				=> '',
		));

		// Field Group - Post Author
		acf_add_local_field_group( array(
			'key'				=> 'group_5f894b45452da',
			'title'				=> 'Post Author',
			'fields'			=> array(

				// Field - Author - Post Object
				array(
					'key'				=> 'field_5f894b57d2989',
					'label'				=> 'Author',
					'name'				=> 'entry_team_author',
					'type'				=> 'post_object',
					'instructions'		=> '',
					'required'			=> 0,
					'conditional_logic'	=> 0,
					'wrapper'			=> array(
						'width'				=> '',
						'class'				=> '',
						'id'				=> '',
					),
					'post_type'			=> array(
						0 					=> 'team',
					),
					'taxonomy'			=> '',
					'allow_null'		=> 1,
					'multiple'			=> 0,
					'return_format'		=> 'id',
					'ui'				=> 1,
				),
			),

			// Location Rules - Single Post
			'location' => array(
				array(
					array(
						'param'					=> 'post_type',
						'operator'				=> '==',
						'value'					=> 'post',
					),
				),
			),
			'menu_order'				=> 14,
			'position'					=> 'side',
			'style'						=> 'default',
			'label_placement'			=> 'top',
			'instruction_placement'		=> 'label',
			'hide_on_screen'			=> '',
			'active'					=> true,
			'description'				=> '',
		));
	}
}
