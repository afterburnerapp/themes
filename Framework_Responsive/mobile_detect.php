<?php /*

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
	
	
	$mobile = explode("\n", trim(get_option('wpmsme_mobile_browsers')));
		$wpmsme_mobile_browsers = apply_filters('mobile_browsers', $mobile);
		
		
		if (count($wpmsme_mobile_browsers))
			foreach ($wpmsme_mobile_browsers as $browser) {
				if (!empty($browser) && strpos($_SERVER["HTTP_USER_AGENT"], trim($browser)) !== false) {
					$hmobile=1;
				}
			}


$touch = explode("\n", trim(get_option('wpmsme_touch_browsers')));
		$wpmsme_touch_browsers = apply_filters('touch_browsers', $touch);
		
		if (count($wpmsme_touch_browsers))
			foreach ($wpmsme_touch_browsers as $browser) {
				if (!empty($browser) && strpos($_SERVER["HTTP_USER_AGENT"], trim($browser)) !== false) {
					$hmobile=2;
				}
			}

?>