<html>
    <?php

    include 'menu_view.php';
    if ($_SESSION["admin"]!=1){

        redirect(base_url()."shop/shop_view");

    }
    else{

		if(isset($msg)){
			echo $msg;

		}


    ?>
    <head>
       <meta charset="utf-8">
        <title>Tc Plainchamp</title>
        <link rel="stylesheet" href="style2.css"  />
    </head>
    <body>
        <div id="container2">

        <form action="ajout_item_verif" method="POST" enctype="multipart/form-data">
        		<a class='btn btn-xs btn-primary'  href= <?php echo base_url()."shop/shop_view";?> >retour </a>
                <h1>Ajouter un nouvel objet à la boutique</h1>

                <label><b>Nom</b></label>
                <input type="text" name="nom_item">
                <label><b>Catégorie</b></label>
                <select type="text" name="cat_item">
                 <option value="raquette">Raquette de Tennis</option>
                 <option value="grips">Grips et Surgrips</option>

                 <option value="sac">Sac de Tennis</option>
                 <option value="balle">Balles de Tennis</option>
                 <option value="accessoire">Accessoires</option>
                 <option value="autre">Autres</option>
                </select>
                <label><b>Description</b></label>
                <input type="textarea" name="descri_item">
                <label><b>Prix</b></label>
                <input type="number" name="prix_item">
                <label><b>Quantité</b></label>
                <input type="number" name="quantite_item">
                <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Envoyer l image :</label>
                <input type="file" name="fileToUpload" id="fileToUpload">



                <input type="submit" id='submit' name='submit' value="Ajouter à la boutique" >

            </form>


        </div>
    </body>
    <?php } ?>
</html>
