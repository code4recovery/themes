<!doctype html>
<html <?php language_attributes()?>>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="<?php bloginfo('description')?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?php wp_title('|', true, 'right')?><?php echo get_bloginfo('name')?></title>
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<?php wp_head()?>
	</head>
	<body <?php body_class()?>>
		<header class="jumbotron rounded-0 p-0">
			<div class="container py-4">
				<h1 class="my-4">
					<a href="/"><?php echo get_bloginfo('name')?></a>
				 	<small class="text-muted"><?php bloginfo('description')?></small>		
				</h1>
			</div>
		</header>