<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">
	</head>
	<?php include 'menu_view.php';?>
	<body>


                    <div id="container2">
                        <!-- zone de connexion -->
                        <form action= "test_inscription" method="POST">
                            <h1>Inscription</h1>
                            <label><b>Nom:</b></label>
                            <input type="text" placeholder="Entrer votre nom" name="nom" value="<?php if(isset($nom)){echo $nom;}else{echo '';} ?>" required>
                            <label><b>Prenom:</b></label>
                            <input type="text" placeholder="Entrer votre Prénom" name="prenom" value="<?php if(isset($prenom)){echo $prenom;}else{echo '';} ?>"required>
                            <label><b>Adresse Mail:</b></label>
                            <input type="email" placeholder="Entrer votre adresse mail" name="mail" value="<?php if(isset($mail)){echo $mail;}else{echo '';} ?>" required>
                            <label><b>Mot de passe:</b></label>
                            <input type="password" placeholder="Entrer le mot de passe" name="password" required>
                            <label><b>Confirmation Mot de passe:</b></label>
                            <input type="password" placeholder="Entrer le mot de passe" name="password2" required>
                            <label><b>Classement:</b></label>
                            <select id="classement" name="classement" value="<?php if(isset($classement)){echo $classement;} ?>">
                              <option value="NC">NC</option>
                              <option value="C30.6">C30.6</option>
                              <option value="C30.5">C30.5</option>
                              <option value="C30.4">C30.4</option>
                              <option value="C30.3">C30.3</option>
                              <option value="C30.2">C30.2</option>
                              <option value="C30.1">C30.1</option>
                              <option value="C30.0">C30.0</option>
                              <option value="C15.5">C15.5</option>
                              <option value="C15.4">C15.4</option>
                              <option value="C15.3">C15.3</option>
                              <option value="C15.2">C15.2</option>
                              <option value="C15.1">C15.1</option>
                              <option value="C15">C15</option>
                              <option value="B4/6">B4/6</option>
                              <option value="B2/6">B2/6</option>
                              <option value="B0">B0</option>
                              <option value="B-2/6">B-2/6</option>
                              <option value="B-4/6">B-4/6</option>
                              <option value="B-15">B-15</option>
                              <option value="B-15.1">B-15.1</option>
                              <option value="B-15.2">B-15.2</option>
                              <option value="B-15.4">B-15.4</option>
                              <option value="A Nat">A Nat</option>
                              <option value="A int">A int</option>


                            </select>
                            <input type="submit" id='submit' value="S'inscrire" >

                        </form>

                </body>
</html>
