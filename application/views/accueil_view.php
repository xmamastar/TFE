
<!doctype html>
<html>
	<head>

		<meta charset="UTF-8">
		<meta name="author" lang="fr" content="Leroy François Dehoux Matthieu">
		<meta name="description" content="Site d'un club de tennis">
		<meta name="keywords" content="accueil">
		<meta name="generator" content="Atom">
		<meta name="robots" content="index">

		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css" crossorigin="anonymous">

	</head>


	<body>
		<header>


			<?php include("menu_view.php"); ?>

		</header>

		<div id="content">
			<div class="carousel-wrapper">
	  <span id="item-1"></span>
	  <span id="item-2"></span>
	  <span id="item-3"></span>
	  <div class="carousel-item item-1">
	    <h2>Bienvenue au Tennis Club Plainchamp</h2>
	    <p>Le club de tennis de Saint-Vaast où règne une ambiance amicale. 3 terrains extérieurs en terre battue et 4 terrains couverts en chevron 400.
           Des terrains uniques dans la région de La Louvière et en Wallonie.
           Venez nous rejoindre dans un club familial ou reprendre ce sport convivial en loisirs et compétition.</p>
	    <a class="arrow arrow-prev" href="#item-3"></a>
	    <a class="arrow arrow-next" href="#item-2"></a>
	  </div>

	  <div class="carousel-item item-2">
	    <a class="arrow arrow-prev" href="#item-1"></a>
	    <a class="arrow arrow-next" href="#item-3"></a>
	  </div>

	  <div class="carousel-item item-3">

	    <a class="arrow arrow-prev" href="#item-2"></a>
	    <a class="arrow arrow-next" href="#item-1"></a>
	  </div>
	</div>

</div>

		</div>
		<div id='content'>
		<h1>Actualités<h1>
        <?php
			if (isset($_SESSION['admin'])){?>
				<a class="btn btn-primary" href="<?php echo base_url()?>admin/annonce_view">Ajouter une annonce</a>


				<?php
			}
            if ($is_null==true){

                echo "<div id='content'><h2>Pas d'annonce pour le moment</h2></div>";

            }
            else{
            	echo "<div id='content'>";
            	foreach($donnees as $d){

					$url=base_url()."css/images/annonces/";
					$url_site=base_url();
					$date=$d['date_ajout'];
					if(isset($_SESSION['admin'])){

						if ($_SESSION['admin']==1){
                        						echo "<div><div><h1>".$d['titre']."</h1><p><time>".$date."</time></p></div><p>".$d['texte'].'</p><img src='.$url.$d['img_item'].'></div><div>'.'<a class="btn btn-primary" href='.$url_site."index/annonce_delete?id=".$d['id'].">Supprimer l'annonce</a><a class='btn btn-primary' href=".$url_site."index/annonce_modif?id=".$d['id'].">Modifier l'annonce</a></div>";

                        					}
					}

					else{

						echo "<div><div><h1>".$d['titre']."</h1><p><time>".$date."</time></p></div><p>".$d['texte'].'</p><img src='.$url.$d['img_item']."></div>";

					}

            	}
            	echo "</div>";
            /*
                $reponse = $bdd->query('SELECT * FROM annonce');
                while ($donnees = $reponse->fetch()){


                }*/
            }?>
            </div>




	</body>
</html>

