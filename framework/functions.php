<?php
/*

 * @package WordPress
 * @subpackage Afterburner Theme`
 
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

include('abrn-shortcodes.php');

set_user_setting( 'dfw_width', 1024 );



function wp_register_theme_deactivation_hook($code, $function) {
    // store function in code specific global
    $GLOBALS["wp_register_theme_deactivation_hook_function" . $code]=$function;
 
    // create a runtime function which will delete the option set while activation of this theme and will call deactivation function provided in $function
    $fn=create_function('$theme', ' call_user_func($GLOBALS["wp_register_theme_deactivation_hook_function' . $code . '"]); delete_option("theme_is_activated_' . $code. '");');
 
    // add above created function to switch_theme action hook. This hook gets called when admin changes the theme.
    // Due to wordpress core implementation this hook can only be received by currently active theme (which is going to be deactivated as admin has chosen another one.
    // Your theme can perceive this hook as a deactivation hook.)
    add_action("switch_theme", $fn);
}

function my_theme_deactivate() {
	
	delete_option('afterburner_install_var');
	delete_option('abrn_options');
	
	$mycustomposts = get_posts( array( 'post_type' => 'altcontent', 'numberposts' => 150) );
	
   foreach( $mycustomposts as $mypost ) {
	  
     wp_delete_post( $mypost->ID, true);
   }

wp_delete_post($abrn_options['Afterburner Home Page Editor'],true);
wp_delete_post($abrn_options['Afterburner Sub Page Editor'],true);
wp_delete_post($abrn_options['Afterburner Default Page Editor'],true);

	
}
 
$abrn_theme_name = wp_get_theme();
wp_register_theme_deactivation_hook($abrn_theme_name, 'my_theme_deactivate');

 
$TEMPLATE_DIR= get_template_directory_uri();
$TEMPLATE_DIR_LOCAL="../wp-content/themes/". get_template() ;
 
require_once(ABSPATH . 'wp-admin/includes/file.php');




/// GRAVATAR

add_filter( 'avatar_defaults', 'newgravatar' );

function newgravatar ($avatar_defaults) {
	$myavatar = get_template_directory_uri() . '/images/afterburner-gravatar.png';
	$avatar_defaults[$myavatar] = "Afterburner Avatar";
	return $avatar_defaults;
	}

/////////////////////////////////////   FIRST LOAD   ///////////////////////////////////// 

function abrn_first_load() {
	global $TEMPLATE_DIR;
	global $TEMPLATE_DIR_LOCAL;
 
	
		add_option('afterburner_install_var',0);
		
	if(get_option('afterburner_install_var')=='0')
	{
		//add_option('abrn_fl_editor_pref','home');
		
		if(!current_user_can('manage_options'))
			die('You are not authorized to edit options.');// not sdmin? Can not change or install theme
	
		$abrn_options=array();//set up options array
		
		//add_option('abrn_options',$abrn_options); //store options array
		
			
		update_option('afterburner_install_var','1');//update install var to 1 - User will then be prompted to install placeholder content - see custom options
				
				global $wp_filesystem;

		
		if ( ! WP_Filesystem($creds) ) {
			die("We are sorry, your installation does not meet the minimum requirements to run this product. See http://www.afterburnerapp.com/requirements");		
			//request_filesystem_credentials($url);
			return true;
		}
		
		
		$filename = $TEMPLATE_DIR_LOCAL .'/options.txt';
	
		
		if ( ! $options=$wp_filesystem->get_contents( $filename ) ) {
			die("(abrn load options) : options not loaded :".$filename);
		}
		
		$options_str=urldecode($options);
		$abrn_options=unserialize($options_str);
			
		//update_option('abrn_options',$abrn_options);
		update_option('abrn_options',$abrn_options);
		
		
	
	}
}






	

	
		/////////////////////////////////////  UTILITY   ///////////////////////////////////// 
		



/////////////////////////////////////   SHORTCODE   ///////////////////////////////////// 
add_shortcode( 'widget', 'shortbar_sc' );
add_action( 'init', 'ilc_register_sidebars');

function ilc_register_sidebars(){
    register_sidebar(array(
        'name' => 'Sidecode',
        'description' => 'Widgets in this area can be displayed in post contents using the shortcode [widget].',
        'before_title' => '<h1>',
        'after_title' => '</h1>',
        'before_widget' => '<div class="sidecode">',
        'after_widget' => '</div>'
    ));
}

function shortbar_sc( $atts ) {
    ob_start();
    dynamic_sidebar('sidecode');
    $html = ob_get_contents();
    ob_end_clean();
    return $html;
}


/////////////////////////////////////   ADMIN INIT   ///////////////////////////////////// 

add_action('admin_init', 'editor_admin_init');
add_action('admin_head', 'editor_admin_head');

function editor_admin_init() {
	
	global $TEMPLATE_DIR;
	
	
	
	wp_admin_css('thickbox');
	wp_enqueue_script('post');
	wp_enqueue_script('media-upload');
	wp_enqueue_script('jquery');
	wp_enqueue_script('tiny_mce');
	wp_enqueue_script('editor');
	wp_enqueue_script('editor-functions');
	add_thickbox();


	wp_enqueue_script( 'modernizr', $TEMPLATE_DIR .'/js/modernizr-2.0.min.js');
	wp_enqueue_script( 'pforcejs', $TEMPLATE_DIR.'/js/admin/afterburner.js', array('jquery', 'jquery-ui-core'));//pf js
	wp_enqueue_script('tabs', $TEMPLATE_DIR . '/js/admin/jquery.ui.tabs.js', array('jquery-ui-core', 'jquery-ui-widget'));
	
	register_setting( 'abrn_options', 'abrn_options' );
	
	if(get_option('afterburner_install_var')==FALSE) {//add install var
		abrn_first_load();
		
		}
		
		if(get_option('afterburner_install_var')==2) {//add install var
		abrn_populate_content();
		
		}
	}
	
	if(isset($_POST['afterburner_install_var']) ) {//set install var
	
	if(!current_user_can('manage_options'))
		die;
	update_option('afterburner_install_var',$_POST['afterburner_install_var']);
}

function abrn_admin_notice(){
      if(get_option('afterburner_install_var')=="1"){
			echo("<div class=\"updated\">
			 <form method='post' action='#'>
			<p>Your Afterburner theme is now installed. Clicking 'yes' below will set up your 'Home' and 'Blog' page. </p>
			<p style='color:#f00' >This will replace your current home and blog pages.</p>
			<input type=\"radio\" name=\"afterburner_install_var\" value=\"2\" > yes
			<input type=\"radio\" name=\"afterburner_install_var\" value=\"-1\" > never
		
			<input type=\"radio\" name=\"afterburner_install_var\" value=\"1\" checked> not yet<br><br>
			
		<input type='submit' name='submit' value='Save Settings' /><br /><br />
			
			</div>
		");
		}
}
add_action('admin_notices', 'abrn_admin_notice');

function editor_admin_head() {
	
	global $TEMPLATE_DIR_LOCAL;
	$abrn_options = get_option('abrn_options');
	
    $siteurl = get_option('siteurl');
    
    $css_url1 = $TEMPLATE_DIR_LOCAL . '/css/admin/afterburner.min.css' . '?ref=' . time();
	
	
	if($abrn_options['google_fonts']!=""){
		echo($abrn_options['google_fonts']);
	}

	if($abrn_options['afterburner_typekit']!=""){
		echo(stripslashes($abrn_options['afterburner_typekit']));
	}
	
	
		echo "<link rel='stylesheet' type='text/css' href='$css_url1' />\n";
	
	
  
	}
	
	
if ( ! isset( $content_width ) )
	$content_width = 640;





function abrn_populate_content() {
	
	$abrn_options=get_option('abrn_options');


	
	
		global $TEMPLATE_DIR;
		update_option('afterburner_install_var','-1');
	
		global $wpdb;
		global $user_ID;
		
global $wp_rewrite;


$page = get_page_by_title( 'Home' );
wp_delete_post( $page->ID,true);


$page = get_page_by_title( 'Blog' );
wp_delete_post( $page->ID,true);
	
	
		
			for($i=1; $i<=10; $i++) {
				if(	$abrn_options['abrn_custom_daughter_title'.$i]!='' &&  substr($abrn_options['abrn_custom_daughter_title'.$i],0,1)!='*'){
	
	//$page = get_page_by_title( $abrn_options['abrn_custom_daughter_title'.$i] );
	//wp_delete_post( $page->ID,true);
	
					$abrn_content="";
	
				
					$abrn_content=$abrn_content.'<div class="top_left_'.$i.'">'.$abrn_options['abrn_daughter1_'.$i.'_content']."</div>";
					
					if($abrn_options['afterburner_layout_home_top_'.$i]==3) { 
						$abrn_content=$abrn_content.'<div class="top_middle_'.$i.'">'.$abrn_options['abrn_daughter2_'.$i.'_content']."</div>";
					}
					
					if($abrn_options['afterburner_layout_home_top_'.$i]>=2) {
						$abrn_content=$abrn_content.'<div class="top_right_'.$i.'">'.$abrn_options['abrn_daughter3_'.$i.'_content']."</div>";
					}
					
					$abrn_content=$abrn_content."<div style='clear:both'></div>";
					
					 if($abrn_options['afterburner_home_rows_'.$i]>1){ 
	
						$abrn_content=$abrn_content.'<div class="middle_left_'.$i.'">'.$abrn_options['abrn_daughter4_'.$i.'_content']."</div>";
						
						if($abrn_options['afterburner_layout_home_middle_'.$i]==3) { 
							$abrn_content=$abrn_content.'<div class="middle_middle_'.$i.'">'.$abrn_options['abrn_daughter5_'.$i.'_content']."</div>";
						}
						
						if($abrn_options['afterburner_layout_home_middle_'.$i]>=2) {
							$abrn_content=$abrn_content.'<div class="middle_right_'.$i.'">'.$abrn_options['abrn_daughter6_'.$i.'_content']."</div>";
						}
						
						$abrn_content=$abrn_content."<div style='clear:both'></div>";
	
					 }
					 
					  if($abrn_options['afterburner_home_rows_'.$i]>2){ 
	
						$abrn_content=$abrn_content.'<div class="bottom_left_'.$i.'">'.$abrn_options['abrn_daughter7_'.$i.'_content']."</div>";
						
						if($abrn_options['afterburner_layout_home_bottom_'.$i]==3) { 
							$abrn_content=$abrn_content.'<div class="bottom_bottom_'.$i.'">'.$abrn_options['abrn_daughter8_'.$i.'_content']."</div>";
						}
						
						if($abrn_options['afterburner_layout_home_bottom_'.$i]>=2) {
							$abrn_content=$abrn_content.'<div class="bottom_right_'.$i.'">'.$abrn_options['abrn_daughter9_'.$i.'_content']."</div>";
						}
						
						$abrn_content=$abrn_content."<div style='clear:both'></div>";
	
					 }
					
					$new_post = array(
					'post_title' => $abrn_options['abrn_custom_daughter_title'.$i],
					'post_content' => $abrn_content,
					'post_date' => date('Y-m-d H:i:s'),
					'post_author' => $user_ID,
					'post_status' => 'publish',
					'post_type' => 'page');
					
				  
					$post_id = wp_insert_post($new_post);
					
					//$template='Afterburner_Custom_'.$i.'.php';
					$template='abrn-full-width.php';
					
					update_post_meta($post_id, '_wp_page_template', $template);
				}
				
			}
			
			$abrn_content="";
	
				
					$abrn_content=$abrn_content.'<div class="top_left">'.$abrn_options['abrn_home1_content']."</div>";
					
					if($abrn_options['afterburner_layout_home_top']==3) { 
						$abrn_content=$abrn_content.'<div class="top_middle">'.$abrn_options['abrn_home2_content']."</div>";
					}
					
					if($abrn_options['afterburner_layout_home_top']>=2) {
						$abrn_content=$abrn_content.'<div class="top_right">'.$abrn_options['abrn_home3_content']."</div>";
					}
					
					$abrn_content=$abrn_content."<div style='clear:both'></div>";
					
					 if($abrn_options['afterburner_home_rows']>1){ 
	
						$abrn_content=$abrn_content.'<div class="middle_left">'.$abrn_options['abrn_home4_content']."</div>";
						
						if($abrn_options['afterburner_layout_home_middle']==3) { 
							$abrn_content=$abrn_content.'<div class="middle_middle">'.$abrn_options['abrn_home5_content']."</div>";
						}
						
						if($abrn_options['afterburner_layout_home_middle']>=2) {
							$abrn_content=$abrn_content.'<div class="middle_right">'.$abrn_options['abrn_home6_content']."</div>";
						}
						
						$abrn_content=$abrn_content."<div style='clear:both'></div>";
	
					 }
					 
					  if($abrn_options['afterburner_home_rows']>2){ 
	
						$abrn_content=$abrn_content.'<div class="bottom_left">'.$abrn_options['abrn_home7_content']."</div>";
						
						if($abrn_options['afterburner_layout_home_bottom']==3) { 
							$abrn_content=$abrn_content.'<div class="bottom_middle">'.$abrn_options['abrn_home8_content']."</div>";
						}
						
						if($abrn_options['afterburner_layout_home_bottom']>=2) {
							$abrn_content=$abrn_content.'<div class=\"bottom_right">'.$abrn_options['abrn_home9_content']."</div>";
						}
						
						$abrn_content=$abrn_content."<div style='clear:both'></div>";
	
					 }
					 
			$new_post = array(
					'post_title' => 'Home',
					'menu_order' => -1,
					'post_content' => $abrn_content,
					'post_date' => date('Y-m-d H:i:s'),
					'post_author' => $user_ID,
					'post_status' => 'publish',
					'post_type' => 'page');
					
				  
			$post_id = wp_insert_post($new_post);
			
			//$template='Afterburner_Custom_Home_Page.php';
							$template='abrn-home-page.php';
	
			update_post_meta($post_id, '_wp_page_template', $template);
			
			
			$new_post = array(
					'post_title' => 'Blog',
					'menu_order' => 11,
					'post_content' => '',
					'post_date' => date('Y-m-d H:i:s'),
					'post_author' => $user_ID,
					'post_status' => 'publish',
					'post_type' => 'page');
					
				  
			$post_id = wp_insert_post($new_post);
			
		
		
		$page = get_page_by_title( 'Sample Page' );//drop sample page
		$post_id=$page->ID;
		wp_delete_post( $post_id );
		
		$page = get_page_by_title( 'Hello World!' );//drop hello world
		$post_id=$page->ID;
		wp_delete_post( $post_id );
		
		update_option('show_on_front','page');//home page on front
		
		$page = get_page_by_title( 'Home' );
		$post_id=$page->ID;
		update_option('page_on_front',$post_id);
		//update_post_meta($post_id, '_wp_page_template', 'Afterburner_Custom_Home_Page.php');
		
		$page = get_page_by_title( 'Blog' );//set blog page
		$post_id=$page->ID;
		update_option('page_for_posts',$post_id);
	
	
	//clear out abrn options of extra values
		
	//}
	

}

/////////////////////////////////////   LEGACY MENU SUPPORT   ///////////////////////////////////// 

 function afterburner_add_menus() { // Menu compatibility built in for legacy Wordpress <3.0 installs
	if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(
		 
		 'sidebar_manu' => 'The Sidebar Menu',
		  'foot_menu' => 'The Footer Menu'
		)
	);
}

}


add_action( 'init', 'afterburner_add_menus' ); //Legacy <3.0 Worpress support
 
function mytheme_nav($menuclass,$depth) {
    if ( function_exists( 'wp_nav_menu' ) )
	{
		 return(wp_nav_menu( 'echo=0&menu=main_nav&container=ul&menu_id=' .  $menuclass  . '& depth=' . $depth . '&fallback_cb=afterburner_nav_fallback' ));
	}
    else
        afterburner_nav_fallback();
}
 
function afterburner_nav_fallback() {// Old exclude code, kept for <3.0 browsers
	$menstr="<ul id=\"dropmenu\">";
    $menstr=$menstr . wp_list_pages('echo=0&sort_column=menu_order&title_li=');
	$menstr = $menstr . "</ul>";
	return($menstr);
}
//create gallery catgoer
$term='gallery';
$taxonomy="category";
$args="";

if(!term_exists($term, $taxonomy)){
  wp_insert_term($term, $taxonomy, $args);
}
/////////////////////////////////////   THEME SETUP   ///////////////////////////////////// 

/** Tell WordPress to run afterburner_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'afterburner_setup' );

if ( ! function_exists( 'afterburner_setup' ) ):

function afterburner_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	//add_theme_support( 'post-thumbnails' );

	add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 255, 105, true ); // default Post Thumbnail dimensions   

// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'afterburner', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'afterburner' ),
	) );


	// Your changeable header business starts here
	define( 'HEADER_TEXTCOLOR', '' );
	// No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
	define( 'HEADER_IMAGE', '%s/images/headers/path.jpg' );

	// The height and width of your custom header. You can hook into the theme's own filters to change these values.
	// Add a filter to afterburner_header_image_width and afterburner_header_image_height to change these values.
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'afterburner_header_image_width', 940 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'afterburner_header_image_height', 198 ) );

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be 940 pixels wide by 198 pixels tall.
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

	// Don't support text inside the header image.
	define( 'NO_HEADER_TEXT', true );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See afterburner_admin_header_style(), below.
	
	/************Removed no header in admin  ************/
	//add_custom_image_header( '', 'afterburner_admin_header_style' );

	// ... and thus ends the changeable header business.

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'berries' => array(
			'url' => '%s/images/headers/berries.jpg',
			'thumbnail_url' => '%s/images/headers/berries-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Berries', 'afterburner' )
		),
		'cherryblossom' => array(
			'url' => '%s/images/headers/cherryblossoms.jpg',
			'thumbnail_url' => '%s/images/headers/cherryblossoms-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Cherry Blossoms', 'afterburner' )
		),
		'concave' => array(
			'url' => '%s/images/headers/concave.jpg',
			'thumbnail_url' => '%s/images/headers/concave-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Concave', 'afterburner' )
		),
		'fern' => array(
			'url' => '%s/images/headers/fern.jpg',
			'thumbnail_url' => '%s/images/headers/fern-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Fern', 'afterburner' )
		),
		'forestfloor' => array(
			'url' => '%s/images/headers/forestfloor.jpg',
			'thumbnail_url' => '%s/images/headers/forestfloor-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Forest Floor', 'afterburner' )
		),
		'inkwell' => array(
			'url' => '%s/images/headers/inkwell.jpg',
			'thumbnail_url' => '%s/images/headers/inkwell-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Inkwell', 'afterburner' )
		),
		'path' => array(
			'url' => '%s/images/headers/path.jpg',
			'thumbnail_url' => '%s/images/headers/path-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Path', 'afterburner' )
		),
		'sunset' => array(
			'url' => '%s/images/headers/sunset.jpg',
			'thumbnail_url' => '%s/images/headers/sunset-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Sunset', 'afterburner' )
		)
	) );
}
endif;

if ( ! function_exists( 'afterburner_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in afterburner_setup().
 *
 * @since Afterburner 1.0
 */
function afterburner_admin_header_style() {
?>
<style type="text/css">
/* Shows the same border as on front end */
#headimg {
	border-bottom: 1px solid #000;
	border-top: 4px solid #000;
}
/* If NO_HEADER_TEXT is false, you would style the text with these selectors:
	#headimg #name { }
	#headimg #desc { }
*/
</style>
<?php
}
endif;

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since Afterburner 1.0
 */
function afterburner_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'afterburner_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Afterburner 1.0
 * @return int
 */
function afterburner_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'afterburner_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Afterburner 1.0
 * @return string "Continue Reading" link
 */
function afterburner_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'afterburner' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and afterburner_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Afterburner 1.0
 * @return string An ellipsis
 */
function afterburner_auto_excerpt_more( $more ) {
	return ' &hellip;' . afterburner_continue_reading_link();
}
add_filter( 'excerpt_more', 'afterburner_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Afterburner 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function afterburner_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= afterburner_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'afterburner_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Afterburner's style.css.
 *
 * @since Afterburner 1.0
 * @return string The gallery style filter, with the styles themselves removed.
 */
function afterburner_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'afterburner_remove_gallery_css' );

if ( ! function_exists( 'afterburner_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own afterburner_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Afterburner 1.0
 */
function afterburner_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s <span class="says">says:</span>', 'afterburner' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em><?php _e( 'Your comment is awaiting moderation.', 'afterburner' ); ?></em>
			<br />
		<?php endif; ?>
`
		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'afterburner' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'afterburner' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'afterburner' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'afterburner'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/////////////////////////////////////   REGISTER SIDEBARS    ///////////////////////////////////// 

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override afterburner_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since Afterburner 1.0
 * @uses register_sidebar
 */
function afterburner_widgets_init() {
		$abrn_options = get_option('abrn_options');

	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Primary Widget Area', 'afterburner' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The primary widget area', 'afterburner' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 2, second sidebar
	register_sidebar( array(
		'name' => __( 'Secondary Widget Area', 'afterburner' ),
		'id' => 'secondary-widget-area',
		'description' => __( 'The secondary widget area', 'afterburner' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	if($abrn_options['afterburner_footer_content_options']!="custom") {
			register_sidebar( array(
				'name' => __( 'First Footer Widget Area', 'afterburner' ),
				'id' => 'first-footer-widget-area',
				'description' => __( 'The first footer widget area', 'afterburner' ),
				'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
				'after_widget' => '</li>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			) );
		
			if($abrn_options['afterburner_layout_footer']>=2) 
			register_sidebar( array(
				'name' => __( 'Second Footer Widget Area', 'afterburner' ),
				'id' => 'second-footer-widget-area',
				'description' => __( 'The second footer widget area', 'afterburner' ),
				'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
				'after_widget' => '</li>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			) );
			
		if($abrn_options['afterburner_layout_footer']>=3) 
			register_sidebar( array(
				'name' => __( 'Third Footer Widget Area', 'afterburner' ),
				'id' => 'third-footer-widget-area',
				'description' => __( 'The third footer widget area', 'afterburner' ),
				'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
				'after_widget' => '</li>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			) );
			
			// Area 6, located in the footer. Empty by default.
			if($abrn_options['afterburner_layout_footer']>=4) 
			register_sidebar( array(
				'name' => __( 'Fourth Footer Widget Area', 'afterburner' ),
				'id' => 'fourth-footer-widget-area',
				'description' => __( 'The fourth footer widget area', 'afterburner' ),
				'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
				'after_widget' => '</li>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			) );
			
			// Area 7, located in the footer. Empty by default.
			
			if($abrn_options['afterburner_layout_footer']>=5) 
			register_sidebar( array(
				'name' => __( 'Fifth Footer Widget Area', 'afterburner' ),
				'id' => 'fifth-footer-widget-area',
				'description' => __( 'The fifth footer widget area', 'afterburner' ),
				'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
				'after_widget' => '</li>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			) );
			
			// Area 8, located in the footer. Empty by default.
			
			if($abrn_options['afterburner_layout_footer']>=6) 
			register_sidebar( array(
				'name' => __( 'Sixth Footer Widget Area', 'afterburner' ),
				'id' => 'sixth-footer-widget-area',
				'description' => __( 'The sixth footer widget area', 'afterburner' ),
				'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
				'after_widget' => '</li>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			) );
		}
}

//post nav

function afterburner_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'afterburner' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'afterburner' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'afterburner' ) ); ?></div>
		</nav><!-- #nav-above -->
	<?php endif;
}



/** Register sidebars by running afterburner_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'afterburner_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *
 * @since Afterburner 1.0
 */
function afterburner_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'afterburner_remove_recent_comments_style' );

if ( ! function_exists( 'afterburner_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post—date/time and author.
 *
 * @since Afterburner 1.0
 */
function afterburner_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'afterburner' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="	-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'afterburner' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'afterburner_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Afterburner 1.0
 */
function afterburner_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'afterburner' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'afterburner' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'afterburner' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;




/**
 * Afterburner Five functions and definitions
 *
 * This additional code adds in HTML5 functionality to the TwentyTen theme.
 * You will still require the orginal functions.php (above) which has not
 * been altered.
 *
 * The code below overwrites or extends some of the TwentyTen functionality.
 *
 * For more information on see 
 * http://www.smashingmagazine.com/2011/02/22/using-html5-to-transform-wordpress-afterburner-theme/
 *
 * and
 * http://afterburnerfive.com
 *
 * @package WordPress
 * @subpackage Press_Force_Five
 * @since TwentyTen Five 1.0.1
 */



add_shortcode('wp_caption', 'afterburner_img_caption_shortcode');
add_shortcode('caption', 'afterburner_img_caption_shortcode');

function afterburner_img_caption_shortcode($attr, $content = null) {

	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''
	), $attr));

	if ( 1 > (int) $width || empty($caption) )
		return $content;


if ( $id ) $idtag = 'id="' . esc_attr($id) . '" ';

  return '<figure ' . $idtag . 'aria-describedby="figcaption_' . $id . '" style="width: ' . (10 + (int) $width) . 'px">' 
  . do_shortcode( $content ) . '<figcaption id="figcaption_' . $id . '">' . $caption . '</figcaption></figure>';
}



/**
 * Prints HTML with meta information for the current post—date/time and author.
 *
 * @since TwentyTen Five 1.0
 */
function afterburner_posted_on() {
		printf( __( 'Posted on %2$s by %3$s', 'afterburner' ),
			'meta-prep meta-prep-author',
			sprintf( '<a href="%1$s" rel="bookmark"><time datetime="%2$s" pubdate>%3$s</time></a>',
			get_permalink(),
			get_the_date('c'),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'afterburner' ), get_the_author() ),
			get_the_author()
		)
	);
}



/**
 * Customise the TwentyTen Five comments fields with HTML5 form elements
 *
 *	Adds support for 	placeholder
 *						required
 *						type="email"
 *						type="url"
 *
 * @since TwentyTen Five 1.0
 */
function afterburnerfive_comments() {

	$req = get_option('require_name_email');

	$fields =  array(
		'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name','afterbunrer' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
		            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' placeholder = "What can we call you?"' . ( $req ? ' required' : '' ) . '/></p>',
		            
		'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email','afterbunrer' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
		            '<input id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' placeholder="How can we reach you?"' . ( $req ? ' required' : '' ) . ' /></p>',
		            
		'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website','afterbunrer' ) . '</label>' .
		            '<input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" placeholder="Have you got a website?" /></p>'

	);
	return $fields;
}


function afterburnerfive_commentfield() {	

	$commentArea = '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun','afterburner' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" required placeholder="What\'s on your mind?"	></textarea></p>';
	
	return $commentArea;

}



add_filter('comment_form_default_fields', 'afterburnerfive_comments');
add_filter('comment_form_field_comment', 'afterburnerfive_commentfield');



	
/////////////////////////////////////   CUSTOM ADMIN OPTIIONS   ///////////////////////////////////// 
/*
add_action('admin_menu', 'add_afterburner_custom_function');

function add_afterburner_custom_function() {
	add_menu_page( 'Afterburner Custom Options', 'Custom Options' , 'manage_options', 'afterburner_custom_options', 'afterburner_custom_options_function','http://www.pressforce.org/settings.png' );
	//add_options_page('Global Custom Fields', 'Afterburner Custom Fields', '8', 'functions', 'afterburner_custom_options');
	          
}*/
add_action('admin_menu', 'add_afterburner_custom_function');

function add_afterburner_custom_function() {
	add_theme_page('Afterburner Custom Options', 'Afterburner Options', 'manage_options', 'afterburner_custom_options', 'afterburner_custom_options_function');
}


/*
add_action('admin_menu', 'add_afterburner_layout_interface');

function add_afterburner_layout_interface() {
add_menu_page( 'Afterburner Template Builder', 'Template Editor' , 'manage_options', 'afterburner_layout', 'afterburner_layout_editor','http://www.pressforce.org/layout.png' );

}


*/


 
/////////////////////////////////////   Lyout Editor  ///////////////////////////////////// 
/*
 function afterburner_layout_editor() {
	 
	  global $abrn_options;
		//handled with redirect to layout editor	 
 
  }
  */
 
 

function afterburner_custom_options_function() {
	
	?>
 
  <div class='wrap'>
      
	        <form method="post" action="options.php">

       <?php settings_fields('abrn_options'); ?>
            <?php $abrn_options = get_option('abrn_options'); 
			
			
			//delete_option('afterburner_install_var'); ?>

  
    
  
 
<p><input name="Submit" type="image" value="Save Settings" src="<?php echo get_template_directory_uri(); ?>/images/admin/save-changes.jpg" />
 <img src="<?php echo get_template_directory_uri() ; ?>/images/admin/ptheme-logo.jpg" alt="seo"style="float:right;" />
  </p>
 
    
	
	
      
  <!-- the tabs -->
  <div id="tabs" style="font-size:11px;">
  <?php 



?>
  <ul>
  <li><a href="#tabs-1">Afterburner Admin</a></li>
    
   
    <li><a href="#tabs-2">Header and Animation</a></li>
    
     
  
   
    
  </ul>
    
  <div id="tabs-1" style="height:auto; padding:20px;">
  <div class="admin_box">
   
  <span class="ux_h2">SOCIAL MEDIA OPTIONS</span> <br /><br />
   <span class="ux_p">Include page titles on pages?</span><br /><br />
	<input type="radio" name="abrn_options[afterburner_show_title]" value="yes" <?php if ($abrn_options['afterburner_show_title']=="yes"){echo("checked");}?>> yes
	<input type="radio" name="abrn_options[afterburner_show_title]" value="no" <?php if ($abrn_options['afterburner_show_title']=="no"){echo("checked");}?>> no
    <br /><br />
   <span class="ux_p">Include comment form on pages?</span><br /><br />
	<input type="radio" name="abrn_options[afterburner_show_comments]" value="yes" <?php if ($abrn_options['afterburner_show_comments']=="yes"){echo("checked");}?>> yes
	<input type="radio" name="abrn_options[afterburner_show_comments]" value="no" <?php if ($abrn_options['afterburner_show_comments']=="no"){echo("checked");}?>> no
    <br /><br />
 

    
  
   
    </div><!-- End Admin Box -->
  </div>
 
    
 
    
    
    <div id="tabs-2" style="height:auto; padding:20px;">
      
      <div class="admin_box">
        <span class="ux_h2">Web Header</span>
        
        <table width="100%" valign="top">
          <tr>
            <td width="33%" valign="top">
              
              <?php for ($i=1; $i<=$abrn_options['abrn_number_of_slides']; $i++) { 
              echo('<p>Header image link #'.$i.' (in the form &quot;http://www...&quot;)
                <input type="text" name="abrn_options[afterburner_link'.$i.'_number]" size="45" value="'.$abrn_options['afterburner_link'.$i.'_number'].'" /></p>');
			  }
			   
			  ?>
             
              <p>Animate Slides on the Home Page?
                <input type="radio" name="abrn_options[afterburner_anim]" value="yes" <?php if ($abrn_options['afterburner_anim']=="yes"){echo("checked");}?>> yes
                <input type="radio" name="abrn_options[afterburner_anim]" value="no" <?php if ($abrn_options['afterburner_anim']=="no"){echo("checked");}?>> no</p>
              <p>Include Navigation Buttons?<br />
              (For Scroll Horiz, Scroll Vert and Fade)
                <input type="radio" name="abrn_options[afterburner_anim_buttons]" value="yes" <?php if ($abrn_options['afterburner_anim_buttons']=="yes"){echo("checked");}?>> yes
                <input type="radio" name="abrn_options[afterburner_anim_buttons]" value="no" <?php if ($abrn_options['afterburner_anim_buttons']=="no"){echo("checked");}?>> no</p>
             
              <p>Pause Slideshow if Hovering over Image?
                <input type="radio" name="abrn_options[afterburner_anim_pause]" value="yes" <?php if ($abrn_options['afterburner_anim_pause']=="yes"){echo("checked");}?>> yes
                <input type="radio" name="abrn_options[afterburner_anim_pause]" value="no" <?php if ($abrn_options['afterburner_anim_pause']=="no"){echo("checked");}?>> no</p>
             
              <p>Time between header slides
                <input type="text" name="abrn_options[afterburner_anim_speed]" size="6`" value="<?php echo $abrn_options['afterburner_anim_speed'] ?>" /><br />
                In microseconds (1000 = 1 second)</p>
              <p>Transition Speed
                <input type="text" name="abrn_options[afterburner_anim_trans_speed]" size="6" value="<?php echo $abrn_options['afterburner_anim_trans_speed'] ?>" />
                <br />
                In microseconds (1000 = 1 second)</p>
            
           <p> Numner of Slides<br />
             <select name="abrn_options[abrn_number_of_slides]">
                <option value="1" <?php if ($abrn_options['abrn_number_of_slides']=="1") echo("selected=\"selected\""); ?>>1</option>
                <option value="2" <?php if ($abrn_options['abrn_number_of_slides']=="2") echo("selected=\"selected\""); ?>>2</option>
                <option value="3" <?php if ($abrn_options['abrn_number_of_slides']=="3") echo("selected=\"selected\""); ?>>3</option>
                <option value="4" <?php if ($abrn_options['abrn_number_of_slides']=="4") echo("selected=\"selected\""); ?>>4</option>
                <option value="5" <?php if ($abrn_options['abrn_number_of_slides']=="5") echo("selected=\"selected\""); ?>>5</option>
                <option value="6" <?php if ($abrn_options['abrn_number_of_slides']=="6") echo("selected=\"selected\""); ?>>6</option>
                <option value="7" <?php if ($abrn_options['abrn_number_of_slides']=="7") echo("selected=\"selected\""); ?>>7</option>
                <option value="8" <?php if ($abrn_options['abrn_number_of_slides']=="8") echo("selected=\"selected\""); ?>>8</option>        
		 	 </select></p>
            
            <td style="width:6%"></td>
            <td width="60%" valign="top">
              <?php echo($abrn_options['afterburner_anim_transition']) ?>
              <table width="100%">
                <tr>
                  <td width="33%" valign="top">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/admin/blindx.jpg" alt="seo" width="103" height="63" /><br />
                    <input type="radio" name="abrn_options[afterburner_anim_transition]" value="blindX" <?php if ($abrn_options['afterburner_anim_transition'] =="blindX"){echo("checked");}?>>BlindX<br><br />
                    </td>
                  <td width="33%" valign="top">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/admin/blindy.jpg" alt="seo" width="103" height="63" /><br />
                    <input type="radio" name="abrn_options[afterburner_anim_transition]" value="blindY" <?php if ($abrn_options['afterburner_anim_transition'] =="blindY"){echo("checked");}?>>BlindY<br><br />
                    </td>
                  <td width="33%" valign="top">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/admin/blindz.jpg" alt="seo" width="103" height="63" /><br />
                    <input type="radio" name="abrn_options[afterburner_anim_transition]" value="blindZ" <?php if ($abrn_options['afterburner_anim_transition'] =="blindZ"){echo("checked");}?>> BlindZ<br><br />
                    </td>
                  </tr>
                <tr>
                  <td width="33%" valign="top">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/admin/curtain.jpg" alt="seo" width="103" height="63" /><br />
                    <input type="radio" name="abrn_options[afterburner_anim_transition]" value="curtainX" <?php if ($abrn_options['afterburner_anim_transition'] =="curtainX"){echo("checked");}?>>Curtain<br><br />
                    </td>
                  <td width="33%" valign="top">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/admin/scrollleft.jpg" alt="seo" width="103" height="63" /><br />
                    <input type="radio" name="abrn_options[afterburner_anim_transition]" value="scrollLeft" <?php if ($abrn_options['afterburner_anim_transition'] =="scrollLeft"){echo("checked");}?>>Scroll Left<br><br />
                    </td>
                  <td width="33%" valign="top">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/admin/scrollright.jpg" alt="seo" width="103" height="63" /><br />
                    <input type="radio" name="abrn_options[afterburner_anim_transition]" value="scrollRight" <?php if ($abrn_options['afterburner_anim_transition'] =="scrollRight"){echo("checked");}?>>Scroll Right<br><br />
                    </td>
                  </tr>
                <tr>
                  <td width="33%" valign="top">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/admin/scrolldown.jpg" alt="seo" width="103" height="63" /><br />
                    <input type="radio" name="abrn_options[afterburner_anim_transition]" value="scrollDown" <?php if ($abrn_options['afterburner_anim_transition'] =="scrollDown"){echo("checked");}?>>Scroll Down<br><br />
                    </td>
                  <td width="33%" valign="top">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/admin/scrollup.jpg" alt="seo" width="103" height="63" /><br />
                    <input type="radio" name="abrn_options[afterburner_anim_transition]" value="scrollUp" <?php if ($abrn_options['afterburner_anim_transition'] =="scrollUp"){echo("checked");}?>>Scroll Up<br><br />
                    </td>
                  <td width="33%" valign="top">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/admin/scrollleftright.jpg" alt="seo" width="103" height="63" /><br />
                    <input type="radio" name="abrn_options[afterburner_anim_transition]" value="scrollHorz" <?php if ($abrn_options['afterburner_anim_transition'] =="scrollHorz"){echo("checked");}?>>
                    Scroll Horiz (reversible)<br>
                    <br />
                    </td>
                    
                  </tr>
                <tr>
                <td width="33%" valign="top">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/admin/scrollupdown.jpg" alt="seo" width="103" height="63" /><br />
                    <input type="radio" name="abrn_options[afterburner_anim_transition]" value="scrollVert" <?php if ($abrn_options['afterburner_anim_transition'] =="scrollVert"){echo("checked");}?>>
                    Scroll Vert (reversible)<br>
                    <br />
                    </td>
                    <td width="33%" valign="top">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/admin/fade.jpg" alt="seo" width="103" height="63" /><br />
                    <input type="radio" name="abrn_options[afterburner_anim_transition]" value="fade" <?php if ($abrn_options['afterburner_anim_transition'] =="fade"){echo("checked");}?>>
                    Fade (reversible)<br>
                    <br />
                    </td>
                    <td>&nbsp;</td>
                    </tr>
                </table>
              <br />
              <br />
              </td>
            </tr>
          </table>
        </div>
  </div>
    
    
    
    
    
    
    
    </div><!-- End Tabs-->
 
			
 <input type="hidden" value="<?php echo($abrn_options['abrn_logo_image_type']); ?>" name="abrn_options[abrn_logo_image_type]" />
 <input type="hidden" value="<?php echo($abrn_options['afterburner_typekit']); ?>" name="abrn_options[afterburner_typekit]" />
 <input type="hidden" value="<?php echo($abrn_options['afterburner_topbar_options']); ?>" name="abrn_options[afterburner_topbar_options]" />
 <input type="hidden" value="<?php echo($abrn_options['afterburner_layout_menu']); ?>" name="abrn_options[afterburner_layout_menu]" />
 <input type="hidden" value="<?php echo($abrn_options['afterburner_header_options']); ?>" name="abrn_options[afterburner_header_options]" />
 
 <input type="hidden" value="<?php echo($abrn_options['afterburner_layout_footer']); ?>" name="abrn_options[afterburner_layout_footer]" />

 
 
 <input type="hidden" value="<?php echo($abrn_options['abrn_slide1_image_type']); ?>" name="abrn_options[abrn_slide1_image_type]" />
 <input type="hidden" value="<?php echo($abrn_options['abrn_slide2_image_type']); ?>" name="abrn_options[abrn_slide2_image_type]" />
 <input type="hidden" value="<?php echo($abrn_options['abrn_slide3_image_type']); ?>" name="abrn_options[abrn_slide3_image_type]" />
 <input type="hidden" value="<?php echo($abrn_options['abrn_slide4_image_type']); ?>" name="abrn_options[abrn_slide4_image_type]" />
 <input type="hidden" value="<?php echo($abrn_options['abrn_slide5_image_type']); ?>" name="abrn_options[abrn_slide5_image_type]" />
 <input type="hidden" value="<?php echo($abrn_options['abrn_slide6_image_type']); ?>" name="abrn_options[abrn_slide6_image_type]" />
 <input type="hidden" value="<?php echo($abrn_options['abrn_slide7_image_type']); ?>" name="abrn_options[abrn_slide7_image_type]" />
 <input type="hidden" value="<?php echo($abrn_options['abrn_slide8_image_type']); ?>" name="abrn_options[abrn_slide8_image_type]" />
 <input type="hidden" value="<?php echo($abrn_options['abrn_slide9_image_type']); ?>" name="abrn_options[abrn_slide9_image_type]" />
 <input type="hidden" value="<?php echo($abrn_options['abrn_slide10_image_type']); ?>" name="abrn_options[abrn_slide10_image_type]" />
    
    </form>

    </div><!-- End wrap -->
    
    
   
	<?php
}


add_filter('mce_css', 'my_editor_style');
function my_editor_style($url) {

  if ( !empty($url) )
    $url .= ',';

  // Change the path here if using sub-directory
  $url .= trailingslashit( get_stylesheet_directory_uri() ) . 'afterburner.css';
  

  return $url;
}

//


?>