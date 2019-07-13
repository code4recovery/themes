<?php
get_header();
?>

<div class="container py-4">
	<div class="row main-row">
		<main class="col-md-8">
			<?php if (is_search()) {?>
				<h2 class="pb-3 mb-4 border-bottom">
					Search: <span class="text-muted"><?php the_search_query()?></span>
				</h2>
			<?php } elseif (is_archive()) {?>
				<h2 class="pb-3 mb-4 border-bottom">
					Category: <span class="text-muted"><?php single_cat_title()?></span>
				</h2>
			<?php }?>
			<?php while (have_posts()) {
				the_post();
				if (is_singular()) {?>
				<div class="post pb-4">
					<h2 class="mb-3"><?php the_title()?></h2>
					<?php the_content()?>
				</div>
				<?php } else {?>
				<div class="post pb-4">
					<h3 class="mb-3"><a href="<?php the_permalink()?>"><?php the_title()?></a></h3>
					<?php the_excerpt()?>
				</div>
				<?php }?>
			<?php }?>
		</main>
		<aside class="col-md-4 border-left">
			<?php dynamic_sidebar('sidebar')?>
		</aside>
	</div>
</div>

<?php
get_footer();