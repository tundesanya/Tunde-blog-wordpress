<?php 
// for past event archive page (i.e all past event)
	get_header();
	pageBanner(array(
		'title' => 'Past Events',
		'subtitle' => 'A recap of our past events'
	));
	?>
  <div class="container container--narrow page-section">
	<?php

		$today = date('Ymd'); 
		$pastEvents = new WP_Query(array(
			'paged' => get_query_var('paged', 1),
			// this will make the post query be that of the past event posts
			'post_type' => 'event',
			'meta_key' => 'event_date',
			'orderby' => 'meta_value_num',
			'order' => 'ASC',
			'meta_query' => array(
				array(
					'key' => 'event_date',
					'compare' => '<',
					'value' => $today,
					'type' => 'numeric'
				)
			)
		));
		//pasting post or blog body 
		while ($pastEvents->have_posts()) {
			$pastEvents->the_post();
			get_template_part('template-parts/content-event');
			

	 }
	// give the paginate function an argument that will direct it to a custom query. it works perfectly if the query was a default wordpress query
	echo paginate_links(array(
		'total' => $pastEvents->max_num_pages
	));
	?>
  </div>

<?php	get_footer();

?>

