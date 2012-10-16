<?php
/**
Template Name: Afterburner Blog Alt
*
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
get_header();  

$abrn_options=get_option('abrn_options');?>

<?php
$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
$term = get_term_by('name', 'gallery', 'category');
query_posts("posts_per_page=5&paged=$page&cat=-".$term->term_id);	?>

<?php 
	if($abrn_options['afterburner_daughter_content1']=="content"){ 
		echo('<div id="primary">
				<div id="content" role="main">');
		$post_num=0;
		 if (have_posts()) : while (have_posts()) : the_post(); 
		 	if ( has_post_thumbnail() )  // check if the post has a Post Thumbnail assigned to it.
		$abrn_gallery_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
	
	?>   
         			<?php if ($post_num==0 && !empty($abrn_gallery_img ) && $abrn_gallery_img!="") { ?><img  src="<?php echo $abrn_gallery_img[0]; ?>" class="img_shadow" /><?php }  ?>
                    
	  				<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
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
						<div class="storycontent">
							<?php if($post_num==0) the_content(__('(more...)','afterburner')); else the_excerpt(); ?>
						</div>
						<?php if($post_num==0) { get_template_part( 'social_media' ); ?>
                    
                        <div class="feedback">
                            <?php wp_link_pages(); ?>
                            <?php comments_popup_link(__('Comments (0)','afterburner'), __('Comments (1)','afterburner'), __('Comments (%)','afterburner')); ?>
                        </div>
        
						<? } ;$post_num++?>
        
					</div><!-- End Posts-->
			
					<?php comments_template(); // Get wp-comments.php template ?>	
					<?php endwhile; else: ?>
					<?php _e('<p>We are sorry there is no page at this address.</p>','afterburner'); ?>
					<?php endif; ?>	
					<?php posts_nav_link(' &#8212; ', __('&laquo; Newer Posts','afterburner'), __('Older Posts &raquo;','afterburner')); 
	echo('</div>
				</div>');
	}
	if($abrn_options['afterburner_daughter_content1']=="sidebar-secondary"){
		get_sidebar('secondary');
	}
	if($abrn_options['afterburner_daughter_content1']=="sidebar-primary"){
		get_sidebar('primary');
	}
	if($abrn_options['afterburner_daughter_content1']=="custom"){
		$post_id = $abrn_options['abrn_Daughter'];
		$queried_post = get_post($post_id);
		?>
		<h2><?php echo $queried_post->post_title; ?></h2>
		<?php echo $queried_post->post_content; 
	
	}
	
	

if($abrn_options['afterburner_layout_daughter']>=2) {
	
	
	if($abrn_options['afterburner_daughter_content2']=="content"){ 
	echo('<div id="primary">
				<div id="content" role="main">');
		 if (have_posts()) : while (have_posts()) : the_post(); ?>
         			<?php if ($post_num==0 && $abrn_gallery_img!="") { ?><img  src="<?php $abrn_gallery_img[0] ?>" /><?php } ?>

	  				<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
		 				<h3 class="storytitle"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
						<div class="meta">
							<?php _e("Filed under:",'afterburner'); ?> <?php the_category(',') ?> &#8212; <?php the_tags(__('Tags: ','afterburner'), ', ', ' &#8212; '); ?> <?php the_author() ?> @ <?php the_time() ?> <?php edit_post_link(__('Edit This','afterburner')); ;?>
                        </div>
						<div class="storycontent">
<?php if($post_num==0) the_content(__('(more...)','afterburner')); else the_excerpt();?>						</div>
						 <?php if($post_num==0) { get_template_part( 'social_media' );?>
                    
                        <div class="feedback">
                            <?php wp_link_pages(); ?>
                            <?php comments_popup_link(__('Comments (0)','afterburner'), __('Comments (1)','afterburner'), __('Comments (%)','afterburner')); ?>
                        </div>
        
						<? } ;$post_num++?>
        
					</div><!-- End Posts-->
			
					<?php comments_template(); // Get wp-comments.php template ?>	
					<?php endwhile; else: ?>
					<?php _e('<p>We are sorry there is no page at this address.</p>','afterburner'); ?>
					<?php endif; ?>	
					<?php posts_nav_link(' &#8212; ', __('&laquo; Newer Posts','afterburner'), __('Older Posts &raquo;','afterburner')); 
	echo('</div>
				</div>');
	}
	if($abrn_options['afterburner_daughter_content2']=="sidebar-secondary"){
		get_sidebar('secondary');
	}
	if($abrn_options['afterburner_daughter_content2']=="sidebar-primary"){
		get_sidebar('primary');
	}
	if($abrn_options['afterburner_daughter_content2']=="custom"){
		$post_id = $abrn_options['abrn_Daughter'];
		$queried_post = get_post($post_id);
		?>
		<h2><?php echo $queried_post->post_title; ?></h2>
		<?php echo $queried_post->post_content; 
	}
	
	
}
if($abrn_options['afterburner_layout_daughter']==3){
	
	if($abrn_options['afterburner_daughter_content3']=="content"){ 
	echo('<div id="primary">
				<div id="content" role="main">');
		 if (have_posts()) : while (have_posts()) : the_post(); ?>
         			<?php if ($post_num==0 && $abrn_gallery_img!="") { ?><img  src="<?php $abrn_gallery_img[0] ?>" /><?php } ?>

	  				<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
		 				<h3 class="storytitle"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h3>
						<div class="meta">
							<?php _e("Filed under:",'afterburner'); ?> <?php the_category(',') ?> &#8212; <?php the_tags(__('Tags: ','afterburner'), ', ', ' &#8212; '); ?> <?php the_author() ?> @ <?php the_time() ?> <?php edit_post_link(__('Edit This','afterburner'));?>
                        </div>
						<div class="storycontent">
<?php if($post_num==0) the_content(__('(more...)','afterburner')); else the_excerpt(); $post_num++?>						</div>
						 <?php if($post_num==0) { get_template_part( 'social_media' ) ?>
                    
                        <div class="feedback">
                            <?php wp_link_pages(); ?>
                            <?php comments_popup_link(__('Comments (0)','afterburner'), __('Comments (1)','afterburner'), __('Comments (%)','afterburner')); ?>
                        </div>
						
						<? } ;$post_num++?>
        
					</div><!-- End Posts-->
			
					<?php comments_template(); // Get wp-comments.php template ?>	
					<?php endwhile; else: ?>
					<?php _e('<p>We are sorry there is no page at this address.</p>','afterburner'); ?>
					<?php endif; ?>	
					<?php posts_nav_link(' &#8212; ', __('&laquo; Newer Posts','afterburner'), __('Older Posts &raquo;','afterburner')); 
	echo('</div>
				</div>');
	}
	if($abrn_options['afterburner_daughter_content3']=="sidebar-secondary"){
		get_sidebar('secondary');
	}
	if($abrn_options['afterburner_daughter_content3']=="sidebar-primary"){
		get_sidebar('primary');
	}
	if($abrn_options['afterburner_daughter_content3']=="custom"){
		$post_id = $abrn_options['abrn_Daughter'];
		$queried_post = get_post($post_id);
		?>
		<h2><?php echo $queried_post->post_title; ?></h2>
		<?php echo $queried_post->post_content; 
	}
	

}
?>

        
   
    
     <div class="line"></div> 
    
     <?php get_footer(); ?>
		


