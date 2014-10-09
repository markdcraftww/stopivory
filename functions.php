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
	wp_register_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.js', false, '2.7.1', false );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'modernizr' );
}
add_action( 'wp_enqueue_scripts', 'si_scripts' );

// enqueue styles
function si_css() {
	wp_register_style( 'OpenSans', 'http://fonts.googleapis.com/css?family=Open+Sans:400italic,800italic,400,700,800', false, false );
	wp_register_style( 'styles', get_template_directory_uri() . '/css/styles.css', false, false );
	wp_enqueue_style( 'styles' );
	wp_enqueue_style( 'OpenSans' );
}
add_action( 'wp_enqueue_scripts', 'si_css' );

function remove_menus () {
global $menu;
	$restricted = array( __('Posts'), __('Links'), __('Tools'), __('Comments'), __('Plugins'), __('Settings'));
	end ($menu);
	while (prev($menu)){
		$value = explode(' ',$menu[key($menu)][0]);
		if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
	}
}
add_action('admin_menu', 'remove_menus');

function my_remove_menu_pages() {
	remove_submenu_page ('themes.php', 'themes.php');
	remove_submenu_page ('themes.php', 'theme-editor.php');
	remove_submenu_page ('themes.php', 'customize.php');
}
add_action( 'admin_init', 'my_remove_menu_pages' );
    
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
	add_image_size( 'big', 750, 295, true );
	add_image_size( 'mobile', 264, 264, true );
	add_image_size( 'grid', 264, 218 );
	add_image_size( 'sliver', 1120, 350, true );
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

// custom excerpt length
function custom_excerpt_length( $length ) {
	return 15;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

// new excerpt end
function new_excerpt_more( $more ) {
	return '';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );

// change menu name
function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[10][0] = 'Images/PDFs';
    echo '';
}
add_action( 'init', 'change_post_object_label' );
add_action( 'admin_menu', 'change_post_menu_label' );

// have to have post thumbnail on news stories
add_action('save_post', 'wpds_check_thumbnail');
add_action('admin_notices', 'wpds_thumbnail_error');
function wpds_check_thumbnail($post_id) {
    if(get_post_type($post_id) != 'news')
        return;
    if ( !has_post_thumbnail( $post_id ) ) {
        set_transient( "has_post_thumbnail", "no" );
        remove_action('save_post', 'wpds_check_thumbnail');
        wp_update_post(array('ID' => $post_id, 'post_status' => 'draft'));
        add_action('save_post', 'wpds_check_thumbnail');
    } else {
        delete_transient( "has_post_thumbnail" );
    }
}
function wpds_thumbnail_error() {
    if ( get_transient( "has_post_thumbnail" ) == "no" ) {
        echo "<div id='message' class='error'><p><strong>You must select a Featured Image. Your Post is saved but it can not be published.</strong></p></div>";
        delete_transient( "has_post_thumbnail" );
    }
}

//custom post types & taxonomies
function news() {
	$labels = array(
		'name'                => _x( 'News', 'Post Type General Name', 'stop_ivory' ),
		'singular_name'       => _x( 'News', 'Post Type Singular Name', 'stop_ivory' ),
		'menu_name'           => __( 'News', 'stop_ivory' ),
		'parent_item_colon'   => __( 'Parent News:', 'stop_ivory' ),
		'all_items'           => __( 'All News', 'stop_ivory' ),
		'view_item'           => __( 'View News', 'stop_ivory' ),
		'add_new_item'        => __( 'Add New News', 'stop_ivory' ),
		'add_new'             => __( 'Add New', 'stop_ivory' ),
		'edit_item'           => __( 'Edit News', 'stop_ivory' ),
		'update_item'         => __( 'Update News', 'stop_ivory' ),
		'search_items'        => __( 'Search News', 'stop_ivory' ),
		'not_found'           => __( 'Not found', 'stop_ivory' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'stop_ivory' ),
	);
	$args = array(
		'label'               => __( 'news', 'stop_ivory' ),
		'description'         => __( 'Governments, IGOs, NGOs, Press, Private Sector', 'stop_ivory' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', ),
		'taxonomies'          => array(  ),
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
		'capability_type'     => 'post',
	);
	register_post_type( 'news', $args );
}
add_action( 'init', 'news', 0 );

function organisation() {
	$labels = array(
		'name'                => _x( 'Organisations', 'Post Type General Name', 'stop_ivory' ),
		'singular_name'       => _x( 'Organisation', 'Post Type Singular Name', 'stop_ivory' ),
		'menu_name'           => __( 'Organisations', 'stop_ivory' ),
		'parent_item_colon'   => __( 'Parent Organisation:', 'stop_ivory' ),
		'all_items'           => __( 'All Organisations', 'stop_ivory' ),
		'view_item'           => __( 'View Organisation', 'stop_ivory' ),
		'add_new_item'        => __( 'Add New Organisation', 'stop_ivory' ),
		'add_new'             => __( 'Add New', 'stop_ivory' ),
		'edit_item'           => __( 'Edit Organisation', 'stop_ivory' ),
		'update_item'         => __( 'Update Organisation', 'stop_ivory' ),
		'search_items'        => __( 'Search Organisation', 'stop_ivory' ),
		'not_found'           => __( 'Not found', 'stop_ivory' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'stop_ivory' ),
	);
	$args = array(
		'label'               => __( 'organisation', 'stop_ivory' ),
		'description'         => __( 'Governments, IGOs, NGOs, Private Sector', 'stop_ivory' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', ),
		'taxonomies'          => array( 'org' ),
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
	register_post_type( 'organisation', $args );
}
add_action( 'init', 'organisation', 0 );

function org_tx() {
	$labels = array(
		'name'                       => _x( 'Organisation categories', 'Taxonomy General Name', 'stop_ivory' ),
		'singular_name'              => _x( 'Organisation category', 'Taxonomy Singular Name', 'stop_ivory' ),
		'menu_name'                  => __( 'Organisation category', 'stop_ivory' ),
		'all_items'                  => __( 'All Organisation categories', 'stop_ivory' ),
		'parent_item'                => __( 'Parent Organisation category', 'stop_ivory' ),
		'parent_item_colon'          => __( 'Parent Organisation category:', 'stop_ivory' ),
		'new_item_name'              => __( 'New Organisation category', 'stop_ivory' ),
		'add_new_item'               => __( 'Add New Organisation category', 'stop_ivory' ),
		'edit_item'                  => __( 'Edit Organisation category', 'stop_ivory' ),
		'update_item'                => __( 'Update Organisation category', 'stop_ivory' ),
		'separate_items_with_commas' => __( 'Separate Organisation categories with commas', 'stop_ivory' ),
		'search_items'               => __( 'Search Organisation categories', 'stop_ivory' ),
		'add_or_remove_items'        => __( 'Add or remove Organisation categories', 'stop_ivory' ),
		'choose_from_most_used'      => __( 'Choose from the most used Organisation categories', 'stop_ivory' ),
		'not_found'                  => __( 'Not Found', 'stop_ivory' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'org', array( 'organisation' ), $args );
}
add_action( 'init', 'org_tx', 0 );

function news_tx() {
	$labels = array(
		'name'                       => _x( 'Filters', 'Taxonomy General Name', 'stop_ivory' ),
		'singular_name'              => _x( 'Filter', 'Taxonomy Singular Name', 'stop_ivory' ),
		'menu_name'                  => __( 'Filters', 'stop_ivory' ),
		'all_items'                  => __( 'All filters', 'stop_ivory' ),
		'parent_item'                => __( 'Parent filter', 'stop_ivory' ),
		'parent_item_colon'          => __( 'Parent filter:', 'stop_ivory' ),
		'new_item_name'              => __( 'New Filter', 'stop_ivory' ),
		'add_new_item'               => __( 'Add New Filter', 'stop_ivory' ),
		'edit_item'                  => __( 'Edit Filter', 'stop_ivory' ),
		'update_item'                => __( 'Update Filter', 'stop_ivory' ),
		'separate_items_with_commas' => __( 'Separate filters with commas', 'stop_ivory' ),
		'search_items'               => __( 'Search Filters', 'stop_ivory' ),
		'add_or_remove_items'        => __( 'Add or remove filters', 'stop_ivory' ),
		'choose_from_most_used'      => __( 'Choose from the most used filters', 'stop_ivory' ),
		'not_found'                  => __( 'Not Found', 'stop_ivory' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'filter', array( 'news' ), $args );
}
add_action( 'init', 'news_tx', 0 );

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

// post 2 post links
function lectureSpeaker() {
    p2p_register_connection_type( array(
        'name' => 'orgs2news',
        'from' => 'organisation',
        'to' => 'news'
	) );
}
add_action( 'p2p_init', 'lectureSpeaker' );

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
				'name' => 'Instructions',
				'desc' => 'Copying and pasting from Word adds double paragraph breaks - remember to delete them or the text will be harder to read on the site.<br />"Related Information" appears at the side of the page.<br />Images uploaded should ideally be a minimum size of 2050x1350 pixels in dimensions.<br />Organisation images should be exactly 297x174 pixels in dimension.',
				'type' => 'title',
				'id' => $prefix . 'test_title'
			),
			array(
				'name' => 'Background Image',
				'desc' => '',
				'type' => 'file',
				'id' => $prefix . 'bg'
			),

			array(
				'name' => 'Extra page text',
				'desc' => '',
				'type' => 'text',
				'id' => $prefix . 'ept'
			),
			array(
				'name' => 'Extra Resources',
				'desc' => 'Space for any PDfs, or supporting information',
				'type' => 'wysiwyg',
				'id' => $prefix . 'pdf'
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
		'pages' => array('executive-team', 'board-of-trustees', 'advisory-panel'),
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

function newsMeta( $meta_boxes ) {
	$prefix = '_cmb_';
	$meta_boxes[] = array(
		'id' => 'meta',
		'title' => 'Extra Info',
		'pages' => array('news'),
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true,
		'fields' => array(
			array(
				'name' => 'Instructions',
				'desc' => 'Copying and pasting from Word adds double paragraph breaks - remember to delete them or the text will be harder to read on the site.<br />"Related Information" appears at the side of the page.<br />Images uploaded should ideally be a minimum size of 2050x1350 pixels in dimensions.<br />Organisation images should be exactly 297x174 pixels in dimension.',
				'type' => 'title',
				'id' => $prefix . 'test_title'
			),
			array(
				'name' => 'Subtitle',
				'desc' => 'News story subtitle',
				'type' => 'text',
				'id' => $prefix . 'sub'
			),
			array(
				'name' => 'Location',
				'desc' => 'Adds the location pertinent to the news story',
				'type' => 'text',
				'id' => $prefix . 'location'
			),
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
			)
		),
	);
	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'newsMeta' );

function organisationMeta( $meta_boxes ) {
	$prefix = '_cmb_';
	$meta_boxes[] = array(
		'id' => 'meta',
		'title' => 'Extra Info',
		'pages' => array('organisation'),
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true,
		'fields' => array(
			array(
				'name' => 'Instructions',
				'desc' => 'Copying and pasting from Word adds double paragraph breaks - remember to delete them or the text will be harder to read on the site.<br />"Related Information" appears at the side of the page.<br />Images uploaded should ideally be a minimum size of 2050x1350 pixels in dimensions.<br />Organisation images should be exactly 297x174 pixels in dimension.',
				'type' => 'title',
				'id' => $prefix . 'test_title'
			),
			array(
				'name'    => 'Type of Organisation',
				'desc'    => 'Select the type of Organisation (this helps with SEO) <a href="http://schema.org/" target="_blank">read more here</a><br />IGOs should be categorised under Government.',
				'id'      => $prefix . 'schema',
				'type'    => 'multicheck',
				'options' => array(
					'Organization' => __( 'Organization', 'cmb' ),
					'Corporation' => __( 'Corporation', 'cmb' ),
					'EducationalOrganization' => __( 'Educational Organization', 'cmb' ),
					'GovernmentOrganization' => __( 'Government', 'cmb' ),
					'LocalBusiness' => __( 'Local Business', 'cmb' ),
					'NGO' => __( 'NGO', 'cmb' ),
				),
				'inline'  => true,
			),
			array(
				'name' => 'Subtitle',
				'desc' => 'News story subtitle',
				'type' => 'text',
				'id' => $prefix . 'sub'
			),
			array(
				'name' => 'Location',
				'desc' => 'Adds the location pertinent to the news story',
				'type' => 'text',
				'id' => $prefix . 'location'
			),
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
			)
		),
	);
	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'organisationMeta' );

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

add_action("wp_head", "my_copyright_meta");
function my_copyright_meta() {
   if(is_singular()){
      echo '<meta name="copyright" content="&copy; Stop Ivory, '.date('Y').'">';
   }
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

// change admin footer
function remove_footer_admin () {
	echo '&copy; '. date('Y') . ' Stop Ivory. Site built by <a href="http://mccannlondon.co.uk">McCann London</a>.';
	echo '<style>#wp-admin-bar-updates,.update-plugins{display:none !important;}.category-adder {display: none !important;}</style>';
}
add_filter('admin_footer_text', 'remove_footer_admin');

// hide WP update
function hide_wp_update_nag() {
    remove_action( 'admin_notices', 'update_nag', 3 ); //update notice at the top of the screen
    remove_filter( 'update_footer', 'core_update_footer' ); //update notice in the footer
}
add_action('admin_menu','hide_wp_update_nag');

function modify_post_mime_types( $post_mime_types ) {
	$post_mime_types['application/pdf'] = array( __( 'PDFs' ), __( 'Manage PDFs' ), _n_noop( 'PDF <span class="count">(%s)</span>', 'PDFs <span class="count">(%s)</span>' ) );
	return $post_mime_types;
}
add_filter( 'post_mime_types', 'modify_post_mime_types' );

add_filter( 'post_class', 'tax_post_class', 10, 3 );

if ( ! function_exists('tax_post_class') ) {
    function tax_post_class($classes, $class, $ID) {

        $taxonomies_args = array(
            'public' => true,
            '_builtin' => false,
        );

        $taxonomies = get_taxonomies( $taxonomies_args, 'names', 'and' );

        $terms = get_the_terms( (int) $ID, (array) $taxonomies );

        if ( ! empty( $terms ) ) {
            foreach ( (array) $terms as $order => $term ) {
                if ( ! in_array( $term->slug, $classes ) ) {
                    $classes[] = $term->slug;
                }
            }
        }

        $classes[] = 'clearfix';

        return $classes;
    }
}
add_action( 'dashboard_glance_items', 'my_add_cpt_to_dashboard' );

function my_add_cpt_to_dashboard() {
	$showTaxonomies = 1;
	if ($showTaxonomies) {
		$taxonomies = get_taxonomies( array( '_builtin' => false ), 'objects' );
		foreach ( $taxonomies as $taxonomy ) {
			$num_terms  = wp_count_terms( $taxonomy->name );
			$num = number_format_i18n( $num_terms );
			$text = _n( $taxonomy->labels->singular_name, $taxonomy->labels->name, $num_terms );
			$associated_post_type = $taxonomy->object_type;
			if ( current_user_can( 'manage_categories' ) ) {
			  $output = '<a href="edit-tags.php?taxonomy=' . $taxonomy->name . '&post_type=' . $associated_post_type[0] . '">' . $num . ' ' . $text .'</a>';
			}
			echo '<li class="taxonomy-count">' . $output . ' </li>';
		}
	}
	// Custom post types counts
	$post_types = get_post_types( array( '_builtin' => false ), 'objects' );
	foreach ( $post_types as $post_type ) {
		if($post_type->show_in_menu==false) {
			continue;
		}
		$num_posts = wp_count_posts( $post_type->name );
		$num = number_format_i18n( $num_posts->publish );
		$text = _n( $post_type->labels->singular_name, $post_type->labels->name, $num_posts->publish );
		if ( current_user_can( 'edit_posts' ) ) {
			$output = '<a href="edit.php?post_type=' . $post_type->name . '">' . $num . ' ' . $text . '</a>';
		}
		echo '<li class="page-count ' . $post_type->name . '-count">' . $output . '</td>';
	}
}

add_action( 'admin_init', 'super_sticky_add_meta_box' );
add_action( 'admin_init', 'super_sticky_admin_init', 20 );
add_action( 'pre_get_posts', 'super_sticky_posts_filter' );

function super_sticky_description() {
	echo '<p>' . __( 'Enable support for sticky custom post types.' ) . '</p>';
}

function super_sticky_set_post_types() {
	$post_types = get_post_types( array( '_builtin' => false, 'public' => true ), 'names' );
	if ( ! empty( $post_types ) ) {
		$checked_post_types = super_sticky_post_types();
		foreach ( $post_types as $post_type ) { ?>
			<div><input type="checkbox" id="<?php echo esc_attr( 'post_type_' . $post_type ); ?>" name="sticky_custom_post_types[]" value="<?php echo esc_attr( $post_type ); ?>" <?php checked( in_array( $post_type, $checked_post_types ) ); ?> /> <label for="<?php echo esc_attr( 'post_type_' . $post_type ); ?>"><?php echo esc_html( $post_type ); ?></label></div><?php
		}
	} else {
		echo '<p>' . __( 'No public custom post types found.' ) . '</p>';
	}
}

function super_sticky_filter( $query_type ) {
	$filters = (array) get_option( 'sticky_custom_post_types_filters', array() );

	return in_array( $query_type, $filters );
}

function super_sticky_set_filters() { ?>
	<span><input type="checkbox" id="sticky_custom_post_types_filters_home" name="sticky_custom_post_types_filters[]" value="home" <?php checked( super_sticky_filter( 'home' ) ); ?> /> <label for="sticky_custom_post_types_filters_home">home</label></span><?php
}

function super_sticky_admin_init() {
	register_setting( 'reading', 'sticky_custom_post_types' );
	register_setting( 'reading', 'sticky_custom_post_types_filters' );
	add_settings_section( 'super_sticky_options', __( 'Sticky Custom Post Types' ), 'super_sticky_description', 'reading' );
	add_settings_field( 'sticky_custom_post_types', __( 'Show "Stick this..." checkbox on' ), 'super_sticky_set_post_types', 'reading', 'super_sticky_options' );
	add_settings_field( 'sticky_custom_post_types_filters', __( 'Display selected post type(s) on' ), 'super_sticky_set_filters', 'reading', 'super_sticky_options' );
}

function super_sticky_post_types() {
	return (array) get_option( 'sticky_custom_post_types', array() );
}

function super_sticky_meta() { ?>
	<input id="super-sticky" name="sticky" type="checkbox" value="sticky" <?php checked( is_sticky() ); ?> /> <label for="super-sticky" class="selectit"><?php _e( 'Add this to the home page carousel' ) ?></label><?php
}

function super_sticky_add_meta_box() {
	if( ! current_user_can( 'edit_others_posts' ) )
		return;

	foreach( super_sticky_post_types() as $post_type )
		add_meta_box( 'super_sticky_meta', __( 'Carousel' ), 'super_sticky_meta', $post_type, 'side', 'high' );
}

function super_sticky_posts_filter( $query ) {
	if ( $query->is_main_query() && $query->is_home() && ! $query->get( 'suppress_filters' ) && super_sticky_filter( 'home' ) ) {

		$super_sticky_post_types = super_sticky_post_types();

		if ( ! empty( $super_sticky_post_types ) ) {
			$post_types = array();

			$query_post_type = $query->get( 'post_type' );

			if ( empty( $query_post_type ) ) {
				$post_types[] = 'post';
			} elseif ( is_string( $query_post_type ) ) {
				$post_types[] = $query_post_type;
			} elseif ( is_array( $query_post_type ) ) {
				$post_types = $query_post_type;
			} else {
				return; // Unexpected value
			}

			$post_types = array_merge( $post_types, $super_sticky_post_types );

			$query->set( 'post_type', $post_types );
		}
	}
}

function my_custom_login_logo() {
    echo '<style  type="text/css"> body.login { background: url(' . get_bloginfo('template_directory') . '/img/admin_bg.jpg) center center; background-size: cover !important; } h1 a {  background-image:url(' . get_bloginfo('template_directory') . '/img/admin_logo.png)  !important; } .login #nav a , .login #backtoblog a { color: #efefef; text-decoration: none; } .login #nav a:hover, .login #backtoblog a:hover { color: #a21b25; text-decoration: none; } #login_error { display: none; } .login form { background: rgba(0,0,0,0.4) } .login label { color: #efefef; } .wp-core-ui .button-primary { background: #a21b25; border-color: #5F1C2C; box-shadow: 0 1px 0 rgba(174,50,81, 0.5) inset, 0 1px 0 rgba(0, 0, 0, 0.15); color: #fff; text-decoration: none; } .wp-core-ui .button-primary:hover { background: #6F2034; border-color: #4F1725; box-shadow: 0 1px 0 rgba(174,50,81, 0.5) inset, 0 1px 0 rgba(0, 0, 0, 0.15); color: #fff; text-decoration: none; }</style>';
}
add_action('login_head',  'my_custom_login_logo');

function additional_admin_color_schemes() {  
    $theme_dir = get_template_directory_uri();  
    wp_admin_css_color( 'stopivory', __( 'Stop Ivory' ),  
        $theme_dir . '/css/si_admin.css',  
        array( '#222222', '#000000', '#a21b25', '#efefef' )  
    );  
}  
add_action('admin_init', 'additional_admin_color_schemes');

class wpse_59862_walker extends Walker_Category {
    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        extract($args);
        $cat_name = esc_attr( $category->name );
        $cat_name = apply_filters( 'list_cats', $cat_name, $category );
        $my_blog_link = site_url('/');

        $link = '<button class="filterer" data-filter=".'.$category->slug.'" href="#'.$category->slug.'" ';
        if ( $use_desc_for_title == 0 || empty($category->description) )
            $link .= 'title="' . esc_attr( sprintf(__( 'Filter news categorised as %s' ), $cat_name) ) . '"';
        else
            $link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
        $link .= '>';
        $link .= $cat_name . '</button>';
        if ( !empty($feed_image) || !empty($feed) ) {
            $link .= ' ';
            if ( empty($feed_image) )
                $link .= '(';
            $link .= '<a href="' . esc_url( get_term_feed_link( $category->term_id, $category->taxonomy, $feed_type ) ) . '"';
            if ( empty($feed) ) {
                $alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s' ), $cat_name ) . '"';
            } else {
                $title = ' title="' . $feed . '"';
                $alt = ' alt="' . $feed . '"';
                $name = $feed;
                $link .= $title;
            }
            $link .= '>';
            if ( empty($feed_image) )
                $link .= $name;
            else
                $link .= "<img src='$feed_image'$alt$title" . ' />';
            $link .= '</button>';
            if ( empty($feed_image) )
                $link .= ')';
        }
        if ( !empty($show_count) )
            $link .= ' (' . intval($category->count) . ')';
        if ( 'list' == $args['style'] ) {
            $output .= "\t<li";
            $class = 'cat-item cat-item-' . $category->term_id;
            if ( !empty($current_category) ) {
                $_current_category = get_term( $current_category, $category->taxonomy );
                if ( $category->term_id == $current_category )
                    $class .=  ' current-cat';
                elseif ( $category->term_id == $_current_category->parent )
                    $class .=  ' current-cat-parent';
            }
            $output .=  ' class="' . $class . '"';
            $output .= ">$link\n";
        } else {
            $output .= "\t$link<br />\n";
        }
    }
}

add_filter('nav_menu_css_class', 'current_type_nav_class', 10, 2);
function current_type_nav_class($classes, $item) {
	// Get post_type for this post
	$post_type = get_query_var('post_type');
	// Go to Menus and add a menu class named: {custom-post-type}-menu-item
	// This adds a 'current_page_parent' class to the parent menu item
	if( in_array( $post_type.'-menu-item', $classes ) )
		array_push($classes, 'current_page_parent');
	return $classes;
}

add_action('admin_head-nav-menus.php', 'wpclean_add_metabox_menu_posttype_archive');

function wpclean_add_metabox_menu_posttype_archive() {
	add_meta_box('wpclean-metabox-nav-menu-posttype', 'Custom Post Type Archives', 'wpclean_metabox_menu_posttype_archive', 'nav-menus', 'side', 'default');
}
 
function wpclean_metabox_menu_posttype_archive() {
	$post_types = get_post_types(array('show_in_nav_menus' => true, 'has_archive' => true), 'object');
	if ($post_types) :
		$items = array();
		$loop_index = 999999;
		foreach ($post_types as $post_type) {
			$item = new stdClass();
			$loop_index++;
			$item->object_id = $loop_index;
			$item->db_id = 0;
			$item->object = 'post_type_' . $post_type->query_var;
			$item->menu_item_parent = 0;
			$item->type = 'custom';
			$item->title = $post_type->labels->name;
			$item->url = get_post_type_archive_link($post_type->query_var);
			$item->target = '';
			$item->attr_title = '';
			$item->classes = array();
			$item->xfn = '';
			$items[] = $item;
		}
		$walker = new Walker_Nav_Menu_Checklist(array());
		echo '<div id="posttype-archive" class="posttypediv">';
		echo '<div id="tabs-panel-posttype-archive" class="tabs-panel tabs-panel-active">';
		echo '<ul id="posttype-archive-checklist" class="categorychecklist form-no-clear">';
		echo walk_nav_menu_tree(array_map('wp_setup_nav_menu_item', $items), 0, (object) array('walker' => $walker));
		echo '</ul>';
		echo '</div>';
		echo '</div>';
		echo '<p class="button-controls">';
		echo '<span class="add-to-menu">';
		echo '<input type="submit"' . disabled(1, 0) . ' class="button-secondary submit-add-to-menu right" value="' . __('Add to Menu', 'stop_ivory') . '" name="add-posttype-archive-menu-item" id="submit-posttype-archive" />';
		echo '<span class="spinner"></span>';
		echo '</span>';
		echo '</p>';
	endif;
}

function revcon_change_post_label() {
    global $menu;
    global $submenu;
    $menu[10][0] = 'Uploads';
    echo '';
}
function revcon_change_post_object() {
    global $wp_post_types;
}
add_action( 'admin_menu', 'revcon_change_post_label' );
add_action( 'init', 'revcon_change_post_object' );

//dashboard icons
function add_menu_icons_styles(){
 
echo '<style>
#adminmenu .menu-icon-news div.wp-menu-image:before {
	content: "\f325";
}
#adminmenu .menu-icon-organisation div.wp-menu-image:before {
	content: "\f307";
}
#adminmenu .menu-icon-executive-team div.wp-menu-image:before, #adminmenu .menu-icon-board-of-trustees div.wp-menu-image:before, #adminmenu .menu-icon-advisory-panel div.wp-menu-image:before {
	content: "\f338";
}
#adminmenu .menu-icon-actions div.wp-menu-image:before {
	content: "\f242";
}
#adminmenu .menu-icon-contacts div.wp-menu-image:before {
	content: "\f336";
}
#dashboard_right_now .organisation-count a:before {
    content: "\f307";
}
#dashboard_right_now .board-of-trustees-count a:before, #dashboard_right_now .executive-team-count a:before, #dashboard_right_now .advisory-panel-count a:before {
    content: "\f338";
}
#dashboard_right_now .actions-count a:before {
    content: "\f242";
}
#dashboard_right_now .contacts-count a:before {
    content: "\f336";
}
#dashboard_right_now .news-count a:before {
    content: "\f325";
}
#dashboard_right_now .taxonomy-count a:before {
    content: "\f203";
}
</style>';

}
add_action( 'admin_head', 'add_menu_icons_styles' );