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
global $hmobile;
 ?>


 </div><!-- end wrapper -->

    <div class="footer">
        <div class="footer_container">
         <section class="footer_div"><ul><?php dynamic_sidebar('First Footer Widget Area') ?></ul></section>
         <section class="footer_div"><ul><?php dynamic_sidebar('Second Footer Widget Area') ?></ul></section>
         <section class="footer_div"><ul><?php dynamic_sidebar('Third Footer Widget Area') ?></ul></section>
         <section class="footer_div footer_right"><ul><?php dynamic_sidebar('Fourth Footer Widget Area') ?></ul></section>
         
         
         
            <!--End Footer section -->
           <? if($abrn_options['afterburner_copyright']!=""){ ?>
         <div class="copyright-back"><!--Copyright Div-->
                    <span class="copyright"><?php echo $abrn_options['afterburner_copyright']; ?> 
                   
                    </span>
                   
                   
                </div><!-- End Copyright Div-->
                <? } ?>
             
        
        </div><!-- Footer Container -->
      

         
       </div><!-- End Footer -->
	</div><!-- end page-->
    
  <?php 
	if (function_exists('wpms_mobile_return') && $hmobile!=0) { ?>
	<div class="abrn_moile_return">
	<p>Please return to:</p>
	<?php echo(wpms_mobile_return(NULL)); ?>
	</div>
	<?php } ?>
 
    <?php
    /* Always have wp_footer() just before the closing </body>
     * tag of your theme, or you will break many plugins, which
     * generally use this hook to reference JavaScript files.
     */
    
    wp_footer();
    ?>
    
</body>

</html>
