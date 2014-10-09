<?php get_header(); ?>
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>" style="background: url(<?php global $post; $image = get_post_meta( $post->ID, '_cmb_bg', true ); echo $image;  ?>) no-repeat center center;">
		<div class="grid" id="pageText">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="col-1-1">
				<div <?php post_class('news'); ?>>
					<?php 
						if(mobile_detected($devices)) {
					?>
					<?php the_post_thumbnail('mobile'); ?>
					<?php
						} else {
					?>
					<?php the_post_thumbnail('big'); ?>
					<?php
						}
					?>
					dfg
					<h4><?php the_title(); ?></h4>
					<h5>
						<?php global $post; $location = get_post_meta( $post->ID, '_cmb_location', true ); if( $location != '' ) :  ?>
							<?php global $post; $location = get_post_meta( $post->ID, '_cmb_location', true ); echo $location;  ?>, 
						<?php endif; ?>
						<?php the_time('jS F, Y') ?>
					</h5>
					<?php the_content(); ?>
					<p><?php the_author(); ?>, <em><?php the_author_description(); ?></em></p>
				</div>
			</div>
			<?php endwhile; else :  endif; ?>
		</div>
	</div>
<?php get_footer(); ?>
<script>
$(function(){var owl=$("#homePageCarousel");owl.owlCarousel({navigation:true,slideSpeed:2000,paginationSpeed:800,singleItem:true,autoPlay:5000,stopOnHover:true,transitionStyle:'fade'});$('.device-header').slideUp('slow');$('.menuToggle').on('click','a',function(e){e.preventDefault();$('.device-header').slideDown('slow');$(this).addClass('activeOpen');$('.menuToggle').on('click', '.activeOpen', function(e){e.preventDefault;$('.device-header').slideUp('slow');$(this).removeClass('activeOpen')});});$('.device-header').on('click','a',function(){$('.device-header').slideUp('slow');});if(exists($.cookie('StopIvory_Cookie'))) {} else {$('#cookie').fadeIn('fast');$.cookie('StopIvory_Cookie', 'StopIvory', {expires: 1000000, path: '/'});}$('#closeCookie').on('click', function(e){e.preventDefault();$('#cookie').fadeOut('fast');});
$('#page').fullpage({verticalCentered:true,resize:true,scrollingSpeed:700,easing:'easeInQuart',<?php if(is_page(array('Stop Ivory','Contact Us'))){?>navigation:false,<?}else{if(have_posts()):while(have_posts()):the_post();?>anchors:['<?php echo(basename(get_permalink())); ?>',<?php $args=array('orderby'=>'menu_order','order'=>'ASC','post_parent'=>$post->ID,'post_type'=>'page','post_status'=>'publish');$postslist=get_posts($args);foreach($postslist as $post):setup_postdata($post);?>'<?php echo(basename(get_permalink())); ?>',<?php endforeach;?>],<?php endwhile;else:endif;?>menu:false,navigation:true,navigationPosition:'right',<?php if(have_posts()):while(have_posts()):the_post();?>navigationTooltips:['<?php the_title(); ?>',<?php $args=array('orderby'=>'menu_order','order'=>'ASC','post_parent'=>$post->ID,'post_type'=>'page','post_status'=>'publish');$postslist=get_posts($args);foreach($postslist as $post):setup_postdata($post);?>'<?php the_title(); ?>',<?php endforeach;?>],<?php endwhile;else:endif;}?>slidesNavigation:true,slidesNavPosition:'bottom',loopBottom:false,loopTop:false,loopHorizontal:false,autoScrolling:true,scrollOverflow:true,css3:true,paddingTop:'0',paddingBottom:'0',normalScrollElements:'#altContent, #advisory-panel',normalScrollElementTouchThreshold:10,keyboardScrolling:true,touchSensitivity:5,fixedElements:'#mainMenu, #copyright, #cookie',continuousVertical:false,animateAnchor:true,sectionSelector:'.section',slideSelector:'.slide',onLeave:function(index,direction){$('.device-header').slideUp('slow');},afterLoad:function(anchorLink,index){},afterRender:function(){},afterSlideLoad:function(anchorLink,index,slideAnchor,slideIndex){},onSlideLeave:function(anchorLink,index,slideIndex,direction){}});var $container=$('#sortable');$container.imagesLoaded(function(){$container.isotope({itemSelector:'.col-1-3'});});$('#desktopfilters').on('click','button',function(e){e.preventDefault();$('.filterer').removeClass('activeFilter');$(this).addClass('activeFilter');var filterValue=$(this).attr('data-filter');var filterDesc=$(this).attr('data-desc');$('#cat_desc').fadeOut(250,'linear',function(){$('#cat_desc').html(filterDesc);$('#cat_desc').fadeIn(250,'linear');});$container.isotope({filter:filterValue});});$('#mobilefilters').on('click','button',function(e){e.preventDefault();$('.filterer').removeClass('activeFilter');$(this).addClass('activeFilter');var filterValue=$(this).attr('data-filter');var filterDesc=$(this).attr('data-desc');$('#cat_desc').fadeOut(250,'linear',function(){$('#cat_desc').html(filterDesc);$('#cat_desc').fadeIn(250,'linear');});$('.filterhide').hide('slow');$container.isotope({filter:filterValue});});$('#mobilefilters').on('click','h4',function(e){$('.filterhide').show('slow');$(this).addClass('open');});$('#mobilefilters').on('click','h4.open',function(e){$('.filterhide').hide('slow');$(this).removeClass('open');});});$(document).keyup(function(e){if(e.keyCode==27){$('.device-header').slideUp('slow');}});function exists(data){if(!data||data==null||data=='undefined'||typeof(data)=='undefined')return false;else return true;}
</script>