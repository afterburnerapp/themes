<?php
		if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php if($abrn_options['afterburner_show_title']=="yes") { ?>
                <header class="entry-header">
                   
                <?php if ( is_front_page()  =="yes") { ?>
                    <h2 class="entry-title"><?php the_title(); ?></h2>
                <?php } else { ?>
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                <?php } ?>
                </header><?php 
				} ?>
                <div class="entry-content">
                    <?php the_content(); ?>
                    <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'pressforce' ), 'after' => '</div>' ) ); ?>
                    <?php edit_post_link( __( 'Edit', 'pressforce' ), '<span class="edit-link">', '</span>' ); ?>
                </div><!-- entry-content -->
            </article><!-- #post-## -->
            <?php if($abrn_options['afterburner_show_comments']=="yes")comments_template( '', true ); ?>
    <?php endwhile; 
