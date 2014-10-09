<?php get_header(); ?>

<?php if( is_page('Stop Ivory') ) { ?>
<div id="page" role="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>" style="background: url(<?php global $post; $image = get_post_meta( $post->ID, '_cmb_bg', true ); echo $image;  ?>) no-repeat center center;">
			<div class="grid" id="pageText">
				<div class="col-3-4 tablet-1-1">
					<div class="grid owl-carousel" id="homePageCarousel" data-owlCarousel>
					<?php
					$args = array (
						'post_type'              => 'news',
						'pagination'             => true,
						'post__in'				 => get_option('sticky_posts'),
						'order'                  => 'DESC',
						'orderby'                => 'date',
					);
					$news = new WP_Query( $args );
					if ( $news->have_posts() ) {
						while ( $news->have_posts() ) {
							$news->the_post();
					?>
						<div class="col-1-1 nopad">
							<div <?php post_class('newsGridHome'); ?> itemscope itemtype="http://schema.org/Article">
								<meta itemprop="description" content="<?php $myExcerpt = get_the_excerpt(); $tags = array("<p>", "</p>"); $myExcerpt = str_replace($tags, "", $myExcerpt); echo $myExcerpt; ?>"/>
								<a href="<?php the_permalink(); ?>">
								<div class="img">
									<?php the_post_thumbnail('big'); ?>
								</div>
								<div class="padding">
									<h4 itemprop="name headline"><?php the_title(); ?></h4>
					    			<h5>
					    				<?php global $post; $location = get_post_meta( $post->ID, '_cmb_location', true ); if( $location != '' ) :  ?>
					    					<?php global $post; $location = get_post_meta( $post->ID, '_cmb_location', true ); echo $location;  ?>, 
					    				<?php endif; ?>
					    				<?php the_time('jS F, Y') ?>
					    			</h5>
					    			<div itemprop="articleBody">
						    			<?php the_excerpt() ?> 
					    			</div>
					    			<span>Read more <i class="fa fa-arrow-circle-o-right"></i></span>
								</div>	
					    		</a>
							</div>
						</div>
					<?php
						}
					} else {
						// no posts found
					}
					wp_reset_postdata();
					?>
					</div>		
				</div>
				<div class="col-1-4">
					<article id="twitter" class="clearfix">
						<h3>TWITTER NEWSFEED</h3>
						<a class="twitter-timeline" data-dnt="true" href="https://twitter.com/StopIvory" data-widget-id="477086014574297088" data-chrome="noborders nofooter transparent" data-link-color="#a21b25" data-theme="light" data-aria-polite="assertive" width="300">Tweets by @StopIvory</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
					</article>
				</div>
			</div>
		</div>	
		
	<?php endwhile; else :  endif; ?>
</div>	
<?php } ?>

<?php if( is_page('Who we are') ) { ?>
<div id="page" role="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>	
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>" style="background: url(<?php global $post; $image = get_post_meta( $post->ID, '_cmb_bg', true ); echo $image;  ?>) no-repeat center center;">
		<div class="grid" id="altContent">
			<div class="col-1-1">
				<div class="pageContent">
					<h2><?php the_title(); ?></h2>
				</div>
			</div>
			<div class="col-1-3 push-2-3">
				<div class="padding pageContent pageText">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</div>	
	<?php 
		$args = array( 
			'orderby' => 'menu_order',
			'order' => 'ASC', 
			'post_parent' => $post->ID, 
			'post_type' => 'page', 
			'post_status' => 'publish' 
		); 
		$postslist = get_posts($args); 
		foreach ($postslist as $post) : setup_postdata($post); 
	?>
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>" style="background: url(<?php global $post; $image = get_post_meta( $post->ID, '_cmb_bg', true ); echo $image;  ?>) no-repeat center center;"> 

		<div class="grid pageFull nopad">
			<div class="col-1-2">
				<h2 class="whoweareTitle"><?php the_title(); ?></h2>
			</div>
		</div>
		
		<div class="grid pageFull nopad">
		<?php
			$count = 0;
			$args = array (
    			'post_type' => basename(get_permalink()),
    			'orderby' => 'menu_order',
    			'order' => 'ASC',
    		);
    		$query = new WP_Query( $args );	
    		if ( $query->have_posts() ) {
    			while ( $query->have_posts() ) {
    				$query->the_post();
    				$count++;
		?>	
		<?php 
			if ( 'executive-team' == get_post_type() ) {
		?>
			<div <?php post_class('col-1-3'); ?> itemscope itemtype="http://schema.org/Person">
				<div class="team">
					<div class="padding">
						<div class="img">
							<?php if(has_post_thumbnail()) : the_post_thumbnail('large');  else : endif;?>
						</div>
						<div class="teamContent">
							<h4 itemprop="name"><?php the_title(); ?></h4>
							<?php global $post; $job = get_post_meta( $post->ID, '_cmb_job', true ); if($job != '') : ?>
							<h5 itemscope itemtype="http://schema.org/Organization"><?php global $post; $job = get_post_meta( $post->ID, '_cmb_job', true ); echo $job; ?></h5>
							<?php endif; ?>
							<?php the_content(); ?>
						</div>
					</div>
				</div>
			</div>
		<?php	
			}
		?>
		<?php 
			if ( 'board-of-trustees' == get_post_type() ) {
		?>
			<div <?php post_class('col-1-4'); ?> itemscope itemtype="http://schema.org/Person">
				<div class="team">
					<div class="padding">
						<div class="img">
							<?php if(has_post_thumbnail()) : the_post_thumbnail('large');  else : endif;?>
						</div>
						<div class="teamContent">
							<h4 itemprop="name"><?php the_title(); ?></h4>
							<?php global $post; $job = get_post_meta( $post->ID, '_cmb_job', true ); if($job != '') : ?>
							<h5 itemscope itemtype="http://schema.org/Organization"><?php global $post; $job = get_post_meta( $post->ID, '_cmb_job', true ); echo $job; ?></h5>
							<?php endif; ?>
							<?php the_content(); ?>
						</div>
					</div>
				</div>
			</div>
		<?php	
			}
		?>
		<?php 
			if ( 'advisory-panel' == get_post_type() ) {
		?>

			<div <?php post_class('col-1-4'); ?> itemscope itemtype="http://schema.org/Person">
				<div class="team">
					<div class="padding">
						<div class="img">
							<?php if(has_post_thumbnail()) : the_post_thumbnail('large');  else : endif;?>
						</div>
						<div class="teamContent">
							<h4 itemprop="name"><?php the_title(); ?></h4>
							<?php global $post; $job = get_post_meta( $post->ID, '_cmb_job', true ); if($job != '') : ?>
							<h5 itemscope itemtype="http://schema.org/Organization"><?php global $post; $job = get_post_meta( $post->ID, '_cmb_job', true ); echo $job; ?></h5>
							<?php endif; ?>
							<?php the_content(); ?>
						</div>
					</div>
				</div>
			</div>
		<?php	
			}
		?>
		
		<?php
				}
    		} else {}
    		wp_reset_postdata();	
		?>
		</div>
	</div>
	<?php endforeach; ?>	
	<?php endwhile; else :  endif; ?>
</div>			
<?php } ?>

<?php if( is_page(array('Why we exist','How it works')) ) { ?>
<div id="page" role="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>" style="background: url(<?php global $post; $image = get_post_meta( $post->ID, '_cmb_bg', true ); echo $image;  ?>) no-repeat center center;">
		<div class="grid" id="altContent">
			<div class="col-1-1">
				<div class="pageContent">
					<h2><?php the_title(); ?></h2>
				</div>
			</div>
			<div class="col-1-3 push-2-3">
				<div class="padding pageContent pageText">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</div>	
	<?php 
		$args = array( 
			'orderby' => 'menu_order',
			'order' => 'ASC', 
			'post_parent' => $post->ID, 
			'post_type' => 'page', 
			'post_status' => 'publish' 
		); 
		$postslist = get_posts($args); 
		foreach ($postslist as $post) : setup_postdata($post); 
	?>
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>" style="background: url(<?php global $post; $image = get_post_meta( $post->ID, '_cmb_bg', true ); echo $image;  ?>) no-repeat center center;"> 

	<div class="grid" id="altContent">
		<div class="col-1-3">
			<h3><?php the_title(); ?></h3>
			<?php global $post; $pdf = get_post_meta( $post->ID, '_cmb_pdf', true ); if( $pdf != '' ) :  ?>
				<div class="related padding pageText">
					<h4>Related Information:</h4>
					<?php echo apply_filters( 'the_content', get_post_meta( get_the_ID(), $prefix . '_cmb_pdf', true ) );  ?>
				</div>
			<?php endif; ?>
		</div>
		<div class="col-2-3">
			<div class="padding pageText">
				<?php the_content(); ?>
			</div>
		</div>
	</div>
	</div>
	<?php endforeach; ?>	
	<?php endwhile; else :  endif; ?>
</div>	
<?php } ?>

<?php if( is_page('Contact us') ) { ?>
<div id="page" role="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>" style="background: url(<?php global $post; $image = get_post_meta( $post->ID, '_cmb_bg', true ); echo $image;  ?>) no-repeat center center;">

		<div class="grid" id="altContent">
			<div class="col-1-3">
				<h3><?php the_title(); ?></h3>
				<?php global $post; $pdf = get_post_meta( $post->ID, '_cmb_pdf', true ); if( $pdf != '' ) :  ?>
					<div class="related padding pageText">
						<h4>Related Information:</h4>
						<?php echo apply_filters( 'the_content', get_post_meta( get_the_ID(), $prefix . '_cmb_pdf', true ) );  ?>
					</div>
				<?php endif; ?>
			</div>
			<div class="col-2-3">
				<div class="padding pageText">
				<?php
					$count = 0;
					$args = array (
		    			'post_type' => 'contacts',
		    			'orderby' => 'date',
		    			'order' => 'DESC',
		    		);
		    		$query = new WP_Query( $args );	
		    		if ( $query->have_posts() ) {
		    			while ( $query->have_posts() ) {
		    				$query->the_post();
		    				$count++;
				?>	
					<div <?php post_class('details contactDetails padding pageContent pageText'); ?>>
						<h4><?php the_title(); ?></h4>
						<?php the_content(); ?>
					</div>
				<?php		
					}
				} else {
					// no posts found
				}
				wp_reset_postdata();
				?>
				</div>
			</div>
		</div>
	
	</div>	
	
	<?php endwhile; else :  endif; ?>
</div>	
<?php } ?>

<?php get_footer(); ?>
<script>
$(function(){var owl=$("#homePageCarousel");owl.owlCarousel({navigation:true,slideSpeed:2000,paginationSpeed:800,singleItem:true,autoPlay:5000,stopOnHover:true,transitionStyle:'fade'});$('.device-header').slideUp('slow');$('.menuToggle').on('click','a',function(e){e.preventDefault();$('.device-header').slideDown('slow');$(this).addClass('activeOpen');$('.menuToggle').on('click', '.activeOpen', function(e){e.preventDefault;$('.device-header').slideUp('slow');$(this).removeClass('activeOpen')});});$('.device-header').on('click','a',function(){$('.device-header').slideUp('slow');});if(exists($.cookie('StopIvory_Cookie'))) {} else {$('#cookie').fadeIn('fast');$.cookie('StopIvory_Cookie', 'StopIvory', {expires: 1000000, path: '/'});}$('#closeCookie').on('click', function(e){e.preventDefault();$('#cookie').fadeOut('fast');});
$('#page').fullpage({verticalCentered:true,resize:true,scrollingSpeed:700,easing:'easeInQuart',<?php if(is_page(array('Stop Ivory','Contact us'))){?>navigation:false,<?}else{if(have_posts()):while(have_posts()):the_post();?>anchors:['<?php echo(basename(get_permalink())); ?>',<?php $args=array('orderby'=>'menu_order','order'=>'ASC','post_parent'=>$post->ID,'post_type'=>'page','post_status'=>'publish');$postslist=get_posts($args);foreach($postslist as $post):setup_postdata($post);?>'<?php echo(basename(get_permalink())); ?>',<?php endforeach;?>],<?php endwhile;else:endif;?>menu:false,navigation:true,navigationPosition:'right',<?php if(have_posts()):while(have_posts()):the_post();?>navigationTooltips:['<?php the_title(); ?>',<?php $args=array('orderby'=>'menu_order','order'=>'ASC','post_parent'=>$post->ID,'post_type'=>'page','post_status'=>'publish');$postslist=get_posts($args);foreach($postslist as $post):setup_postdata($post);?>'<?php the_title(); ?>',<?php endforeach;?>],<?php endwhile;else:endif;}?>slidesNavigation:true,slidesNavPosition:'bottom',loopBottom:false,loopTop:false,loopHorizontal:false,autoScrolling:true,scrollOverflow:true,css3:true,paddingTop:'0',paddingBottom:'0',normalScrollElements:'#altContent',normalScrollElementTouchThreshold:10,keyboardScrolling:true,touchSensitivity:5,fixedElements:'#mainMenu, #copyright, #cookie',continuousVertical:false,animateAnchor:true,sectionSelector:'.section',slideSelector:'.slide',onLeave:function(index,direction){$('.device-header').slideUp('slow');},afterLoad:function(anchorLink,index){},afterRender:function(){},afterSlideLoad:function(anchorLink,index,slideAnchor,slideIndex){},onSlideLeave:function(anchorLink,index,slideIndex,direction){}});var $container=$('#sortable');$container.imagesLoaded(function(){$container.isotope({itemSelector:'.col-1-3'});});$('#desktopfilters').on('click','button',function(e){e.preventDefault();$('.filterer').removeClass('activeFilter');$(this).addClass('activeFilter');var filterValue=$(this).attr('data-filter');var filterDesc=$(this).attr('data-desc');$('#cat_desc').fadeOut(250,'linear',function(){$('#cat_desc').html(filterDesc);$('#cat_desc').fadeIn(250,'linear');});$container.isotope({filter:filterValue});});$('#mobilefilters').on('click','button',function(e){e.preventDefault();$('.filterer').removeClass('activeFilter');$(this).addClass('activeFilter');var filterValue=$(this).attr('data-filter');var filterDesc=$(this).attr('data-desc');$('#cat_desc').fadeOut(250,'linear',function(){$('#cat_desc').html(filterDesc);$('#cat_desc').fadeIn(250,'linear');});$('.filterhide').hide('slow');$container.isotope({filter:filterValue});});$('#mobilefilters').on('click','h4',function(e){$('.filterhide').show('slow');$(this).addClass('open');});$('#mobilefilters').on('click','h4.open',function(e){$('.filterhide').hide('slow');$(this).removeClass('open');});});$(document).keyup(function(e){if(e.keyCode==27){$('.device-header').slideUp('slow');}});function exists(data){if(!data||data==null||data=='undefined'||typeof(data)=='undefined')return false;else return true;}
</script>