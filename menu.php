<!doctype html>
<html>
    <?php
        session_start();
        ?>
	<head>

		<meta charset="UTF-8">

		<link rel="stylesheet" href="style.css" />
		<script src="js/jquery-3.4.1.min.js"></script>
	</head>
	<body>
	<header>
		<div id="menu-nav" class="topnav">
			<div id="logo">
				<img src="images/logo.png" height="75px" width="100px" >
			</div>
		<nav>
					<ul class="nav">
						<li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
						<li class="nav-item"><a class="nav-link" href="calendrier.php">Réservation</a></li>
						<li class="nav-item"><a class="nav-link" href="">Shop</a></li>

						<?php
							if(isset($_SESSION['nom']))
							{
							?>
							<li><a href="profil.php">Profil</a></li>
							<li><a href="deconnexion.php">Déconnexion</a></li>

							<?php
							}
							else{
							?>
							<li><a href="inscription.php">Inscription</a></li>
							<li><a href="connexion.php">Connexion</a></li>
							<?php
							}


							?>


					</ul>
				</div>
			</nav>
			<div ><img class="icon" src="images/burger.png"></div>
			<script type="text/javascript">
            $(document).ready(function(){
                $('.icon').click(function(){
                    $('nav').toggleClass('active')
                })
            })
            </script>
	</header>
	</body>

</html>
