<?php
/**
 * orgnk_single_team_schema()
 * Generates person schema script for outputting in the document head
 */
function orgnk_single_team_schema() {

    $schema = NULL;
    $sub_schema = array();

    if ( is_singular( ORGNK_TEAMS_CPT_NAME ) ) {

        // Post variables
        $name = esc_html( get_the_title() );
        $permalink = esc_url( get_the_permalink() );
        $image = esc_url( get_the_post_thumbnail_url( get_the_ID(), 'full' ) );
        $position = esc_html( get_post_meta( orgnk_get_the_ID(), 'team_member_position', true ) );
        $phone = esc_html( get_post_meta( orgnk_get_the_ID(), 'team_member_phone', true ) );
        $email = sanitize_email( get_post_meta( orgnk_get_the_ID(), 'team_member_email', true ) );

        $sub_schema = array(
            'name' 			    => $name,
            'url'               => $permalink
        );

        if ( $position ) {
            $sub_schema['jobTitle'] = $position;
        }

        if ( has_post_thumbnail( get_the_ID() ) ) {
            $sub_schema['image'] = $image;
        }

        if ( $email ) {
            $sub_schema['email'] = 'mailto:' . $email;
        }

        if ( $phone ) {
            if ( function_exists( 'orgnk_format_phone_link' ) ) {
                $sub_schema['telephone'] = orgnk_format_phone_link( $phone );
            } else {
                $sub_schema['telephone'] = $phone;
            }
        }

        // Check if anything has been stored for output
		if ( $sub_schema ) {

            $schema = array(
                '@context'  		=> 'http://schema.org',
                '@type'             => 'Person',
            );

            $schema = array_merge( $schema, $sub_schema );
        }

        // Finally, check if there is any compiled schema to return
        if ( $schema ) {
            return '<script type="application/ld+json" class="organik-person-schema">' . json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>';
        }
    }
}
