
<html>
    <head>
       <meta charset="utf-8">
        <title>Tc Plainchamp</title>
        <link rel="stylesheet" href="style2.css"  />
    </head>

    <body>
        <?php
           include 'menu_view.php';


		?>
			<div id="container2">

			<form action="annonce" method="POST" enctype="multipart/form-data">
				<h1>Ecrire une petite annonce</h1>
				<label><b>Titre:</b></label>
				<input type="text" placeholder="" name="titre" value=""required>
				<label><b>Texte:</b></label>
				<textarea class="form-control" id="exampleFormControlTextarea1" name="texte" rows="6" required></textarea>
				<label for="fichier_a_uploader" title="Recherchez le fichier à uploader !"><b>Ajoutez une image à votre annonce:</b></label>
				<input type="file" name="fileToUpload" id="fileToUpload">
				<input type="submit" id='submit' name='submit' value="Publier" >

			</form>

</body>

</html>
