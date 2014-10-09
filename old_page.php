<?php get_header(); ?>

<?php
$devices = array(
	"iphone", "ipod", "ipad", "android", "windows ce", "windows phone os", "blackberry", "palm", "symbian", "series60"
);
?>

<?php if( is_page('Splash') ) { ?>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php 
		if(mobile_detected($devices)) {
	?>
		<div class="section" data-anchor="news" style="background: url(<?php global $post; $image = get_post_meta( $post->ID, '_cmb_bg_p', true ); echo $image;  ?>) no-repeat center center;">
	<?php } else { ?>
		<div class="section" data-anchor="news" style="background: url(<?php global $post; $image = get_post_meta( $post->ID, '_cmb_bg', true ); echo $image;  ?>) no-repeat center center;">
	<?php } ?>
		<div class="grid dark">
			<div class="col-1-2">
				&nbsp;
			</div>
			<div class="col-1-2">
				<h3>Stop Ivory commits to $2 Million to Launch <br />Elephant Protection Initiative</h3>
				<p><a href="/wp-content/uploads/2014/02/statement.pdf" target="_blank" class="button" onclick="ga('send','event','Stop Ivory News','downloads/statement.pdf')">Read full statement</a></p>
				<p><a href="/wp-content/uploads/2014/02/Elephant-Protection-Initiative-210214.pdf" target="_blank" class="button" onclick="ga('send','event','Stop Ivory News','downloads/Elephant_Protection_Initiative.pdf')">Read Full Initiative</a></p>
				<p><a href="stop-ivory/" class="button">Go to main site</a></p>
			</div>
		</div>
	</div>
	<?php endwhile; else :  endif; ?>
	
<?php } ?>

<?php if( is_page('Stop Ivory') ) { ?>
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>" style="background: url(<?php global $post; $image = get_post_meta( $post->ID, '_cmb_bg', true ); echo $image;  ?>) no-repeat center center;">

	<div class="grid" id="">
		<div class="col-3-4">
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
					<div <?php post_class('newsGridHome'); ?>>
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('big'); ?>
						<div class="padding">
							<h4><?php the_title(); ?></h4>
			    			<h5>
			    				<?php global $post; $location = get_post_meta( $post->ID, '_cmb_location', true ); if( $location != '' ) :  ?>
			    					<?php global $post; $location = get_post_meta( $post->ID, '_cmb_location', true ); echo $location;  ?>, 
			    				<?php endif; ?>
			    				<?php the_time('jS F, Y') ?>
			    			</h5>
			    			<?php the_excerpt() ?> 
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
				<a class="twitter-timeline" data-dnt="true" href="https://twitter.com/StopIvory" data-widget-id="477086014574297088" data-chrome="noborders nofooter transparent" data-link-color="#a21b25" data-theme="dark" data-aria-polite="assertive" width="300">Tweets by @StopIvory</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			</article>
		</div>
	</div>	
			
	</div>	
	
	<?php endwhile; else :  endif; ?>
	
<?php } ?>

<?php if( is_page('Who We Are') ) { ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>	
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>" style="background: url(<?php global $post; $image = get_post_meta( $post->ID, '_cmb_bg', true ); echo $image;  ?>) no-repeat center center;">
		<div class="grid">
			<div class="col-9-12 push-1-8">
				<?php the_content(); ?>
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
		<?php 
			if(mobile_detected($devices)) {
		?>
		<div class="slide" data-anchor="<?php echo(basename(get_permalink())); ?>">
			<h2><?php the_title(); ?></h2>
		</div>
		<?php
			$args = array (
				'post_type' => basename(get_permalink()),
    			'orderby' => 'menu_order',
    			'order' => 'ASC',
			);
			$query = new WP_Query( $args );
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
			?>
		<div class="slide" data-anchor="<?php the_title(); ?>">
			<div class="teamHolder">
				<div class="team">
					<div class="teamImage">
						<?php if(has_post_thumbnail()) : the_post_thumbnail('large');  else : endif;?>
					</div>
					<div class="teamContent">
						<h4><?php the_title(); ?></h4>
						<?php global $post; $job = get_post_meta( $post->ID, '_cmb_job', true ); if($job != '') : ?>
						<h5><?php global $post; $job = get_post_meta( $post->ID, '_cmb_job', true ); echo $job; ?></h5>
						<?php endif; ?>
						<?php the_content(); ?>
					</div>
				</div>			
			</div>
		</div>
		<?php
			}
		} else {
			// no posts found
		}
		wp_reset_postdata();
		?>
		<?php		
			} else {
		?>
		<div class="grid">
			<div class="col-9-12 push-1-8">
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
			<div class="col-1-3">
				<div class="team">
					<div class="teamImage">
						<?php if(has_post_thumbnail()) : the_post_thumbnail('large');  else : endif;?>
					</div>
					<div class="teamContent">
						<h4><?php the_title(); ?></h4>
						<?php global $post; $job = get_post_meta( $post->ID, '_cmb_job', true ); if($job != '') : ?>
						<h5><?php global $post; $job = get_post_meta( $post->ID, '_cmb_job', true ); echo $job; ?></h5>
						<?php endif; ?>
						<?php the_content(); ?>
					</div>
				</div>
			</div>
		<?php	
			}
		?>
		<?php 
			if ( 'board-of-trustees' == get_post_type() ) {
		?>
			<div class="col-1-4">
				<div class="team">
					<div class="teamImage">
						<?php if(has_post_thumbnail()) : the_post_thumbnail('who');  else : endif;?>
					</div>
					<div class="teamContent">
						<h4><?php the_title(); ?></h4>
						<?php global $post; $job = get_post_meta( $post->ID, '_cmb_job', true ); if($job != '') : ?>
						<h5><?php global $post; $job = get_post_meta( $post->ID, '_cmb_job', true ); echo $job; ?></h5>
						<?php endif; ?>
						<?php the_content(); ?>
					</div>
				</div>
			</div>
		<?php	
			}
		?>
		<?php 
			if ( 'advisory-panel' == get_post_type() ) {
		?>
			<?php if ($count == 1) : ?>
			<div class="slide">
			<div class="grid">
				<div class="col-9-12 push-1-8">
					<h2><?php $post_type = get_post_type_object( get_post_type($post) ); echo $post_type->label; ?></h2>
				</div>
			</div>
			<?php endif; ?>
				<div class="col-1-5">
					<div class="team">
						<div class="teamContent">
							<h4><?php the_title(); ?></h4>
							<?php global $post; $job = get_post_meta( $post->ID, '_cmb_job', true ); if($job != '') : ?>
							<h5><?php global $post; $job = get_post_meta( $post->ID, '_cmb_job', true ); echo $job; ?></h5>
							<?php endif; ?>
							<?php the_content(); ?>
						</div>
					</div>
				</div>
			<?php if ($count == 5) : ?>
			</div>
			<div class="slide">
			<div class="grid">
				<div class="col-9-12 push-1-8">
					<h2><?php $post_type = get_post_type_object( get_post_type($post) ); echo $post_type->label; ?></h2>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($count%10 == 0) : ?>
			</div>
			<?php endif; ?>
		<?php	
			}
		?>
		
		<?php
				}
    		} else {}
    		wp_reset_postdata();	
			}
		?>
		</div>
	</div>
	<?php endforeach; ?>	
	<?php endwhile; else :  endif; ?>
	
<?php } ?>

<?php if( is_page('Why We Exist') ) { ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>" style="background: url(<?php global $post; $image = get_post_meta( $post->ID, '_cmb_bg', true ); echo $image;  ?>) no-repeat center center;">
		<div class="grid">
			<div class="col-9-12 push-1-8">
				<?php the_content(); ?>
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

	<div class="content">
		<div class="title">
			<h3><?php the_title(); ?></h3>
				<?php 
					if(mobile_detected($devices)) {
						
					} else {
				?>
			<?php global $post; $pdf = get_post_meta( $post->ID, '_cmb_pdf', true ); if( $pdf != '' ) :  ?>
				<div class="related">
					<h4>Related Information:</h4>
					<?php echo apply_filters( 'the_content', get_post_meta( get_the_ID(), $prefix . '_cmb_pdf', true ) );  ?>
				</div>
			<?php endif; ?>
			<?php } ?>
		</div>
		<div class="container">
			<?php the_content(); ?>
		</div>
	</div>
	</div>
	<?php endforeach; ?>	
	<?php endwhile; else :  endif; ?>
	
<?php } ?>

<?php if( is_page('How It Works') ) { ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>" style="background: url(<?php global $post; $image = get_post_meta( $post->ID, '_cmb_bg', true ); echo $image;  ?>) no-repeat center center;">
		<div class="grid">
			<div class="col-9-12 push-1-8">
				<?php the_content(); ?>
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
	<?php 
		if(mobile_detected($devices)) {
	?>
	<?php if($post->post_content=="") : ?>
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
			if ( 'actions' == get_post_type() ) {
		?>
		<div class="slide">
			<div class="col-1-3">
				<h2><?php global $post; $ar = get_post_meta( $post->ID, '_cmb_ar', true ); echo $ar;  ?></h2>
				<div <?php post_class('wwd'); ?>>
					<h4><?php the_title(); ?></h4>
					<?php the_content(); ?>
				</div>
			</div>
		</div>
		<?php
			}
		?>
		<?php
			}
		} else {
			// no posts found
		}
		wp_reset_postdata();
		?>
		<?php else : ?>
		<h2><?php the_title(); ?></h2>	
		<div class="grid grid-big">
			<div class="col-1-1">
				<div <?php post_class('faq'); ?>>
					<?php the_content(); ?>
				</div>
			</div>
		</div>
		<?php endif; ?>
	<?php
		} else {
	?>
		<?php if($post->post_content=="") : ?>
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
			if ( 'actions' == get_post_type() ) {
		?>
		<?php if ($count == 1) : ?>
		<div class="slide">
		<div class="grid nopad">
		<?php endif; ?>
		<?php if ($count == 1) : ?>
		<div class="grid">
			<div class="col-9-12 push-1-8">
				<h2>ACTIONS</h2>
			</div>
		</div>
		<?php endif; ?>
			<div class="col-1-3">
				<div <?php post_class('wwd'); ?>>
					<h4><?php the_title(); ?></h4>
					<?php the_content(); ?>
				</div>
			</div>
		<?php if ($count == 3) : ?>
    	</div>
    	</div>
    	<div class="slide">
    	<div class="grid grid-big">
    		<div class="col-1-1">
				<div class="grid">
					<div class="col-9-12 push-1-8">
						<h2>RESULTS</h2>
					</div>
				</div>
    		</div>
    	<div class="col-1-4">&nbsp;</div>
    	<?php endif; ?>
    	<?php if ($count%4 == 0) : ?>
    	<div class="col-1-4">&nbsp;</div>
    	</div>
    	</div>
    	<?php endif; ?>
		<?php
			}
		?>
		<?php
			}
		} else {
			// no posts found
		}
		wp_reset_postdata();
		?>		
		<?php else : ?>
		<div class="grid">
			<div class="col-9-12 push-1-8">
				<h2><?php the_title(); ?></h2>	
				<div <?php post_class('faq'); ?>>
					<?php the_content(); ?>
				</div>
			</div>
		</div>
		<?php endif; ?>
	<?php
		} 
	?>
	</div>
	<?php endforeach; ?>	
	<?php endwhile; else :  endif; ?>
	
<?php } ?>



<?php if( is_page('What We\'re Doing') ) { ?>
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>" style="background: url(<?php global $post; $image = get_post_meta( $post->ID, '_cmb_bg', true ); echo $image;  ?>) no-repeat center center;">
		<div class="grid">
		<?php
		$args = array (
			'post_type'              => 'news',
			'pagination'             => true,
			'posts_per_page'         => '6',
			'order'                  => 'DESC',
			'orderby'                => 'date',
		);
		$news = new WP_Query( $args );
		if ( $news->have_posts() ) {
			while ( $news->have_posts() ) {
				$news->the_post();
		?>
			<div class="col-1-4">
				<div <?php post_class('newsGrid'); ?>>
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('grid'); ?>
					<h4><?php the_title(); ?></h4>
	    			<h5>
	    				<?php global $post; $location = get_post_meta( $post->ID, '_cmb_location', true ); if( $location != '' ) :  ?>
	    					<?php global $post; $location = get_post_meta( $post->ID, '_cmb_location', true ); echo $location;  ?>, 
	    				<?php endif; ?>
	    				<?php the_time('jS F, Y') ?>
	    			</h5>
	    			<?php the_excerpt() ?></a>
				</div>
			</div>
		<?php
			}
		} else {
			// no posts found
		}
		wp_reset_postdata();
		?>
			<div class="col-1-4">
				<div class="newsGrid">
					<ul class="filter">
					<?php
					$args = array(
						'orderby'            => 'ID',
						'order'              => 'ASC',
						'style'              => 'list',
						'show_count'         => 0,
						'hide_empty'         => 1,
						'use_desc_for_title' => 1,
						'child_of'           => 0,
						'hierarchical'       => true,
						'title_li'           => __( 'REFINE BY TAG:' ),
						'show_option_none'   => __(''),
						'number'             => NULL,
						'echo'               => 1,
						'depth'              => 0,
						'current_category'   => 0,
						'pad_counts'         => 1,
						'taxonomy'           => 'filter',
						'walker'             => ''
					);
					wp_list_categories($args);
					?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	
<?php } ?>

<?php if( is_page('Contact Us') ) { ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>" style="background: url(<?php global $post; $image = get_post_meta( $post->ID, '_cmb_bg', true ); echo $image;  ?>) no-repeat center center;">
		<?php the_content(); ?>
		<div class="grid">
			<div class="col-9-12 push-1-8">
				<h2>CONTACT US</h2>
			</div>
		</div>
		<div class="grid">
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
			<div class="col-1-2">
				<div <?php post_class('details contactDetails'); ?>>
					<h4><?php the_title(); ?></h4>
					<?php the_content(); ?>
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
	
	<?php endwhile; else :  endif; ?>
	
<?php } ?>

<?php get_footer(); ?>
<script>
$(function() {var owl = $("#homePageCarousel");owl.owlCarousel({navigation : true,slideSpeed : 2000,paginationSpeed : 800,singleItem:true,autoPlay : 5000,stopOnHover : true,transitionStyle: 'fade'});$('.device-header').slideUp('slow');$('.menuToggle').on('click', 'a', function(e){e.preventDefault();$('.device-header').slideDown('slow');});$('.device-header').on('click', 'a', function(){$('.device-header').slideUp('slow');});$('.tweets-list-container').tweetscroll({ username: 'StopIvory', time: true, limit: 4,replies: true, position: 'prepend', date_format: 'style2', animation: 'slide_down', visible_tweets: 3 });if(exists($.cookie('StopIvory_Cookie'))) {} else {	$('#cookie').fadeIn('slow');$.cookie('StopIvory_Cookie', 'StopIvory', { expires: 1000000, path: '/' });}
$.fn.fullpage({verticalCentered: true,resize : true,scrollingSpeed: 700,easing: 'easeInQuart',<?php if( is_page( array( 'Stop Ivory', 'Contact Us' ) ) ) { ?> navigation: false, <? } else { if (have_posts()) : while (have_posts()) : the_post(); ?>anchors:['<?php echo(basename(get_permalink())); ?>',<?php $args = array( 'orderby' => 'menu_order','order' => 'ASC', 'post_parent' => $post->ID, 'post_type' => 'page', 'post_status' => 'publish'); $postslist = get_posts($args); foreach ($postslist as $post) : setup_postdata($post); ?>'<?php echo(basename(get_permalink())); ?>',<?php endforeach; ?>],<?php endwhile; else :  endif; ?>menu: false,navigation: true,<?php if (have_posts()) : while (have_posts()) : the_post(); ?>navigationTooltips: ['<?php the_title(); ?>', <?php $args = array( 'orderby' => 'menu_order','order' => 'ASC', 'post_parent' => $post->ID, 'post_type' => 'page', 'post_status' => 'publish' ); $postslist = get_posts($args); foreach ($postslist as $post) : setup_postdata($post); ?>'<?php the_title(); ?>',<?php endforeach; ?>],<?php endwhile; else :  endif; } ?>slidesNavigation: true,slidesNavPosition: 'top',loopBottom: false,loopTop: false,loopHorizontal: false,autoScrolling: true,scrollOverflow: true,css3: true,paddingTop: '0',paddingBottom: '0',fixedElements: '#mainMenu, .device-header, .menuToggle, #mainMenu, #copyright, #cookie',keyboardScrolling: true,touchSensitivity: 20,onLeave: function(index, direction){$('.device-header').slideUp('slow');},afterLoad: function(anchorLink, index){},afterRender: function(){},afterSlideLoad: function(anchorLink, index, slideAnchor, slideIndex){},onSlideLeave: function(anchorLink, index, slideIndex, direction){}});});
$(document).keyup(function(e) {if(e.keyCode == 27) {$('.device-header').slideUp('slow');}});
function exists(data) {if(!data || data==null || data=='undefined' || typeof(data)=='undefined') return false;else return true;}
</script>