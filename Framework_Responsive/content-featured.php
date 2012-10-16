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

global $feature_class;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $feature_class ); ?>>
	<header class="entry-header">
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'afterburner' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

		<div class="entry-meta">
			<?php afterburner_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'afterburner' ) . '</span>', 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'afterburner' ) );
			if ( '' != $tag_list ) {
				$utility_text = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'afterburner' );
			} else {
				$utility_text = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'afterburner' );
			}
			printf(
				$utility_text,
				/* translators: used between list items, there is a space after the comma */
				get_the_category_list( __( ', ', 'afterburner' ) ),
				$tag_list,
				esc_url( get_permalink() ),
				the_title_attribute( 'echo=0' )
			);
		?>

		<?php edit_post_link( __( 'Edit', 'afterburner' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
