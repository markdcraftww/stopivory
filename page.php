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
				<p><a href="/stop-ivory/" class="button">Go to main site</a></p>
			</div>
		</div>
	</div>
	<?php endwhile; else :  endif; ?>
	
<?php } ?>

<?php if( is_page('Stop Ivory') ) { ?>
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>" style="background: url(<?php global $post; $image = get_post_meta( $post->ID, '_cmb_bg', true ); echo $image;  ?>) no-repeat center center;">
		<div class="homeLogo" <?php if(mobile_detected($devices)) { ?>style="background: url(<?php bloginfo('template_url'); ?>/img/home_logo_portrait.png) no-repeat center center"<?php } else { ?>style="background: url(<?php bloginfo('template_url'); ?>/img/home_logo.png) no-repeat center center"<?php }	?>></div>
		<article id="twitter" class="clearfix"><h3>NewsFeed</h3><a href="https://twitter.com/StopIvory" target="_blank" class="follow"><i class="fa fa-twitter"></i> Follow @StopIvory on Twitter</a><div class="tweets-list-container"></div></article>
		<div class="homePage"><?php the_content(); ?></div>
	</div>	
	
	<?php endwhile; else :  endif; ?>
	
<?php } ?>

<?php if( is_page('Who We Are') ) { ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>	
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>" style="background: url(<?php global $post; $image = get_post_meta( $post->ID, '_cmb_bg', true ); echo $image;  ?>) no-repeat center center;">
		<?php the_content(); ?>
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
		<h2 class="whoweareTitle"><?php the_title(); ?></h2>
		
			<div class="grid">
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
			<h2><?php $post_type = get_post_type_object( get_post_type($post) ); echo $post_type->label; ?></h2>
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
			<h2><?php $post_type = get_post_type_object( get_post_type($post) ); echo $post_type->label; ?></h2>
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
		<?php the_content(); ?>
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
		<?php the_content(); ?>
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
		<div class="grid">
		<?php endif; ?>
		<?php if ($count == 1) : ?>
		<h2>ACTIONS</h2>
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
    	<h2>RESULTS</h2>
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
		<h2><?php the_title(); ?></h2>	
		<div <?php post_class('faq'); ?>>
			<?php the_content(); ?>
		</div>
		<?php endif; ?>
	<?php
		} 
	?>
	</div>
	<?php endforeach; ?>	
	<?php endwhile; else :  endif; ?>
	
<?php } ?>

<?php if( is_page('Who We Work With') ) { ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>" style="background: url(<?php global $post; $image = get_post_meta( $post->ID, '_cmb_bg', true ); echo $image;  ?>) no-repeat center center;">
		<?php the_content(); ?>
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
			<div class="slide">
				<h2><?php the_title(); ?></h2>
				<?php //global $post; $ept = get_post_meta( $post->ID, '_cmb_ept', true ); if( $ept != '' ) :  ?>	
				<h4><?php global $post; $ept = get_post_meta( $post->ID, '_cmb_ept', true ); echo $ept;  ?></h4>
				<?php //endif; ?>			
			</div>
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
			<div class="slide">
				<div class="partner">
					<?php if(has_post_thumbnail()) : the_post_thumbnail();  else : endif;?>
					<h4><?php the_title(); ?></h4>
					<h4><?php global $post; $at = get_post_meta( $post->ID, '_cmb_at', true ); echo $at;  ?></h4>
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

		<h2><?php the_title(); ?></h2>
		<?php //global $post; $ept = get_post_meta( $post->ID, '_cmb_ept', true ); if( $ept != '' ) :  ?>	
		<h4><?php global $post; $ept = get_post_meta( $post->ID, '_cmb_ept', true ); echo $ept;  ?></h4>
		<?php //endif; ?>	
		<div class="grid">
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
			<div class="col-1-4">
				<div class="partner">
					<?php if(has_post_thumbnail()) : the_post_thumbnail();  else : endif;?>
					<h4><?php the_title(); ?></h4>
					<h4><?php global $post; $at = get_post_meta( $post->ID, '_cmb_at', true ); echo $at;  ?></h4>
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
		
		<?php
			}
		?>	
	</div>
	<?php endforeach; ?>	
	<?php endwhile; else :  endif; ?>
	
<?php } ?>

<?php if( is_page('What We\'re Doing') ) { ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>" style="background: url(<?php global $post; $image = get_post_meta( $post->ID, '_cmb_bg', true ); echo $image;  ?>) no-repeat center center;">
		<?php the_content(); ?>
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
			<div class="slide">
				<h2><?php the_title(); ?></h2>				
			</div>
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
			<div class="slide">
				<div <?php post_class('wwd'); ?>>
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
					
		<?php
			} else {
		?>

		<div class="grid">
		<?php
			$count = 0;
			$args = array (
    			'post_type' => basename(get_permalink()),
    			'orderby' => 'date',
    			'order' => 'DESC',
    		);
    		$query = new WP_Query( $args );	
    		if ( $query->have_posts() ) {
    			while ( $query->have_posts() ) {
    				$query->the_post();
    				$count++;
		?>	
			<?php if ($count == 1) : ?>
			<div class="slide">
			<?php endif; ?>
			<div class="col-1-4">
				<div <?php post_class('wwd'); ?>>
					<h4><?php the_title(); ?></h4>
					<?php the_content(); ?>
				</div>
			</div>
			<?php if ($count%4 == 0) : ?>
			</div>
			<div class="slide">
			<?php endif; ?>
			
		<?php
			}
		} else {
			// no posts found
		}
		wp_reset_postdata();
		?>	
		</div>	
		
		<?php
			}
		?>	
	</div>
	<?php endforeach; ?>	
	<?php endwhile; else :  endif; ?>
	
<?php } ?>

<?php if( is_page('Contact Us') ) { ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<div class="section" data-anchor="<?php echo(basename(get_permalink())); ?>" style="background: url(<?php global $post; $image = get_post_meta( $post->ID, '_cmb_bg', true ); echo $image;  ?>) no-repeat center center;">
		<?php the_content(); ?>
		<div class="grid">
		<h2>CONTACT US</h2>
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
$(function() {$('.device-header').slideUp('slow');$('.menuToggle').on('click', 'a', function(e){e.preventDefault();$('.device-header').slideDown('slow');});$('.device-header').on('click', 'a', function(){$('.device-header').slideUp('slow');});$('.tweets-list-container').tweetscroll({ username: 'StopIvory', time: true, limit: 3,replies: true, position: 'prepend', date_format: 'style2', animation: 'slide_down', visible_tweets: 3 });if(exists($.cookie('StopIvory_Cookie'))) {} else {	$('#cookie').fadeIn('slow');$.cookie('StopIvory_Cookie', 'StopIvory', { expires: 1000000, path: '/' });}
$.fn.fullpage({verticalCentered: true,resize : true,scrollingSpeed: 700,easing: 'easeInQuart',<?php if( is_page( array( 'Stop Ivory', 'Contact Us' ) ) ) { ?> navigation: false, <? } else { if (have_posts()) : while (have_posts()) : the_post(); ?>anchors:['<?php echo(basename(get_permalink())); ?>',<?php $args = array( 'orderby' => 'menu_order','order' => 'ASC', 'post_parent' => $post->ID, 'post_type' => 'page', 'post_status' => 'publish'); $postslist = get_posts($args); foreach ($postslist as $post) : setup_postdata($post); ?>'<?php echo(basename(get_permalink())); ?>',<?php endforeach; ?>],<?php endwhile; else :  endif; ?>menu: false,navigation: true,<?php if (have_posts()) : while (have_posts()) : the_post(); ?>navigationTooltips: ['<?php the_title(); ?>', <?php $args = array( 'orderby' => 'menu_order','order' => 'ASC', 'post_parent' => $post->ID, 'post_type' => 'page', 'post_status' => 'publish' ); $postslist = get_posts($args); foreach ($postslist as $post) : setup_postdata($post); ?>'<?php the_title(); ?>',<?php endforeach; ?>],<?php endwhile; else :  endif; } ?>slidesNavigation: true,slidesNavPosition: 'bottom',loopBottom: false,loopTop: false,loopHorizontal: false,autoScrolling: true,scrollOverflow: true,css3: true,paddingTop: '0',paddingBottom: '0',fixedElements: '#mainMenu, .device-header, .menuToggle, #copyright, #cookie',keyboardScrolling: true,touchSensitivity: 20,onLeave: function(index, direction){$('.device-header').slideUp('slow');},afterLoad: function(anchorLink, index){},afterRender: function(){},afterSlideLoad: function(anchorLink, index, slideAnchor, slideIndex){},onSlideLeave: function(anchorLink, index, slideIndex, direction){}});});
$(document).keyup(function(e) {if(e.keyCode == 27) {$('.device-header').slideUp('slow');}});
function exists(data) {if(!data || data==null || data=='undefined' || typeof(data)=='undefined') return false;else return true;}
</script>