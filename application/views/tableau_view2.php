<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">

		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style2.css">
	</head>
    	<header>
    		<div id="menu-nav" class="topnav">
    			<div id="logo">
    				<img src="<?php echo base_url(); ?>css/images/logo.png" height="75px" width="100px" >
    			</div>
    		<nav>
    					<ul class="nav">
    						<li class="nav-item"><a class="nav-link" href="<?php echo base_url()?>index/accueil">Accueil</a></li>
    						<li class="nav-item"><a class="nav-link" href="<?php echo base_url()?>calendrier/calendar">Réservation</a></li>
    						<li class="nav-item"><a class="nav-link" href="<?php echo base_url()?>shop/shop_view?cat=all">Shop</a></li>

    						<?php
    							if(isset($_SESSION['nom']))
    							{
    							?>
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
	<body>

<article id="container4">
<a class='btn btn-xs btn-primary'  href= <?php echo base_url()."tournoi/accueil"?> > <img src=<?php echo base_url(); ?>css/images/retour.png height="75px" width="100px" ></a>
<div id='tableau'>

<h2>Tournoi du 28/08/2020 au 04/09/2020</h2>
<section>
<div>Leroy B-2/6</div>
    <div>De-Witte C30</div>
    <div>Dupont C15</div>
    <div>Dehoux C15.3</div>
    <div>Lotti C15</div>
    <div>Merlin B4/6</div>
    <div>Trussart C15</div>
    <div>Rousseaux B0</div>

</section>

<div class="connecter">
    <div id="demi1_joueur1"></div>
    <div id="demi1_joueur2"></div>
    <div id ="demi2_joueur1"></div>
    <div id ="demi2_joueur2"></div>
</div>

<div class="ligne">
    <div>
    </div><div>
    </div><div>
    </div><div>
    </div>
</div>

<section id="quarterFinals">
	<div>29/08  </br> 19h00</div>
	<div>Dupont </br> 6/3 3/6 7/6</div>
	<div>Merlin </br> 6/4 6/2</div>
	<div>30/08</br> 20h00</div>

</section>

<div class="connecter" id="conn2">
    <div></div>
    <div></div>
</div>

<div class="ligne" id="ligne2">
    <div></div>
    <div></div>
</div>

<section id="semiFinals">
    <div>01/09</br>18h00</div>
    <div>02/09 </br>20h00</div>
</section>

<div class="connecter" id="conn3">
    <div></div>
</div>

<div class="ligne" id="ligne3">
    <div></div>
</div>

<section id="final">
<div>04/09</br>19h00</div>
</section>
</div>
</article>




