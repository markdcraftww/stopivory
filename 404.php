<?php get_header(); ?>
	
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>" style="background: url(<?php bloginfo('template_url'); ?>/img/404.jpg) no-repeat center center;">
		<h2>NOT FOUND</h2>
		<hr />
		<h4>The page you were looking for has been moved or does not exist</h4>
	</div>	
	
<?php get_footer(); ?>

<script>
$(function() {$('.device-header').slideUp('slow');$('.menuToggle').on('click', 'a', function(e){e.preventDefault();$('.device-header').slideDown('slow');});$('.device-header').on('click', 'a', function(){$('.device-header').slideUp('slow');});$('.tweets-list-container').tweetscroll({ username: 'StopIvory', time: true, limit: 10,replies: true, position: 'prepend', date_format: 'style2', animation: 'slide_down', visible_tweets: 5 });if(exists($.cookie('StopIvory_Cookie'))) {} else {	$('#cookie').fadeIn('slow');$.cookie('StopIvory_Cookie', 'StopIvory', { expires: 1000000, path: '/' });}
$.fn.fullpage({verticalCentered: true,resize : true,scrollingSpeed: 700,easing: 'easeInQuart',<?php if( is_page( array( 'Stop Ivory', 'Contact Us' ) ) ) { ?> navigation: false, <? } else { if (have_posts()) : while (have_posts()) : the_post(); ?>anchors:['<?php echo(basename(get_permalink())); ?>',<?php $args = array( 'orderby' => 'menu_order','order' => 'ASC', 'post_parent' => $post->ID, 'post_type' => 'page', 'post_status' => 'publish'); $postslist = get_posts($args); foreach ($postslist as $post) : setup_postdata($post); ?>'<?php echo(basename(get_permalink())); ?>',<?php endforeach; ?>],<?php endwhile; else :  endif; ?>menu: false,navigation: true,<?php if (have_posts()) : while (have_posts()) : the_post(); ?>navigationTooltips: ['<?php the_title(); ?>', <?php $args = array( 'orderby' => 'menu_order','order' => 'ASC', 'post_parent' => $post->ID, 'post_type' => 'page', 'post_status' => 'publish' ); $postslist = get_posts($args); foreach ($postslist as $post) : setup_postdata($post); ?>'<?php the_title(); ?>',<?php endforeach; ?>],<?php endwhile; else :  endif; } ?>slidesNavigation: true,slidesNavPosition: 'bottom',loopBottom: false,loopTop: false,loopHorizontal: false,autoScrolling: true,scrollOverflow: true,css3: true,paddingTop: '0',paddingBottom: '0',fixedElements: '#mainMenu, .device-header, .menuToggle, #copyright, #cookie',keyboardScrolling: true,touchSensitivity: 20,onLeave: function(index, direction){$('.device-header').slideUp('slow');},afterLoad: function(anchorLink, index){},afterRender: function(){},afterSlideLoad: function(anchorLink, index, slideAnchor, slideIndex){},onSlideLeave: function(anchorLink, index, slideIndex, direction){}});});
$(document).keyup(function(e) {if(e.keyCode == 27) {$('.device-header').slideUp('slow');}});
function exists(data) {if(!data || data==null || data=='undefined' || typeof(data)=='undefined') return false;else return true;}
</script>