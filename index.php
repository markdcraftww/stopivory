<?php get_header(); ?>

	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>" style="background: url(<?php global $post; $image = get_post_meta( $post->ID, '_cmb_bg', true ); echo $image;  ?>) no-repeat center center;">
		<div class="grid">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="col-1-4">
				<div <?php post_class('news'); ?>>
					<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
				</div>
			</div>
			<?php endwhile; else :  endif; ?>
		</div>
	</div>

<?php get_footer(); ?>
<script>
$(function() {$('.device-header').slideUp('slow');$('.menuToggle').on('click', 'a', function(e){e.preventDefault();$('.device-header').slideDown('slow');});$('.device-header').on('click', 'a', function(){$('.device-header').slideUp('slow');});$('.tweets-list-container').tweetscroll({ username: 'StopIvory', time: true, limit: 10,replies: true, position: 'prepend', date_format: 'style2', animation: 'slide_down', visible_tweets: 5 });if(exists($.cookie('StopIvory_Cookie'))) {} else {	$('#cookie').fadeIn('slow');$.cookie('StopIvory_Cookie', 'StopIvory', { expires: 1000000, path: '/' });}
$.fn.fullpage({verticalCentered: true,resize : true,scrollingSpeed: 700,easing: 'easeInQuart',<?php if( is_page( array( 'Stop Ivory', 'Contact Us' ) ) ) { ?> navigation: false, <? } else { if (have_posts()) : while (have_posts()) : the_post(); ?>anchors:['<?php echo(basename(get_permalink())); ?>',<?php $args = array( 'orderby' => 'menu_order','order' => 'ASC', 'post_parent' => $post->ID, 'post_type' => 'page', 'post_status' => 'publish'); $postslist = get_posts($args); foreach ($postslist as $post) : setup_postdata($post); ?>'<?php echo(basename(get_permalink())); ?>',<?php endforeach; ?>],<?php endwhile; else :  endif; ?>menu: false,navigation: true,<?php if (have_posts()) : while (have_posts()) : the_post(); ?>navigationTooltips: ['<?php the_title(); ?>', <?php $args = array( 'orderby' => 'menu_order','order' => 'ASC', 'post_parent' => $post->ID, 'post_type' => 'page', 'post_status' => 'publish' ); $postslist = get_posts($args); foreach ($postslist as $post) : setup_postdata($post); ?>'<?php the_title(); ?>',<?php endforeach; ?>],<?php endwhile; else :  endif; } ?>slidesNavigation: true,slidesNavPosition: 'bottom',loopBottom: false,loopTop: false,loopHorizontal: false,autoScrolling: true,scrollOverflow: true,css3: true,paddingTop: '0',paddingBottom: '0',fixedElements: '#mainMenu, .device-header, .menuToggle, #copyright, #cookie',keyboardScrolling: true,touchSensitivity: 200,onLeave: function(index, direction){$('.device-header').slideUp('slow');},afterLoad: function(anchorLink, index){},afterRender: function(){},afterSlideLoad: function(anchorLink, index, slideAnchor, slideIndex){},onSlideLeave: function(anchorLink, index, slideIndex, direction){}});});
$(document).keyup(function(e) {if(e.keyCode == 27) {$('.device-header').slideUp('slow');}});
function exists(data) {if(!data || data==null || data=='undefined' || typeof(data)=='undefined') return false;else return true;}
</script>