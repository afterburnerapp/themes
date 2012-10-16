<?php
/*
Template Name: Gallery
Do not modify any text above this line
*/
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

get_header(); ?>
<body <?php if(!is_front_page())echo("class=\"daughter_background\""); ?>>

<?php
$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
$term = get_term_by('name', 'gallery', 'category');
query_posts("posts_per_page=12&paged=$page&cat=".$term->term_id);	?>


<!--[if lte IE 8 ]>
<noscript><strong>JavaScript is required for this website to be displayed correctly. Please enable JavaScript before continuing...</strong></noscript>
<![endif]-->
<div style="padding:0; margin: 4% 0 2% 0">

<?php
	if (have_posts()) : while (have_posts()) : the_post(); ?>
    
    <div class="abrn_gallery" >
        
        <?php 
		if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
		$abrn_gallery_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
		
		
echo('<div  class="abrn_gallery2 img_shadow" ><div class="abrn_gall_inner" ><img src="'.$abrn_gallery_img[0].'" width="400px" height="auto" /></div></div>');
			
		}?>
        
		<h3 style="margin:.2em 0 .2em 0"><?php the_title(); ?></h3>
        
<?php 	$abrn_gallery_str=preg_replace('/\s+?(\S+)?$/', '', substr(get_the_content() . ' ', 0, 150));
		
		
		echo("<div class='abrn_gallery_text' style='width:221px; margin-left:20px; text-align:left'>".$abrn_gallery_str); 
		
		if(strlen($abrn_gallery_str)<strlen(get_the_content()))
			echo("<a href='".get_permalink()."' >more...</a>"); 
    	echo("</div>");
 ?>
 	<a href='<?php echo(get_permalink()) ?>' >
    <img src='<?php echo(get_template_directory_uri()."/images/view-image.png") ?> ' class='view_img_button'/>
    </a>
    
    </div>
    <!-- End Posts-->

    <?php endwhile; else: ?>
    <?php _e('<p>We are sorry there is no page at this address.</p>','afterburner'); ?>
    <?php endif; ?>					

</div>
<div class="line"></div>

 
<?php get_footer(); ?>
		


