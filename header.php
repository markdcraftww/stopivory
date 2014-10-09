<!DOCTYPE html>
<html>
<head>
<?php if( is_page('Splash') ) { ?>
<title><?php bloginfo('name'); ?> | <?php bloginfo('description'); ?></title>
<?php } else { ?>
<title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?> | <?php bloginfo('description'); ?></title>
<?php } ?>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php echo basic_wp_seo(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php
	if(is_page()) {
		$twitter_url = get_permalink();
		$twitter_title = get_the_title();
		$twitter_desc = get_the_excerpt();
?>
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@StopIvory">
<meta name="og:title" content="<?php echo $twitter_title; ?>">
<meta name="twitter:url" content="<?php echo $twitter_url; ?>">
<meta name="twitter:domain" content="<?php bloginfo('url'); ?>">
<meta name="twitter:description" content="<?php echo $twitter_desc; ?>">
<meta name="twitter:creator" content="@StopIvory">
<meta name="twitter:image" content="<?php $image = get_post_meta( $post->ID, '_cmb_bg', true ); echo $image; ?>">
<meta property="og:title" content="<?php echo $twitter_title; ?>" />
<meta property="og:type" content="article" />
<meta property="og:image" content="<?php $image = get_post_meta( $post->ID, '_cmb_bg', true ); echo $image; ?>" />
<meta property="og:url" content="<?php echo $twitter_url; ?>" />
<meta property="og:description" content="<?php echo $twitter_desc; ?>" />
<meta property="title" content="<?php echo $twitter_title; ?>" />
<meta property="type" content="article" />
<meta property="image" content="<?php $image = get_post_meta( $post->ID, '_cmb_bg', true ); echo $image; ?>" />
<meta property="url" content="<?php echo $twitter_url; ?>" />
<meta property="description" content="<?php echo $twitter_desc; ?>" />
<?php		
	}
?>
<?php endwhile; else :  endif; ?>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800" rel="stylesheet" type="text/css">
<?php wp_head(); ?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
</head>
<body <?php body_class(); ?>>

<div class="device-header">
	<?php wp_nav_menu( array('menu' => 'Mobile Menu' )); ?>
</div>

<div class="menuToggle">
	<a href="#">
		<div></div>
		<div></div>
		<div></div>
	</a>
</div>
<?php if( is_page('Splash') ) { ?>

<?php } else { ?>  
<div id="mainMenu" class="hidden-phone hidden-tablet">
	<?php wp_nav_menu( array('menu' => 'Main Menu' )); ?>
	<?php wp_nav_menu( array('menu' => 'Social Menu' )); ?>
</div>
<?php } ?>