<?php 
// for event archive page (i.e all event)
	get_header(); 
	pageBanner(array(
		'title' => 'All Events',
		'subtitle' => 'See what is going on in our world'
	));
?>

  <div class="container container--narrow page-section">
	<?php
		//pasting post or blog body 
		while (have_posts()) {
			the_post();
			get_template_part('template-parts/content-event');
			 }
	echo paginate_links();
	?>
	
	<hr class="section-break">

	<p>Loking for a recap of past events? <a href="<?php echo site_url('past-events') ?>">Check out our past events archive</a>.</p>

  </div>

<?php	get_footer();

?>