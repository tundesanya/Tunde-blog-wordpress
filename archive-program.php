<?php 
// for event archive page (i.e all event)
	get_header(); 
	pageBanner(array(
		'title' => 'All Programs',
		'subtitle' => 'There is something for everyone. Have a look around.'
	));
	?>

  <div class="container container--narrow page-section">
	
	<ul class="link-list min-list">
		<?php
			//pasting all programs archive body 
			while (have_posts()) {
				the_post();?>
				<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
				

		<?php }
		echo paginate_links();
		?>
	</ul>
	

  </div>

<?php	get_footer();

?>