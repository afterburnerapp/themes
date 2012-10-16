<?php
/*
Template Name: Home Page
Do not modify any text above this line
*/
/*

 * @package WordPress
 * @subpackage Afterburner Theme

 This theme was created with the Afterburner application, and fast and reliable tool to prototype themes with full control over CSS styles, fonts and layout. 
 Create up to 10 custom daughter page templates and publish your themes for distribution. Learn more at: 
 
 http://www.afterburberapp.com

 All php code in themes published with the Afterburner application is protected under the GPL license.
 
 Afterburner is a Hotware® LLC Company.

 This software is provided "as is" and any expressed or implied warranties, including, but not limited to, the implied warranties of merchantability and 
 fitness for a particular purpose are disclaimed. in no event shall the regents or contributors be liable for any direct, indirect, incidental, special,
 exemplary, or consequential damages (including, but not limited to, procurement of substitute goods or services; loss of use, data, or profits; or 
 business interruption) however caused and on any theory of liability, whether in contract, strict liability, or tort (including negligence or otherwise) 
 arising in any way out of the use of this software, even if advised of the possibility of such damage.


*/



$abrn_options=get_option('abrn_options');
global $hmobile;
include("mobile_detect.php");


?>

<!DOCTYPE html>

<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html <?php language_attributes(); ?> class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=1100" /> 
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
<!--[if gte IE 8]>
<link rel="stylesheet" media="all" href="<?php echo get_template_directory_uri(); ?>/css/html5.css" />
<![endif]-->
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
<?php wp_enqueue_script('jquery'); //wp native necc?  ?>


<?php 
	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
<!-- Rotator -->
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.cycle.all.2.99.js"></script>

<!-- Drop Menu -->
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/dropmenu.js" ></script>

<!-- Font Replacement -->
<?php 	
	if($abrn_options['abrn_embed_google_fonts']!=""){
		echo($abrn_options['abrn_embed_google_fonts']);
	}
	
	if($abrn_options['afterburner_typekit']!=""){
	echo($abrn_options['afterburner_typekit']);
	}
	?>


</head>	



<body <?php body_class($class); ?>>
<div id="page" class="hfeed">

<!--[if lte IE 8 ]>
<noscript><strong>JavaScript is required for this website to be displayed correctly. Please enable JavaScript before continuing...</strong></noscript>
<![endif]-->
    <header id="branding" role="banner" >
   
    <?php get_template_part( 'topbar','default'); ?>
	 <div id="abrn_next" style="cursor: pointer"></div>
        <div id="abrn_prev" style="cursor: pointer"></div>
		
<?php get_template_part( 'menu','home'); ?>
  
  	<!-- Menu Above Header -->  
    </div><!-- close topbar -->
   		
	 <?php get_template_part('slider','default'); ?>  


     <!-- Menu Below Header -->  

  	</header>
    
    
	<div style="clear:both"></div>
    <div class="wrapper">

  				<div id="content" role="main"><?php get_template_part( 'content', 'page' ); ?></div>

	

 
  <div class="line"></div> <!-- clear any floats -->
	
   
    
    <?php get_footer(); ?>