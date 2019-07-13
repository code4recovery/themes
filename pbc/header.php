<!DOCTYPE html>
<html>
	<head>
		<title><?php wp_title('|', true, 'right')?><?php echo get_bloginfo('name')?></title>
		<meta name="Description" content="<?php echo get_bloginfo('name')?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<meta name="google-site-verification" content="e03b2sls1vvwekkMZ0wBAnPTB8A0Q7530eBmBVImEoE">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
		<link href="<?php echo get_stylesheet_directory_uri()?>/images/favicon.ico" rel="icon" type="image/x-icon">
		<?php wp_head()?>
	</head>
	<body <?php echo body_class()?>>
		<div class="bannerArea">
			<div class="container">
				<img src="<?php echo get_stylesheet_directory_uri()?>/images/aa_logo_gold.png" alt="" name="aatriangle" width="122" height="120" hspace="65" border="0" align="right" class="toplogo" id="aatriangle">
				<div class="BannerTextDiv">
					<h1 class="BannerText"><br>
				<span class="toplogo"><?php echo get_bloginfo('name')?></span></h1>
				</div>
			</div>
		</div>
		<div class="topnavigationArea">
			<div class="container">
				<div class="topnavigationgroup">
					<?php echo wp_nav_menu(array(
						'theme_location' => 'main',
						'container' => null,
						'menu_id' => 'MenuBar1',
						'menu_class' => 'MenuBarHorizontal',
					))?>
				</div>
				<div style="clear:both;"></div>
			</div>
			<div class="container"></div>
		</div>
		<div class="contentArea">
			<div class="container">
