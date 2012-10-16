<?php 
/*

 * @package WordPress 

* @subpackage Afterburner Theme * 
All PHP code in this theme is licensed under the GNU Genral Public License, which can be found here: http://www.gnu.org/copyleft/gpl.html

The images, CSS code, graphics source files and Javascript code for this theme are licensed under the Hotware License Agreement which can 
be found here: http://afterburnerapp.com/Hotware_Distributed_Theme_License.html.

* Copyright Hotware LLC 2011
 
 This software is provided "as is" and any expressed or implied warranties, including, but not limited to, the implied warranties of merchantability and 
 fitness for a particular purpose are disclaimed. in no event shall the regents or contributors be liable for any direct, indirect, incidental, special,
 exemplary, or consequential damages (including, but not limited to, procurement of substitute goods or services; loss of use, data, or profits; or 
 business interruption) however caused and on any theory of liability, whether in contract, strict liability, or tort (including negligence or otherwise) 
 arising in any way out of the use of this software, even if advised of the possibility of such damage.

*/

global $abrn_options;

?>
 <div class="topbar">
        <hgroup>
            <?php  if($abrn_options['abrn_logo_image_type']==".jpg") $ityp=".jpg"; if($abrn_options['abrn_logo_image_type']==".png") $ityp=".png";  if($abrn_options['abrn_logo_image_type']==".gif") $ityp=".gif";?>
            <h1 id="site-title"><a class="logo_pos" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo get_template_directory_uri(); ?>/images/logo<?php echo($ityp); ?>" alt="<?php bloginfo( 'name' ); ?>"></a></h1>
         <h2 id="site-description" ><span class="site_desc"><?php bloginfo( 'description' ); ?></span></h2>
	        
        </hgroup>        
    
    <nav role="navigation">
            <div class="skip-link screen-reader-text"><a href="#content" title="Skip to content">Skip to content</a></div>
            <div id="centeredmenu" class="abrn_menu_sub"><?php echo(mytheme_nav("dropmenu",0)); ?></div>
        <div class="abrn_menu_bck">
</div>
</nav><!-- nav --> 
         
    
   