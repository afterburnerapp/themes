<?php
/*

 * @package WordPress
 * @subpackage Afterburner Theme
 
 * All graphics, images, PHP code, Javascript code and content for the Afterburner Application are protected and 
 * licensed under the Afterburner Developer Licensing Agreement which can be found here: http://www.afterburnerapp.com/Afterburner_Developer_License.pdf.
 * Themes published with the Afterburner Application are licensed under the GPL license found here: http://www.gnu.org/licenses/gpl.html 
 * Copyright Hotware(R) LLC 2011 
 
 * Afterburner is a Hotware® LLC Company.
 
 This software is provided "as is" and any expressed or implied warranties, including, but not limited to, the implied warranties of merchantability and 
 fitness for a particular purpose are disclaimed. in no event shall the regents or contributors be liable for any direct, indirect, incidental, special,
 exemplary, or consequential damages (including, but not limited to, procurement of substitute goods or services; loss of use, data, or profits; or 
 business interruption) however caused and on any theory of liability, whether in contract, strict liability, or tort (including negligence or otherwise) 
 arising in any way out of the use of this software, even if advised of the possibility of such damage.

*/
?>
<?php while ( have_posts() ) : the_post(); ?>
    <nav id="nav-single">
        <h3 class="assistive-text"><?php _e( 'Post navigation', 'afterburner' ); ?></h3>
        <span class="nav-previous"><?php previous_post_link( '%link', __( '<span class="meta-nav">&larr;</span> Previous', 'afterburner' ) ); ?></span>
        <span class="nav-next"><?php next_post_link( '%link', __( 'Next <span class="meta-nav">&rarr;</span>', 'afterburner' ) ); ?></span>
    </nav><!-- #nav-single -->
    <div style="clear:both; height:20px"></div>
    <?php  
		 	if ( has_post_thumbnail() )  // check if the post has a Post Thumbnail assigned to it.
		$abrn_gallery_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
        
        
           			<?php if ($post_num==0 && $abrn_gallery_img!="") { ?><img style="width:100%; height:auto; max-width:400px" class="img_shadow" src="<?php echo $abrn_gallery_img[0]; ?>" /><?php } $post_num++; ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="calbox">
                        <?php $abrn_date=strtoupper(the_date( 'M d Y',NULL,NULL,FALSE )); ?> 
                        <p class="abrn_cal1"><?php echo(substr($abrn_date,0,6 ))?></p>
                            <p class="abrn_cal2"><?php echo(substr($abrn_date,7,4)) ?></p>
                        </div>
                        <div class="title_cal">
                            <h3 class="storytitle"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                            <div class="meta">
                                <?php _e("Filed under:",'afterburner'); ?> <?php the_category(',') ?> &#8212; <?php the_tags(__('Tags: ','afterburner'), ', ', ' &#8212; '); ?> <?php the_author() ?> @ <?php the_time() ?> <?php edit_post_link(__('Edit This','afterburner')); ?>
                            </div>
                        </div>
                        <div class="title_clear"></div>
    
        <div class="entry-content">
            <?php the_content(); ?>
            <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'afterburner' ) . '</span>', 'after' => '</div>' ) ); ?>
        </div><!-- .entry-content -->
    
        <footer class="entry-meta">
            <?php
                /* translators: used between list items, there is a space after the comma */
                $categories_list = get_the_category_list( __( ', ', 'afterburner' ) );
    
                /* translators: used between list items, there is a space after the comma */
                $tag_list = get_the_tag_list( '', __( ', ', 'afterburner' ) );
                if ( '' != $tag_list ) {
                    $utility_text = __( 'This entry was posted in %1$s and tagged %2$s by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'afterburner' );
                } elseif ( '' != $categories_list ) {
                    $utility_text = __( 'This entry was posted in %1$s by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'afterburner' );
                } else {
                    $utility_text = __( 'This entry was posted by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'afterburner' );
                }
    
                printf(
                    $utility_text,
                    $categories_list,
                    $tag_list,
                    esc_url( get_permalink() ),
                    the_title_attribute( 'echo=0' ),
                    get_the_author(),
                    esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )
                );
            ?>
            <?php edit_post_link( __( 'Edit', 'afterburner' ), '<span class="edit-link">', '</span>' ); ?>
    
            <?php if ( get_the_author_meta( 'description' ) && is_multi_author() ) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries ?>
            <div id="author-info">
                <div id="author-avatar">
                    <?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentyeleven_author_bio_avatar_size', 68 ) ); ?>
                </div><!-- #author-avatar -->
                <div id="author-description">
                    <h2><?php printf( esc_attr__( 'About %s', 'afterburner' ), get_the_author() ); ?></h2>
                    <?php the_author_meta( 'description' ); ?>
                    <div id="author-link">
                        <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
                            <?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'afterburner' ), get_the_author() ); ?>
                        </a>
                    </div><!-- #author-link	-->
                </div><!-- #author-description -->
            </div><!-- #entry-author-info -->
            <?php endif; ?>
        </footer><!-- .entry-meta -->
    </article><!-- #post-<?php the_ID(); ?> -->
    <?php comments_template( '', true ); ?>
<?php endwhile; // end of the loop. ?>
