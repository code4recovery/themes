<?php
get_header();
setup_postdata($post);
?>

<div class="container">
	<div class="col-sm-1"></div>
	<div class="col-sm-8">
		<div class="contentleft">
			<h1><?php the_title()?></h1>
			<?php the_content()?>
		</div>
	</div>
<?php
get_footer();
?>
</div>
