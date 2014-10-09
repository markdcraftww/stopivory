<?php get_header(); ?>
<div id="page" role="main">	
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>" style="background: url(<?php $args = array ( 'pagename' => 'Who We Work With Background Image');$query = new WP_Query( $args ); if ( $query->have_posts() ) { while ( $query->have_posts() ) { $query->the_post(); global $post; $image = get_post_meta( $post->ID, '_cmb_bg', true ); echo $image; }} else {} wp_reset_postdata();?>) no-repeat center center;">
		<div class="grid" id="pageText">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="col-1-2">
				<div <?php post_class('orgn'); ?> itemscope itemtype="http://schema.org/<?php global $post; $schema = get_post_meta( $post->ID, '_cmb_schema', true ); if( $schema != '' ) :  ?><?php global $post; $schema = get_post_meta( $post->ID, '_cmb_schema', true ); echo $schema;  ?><?php else : ?>Organization<?php endif; ?>">
					<meta itemprop="description" content="<?php $myExcerpt = get_the_excerpt(); $tags = array("<p>", "</p>"); $myExcerpt = str_replace($tags, "", $myExcerpt); echo $myExcerpt; ?>"/>
					<div class="team">
						<div class="padding">
							<div class="img">
								<?php if(has_post_thumbnail()) : the_post_thumbnail('large');  else : endif;?>
							</div>
							<div class="teamContent">
								<h4 itemprop="name"><?php the_title(); ?></h4>
								<?php the_content(); ?>
								<p><span><a href="<?php print $_SERVER['HTTP_REFERER'];?>"><i class="fa fa-arrow-circle-o-left"></i> Back</a></span></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-1-2">
				<div <?php post_class('orgn newsList'); ?>>
					<div class="team">
						<div class="padding">
							<h2>News and Activity</h2>
							<ul>
							<?php
				    			$args = array (
				    				'connected_type' => 'orgs2news',
				    				'connected_items' => $post,
				    				'nopaging' => true,
				    				'orderby' => 'rand'
				    			);
				    			$lecture_speaker = new WP_Query( $args );
				    			if ( $lecture_speaker->have_posts() ) {
				    				while ( $lecture_speaker->have_posts() ) {
				    					$lecture_speaker->the_post();
				    		?>    								
								<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?> <i class="fa fa-arrow-circle-o-right"></i></a></li>
				    		<?php
				    				}
				    			} else {
				    		?>
				    			<li>No news found</li>
				    		<?php
				    			}
				    			wp_reset_postdata();
				    		?>	
							</ul>
						</div>
					</div>				
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