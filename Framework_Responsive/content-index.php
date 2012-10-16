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
<?php $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
$term = get_term_by('name', 'gallery', 'category');
query_posts("posts_per_page=5&paged=$page&cat=-".$term->term_id);	?>
<?php if ( have_posts() ) :
 	if ( has_post_thumbnail() )  // check if the post has a Post Thumbnail assigned to it.
		$abrn_gallery_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
	 ?>

				

				<?php /* Start the Loop */ $post_num=0;?>
                
               
				<?php while ( have_posts() ) : the_post(); ?>
           			<?php if ($post_num==0 && $abrn_gallery_img!="") { ?><img style="width:100%; height:auto; max-width:400px" class="img_shadow" src="<?php echo $abrn_gallery_img[0]; ?>" /><?php } $post_num++; ?>

					<?php   get_template_part( 'content', get_post_format() ); ?>

				<?php endwhile; ?>

				<?php afterburner_content_nav( 'nav-below' ); ?>

			<?php else : ?>

			<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'afterburner' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'afterburner' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>