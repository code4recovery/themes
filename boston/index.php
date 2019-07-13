<?php
get_header();
?>
<div class="container">
	<div class="row">
		<aside class="col-md-4 col-xl-3 mb-4">
			<?php if (is_ssl()) {?>
			<a href="/meetings?tsml-mode=me&tsml-time=upcoming&tsml-distance=5" class="btn btn-block btn-primary my-3">Meetings Near Me</a>
			<?php }?>
			<a href="/meetings" class="btn btn-block btn-primary btn-outline-primary my-3">All Meetings Today</a>
			<h3>Questions About AA?</h3>
			<p> Give us a call @ <a href="tel:6174269444">617-426-9444</a></p>
			<p>Mon-Fri 9-9; Sat/Sun/Hol. 12-9</p>
			<h3>Other Meetings/Links</h3>
			<?php wp_nav_menu(array(
				'menu' => 'side'
			))?>
		</aside>
		<article class="col-md-8 col-xl-7 offset-xl-1 mb-4">
			<?php 
			if (have_posts()) {
				the_post();
				?>
				<h1><?php the_title()?></h1>
				<?php the_content()?>
			<?php } else {?>
				<h1>404: Page Not Found</h1>
				<p>We recently updated our site and this page must have moved. We regret the inconvenience.</p>
				<p><a href="/" class="btn btn-primary">Home Page</a>
			<?php }?>
		</article>
	</div>
</div>
<?php
get_footer();