<?php
/**
Template Name: Afterburner Blog Grid
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




global $hmobile;

	$hmobile=0;
include("mobile_detect.php");
$abrn_options=get_option('abrn_options');

?>

<!DOCTYPE html>
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html <?php language_attributes(); ?> class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<!-- <meta name="viewport" content="width=1100" /> -->

<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'afterburner' ), max( $paged, $page ) );

	?></title>
    
<!-- <link rel="profile" href="http://gmpg.org/xfn/11" /> Not needed as per WP codex: "Wholly HTML 5 themes must not have the profile, as HTML 5 does not support it."-->

<!-- Main CSS -->
<link rel="stylesheet" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="stylesheet" media="all" href="<?php echo get_template_directory_uri(); ?>/afterburner.css" />

<link rel="stylesheet" media="all" href="<?php echo get_template_directory_uri(); ?>/afterburner_responsive.css" />



<!-- Pingback -->
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
?>

<!-- JQuery -->
<?php //wp_enqueue_script('jquery'); //wp native necc?  ?>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.min.js"></script>

<!-- Rotator -->
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.cycle.all.2.99.js"></script>

<!-- Drop Menu -->
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/dropmenu.js" ></script>

<!-- Font Replacement -->
<?php 	
	if(get_option('abrn_embed_google_fonts')!=""){
		echo(get_option('abrn_embed_google_fonts'));
	}
	
	if(get_option('afterburner_typekit')!=""){
	echo(get_option('afterburner_typekit'));
	}
	?>



<?php 
	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>

<script type="text/javascript">
//ipad and iphone fix

if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i))) {
    $(".first").bind('touchstart', function(){
        console.log("touch started");
    });

</script>
</head>	

<body>

<div id="page" class="hfeed">
<!--[if lte IE 8 ]>
<noscript><strong>JavaScript is required for this website to be displayed correctly. Please enable JavaScript before continuing...</strong></noscript>
<![endif]-->
<header id="branding" role="banner">
    

        <hgroup>
            <?php  if($abrn_options['abrn_logo_image_type']==".jpg") $ityp=".jpg"; if($abrn_options['abrn_logo_image_type']==".png") $ityp=".png";  if($abrn_options['abrn_logo_image_type']==".gif") $ityp=".gif";?>
            <h1 id="site-title"><a class="logo_pos" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo get_template_directory_uri(); ?>/images/logo<?php echo($ityp); ?>" alt="<?php bloginfo( 'name' ); ?>"></a></h1>
        </hgroup>        
    
         
    
     
    <nav role="navigation">
            <div class="skip-link screen-reader-text"><a href="#content" title="Skip to content">Skip to content</a></div>
            <div id="centeredmenu"><?php echo(mytheme_nav("dropmenu",0)); ?></div>
            <div class="abrn_menu_bck">
</div>
        </nav><!-- nav --> 

   
      

</header>

<div style="clear:both;"></div>

         
		 <?php
$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
$term = get_term_by('name', 'gallery', 'category');
query_posts("posts_per_page=16&paged=$page&cat=".$term->term_id);	?>


<?php
	echo('<div style="width:100%; padding:0; margin:0 0 54px 0">');
	
		 if (have_posts()) : while (have_posts()) : the_post(); 
		 
		 	if ( has_post_thumbnail() )  // check if the post has a Post Thumbnail assigned to it.
				$abrn_gallery_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
	
				?>   	
         			
                <div class="abrn_top">
                    <div class="first">
                    	<a href="<?php the_permalink() ?>" ><img  src="<?php echo $abrn_gallery_img[0]; ?>" /></a>
                      <div class="grid_title">
					 <h1> <?php the_title() ?></h1>
                     <?php //the_excerpt(); ?>
                        </div>
                    </div>
                    <div class="second">
					<a href="<?php the_permalink() ?>" ><img  src="<?php echo $abrn_gallery_img[0]; ?>" /></a>
					<div class="grid_title_second">
					  <h1><?php the_title() ?></h1>
                      <?php the_excerpt(); ?>
                     <!--<p> <?php //$str=preg_replace('/\s+?(\S+)?$/', '', substr(get_the_content() . ' ', 0, 150));
//echo($str);if(strlen(get_the_content())>150) { ?>
	...</p><a href="<?  //the_permalink() ?>" >more &rarr;</a><?// } else {echo("</p>"); }?>
</span>-->
                        </div>
						</div>
                </div>
				<?php endwhile; else: ?>
				<?php _e('<p>We are sorry there is no page at this address.</p>','afterburner'); ?>
				<?php endif; ?>	
				
				<? 
	echo('</div>');
	
	
	
	
	

?>
<div style="clear:both"></div>
        
  <div style="float:left; padding:25px; "> <?php previous_posts_link('<img src="'.get_template_directory_uri().'/images/abrn_arrow_left.png" alt"next"/>') ?></div>
     
  <div style="float:right; padding:25px; "> <?php next_posts_link('<img src="'.get_template_directory_uri().'/images/abrn_arrow_right.png" alt"next"/>') ?></div>
    
     <div class="line"></div> 
    
     <?php get_footer(); ?>
		


