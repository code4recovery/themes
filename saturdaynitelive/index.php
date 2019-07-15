<?php
get_header();

$query = new WP_Query([
	'post_type'		=> 'page',
	'orderby'		=> 'menu_order',
	'order'			=> 'asc',
	'post_parent'	=> 0,
]);

$nav = [];

if ($query->have_posts() ) {
    while ($query->have_posts()) {
		$query->the_post();
	    $parent = $post->post_name;
	    $nav[$parent] = $post->post_title;
?>
	
<section class="<?php echo $parent?>"<?php if ($post->post_name == 'home') {?> id="<?php echo $parent?>"<?php }?>>

	<?php if (has_post_thumbnail()) {?>
		<div class="banner skrollable skrollable-between" data-smooth-scrolling="off" data-top-bottom="background-position: 50% 0;" data-bottom-top="background-position: 50% 100%;" style="background-image: url(<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large')[0]?>);"></div>
	<?php }?>
	
	<div class="container">
		<div class="row">
			<div class="col-md-9 col-md-offset-3 col-sm-offset-4">
				<?php if ($post->post_name == 'home') {?>
				<div class="page-header">
					<h1><?php echo $post->post_title?></h1>
				<?php } else {?>
				<div class="page-header" id="<?php echo $parent?>">
					<h2><?php echo $post->post_title?></h2>
					<?php }
					edit_post_link('<i class="glyphicon glyphicon-edit"></i>'); 
					?>
				</div>

				<?php the_content()?>

				<?php
				
				$subquery = new WP_Query([
					'post_type'		=> 'page',
					'orderby'		=> 'menu_order',
					'order'			=> 'asc',
					'post_parent'	=> $post->ID,
				]);
				
				if ($subquery->have_posts() ) {?>
				<div class="panel-group" id="<?php echo $post->post_name?>-subpages">
				<?php
				    while ($subquery->have_posts()) {
						$subquery->the_post();
						$subpage = $parent . '-' . $post->post_name;
				?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#<?php echo $parent?>-subpages" href="#<?php echo $subpage?>">
									<?php the_title('<h4 class="panel-title">', '</h4>')?>
								</a>
							</h4>
							<?php edit_post_link('<i class="glyphicon glyphicon-edit"></i>')?>
						</div>
						<div id="<?php echo $subpage?>" class="panel-collapse collapse">
							<div class="panel-body">
								<?php the_content()?>
							</div>
						</div>
					</div>
					<?php }?>
				</div>
				<?php }?>
					
			</div>
		</div>
	</div>
</section>	

<?php 
	}
}

get_footer();