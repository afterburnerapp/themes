<?php
/*

 * @package WordPress
 * @subpackage Skybox Theme
 
 * All Graphics, images are protected under the Hotwarer License Agreement which can be found here: http://www.hotwarethemes.com/Hotware_License_Agreement.html
 * All PHP code is pretoected under the GNU license which can be found here: http://www.gnu.org/licenses/gpl.html
 
 * Copyright Hotware Themes 2010
 
 This software is provided "as is" and any expressed or implied warranties, including, but not limited to, the implied warranties of merchantability and 
 fitness for a particular purpose are disclaimed. in no event shall the regents or contributors be liable for any direct, indirect, incidental, special,
 exemplary, or consequential damages (including, but not limited to, procurement of substitute goods or services; loss of use, data, or profits; or 
 business interruption) however caused and on any theory of liability, whether in contract, strict liability, or tort (including negligence or otherwise) 
 arising in any way out of the use of this software, even if advised of the possibility of such damage.

*/
?>

<a rel="nofollow" href="http://twitter.com/home?status=<?php the_title(); ?>+<?php the_permalink() ?>" title="Share this post on Twitter" target="_blank"><img src="<?php echo(get_template_directory_uri()); ?>/images/twit.png" alt="twitter" class="float-left" width="18" height="18" border="0" /></a>

<a rel="nofollow" href="http://www.facebook.com/share.php?u=<?php the_permalink() ?>" title="Share this post on Facebook" target="_blank"><img src="<?php echo(get_template_directory_uri()); ?>/images/fbook.png" alt="twitter" class="float-left" width="18" height="18" border="0" /></a>

<a rel="nofollow" href="http://www.addthis.com/bookmark.php?pub=USERNAME&amp;url=<?php echo get_permalink(); ?>&amp;title=<?php echo urlencode(get_the_title($id)); ?>" title="Share this post" target="_blank"><img src="<?php echo(get_template_directory_uri()); ?>/images/addthis.png" alt="twitter" class="float-left" width="18" height="18" border="0" /></a>

<a rel="nofollow" href="http://www.myspace.com/Modules/PostTo/Pages/?l=3&amp;u=<?php the_permalink() ?>" title="Share this post on Mysace" target="_blank"><img src="<?php echo(get_template_directory_uri()); ?>/images/myspace.png" alt="twitter" class="float-left" width="18" height="18" border="0" /></a>

<a rel="nofollow" href="http://digg.com/submit?phase=2&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>" title="Share this post on Digg" target="_blank"><img src="<?php echo(get_template_directory_uri()); ?>/images/digg.png" alt="twitter" class="float-left" width="18" height="18" border="0" /></a>

<a rel="nofollow" href="http://reddit.com/submit?url=<?php the_permalink(); ?>&amp;title=<?php echo urlencode(get_the_title($id)); ?>" title="Share this post on Reddit" target="_blank"><img src="<?php echo(get_template_directory_uri()); ?>/images/reddit.png" alt="twitter" class="float-left" width="18" height="18" border="0" /></a>

<a rel="nofollow" href="http://www.stumbleupon.com/submit?url=<?php the_permalink() ?>&amp;title=<?php the_title(); ?>" title="Share this post on Stumbleupon" target="_blank"><img src="<?php echo(get_template_directory_uri()); ?>/images/stumbleupon.png" alt="twitter" class="float-left" width="18" height="18" border="0" /></a>

