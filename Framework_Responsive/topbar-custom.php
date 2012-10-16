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
<div class="topbar">

 <?php if($abrn_options['afterburner_anim_buttons']=='yes' && $abrn_options['afterburner_header_options']=="default"  && $abrn_options['afterburner_home_header_options']=="default") { ?>
        
     <div id="abrn_next" style="cursor: pointer"></div>
        <div id="abrn_prev" style="cursor: pointer"></div>
 <?php } ?>
 
<?php 
$post_id = $abrn_options['abrn_topbar'];
		$queried_post = get_post($post_id);
		echo $queried_post->post_content; 
		
		?>
                    
		<!-- closing </div> in theme writer -->