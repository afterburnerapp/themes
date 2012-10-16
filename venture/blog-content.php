<?php
//echo('<div id="content" role="main">');
//query_posts();

$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
query_posts("posts_per_page=5&paged=$page");	
	 if (have_posts()) : while (have_posts()) : the_post(); ?>
	  				<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
		 				
                        <div class="calbox">
                            <?php $abrn_date=strtoupper(the_date( 'M d Y',NULL,NULL,FALSE )); ?> <p class="abrn_cal1"><?php echo(substr($abrn_date,0,6 ))?></p>
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
							<?php the_content(__('(more...)','afterburner')); ?>
						</div>
						<?php get_template_part( 'social_media' ); ?>
                    
                        <div class="feedback">
                            <?php wp_link_pages(); ?>
                            <?php comments_popup_link(__('Comments (0)','afterburner'), __('Comments (1)','afterburner'), __('Comments (%)','afterburner')); ?>
                        </div>
        
					</div><!-- End Posts-->
			
					<?php comments_template(); // Get wp-comments.php template ?>	
					<?php endwhile; else: ?>
					<?php _e('<p>We are sorry there is no page at this address.</p>','afterburner'); ?>
					<?php endif; ?>	
					<?php posts_nav_link(' &#8212; ', __('&laquo; Newer Posts','afterburner'), __('Older Posts &raquo;','afterburner')); 
	//echo('</div>');
				?>