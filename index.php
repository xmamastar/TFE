<?php session_start(); ?>

<!doctype html>
<html>
	<head>

		<meta charset="UTF-8">
		<meta name="author" lang="fr" content="Leroy François Dehoux Matthieu">
		<meta name="description" content="Site d'un club de tennis">
		<meta name="keywords" content="accueil">
		<meta name="generator" content="Atom">
		<meta name="robots" content="index">

		<link rel="stylesheet" href="style.css" />

	</head>
	<?php
        session_start();
        ?>
	<body>
		<header>


			<?php include("menu.php"); ?>

		</header>

		<div id="content">
			<div class="carousel-wrapper">
	  <span id="item-1"></span>
	  <span id="item-2"></span>
	  <span id="item-3"></span>
	  <div class="carousel-item item-1">
	    <h2>Item 1</h2>
	    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus   accumsan pretium dolor vel convallis. Aliquam erat volutpat. Maecenas lacus nunc, imperdiet sed mi et, finibus suscipit mi.</p>
	    <a class="arrow arrow-prev" href="#item-3"></a>
	    <a class="arrow arrow-next" href="#item-2"></a>
	  </div>

	  <div class="carousel-item item-2">
	    <h2>Item 2</h2>
	    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus accumsan pretium dolor vel convallis. Aliquam erat volutpat.</p>
	    <a class="arrow arrow-prev" href="#item-1"></a>
	    <a class="arrow arrow-next" href="#item-3"></a>
	  </div>

	  <div class="carousel-item item-3">
	    <h2>Item 3</h2>
	    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus accumsan pretium dolor vel convallis. Aliquam erat volutpat.</p>
	    <a class="arrow arrow-prev" href="#item-2"></a>
	    <a class="arrow arrow-next" href="#item-1"></a>
	  </div>
	</div>

</div>

		</div>

		<div id="content">

		</div>

		<footer>
		</footer>


	</body>
</html>
