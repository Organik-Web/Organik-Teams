<?php
/**
 * orgnk_teams_author_avatar()
 * Outputs markup for a post author avatar and post meta using the assigned team member post
 */
function orgnk_teams_author_avatar( $name_size = 'h4' ) {

    $output = NULL;
    $author_id = esc_html( get_post_meta( get_the_ID(), 'entry_team_author', true ) );

    if ( $author_id ) {

        $name = esc_html( get_the_title( $author_id ) );
        $image = esc_url( get_the_post_thumbnail_url( $author_id, 'large' ) );
        $permalink = esc_url( get_permalink( $author_id ) );

        $output .= '<div class="orgnk-teams-author-avatar">';
            $output .= '<div class="author-image" style="background-image: url(' . $image . ');"><div class="ratio-sizer"></div></div>';
            $output .= '<div class="author-meta">';

                $output .= '<a class="author-link" href="' . $permalink . '" target="_self">';
                    $output .= '<span class="author-name ' . $name_size . '">' . $name . '</span>';
                $output .= '</a>';

                $output .= '<div class="post-attributes">';
                    $output .= '<span class="posted-on">' . get_the_date() . '</span>';
                    $output .= '<span class="posted-in"> in ' . get_the_term_list( get_the_ID(), 'category', '', ', ' ) . '</span>';
                $output .= '</div>';

            $output .= '</div>';
        $output .= '</div>';
    }

    return $output;
}



/**
 * orgnk_teams_entry_meta()
 * Generates a table of the team member's contact details
 */
function orgnk_teams_entry_meta( $heading_size = 'h3' ) {

	$output = '';

	// Variables
    $department     = esc_html( get_post_meta( orgnk_get_the_ID(), 'team_member_department', true ) );
    $phone          = esc_html( get_post_meta( orgnk_get_the_ID(), 'team_member_phone', true ) );
    $email          = sanitize_email( get_post_meta( orgnk_get_the_ID(), 'team_member_email', true ) );

	if ( $department || $phone || $email ) {

        $output .= '<div class="entry-meta entry-meta-table team-member-entry-meta">';

            $output .= '<div class="meta-table-header">';
            $output .= '<span class="title ' . $heading_size . '">Contact details</span>';
            $output .= '</div>';

            if ( $department ) {

                $output .= '<div class="meta-group department">';

                    $output .= '<div class="group-label">';
                        $output .= '<span class="label">Department</span>';
                    $output .= '</div>';

                    $output .= '<div class="group-content">';
                        $output .= $department;
                    $output .= '</div>';

                $output .= '</div>';
            }

            if ( $department ) {

                $output .= '<div class="meta-group phone">';

                    $output .= '<div class="group-label">';
                        $output .= '<span class="label">Phone</span>';
                    $output .= '</div>';

                    $output .= '<div class="group-content">';

                        if ( function_exists( 'orgnk_format_phone_link' ) ) {
                            $output .= '<a href="tel:' . orgnk_format_phone_link( $phone ) . '">' . $phone . '</a>';
                        } else {
                            $output .= $phone;
                        }

                    $output .= '</div>';

                $output .= '</div>';
            }

            if ( $email ) {

                $output .= '<div class="meta-group email">';

                    $output .= '<div class="group-label">';
                        $output .= '<span class="label">Email</span>';
                    $output .= '</div>';

                    $output .= '<div class="group-content">';
                        $output .= '<a href="mailto:' . $email . '">' . $email . '</a>';
                    $output .= '</div>';

                $output .= '</div>';
            }
        $output .= '</div>';
	}
	return $output;
}
