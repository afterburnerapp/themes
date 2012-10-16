<?php
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




get_header(); 



?>

   

				<div id="primary">
					<div id="content" role="main"><?php get_template_part( 'content', '404' ); ?></div>
					</div>

<?php get_sidebar("primary"); ?>

	
  <div class="line"></div> <!-- clear any floats -->
 
<?php get_footer(); ?>
		


