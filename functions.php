 <?php
require get_theme_file_path('/inc/search-route.php');

 
// for registering a customized json object property
 function university_custom_rest() {
 	// post is the type of json request eg posts or pages
   register_rest_field('post', 'authorName', array(
     'get_callback' => function() {return get_the_author();}
   ));
 }

 add_action('rest_api_init', 'university_custom_rest');


function pageBanner($args= NULL){
	if (!$args['title']) {
		$args['title'] = get_the_title();
	}

	if (!$args['subtitle']) {
		$args['subtitle'] = get_field('page_banner_subtitle');
	}

	if (!$args['photo']) {
		if (get_field('page_banner_background_image')) {
			$args['photo'] = get_field('page_banner_background_image') ['sizes'] ['pageBanner'];
		} else{
			$args['photo'] = get_theme_file_uri('images/ocean.jpg');
		}
	}

	?>
	 <div class="page-banner">
	  <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>);"></div>
	  <div class="page-banner__content container container--narrow">
	    <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
	    <div class="page-banner__intro">
	      <p><?php echo $args['subtitle']; ?></p>
	    </div>
	  </div>
	</div>
<?php }



function tunde_files(){
	wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyD4LSH6X0--kDVGkFDLe-XK1dsXoAXwh0A', NULL, '1.0', true);
	wp_enqueue_script('mn_js', get_theme_file_uri('/js/search.js'), NULL, microtime(), true);
	wp_enqueue_script('meen_js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, microtime(), true);
	wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
	wp_enqueue_style('font_awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
	wp_enqueue_style('tunde_main_styles', get_stylesheet_uri(), NULL, microtime());
	wp_localize_script('meen_js', 'universityData', array(
	    'root_url' => get_site_url()
	  ));
	}
	

add_action('wp_enqueue_scripts', 'tunde_files');

function tunde_features(){
			//admin menu location
			// register_nav_menu('headerMenuLocation', 'Header Menu Location');
			// register_nav_menu('footerLocationOne', 'Footer Location One');
			// register_nav_menu('footerLocationTwo', 'Footer Location Two');
	//setting the web page title
	add_theme_support('title-tag');

	// for uploding images...after here, we will include it in mu-plugins
	add_theme_support('post-thumbnails');
	// set image size...................wide..height..crop
	add_image_size('professorLandscape', 400, 260, true);

	// set image on the single-professor part
	add_image_size('professorPortrait', 480, 650, true);add_image_size('professorPortrait', 480, 650, true);

	add_image_size('pageBanner', 1500, 350, true);
}

add_action('after_setup_theme', 'tunde_features');

function tunde_adjust_queries($query) {
	// customizing the campus query
	if (!is_admin() AND is_post_type_archive('campus') AND $query->is_main_query()) {
		$query->set('posts_per_page', '-1');
	}


	// customizing the program query
	if (!is_admin() AND is_post_type_archive('program') AND $query->is_main_query()) {
		$query->set('posts_per_page', '-1');
		$query->set('orderby', 'title');
		$query->set('order', 'ASC');
	}

	// customizing the event archive query
	if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
		$today = date('Ymd');
		$query->set('meta_key', 'event_date');
		$query->set('orderby', 'meta_value_num');
		$query->set('order', 'ASC');
		$query->set('meta_query', array(
	        			array(
	        				'key' => 'event_date',
	        				'compare' => '>=',
	        				'value' => $today,
	        				'type' => 'numeric'
	        			)
	        		));
	}
}

add_action('pre_get_posts', 'tunde_adjust_queries');

function tundeMapKey($api) {
	$api['key'] = 'AIzaSyD4LSH6X0--kDVGkFDLe-XK1dsXoAXwh0A';
	return $api;
}
// acf means advanced custom field
add_filter('acf/fields/google_map/api', 'tundeMapKey');
