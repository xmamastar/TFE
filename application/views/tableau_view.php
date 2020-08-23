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
<div id='tableau'>
<h2>Nom tournoi</h2>
<section>
<?php
	$liste_id_match=array();
	if(isset($liste_match)){
		foreach($liste_match as $match){


				$nom1=$match[0]->nom;

				if(strlen($nom1)>9){
					$nom1=substr($nom1,0,9);
				}$nom2=$match[1]->nom;
                 				if(strlen($nom2)>9){
                 					$nom1=substr($nom2,0,9);
                 				}
				$statut=explode('/',$match[4]);
				if($statut[0]=="Quart"){
					echo '<div>'.$nom1.' '.$match[0]->classement.'</div>';
                    echo '<div>'.$nom2.' '.$match[1]->classement.'</div>';

				}

				$liste=array();
				array_push($liste,$match[4]);
				array_push($liste,$match[3]);
				array_push($liste_id_match,$liste);




		}
	}

?>

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
<?php
	$liste_demi=array();
	$liste_id_match=array();
    	if(isset($liste_match)){
    		foreach($liste_match as $match){


    				$nom1=$match[0]->nom;

    				if(strlen($nom1)>9){
    					$nom1=substr($nom1,0,9);
    				}$nom2=$match[1]->nom;
                     				if(strlen($nom2)>9){
                     					$nom1=substr($nom2,0,9);
                     				}
    				$statut=explode('/',$match[4]);
    				if($statut[0]=="Demi"){

    					echo '<div> <a href=encoder_match?id='.$match[3].'&statut='.$match[4].'>'.$nom1.'</a></div>';
                       echo '<div> <a href=encoder_match?id='.$match[3].'&statut='.$match[4].'>'.$nom2.'</a></div>';

    				}

    				$liste=array();
    				array_push($liste,$match[4]);
    				array_push($liste,$match[3]);
    				array_push($liste_id_match,$liste);




    		}
    	}

for($i=0;$i<count($liste_id_match);$i++){
echo "<div>".$liste_id_match[$i][1]."</div>";
	echo "<div> <a href=encoder_match?id=".$liste_id_match[$i][1]."&statut=".$liste_id_match[$i][0].">Vainqueur</a></div>";

}?>

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
    <div>coucou</div>
    <div></div>
</section>

<div class="connecter" id="conn3">
    <div></div>
</div>

<div class="ligne" id="ligne3">
    <div></div>
</div>

<section id="final">
<div></div>
</section>
</div>
</article>




