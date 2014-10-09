<?php get_header(); ?>
<div id="page" role="main">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>	
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>" style="background: url(<?php $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); echo $url; ?>) no-repeat center center;">
		<div class="grid" id="pageText">
			
			<div <?php post_class('col-1-1'); ?> itemscope itemtype="http://schema.org/Article">
				<meta itemprop="description" content="<?php $myExcerpt = get_the_excerpt(); $tags = array("<p>", "</p>"); $myExcerpt = str_replace($tags, "", $myExcerpt); echo $myExcerpt; ?>"/>
				<div class="newsImg">
					<?php 
						if(mobile_detected($devices)) {
					?>
					<?php the_post_thumbnail('mobile'); ?>
					<?php
						} else {
					?>
					<?php the_post_thumbnail('sliver'); ?>
					<?php
						}
					?>				
				</div>
				<div <?php post_class('partner'); ?>>
					<h2 itemprop="name headline"><?php the_title(); ?></h2>
					<?php global $post; $sub = get_post_meta( $post->ID, '_cmb_sub', true ); if( $sub != '' ) :  ?>
						<h3><?php global $post; $sub = get_post_meta( $post->ID, '_cmb_sub', true ); echo $sub;  ?></h3>
					<?php endif; ?>					
					<h4>
						<?php global $post; $location = get_post_meta( $post->ID, '_cmb_location', true ); if( $location != '' ) :  ?>
							<?php global $post; $location = get_post_meta( $post->ID, '_cmb_location', true ); echo $location;  ?>, 
						<?php endif; ?>
						<?php the_time('jS F, Y') ?>
					</h4>
					<div itemprop="articleBody">
						<?php the_content(); ?>
					</div>
					<p><span itemscope itemprop="author" itemtype="http://schema.org/Person"><span itemprop="name"><?php the_author(); ?></span></span>, <em><?php the_author_description(); ?></em></p>
					<p><span><a href="<?php print $_SERVER['HTTP_REFERER'];?>"><i class="fa fa-arrow-circle-o-left"></i> Back</a></span></p>
				</div>
				<div id="nav">
					<div class="col-1-2 nopad"><div class="navArrows alignleft"><?php next_post_link('%link', '<i class="fa fa-arrow-circle-o-left"></i> Next', FALSE); ?></div></div>
					<div class="col-1-2 nopad"><div class="navArrows alignright"><?php previous_post_link('%link', 'Previous <i class="fa fa-arrow-circle-o-right"></i>', FALSE); ?></div></div>
				</div>
			</div>
			<?php endwhile; else :  endif; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
<script>
$(function(){var owl=$("#homePageCarousel");owl.owlCarousel({navigation:true,slideSpeed:2000,paginationSpeed:800,singleItem:true,autoPlay:5000,stopOnHover:true,transitionStyle:'fade'});$('.device-header').slideUp('slow');$('.menuToggle').on('click','a',function(e){e.preventDefault();$('.device-header').slideDown('slow');$(this).addClass('activeOpen');$('.menuToggle').on('click', '.activeOpen', function(e){e.preventDefault;$('.device-header').slideUp('slow');$(this).removeClass('activeOpen')});});$('.device-header').on('click','a',function(){$('.device-header').slideUp('slow');});if(exists($.cookie('StopIvory_Cookie'))) {} else {$('#cookie').fadeIn('fast');$.cookie('StopIvory_Cookie', 'StopIvory', {expires: 1000000, path: '/'});}$('#closeCookie').on('click', function(e){e.preventDefault();$('#cookie').fadeOut('fast');});
$('#page').fullpage({verticalCentered:true,resize:true,scrollingSpeed:700,easing:'easeInQuart',navigation:false,slidesNavigation:true,slidesNavPosition:'bottom',loopBottom:false,loopTop:false,loopHorizontal:false,autoScrolling:true,scrollOverflow:true,css3:true,paddingTop:'0',paddingBottom:'0',normalScrollElements:'#altContent, #advisory-panel',normalScrollElementTouchThreshold:10,keyboardScrolling:true,touchSensitivity:5,fixedElements:'#mainMenu, #copyright, #cookie',continuousVertical:false,animateAnchor:true,sectionSelector:'.section',slideSelector:'.slide',onLeave:function(index,direction){$('.device-header').slideUp('slow');},afterLoad:function(anchorLink,index){},afterRender:function(){},afterSlideLoad:function(anchorLink,index,slideAnchor,slideIndex){},onSlideLeave:function(anchorLink,index,slideIndex,direction){}});var $container=$('#sortable');$container.imagesLoaded(function(){$container.isotope({itemSelector:'.col-1-3'});});$('#desktopfilters').on('click','button',function(e){e.preventDefault();$('.filterer').removeClass('activeFilter');$(this).addClass('activeFilter');var filterValue=$(this).attr('data-filter');var filterDesc=$(this).attr('data-desc');$('#cat_desc').fadeOut(250,'linear',function(){$('#cat_desc').html(filterDesc);$('#cat_desc').fadeIn(250,'linear');});$container.isotope({filter:filterValue});});$('#mobilefilters').on('click','button',function(e){e.preventDefault();$('.filterer').removeClass('activeFilter');$(this).addClass('activeFilter');var filterValue=$(this).attr('data-filter');var filterDesc=$(this).attr('data-desc');$('#cat_desc').fadeOut(250,'linear',function(){$('#cat_desc').html(filterDesc);$('#cat_desc').fadeIn(250,'linear');});$('.filterhide').hide('slow');$container.isotope({filter:filterValue});});$('#mobilefilters').on('click','h4',function(e){$('.filterhide').show('slow');$(this).addClass('open');});$('#mobilefilters').on('click','h4.open',function(e){$('.filterhide').hide('slow');$(this).removeClass('open');});});$(document).keyup(function(e){if(e.keyCode==27){$('.device-header').slideUp('slow');}});function exists(data){if(!data||data==null||data=='undefined'||typeof(data)=='undefined')return false;else return true;}
</script>