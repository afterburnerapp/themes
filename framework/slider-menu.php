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
$abrn_options=get_option('abrn_options');
?>
 <div style="clear:both; position:relative;">
 <hgroup>
            <?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div';  if($abrn_options['abrn_logo_image_type']==".jpg") $ityp=".jpg"; if($abrn_options['abrn_logo_image_type']==".png") $ityp=".png";  if($abrn_options['abrn_logo_image_type']==".gif") $ityp=".gif";?>
            <<?php echo $heading_tag; ?> id="site-title"><a class="logo_pos" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo get_template_directory_uri(); ?>/images/logo<?php echo($ityp); ?>" alt="<?php bloginfo( 'name' ); ?>"></a></<?php echo $heading_tag; ?>>
        </hgroup>        
    
    <nav role="navigation">
            <div class="skip-link screen-reader-text"><a href="#content" title="Skip to content">Skip to content</a></div>
            <div id="centeredmenu"><?php echo(mytheme_nav("dropmenu",0)); ?></div>
        </nav><!-- nav --> 
        </div>
 <?php 
 	if($abrn_options['afterburner_header_options']=="custom") {
		$post_id = $abrn_options['abrn_header'];
		$queried_post = get_post($post_id);
		echo $queried_post->post_content; 
	}
	else {
		echo("<div id='slider'>");
	
		for($i=1; $i<=$abrn_options['abrn_number_of_slides']; $i++){
			
		
			$ityp=$abrn_options['abrn_slide'.$i.'_image_type'];
			$link_str='afterburner_link'.$i.'_number';
			$link=$abrn_options[$link_str];
			$filename=get_bloginfo('template_url')."/images/header_image_".$i.$ityp;
			if($link!='')
			echo("<a class='setheight' href='".$link."'>");	
			echo("<img src='".$filename."'/>");
			if($link!='')
			echo("</a>");
			if($abrn_options['afterburner_anim']=="no")
				break;
		
		}
		
		
		echo("</div>");
		
		if($abrn_options['afterburner_anim']=="yes") { 
		
		if($abrn_options['afterburner_anim_buttons']=="yes" && $abrn_options['afterburner_header_options']!="none"){?>
        <div style="width:960px; margin:0 auto 0 auto; height:0px">
		<div id="abrn_next" style="cursor: pointer"></div>
        <div id="abrn_prev" style="cursor: pointer"></div>	
        </div>
         <div id="caption"></div>			
		<?php } ?>
        
        <script type="text/javascript" >
		
		jQuery('.setheight').css('height',jQuery('#slider').css('height'));
		
		
		
        jQuery('#slider').cycle({ 
	
	timeout: <?php if($abrn_options['afterburner_anim']=="no"){echo("0");} else {echo($abrn_options['afterburner_anim_speed']);} ?>, 
    speed: <?php echo($abrn_options['afterburner_anim_trans_speed']);?>,
	fx: '<?php echo($abrn_options['afterburner_anim_transition']);?>',
	height: 'auto'
	<?php if($abrn_options['afterburner_anim_pause']=='yes') echo(",\npause: true"); ?>	
		<?php if($abrn_options['afterburner_anim_buttons']=="yes") {?>,
		 rev:     1,
	    prev:   '#abrn_prev',
    	next:   '#abrn_next'
    	
    <?php } ?>
	
}); 

</script>

<?php } 
	}?>