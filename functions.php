<?php

// set upload sizes
@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

// IE6-8 polyfills
function add_ie () {
    echo "<!--[if (gte IE 6)&(lte IE 8)]>\n";
    echo "<script src='" . get_template_directory_uri() . "/js/selectivizr.js'></script>\n";
    echo "<![endif]-->\n";
}
add_action('wp_head', 'add_ie');

// enqueue scripts
function si_scripts() {
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', get_template_directory_uri() . '/js/scripts.js', false, '1.11.0', false );
	wp_register_script( 'jqueryui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js', false, '1.9.1', true );
	wp_register_script( 'main', get_template_directory_uri() . '/js/script.js', false, '1.7.1', true );
	wp_register_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.js', false, '2.7.1', false );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jqueryui' );
	wp_enqueue_script( 'main' );
	wp_enqueue_script( 'modernizr' );
}
add_action( 'wp_enqueue_scripts', 'si_scripts' );

// enqueue styles
function si_css() {
	wp_register_style( 'OpenSans', 'http://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800', false, false );
	wp_register_style( 'normalize', get_template_directory_uri() . '/css/normalize.css', false, false );
	wp_register_style( 'fullpage', get_template_directory_uri() . '/css/fullPage.css', false, false );
	wp_enqueue_style( 'normalize' );
	wp_enqueue_style( 'OpenSans' );
	wp_enqueue_style( 'fullpage' );
}
add_action( 'wp_enqueue_scripts', 'si_css' );

// content width for breakpoints
if ( ! isset( $content_width ) )
	$content_width = 960;

// theme functions
function stop_ivory()  {
	add_theme_support( 'automatic-feed-links' );
	$formats = array( );
	$formats = array( 'link', );
	add_theme_support( 'post-formats', $formats );
	add_theme_support( 'post-thumbnails' );	
	set_post_thumbnail_size( 2048, 1342, true );
	add_image_size( 'who', 340, 192, true );
	add_filter('show_admin_bar', '__return_false');
	add_editor_style( get_template_directory_uri() . '/editor-style.css' );	
	$markup = array( 'search-form', 'comment-form', 'comment-list', );
	add_theme_support( 'html5', $markup );	
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'start_post_rel_link' );
	remove_action( 'wp_head', 'index_rel_link' );
	remove_action( 'wp_head', 'adjacent_posts_rel_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'feed_links', 2 );
	add_filter('login_errors', create_function('$a', "return null;"));
	add_filter('jpeg_quality', function($arg){return 90;});
}
add_action( 'after_setup_theme', 'stop_ivory' );

// menu locations
function si_menu() {
	$locations = array(
		'Header' => __( 'Main Menu', 'stop_ivory' ),
		'Mobile' => __( 'Mobile Menu', 'stop_ivory' ),
		'Social' => __( 'Social Menu', 'stop_ivory' ),
	);
	register_nav_menus( $locations );
}
add_action( 'init', 'si_menu' );

//custom post types
function executive_team() {
	$labels = array(
		'name'                => _x( 'Executive Team', 'Post Type General Name', 'stop_ivory' ),
		'singular_name'       => _x( 'Executive Team', 'Post Type Singular Name', 'stop_ivory' ),
		'menu_name'           => __( 'Executive Team', 'stop_ivory' ),
		'parent_item_colon'   => __( 'Parent Executive Team member:', 'stop_ivory' ),
		'all_items'           => __( 'All Executive Team members', 'stop_ivory' ),
		'view_item'           => __( 'View Executive Team member', 'stop_ivory' ),
		'add_new_item'        => __( 'Add New Executive Team member', 'stop_ivory' ),
		'add_new'             => __( 'Add Executive Team member', 'stop_ivory' ),
		'edit_item'           => __( 'Edit Executive Team member', 'stop_ivory' ),
		'update_item'         => __( 'Update Executive Team member', 'stop_ivory' ),
		'search_items'        => __( 'Search Executive Team members', 'stop_ivory' ),
		'not_found'           => __( 'Not found', 'stop_ivory' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'stop_ivory' ),
	);
	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'post-formats', 'page-attributes' ),
		'taxonomies'          => array( 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => '',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'executive-team', $args );
}
add_action( 'init', 'executive_team', 0 );

function board_trustees() {
	$labels = array(
		'name'                => _x( 'Board of Trustees', 'Post Type General Name', 'stop_ivory' ),
		'singular_name'       => _x( 'Board of Trustees', 'Post Type Singular Name', 'stop_ivory' ),
		'menu_name'           => __( 'Board of Trustees', 'stop_ivory' ),
		'parent_item_colon'   => __( 'Parent Board of Trustees member:', 'stop_ivory' ),
		'all_items'           => __( 'All Board of Trustees members', 'stop_ivory' ),
		'view_item'           => __( 'View Board of Trustees member', 'stop_ivory' ),
		'add_new_item'        => __( 'Add New Board of Trustees member', 'stop_ivory' ),
		'add_new'             => __( 'Add Board of Trustees member', 'stop_ivory' ),
		'edit_item'           => __( 'Edit Board of Trustees member', 'stop_ivory' ),
		'update_item'         => __( 'Update Board of Trustees member', 'stop_ivory' ),
		'search_items'        => __( 'Search Board of Trustees members', 'stop_ivory' ),
		'not_found'           => __( 'Not found', 'stop_ivory' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'stop_ivory' ),
	);
	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'post-formats', 'page-attributes' ),
		'taxonomies'          => array( 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => '',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'board-of-trustees', $args );
}
add_action( 'init', 'board_trustees', 0 );

function advisory_panel() {
	$labels = array(
		'name'                => _x( 'Advisory Panel', 'Post Type General Name', 'stop_ivory' ),
		'singular_name'       => _x( 'Advisory Panel', 'Post Type Singular Name', 'stop_ivory' ),
		'menu_name'           => __( 'Advisory Panel', 'stop_ivory' ),
		'parent_item_colon'   => __( 'Parent Advisory Panel member:', 'stop_ivory' ),
		'all_items'           => __( 'All Advisory Panel members', 'stop_ivory' ),
		'view_item'           => __( 'View Advisory Panel member', 'stop_ivory' ),
		'add_new_item'        => __( 'Add New Advisory Panel member', 'stop_ivory' ),
		'add_new'             => __( 'Add Advisory Panel member', 'stop_ivory' ),
		'edit_item'           => __( 'Edit Advisory Panel member', 'stop_ivory' ),
		'update_item'         => __( 'Update Advisory Panel member', 'stop_ivory' ),
		'search_items'        => __( 'Search Advisory Panel members', 'stop_ivory' ),
		'not_found'           => __( 'Not found', 'stop_ivory' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'stop_ivory' ),
	);
	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'post-formats', 'page-attributes' ),
		'taxonomies'          => array( 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => '',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'advisory-panel', $args );
}
add_action( 'init', 'advisory_panel', 0 );

function actions() {
	$labels = array(
		'name'                => _x( 'Actions', 'Post Type General Name', 'stop_ivory' ),
		'singular_name'       => _x( 'Action', 'Post Type Singular Name', 'stop_ivory' ),
		'menu_name'           => __( 'Actions', 'stop_ivory' ),
		'parent_item_colon'   => __( 'Parent Action:', 'stop_ivory' ),
		'all_items'           => __( 'All Actions', 'stop_ivory' ),
		'view_item'           => __( 'View Action', 'stop_ivory' ),
		'add_new_item'        => __( 'Add New Action', 'stop_ivory' ),
		'add_new'             => __( 'Add Action', 'stop_ivory' ),
		'edit_item'           => __( 'Edit Action', 'stop_ivory' ),
		'update_item'         => __( 'Update Action', 'stop_ivory' ),
		'search_items'        => __( 'Search Actions', 'stop_ivory' ),
		'not_found'           => __( 'Not found', 'stop_ivory' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'stop_ivory' ),
	);
	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'post-formats', 'page-attributes' ),
		'taxonomies'          => array( 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => '',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'actions', $args );
}
add_action( 'init', 'actions', 0 );

function igos_ngos() {
	$labels = array(
		'name'                => _x( 'IGOs & NGOs', 'Post Type General Name', 'stop_ivory' ),
		'singular_name'       => _x( 'IGOs & NGOs', 'Post Type Singular Name', 'stop_ivory' ),
		'menu_name'           => __( 'IGOs & NGOs', 'stop_ivory' ),
		'parent_item_colon'   => __( 'Parent IGOs & NGOs:', 'stop_ivory' ),
		'all_items'           => __( 'All IGOs & NGOs', 'stop_ivory' ),
		'view_item'           => __( 'View IGOs & NGOs', 'stop_ivory' ),
		'add_new_item'        => __( 'Add New IGOs & NGOs', 'stop_ivory' ),
		'add_new'             => __( 'Add IGOs & NGOs', 'stop_ivory' ),
		'edit_item'           => __( 'Edit IGOs & NGOs', 'stop_ivory' ),
		'update_item'         => __( 'Update IGOs & NGOs', 'stop_ivory' ),
		'search_items'        => __( 'Search IGOs & NGOs', 'stop_ivory' ),
		'not_found'           => __( 'Not found', 'stop_ivory' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'stop_ivory' ),
	);
	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title', 'thumbnail', 'post-formats', 'page-attributes' ),
		'taxonomies'          => array( 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => '',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'igos-ngos', $args );
}
add_action( 'init', 'igos_ngos', 0 );

function governments() {
	$labels = array(
		'name'                => _x( 'Governments', 'Post Type General Name', 'stop_ivory' ),
		'singular_name'       => _x( 'Government', 'Post Type Singular Name', 'stop_ivory' ),
		'menu_name'           => __( 'Governments', 'stop_ivory' ),
		'parent_item_colon'   => __( 'Parent Government:', 'stop_ivory' ),
		'all_items'           => __( 'All Governments', 'stop_ivory' ),
		'view_item'           => __( 'View Government', 'stop_ivory' ),
		'add_new_item'        => __( 'Add New Government', 'stop_ivory' ),
		'add_new'             => __( 'Add Government', 'stop_ivory' ),
		'edit_item'           => __( 'Edit Government', 'stop_ivory' ),
		'update_item'         => __( 'Update Government', 'stop_ivory' ),
		'search_items'        => __( 'Search Governments', 'stop_ivory' ),
		'not_found'           => __( 'Not found', 'stop_ivory' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'stop_ivory' ),
	);
	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title', 'thumbnail', 'post-formats', 'page-attributes' ),
		'taxonomies'          => array( 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => '',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'governments', $args );
}
add_action( 'init', 'governments', 0 );

function private_sector() {
	$labels = array(
		'name'                => _x( 'Private Sector', 'Post Type General Name', 'stop_ivory' ),
		'singular_name'       => _x( 'Private Sector', 'Post Type Singular Name', 'stop_ivory' ),
		'menu_name'           => __( 'Private Sector', 'stop_ivory' ),
		'parent_item_colon'   => __( 'Parent Private Sector:', 'stop_ivory' ),
		'all_items'           => __( 'All Private Sector', 'stop_ivory' ),
		'view_item'           => __( 'View Private Sector', 'stop_ivory' ),
		'add_new_item'        => __( 'Add New Private Sector', 'stop_ivory' ),
		'add_new'             => __( 'Add Private Sector', 'stop_ivory' ),
		'edit_item'           => __( 'Edit Private Sector', 'stop_ivory' ),
		'update_item'         => __( 'Update Private Sector', 'stop_ivory' ),
		'search_items'        => __( 'Search Private Sector', 'stop_ivory' ),
		'not_found'           => __( 'Not found', 'stop_ivory' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'stop_ivory' ),
	);
	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title', 'thumbnail', 'post-formats', 'page-attributes' ),
		'taxonomies'          => array( 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => '',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'private-sector', $args );
}
add_action( 'init', 'private_sector', 0 );

function timeline() {
	$labels = array(
		'name'                => _x( 'Timeline', 'Post Type General Name', 'stop_ivory' ),
		'singular_name'       => _x( 'Timeline', 'Post Type Singular Name', 'stop_ivory' ),
		'menu_name'           => __( 'Timeline', 'stop_ivory' ),
		'parent_item_colon'   => __( 'Parent Timeline:', 'stop_ivory' ),
		'all_items'           => __( 'All Timeline', 'stop_ivory' ),
		'view_item'           => __( 'View Timeline', 'stop_ivory' ),
		'add_new_item'        => __( 'Add New Timeline', 'stop_ivory' ),
		'add_new'             => __( 'Add Timeline', 'stop_ivory' ),
		'edit_item'           => __( 'Edit Timeline', 'stop_ivory' ),
		'update_item'         => __( 'Update Timeline', 'stop_ivory' ),
		'search_items'        => __( 'Search Timeline', 'stop_ivory' ),
		'not_found'           => __( 'Not found', 'stop_ivory' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'stop_ivory' ),
	);
	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'post-formats', 'page-attributes' ),
		'taxonomies'          => array( 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => '',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'timeline', $args );
}
add_action( 'init', 'timeline', 0 );

function contacts() {
	$labels = array(
		'name'                => _x( 'Contacts', 'Post Type General Name', 'stop_ivory' ),
		'singular_name'       => _x( 'Contact', 'Post Type Singular Name', 'stop_ivory' ),
		'menu_name'           => __( 'Contacts', 'stop_ivory' ),
		'parent_item_colon'   => __( 'Parent Contact:', 'stop_ivory' ),
		'all_items'           => __( 'All Contacts', 'stop_ivory' ),
		'view_item'           => __( 'View Contact', 'stop_ivory' ),
		'add_new_item'        => __( 'Add New Contact', 'stop_ivory' ),
		'add_new'             => __( 'Add Contact', 'stop_ivory' ),
		'edit_item'           => __( 'Edit Contact', 'stop_ivory' ),
		'update_item'         => __( 'Update Contact', 'stop_ivory' ),
		'search_items'        => __( 'Search Contacts', 'stop_ivory' ),
		'not_found'           => __( 'Not found', 'stop_ivory' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'stop_ivory' ),
	);
	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'post-formats', 'page-attributes' ),
		'taxonomies'          => array( 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => '',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'contacts', $args );
}
add_action( 'init', 'contacts', 0 );

// extra meta boxes
function page_image( $meta_boxes ) {
	$prefix = '_cmb_';
	$meta_boxes[] = array(
		'id' => 'meta',
		'title' => 'Page Image',
		'pages' => array('page', 'post'),
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true,
		'fields' => array(
			array(
				'name' => 'Landscape Background Image',
				'desc' => '',
				'type' => 'file',
				'id' => $prefix . 'bg'
			),
			array(
				'name' => 'Portrait Background Image',
				'desc' => '',
				'type' => 'file',
				'id' => $prefix . 'bg_p'
			),
			array(
				'name' => 'Extra page text',
				'desc' => '',
				'type' => 'text',
				'id' => $prefix . 'ept'
			)
		),
	);
	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'page_image' );

function job_title( $meta_boxes ) {
	$prefix = '_cmb_';
	$meta_boxes[] = array(
		'id' => 'meta',
		'title' => 'Job Title',
		'pages' => array('executive-team','board-of-trustees','advisory-panel'),
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true,
		'fields' => array(
			array(
				'name' => 'Job Title',
				'desc' => '',
				'type' => 'text',
				'id' => $prefix . 'job'
			)
		),
	);
	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'job_title' );

function Action_Type( $meta_boxes ) {
	$prefix = '_cmb_';
	$meta_boxes[] = array(
		'id' => 'meta',
		'title' => 'Action/Result',
		'pages' => array('actions'),
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true,
		'fields' => array(
			array(
				'name' => 'Action/Result',
				'desc' => '',
				'type' => 'text',
				'id' => $prefix . 'ar'
			)
		),
	);
	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'Action_Type' );

function extra_wwww( $meta_boxes ) {
	$prefix = '_cmb_';
	$meta_boxes[] = array(
		'id' => 'meta',
		'title' => 'Additional text',
		'pages' => array('private_sector', 'governments', 'igos-ngos'),
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true,
		'fields' => array(
			array(
				'name' => 'Additional text',
				'desc' => '',
				'type' => 'text',
				'id' => $prefix . 'at'
			)
		),
	);
	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'extra_wwww' );

add_action( 'init', 'be_initialize_cmb_meta_boxes', 9999 );
function be_initialize_cmb_meta_boxes() {
	if ( !class_exists( 'cmb_Meta_Box' ) ) {
		require_once( 'metabox/init.php' );
	}
}

// get the slug
function the_slug($echo=true){
	$slug = basename(get_permalink());
	do_action('before_slug', $slug);
	$slug = apply_filters('slug_filter', $slug);
	if( $echo ) echo $slug;
	do_action('after_slug', $slug);
	return $slug;
}

// mobile/tablet detection
function mobile_detected($agents) {
	$userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
	foreach($agents as $agent) {
		if(strpos($userAgent,strtolower($agent)) !== false)
		return true;
	}
	return false;
}

// SEO
function basic_wp_seo() {
	global $page, $paged, $post;
	$default_keywords = 'Poaching, Ivory, Elephant, Crisis, Range States, African Elephant Action Plan, Inventory, CITES';
	$output = '';
	$seo_desc = get_post_meta($post->ID, 'mm_seo_desc', true);
	$description = get_bloginfo('description', 'display');
	$pagedata = get_post($post->ID);
	if (is_singular()) {
		if (!empty($seo_desc)) {
			$content = $seo_desc;
		} else if (!empty($pagedata)) {
			$content = apply_filters('the_excerpt_rss', $pagedata->post_content);
			$content = substr(trim(strip_tags($content)), 0, 155);
			$content = preg_replace('#\n#', ' ', $content);
			$content = preg_replace('#\s{2,}#', ' ', $content);
			$content = trim($content);
		} 
	} else {
		$content = $description;	
	}
	$output .= '<meta name="description" content="' . esc_attr($content) . '">' . "\n";

	$keys = get_post_meta($post->ID, 'mm_seo_keywords', true);
	$cats = get_the_category();
	$tags = get_the_tags();
	if (empty($keys)) {
		if (!empty($cats)) foreach($cats as $cat) $keys .= $cat->name . ', ';
		if (!empty($tags)) foreach($tags as $tag) $keys .= $tag->name . ', ';
		$keys .= $default_keywords;
	}
	$output .= "" . '<meta name="keywords" content="' . esc_attr($keys) . '">' . "\n";
	$output .= "" . '<meta name="copyright" content="© Stop Ivory, ' . date('Y') . '">' . "\n";

	if (is_category() || is_tag()) {
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		if ($paged > 1) {
			$output .=  "" . '<meta name="robots" content="noindex,follow">' . "\n";
		} else {
			$output .=  "" . '<meta name="robots" content="index,follow">' . "\n";
		}
	} else if (is_home() || is_singular()) {
		$output .=  "" . '<meta name="robots" content="index,follow">' . "\n";
	} else {
		$output .= "" . '<meta name="robots" content="noindex,follow">' . "\n";
	}

	$title_custom = get_post_meta($post->ID, 'mm_seo_title', true);
	$url = ltrim(esc_url($_SERVER['REQUEST_URI']), '/');
	$name = get_bloginfo('name', 'display');
	$title = trim(wp_title('', false));
	$cat = single_cat_title('', false);
	$tag = single_tag_title('', false);
	$search = get_search_query();

	if (!empty($title_custom)) $title = $title_custom;
	if ($paged >= 2 || $page >= 2) $page_number = ' | ' . sprintf('Page %s', max($paged, $page));
	else $page_number = '';

	if (is_home() || is_front_page()) $seo_title = $name . ' | ' . $description;
	elseif (is_singular())            $seo_title = $title . ' | ' . $name;
	elseif (is_tag())                 $seo_title = 'Tag Archive: ' . $tag . ' | ' . $name;
	elseif (is_category())            $seo_title = 'Category Archive: ' . $cat . ' | ' . $name;
	elseif (is_archive())             $seo_title = 'Archive: ' . $title . ' | ' . $name;
	elseif (is_search())              $seo_title = 'Search: ' . $search . ' | ' . $name;
	elseif (is_404())                 $seo_title = '404 - Not Found: ' . $url . ' | ' . $name;
	else                              $seo_title = $name . ' | ' . $description;

	return $output;
}

function remove_footer_admin () {
	echo '&copy; '. date('Y') . ' Stop Ivory. Site built by McCann London.';
	echo '<style>#wp-admin-bar-updates,.update-plugins{display:none !important;}';
}
add_filter('admin_footer_text', 'remove_footer_admin');

function hide_wp_update_nag() {
    remove_action( 'admin_notices', 'update_nag', 3 ); //update notice at the top of the screen
    remove_filter( 'update_footer', 'core_update_footer' ); //update notice in the footer
}
add_action('admin_menu','hide_wp_update_nag');