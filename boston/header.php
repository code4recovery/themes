<!DOCTYPE html>
<html>
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<meta name="description" content="Welcome AABoston.org Central Service Committe of Eastern Mass. (Intergroup)" />
		<title>Welcome AABoston.org Central Service Committe of Eastern Mass. (Intergroup)</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<?php wp_head()?>
	</head>
	<body <?php body_class()?>>
		<div id="wrapper">
			<header class="mb-lg-2 d-none d-lg-block">
				<div class="container">
					<div id="logo">
						<h1><a href="/">AA Central Service Committee<br>of Eastern Mass</a></h1>
						<a href="https://goo.gl/maps/ULxYtJQAyFv" target="_blank">12 Channel St, Suite 604<br>
						Raymond L. Flynn Marine Park<br>
						Boston, MA 02210</a> Tel: <a href="tel:6174269444">617-426-9444</a>
					</div>
					<?php wp_nav_menu(array(
						'menu' => 'top',
					))?>
				</div>
			</header>
			<nav class="navbar navbar-expand-lg navbar-dark bg-dark d-lg-none mb-1">
				<a href="/" class="navbar-brand">Boston AA</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mobilenav">
					<span class="navbar-toggler-icon"></span>
				</button>
  				<div class="collapse navbar-collapse" id="mobilenav">
					<ul class="navbar-nav mr-auto">
						<?php
						$items = wp_get_nav_menu_items('top');
						foreach ($items as $item) {?>
						<li class="nav-item <?php echo implode(' ', $item->classes) ?>">
							<a class="nav-link <?php echo implode(' ', $item->classes) ?>" href="<?php echo $item->url ?>"><?php echo $item->title ?></a>
						</li>
						<?php }?>
					</ul>
				</div>
			</nav>

			<main>