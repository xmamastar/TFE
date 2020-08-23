<html>
    <?php

    include 'menu_view.php';
    if ($_SESSION["statut"]!=1){
		redirect(base_url()."index/accueil");


    }

    else{

    ?>
    <head>
       <meta charset="utf-8">
        <title>Tc Plainchamp</title>
        <link rel="stylesheet" href="style2.css"  />
    </head>
    <body>
        <div id="container2">
            <!-- zone de connexion -->

            <form action="" method="POST">
            	<a class='btn btn-xs btn-primary'  href= <?php echo base_url()."admin/admin_com" ;?> >retour </a>
                <h1>Commande n°<?php echo $bon_com;?></h1>
                <table>
				<?php
				$prix_commande=0;?>
				<td>article</td>
				<td>quantité</td>
				<td>prix unitaire</td>
				<td>prix total</td>
				<?php
				foreach($articles_commande as $a){
				?><tr><?php
					$url=base_url()."css/images/items/";?>
					 <td><?php echo $a['1']; ?></br><img class="rounded-sm" src=<?php echo $url.$a['2'];?>></td>
					 <td><?php echo $a['3']; ?></td>
					 <td> <?php echo $a['4'].'€'; ?></td>
					 <td><?php $prix_total=$a['4']*$a['3'] ; $prix_commande+=$prix_total; echo $prix_total.'€';?></td>



					 </tr>

					 <?php

				}?>

				</table>
				<h2>Prix de la commande:            <?php echo $prix_commande.'€';?></h2>






            </form>
        </div>
    </body>
    <?php } ?>
</html>
