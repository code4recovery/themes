<?php
global $nav, $club_info;
?>
		<footer>
			<div class="container">
				<div class="row">
					<div class="col-md-4">
						<?php echo $club_info['name']?><br>
						&copy; <?php echo date('Y'); ?>
					</div>
					<div class="col-md-4">
						<?php echo $club_info['address_1']?><br>
						<?php echo $club_info['address_2']?> 
					</div>
					<div class="col-md-4">
						Running on Wordpress<br>
						Theme: <a href="https://github.com/intergroup/saturday-nite-live">Saturday Nite Live</a>
					</div>
				</div>
				<div id="nav" class="hidden-xs">
					<ul class="nav nav-stacked nav-pills">
						<?php foreach ($nav as $name => $title) {?>
							<li>
								<a href="#<?php echo $name; ?>" class="scroll"><?php echo $title; ?></a>
							</li>
						<?php }?>
					</ul>
				</div>
			</div>
		</footer>
		<?php
		$keys = array_keys($nav);
		$home = array_shift($keys);
		$title = $nav[$home];
		?>
		<nav class="navbar navbar-default navbar-fixed-top hidden visible-xs">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand scroll" href="#<?php echo $home; ?>"><?php echo $title; ?></a>
				</div>
				
				<div class="collapse navbar-collapse" id="navbar-collapse">
					<ul class="nav navbar-nav">
						<?php foreach ($keys as $key) {?>
				    	<li><a href="#<?php echo $key; ?>" class="scroll"><?php echo $nav[$key]; ?></a></li>
				    	<?php } ?>
					</ul>
				</div>
			</div>
		</nav>
		
		<?php wp_footer(); ?>

		<script>
			var _gaq = _gaq || [];
			_gaq.push(["_setAccount", "UA-42485965-1"]);
			_gaq.push(["_trackPageview"]);
			
			(function() {
				var ga = document.createElement("script"); ga.type = "text/javascript"; ga.async = true;
				ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";
				var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>
    </body>
</html>