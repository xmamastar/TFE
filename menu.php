<!doctype html>
<html>
    <?php
        session_start();
        ?>
	<head>

		<meta charset="UTF-8">

		<link rel="stylesheet" href="style.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
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
						<li class="nav-item"><a class="nav-link" href="shop.php?cat=all">Shop</a></li>

						<?php
							if(isset($_SESSION['nom']))
							{
							?>
							<li><a href="profil.php">Profil</a></li>
							<li><a href="tournoi.php">Tournoi</a></li>
							<li><a href="deconnexion.php">Déconnexion</a></li>

							<?php
							}
							else{
							?>
							<li><a href="inscription.php">Inscription</a></li>
							<li><a href="connexion.php">Connexion</a></li>
							<?php
							}
							if(isset($_SESSION['admin']) && $_SESSION['admin']==1 ){

								?>
                            	<li><a href="admin.php">Admin</a></li>
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
