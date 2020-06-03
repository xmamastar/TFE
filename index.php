
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

	<body>
		<header>


			<?php include("menu.php"); require('connexionbdd.php'); ?>

		</header>

		<div class="container-fluid">
			<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators">
                <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
              </ol>
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img src="images/slide1.jpg" class="d-block w-100" alt="slide1">
                  <div class="carousel-caption d-none d-md-block">
                    <h5>First slide label</h5>
                    <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                  </div>
                </div>
                <div class="carousel-item">
                  <img src="images/slide2.jpg" class="d-block w-100" alt="slide2">
                  <div class="carousel-caption d-none d-md-block">
                    <h5>Second slide label</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                  </div>
                </div>
                <div class="carousel-item">
                  <img src="images/slide3.jpg" class="d-block w-100" alt="slide3">
                  <div class="carousel-caption d-none d-md-block">
                    <h5>Third slide label</h5>
                    <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
                  </div>
                </div>
              </div>
              <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>

</div>

		</div>
		<div id="content-index">

        <?php
		$reponse1 = $bdd->query('SELECT * FROM annonce');
            $donnees1 = $reponse1->fetch();
            if ($donnees1==null){

                echo "<div id='content'><h2>Pas d'annonce pour le moment</h2></div>";

            }
            else{
                $reponse = $bdd->query('SELECT * FROM annonce');
                while ($donnees = $reponse->fetch()){

                    echo "<div id='content-index2'><h2>".$donnees['titre']."</h2><br>".$donnees['texte'].'<br><img src=images/items/'.$donnees['img_item'].'>'."</div>";
                }
            }?>

        </div
		<footer>
		</footer>


	</body>
</html>
