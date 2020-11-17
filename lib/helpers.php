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
