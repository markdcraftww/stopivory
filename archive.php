<?php get_header(); ?>
<div id="page" role="main">
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>" style="background: url(<?php $args = array ( 'pagename' => 'News Background Image');$query = new WP_Query( $args ); if ( $query->have_posts() ) { while ( $query->have_posts() ) { $query->the_post(); global $post; $image = get_post_meta( $post->ID, '_cmb_bg', true ); echo $image; }} else {} wp_reset_postdata();?>) no-repeat center center;">


	<div class="grid mobileFilter">
		<div class="col-1-1" id="filterHolder">
			<div id="mobilefilters">
				<div class="partner">
					<h3>Filter by: <i class="fa fa-caret-square-o-down"></i></h3>
					<div id="mobilefilter">
						<button href="#filter" data-filter="*" class="filterer">Show All</button>
						<ul class="filterList">
						<?php
							$args = array(
								'orderby'            => 'ID',
								'order'              => 'ASC',
								'style'              => 'list',
								'show_count'         => 0,
								'hide_empty'         => 1,
								'use_desc_for_title' => 0,
								'child_of'           => 0,
								'hierarchical'       => true,
								'title_li'           => '',
								'show_option_none'   => '',
								'number'             => NULL,
								'echo'               => 1,
								'depth'              => 0,
								'current_category'   => 0,
								'pad_counts'         => 0,
								'taxonomy'           => 'filter',
								'walker'             => new wpse_59862_walker()
							);
							wp_list_categories($args); 
						?>
						</ul>
						<?php
						if (have_posts()) :
						query_posts('post_type=news&posts_per_page=-1&taxonomy=filter&caller_get_posts=1&paged='. $paged );
						while (have_posts()) : the_post();
						?>
						<?php
						endwhile; else : endif;
						?>
					</div>
				</div>
			</div>
		</div>	
	</div>

		
	<div class="grid tabletText" id="pageText">	
		<div class="col-10-12 tablet-10-12 nopad">
			<div class="grid" id="sortable">	
				<?php
				if (have_posts()) :
				query_posts('post_type=news&posts_per_page=9&taxonomy=filter&caller_get_posts=1&paged='. $paged );
				while (have_posts()) : the_post();
				?>
				<div <?php post_class('col-1-3'); ?> itemscope itemtype="http://schema.org/Article">
					<meta itemprop="description" content="<?php $myExcerpt = get_the_excerpt(); $tags = array("<p>", "</p>"); $myExcerpt = str_replace($tags, "", $myExcerpt); echo $myExcerpt; ?>"/>
					<a href="<?php the_permalink(); ?>">
					<div class="team">
						<div class="padding">
							<div class="img">
								<?php if(has_post_thumbnail()) : the_post_thumbnail('large');  else : endif;?>
							</div>
							<div class="teamContent">
								<h2 itemprop="name headline"><?php the_title(); ?></h2>
								<div itemprop="articleBody">
									<?php the_excerpt(); ?>
								</div>
								<span>Read more <i class="fa fa-arrow-circle-o-right"></i></span>
							</div>
						</div>
					</div>
					</a>
				</div>	
				<?php
				endwhile; else : ?>
				<div class="col-1-3 news">
					<div class="partner">
						<h3>No news stories found</h3>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
		<div class="col-1-6 desktopFilter" id="desktopfilters">
			<div id="filter">
				<div class="partner">
					<?php
						$taxonomy = 'filter';
						$tax_terms = get_terms($taxonomy);
					?>
					<div id="desktopfilter">
					<h3>Filter by:</h3>
					<button href="#filter" data-filter="*" class="filterer activeFilter">Show All</button>
						<ul class="filterList">
						<?php
							$args = array(
								'orderby'            => 'ID',
								'order'              => 'ASC',
								'style'              => 'list',
								'show_count'         => 0,
								'hide_empty'         => 1,
								'use_desc_for_title' => 0,
								'child_of'           => 0,
								'hierarchical'       => true,
								'title_li'           => '',
								'show_option_none'   => '',
								'number'             => NULL,
								'echo'               => 1,
								'depth'              => 0,
								'current_category'   => 0,
								'pad_counts'         => 0,
								'taxonomy'           => 'filter',
								'walker'             => new wpse_59862_walker()
							);
							wp_list_categories($args); 
						?>
						</ul>
						<?php
						if (have_posts()) :
						query_posts('post_type=news&posts_per_page=9&taxonomy=filter&caller_get_posts=1&paged='. $paged );
						while (have_posts()) : the_post();
						?>
						<?php
						endwhile;
						?>				
						<?php						
						else : endif;
						?>
					</div>
				</div>
			</div>
		</div>
	</div>	
</div>
</div>
<?php get_footer(); ?>
<script>
$(function(){var owl=$("#homePageCarousel");owl.owlCarousel({navigation:true,slideSpeed:2000,paginationSpeed:800,singleItem:true,autoPlay:5000,stopOnHover:true,transitionStyle:'fade'});$('.device-header').slideUp('slow');$('.menuToggle').on('click','a',function(e){e.preventDefault();$('.device-header').slideDown('slow');$(this).addClass('activeOpen');$('.menuToggle').on('click', '.activeOpen', function(e){e.preventDefault;$('.device-header').slideUp('slow');$(this).removeClass('activeOpen')});});$('.device-header').on('click','a',function(){$('.device-header').slideUp('slow');});if(exists($.cookie('StopIvory_Cookie'))) {} else {$('#cookie').fadeIn('fast');$.cookie('StopIvory_Cookie', 'StopIvory', {expires: 1000000, path: '/'});}$('#closeCookie').on('click', function(e){e.preventDefault();$('#cookie').fadeOut('fast');});
$('#page').fullpage({verticalCentered:true,resize:true,scrollingSpeed:700,easing:'easeInQuart',navigation:false,slidesNavigation:true,slidesNavPosition:'bottom',loopBottom:false,loopTop:false,loopHorizontal:false,autoScrolling:true,scrollOverflow:true,css3:true,paddingTop:'0',paddingBottom:'0',normalScrollElements:'#altContent, #advisory-panel',normalScrollElementTouchThreshold:10,keyboardScrolling:true,touchSensitivity:5,fixedElements:'#mainMenu, #copyright, #cookie',continuousVertical:false,animateAnchor:true,sectionSelector:'.section',slideSelector:'.slide',onLeave:function(index,direction){$('.device-header').slideUp('slow');},afterLoad:function(anchorLink,index){},afterRender:function(){},afterSlideLoad:function(anchorLink,index,slideAnchor,slideIndex){},onSlideLeave:function(anchorLink,index,slideIndex,direction){}});var $container=$('#sortable');$container.imagesLoaded(function(){$container.isotope({itemSelector:'.col-1-3'});});$('#desktopfilters').on('click','button',function(e){e.preventDefault();$('.filterer').removeClass('activeFilter');$(this).addClass('activeFilter');var filterValue=$(this).attr('data-filter');var filterDesc=$(this).attr('data-desc');$('#cat_desc').fadeOut(250,'linear',function(){$('#cat_desc').html(filterDesc);$('#cat_desc').fadeIn(250,'linear');});$container.isotope({filter:filterValue});});$('#mobilefilters').on('click','button',function(e){e.preventDefault();$('.filterer').removeClass('activeFilter');$(this).addClass('activeFilter');var filterValue=$(this).attr('data-filter');var filterDesc=$(this).attr('data-desc');$('#cat_desc').fadeOut(250,'linear',function(){$('#cat_desc').html(filterDesc);$('#cat_desc').fadeIn(250,'linear');});$('#mobilefilter').hide('slow');$container.isotope({filter:filterValue});});$('#mobilefilters').on('click','h3',function(e){$('#mobilefilter').show('slow');$(this).addClass('open');});$('#mobilefilters').on('click','h3.open',function(e){$('#mobilefilter').hide('slow');$(this).removeClass('open');});$('#mobilefilters').on('click', 'button', function(){$('h3.open').removeClass('open');});});$(document).keyup(function(e){if(e.keyCode==27){$('.device-header').slideUp('slow');}});function exists(data){if(!data||data==null||data=='undefined'||typeof(data)=='undefined')return false;else return true;}
</script>