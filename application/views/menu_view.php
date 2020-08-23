<!doctype html>
<html>
    <?php
        //session_start();
        ?>
	<head>

		<meta charset="UTF-8">

		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css" crossorigin="anonymous">

	</head>
	<body>
	<header>
		<div id="menu-nav" class="topnav">
			<div id="logo">
				<img src="<?php echo base_url(); ?>css/images/logo.png" height="75px" width="100px" >
			</div>
		<nav>
					<ul class="nav">
						<li class="nav-item"><a class="nav-link" href="<?php echo base_url()?>index/accueil">Accueil</a></li>


						<?php
							if(isset($_SESSION['nom']))
							{
							?>
							<li class="nav-item"><a class="nav-link" href="<?php echo base_url()?>calendrier/calendar">Réservation</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url()?>shop/shop_view?cat=all">Shop</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?php echo base_url()?>cordages/accueil">Cordages</a></li>
							<li><a href="<?php echo base_url()?>tournoi/accueil">Tournoi</a></li>
							<li><a href="<?php echo base_url()?>user/mon_espace">Mon espace</a></li>

							<li><a href="<?php echo base_url()?>deconnexion/deco">Déconnexion</a></li>

							<?php
							}
							else{
							?>
							<li><a href="<?php echo base_url()?>inscription/form_inscription">Inscription</a></li>
							<li><a href="<?php echo base_url()?>connexion/form_connexion">Connexion</a></li>
							<?php
							}
							if(isset($_SESSION['admin']) && $_SESSION['admin']==1 ){

								?>
                            	<li><a href="<?php echo base_url()?>admin/admin_view">Admin</a></li>
                            <?php
                            	}




							?>


					</ul>
				</div>
			</nav>
			<div ><img class="icon" src="<?php echo base_url(); ?>css/images/burger.png"></div>
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
