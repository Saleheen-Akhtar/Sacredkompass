<?php
get_header();

if ( have_posts() ) :
  while ( have_posts() ) : the_post();

    // Loop through Flexible Content
    if ( have_rows('page_sections') ) :
      while ( have_rows('page_sections') ) : the_row();

        // Include the matching template part based on the layout name
        get_template_part( 'template-parts/blocks/' . get_row_layout() );

      endwhile;
    endif;

  endwhile;
endif;

get_footer();
?>
