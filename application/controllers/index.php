<?php
session_start();
class index extends CI_Controller
{
	public function accueil(){
		$data=array(
		"is_null"=>true,
		"donnees"=>[]);

		$this->load->model('annonce_model', 'annonce');
		$resultat=$this->annonce->select_all();
		if($resultat==null){

        			$data=['is_null'=>true];


        		}
        else{
        	foreach ($resultat as $r){

            			$item=['id'=>$r->id_annonce,'titre'=>$r->titre,'texte'=>$r->texte,'img_item'=>$r->img_item,'date_ajout'=>$r->date_ajout];
            			$d=$data["donnees"];
            			$id=strval($r->id_annonce);
            			$d[$id]=$item;
            			$data["donnees"]=$d;
            			$data["is_null"]=false;

            		}



            			//$data=["is_null"=false, "donnees"=>['titre'=>$resultat->titre,'texte'=>$resultat->texte,'img_item'=>$resultat->img_item]];


        }


		$this->load->view('accueil_view',$data);

	}
	public function annonce_modif(){

    		if($_SESSION['admin']==1){
				$data=array();
    			if(isset($_GET['id'])){
    				$this->load->model('annonce_model', 'annonce');
    				$id=$_GET['id'];
    				$annonce=$this->annonce->get_by_id($id);
    				foreach($annonce as $a){
    					$data=$a;
    				}

    				$this->load->view('modification_annonce_view',$data);

    			}

    		}
    		else{
    			echo "<div class='alert alert-danger' role='alert'> Vous n'êtes pas administrateur</div>";
    			redirect(base_url()."index/accueil");
    		}

    	}
    public function modification_annonce(){
		if ($_SESSION["admin"]!=1){
				header ("location: index.php");
				echo "vous n'etes pas Administrateur";
		}
			else{

			if (isset($_POST['titre'])||isset($_POST["texte"])||isset($target_file)||isset($img_item))
				{
					var_dump($_POST['titre']);
					var_dump($_POST["texte"]);
					$id_annonce=$_POST['id_annonce'];
					$titre=htmlspecialchars($_POST["titre"]);
					$texte=htmlspecialchars($_POST["texte"]);
					$date=date("Y-m-d g:i");
					var_dump($date);
					$target_dir ="./css/images/annonces/";
					$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
					$uploadOk = 1;
					$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
					$img_item = basename($_FILES["fileToUpload"]["name"]);
					if ($_POST['titre']!="" && $_POST['texte']!="")
					{
						if(preg_match("#^[a-zA-Z0-9- ]{2,30}$#", $titre))
						{
								if(preg_match("#^[a-zA-Z0-9- \'\.\,\,\;\-\_\+\!\?\&\é\@\"\#\è\à\ç\€\$\ù\%\:\)\(\* ]{1,1000}$#", $texte))
								{
										$this->load->model('annonce_model', 'annonce');
										$annonces=$this->annonce->get_by_titre($titre);
										if($annonces!=null&&$_POST['old_titre']!=$titre){
											echo "<div class='alert alert-danger' role='alert'> Une annonce avec le même titre existe déjà</div>";
										}


										else
										{

										 if(isset($_FILES['fileToUpload'])){


											if(isset($_POST["submit"])) {
											  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
											  if($check !== false) {
												echo "File is an image - " . $check["mime"] . ".";
												$uploadOk = 1;
											  } else {
												echo "File is not an image.";
												$uploadOk = 0;
											  }

											}
											/*if (file_exists($target_file)) {
											  echo "<div class='alert alert-danger' role='alert'>L'image que vous voulez ajouter existe déjà, changez d'image ou modifiez son nom</div>";
											  $uploadOk = 0;
											}*/
											if ($_FILES["fileToUpload"]["size"] > 500000) {
											  echo "Sorry, your file is too large.";
											  $uploadOk = 0;
											}
											if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
											&& $imageFileType != "gif" ) {
											  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
											  $uploadOk = 0;
											}
											if ($uploadOk == 0) {
											  echo "Sorry, your file was not uploaded.";
											}
											else {
											  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
												//echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
												//echo "Votre compte a été correctement ajouté";
												var_dump($id_annonce);
											  $this->annonce->update_annonce($id_annonce,$titre,$texte,$img_item,$date);


											  echo "<div class='alert alert-success' role='alert'>Annonce créée</div>";

											  } else {
												echo "<div class='alert alert-danger' role='alert'>Il y a eu une erreur lors du chargement de votre fichier</div>";
											  }
											}
										  }
									  else{
										  /*$this->annonce->insert_annonce_without_img($titre,$texte,$date);

											echo "<div class='alert alert-success' role='alert'>Annonce créée</div>";*/

									   }
										}


								}
								else
								{
									echo "Complètez le texte avec des caractères valides";
								}


						}
						else
						{
							echo "Le titre doit contenir entre 2 et 200 caractères";
						}

					}
					else
					{
						echo "Veillez remplir tout les champs.";
					}
					redirect(base_url()."index/accueil");

				}
		}

	}

	public function annonce_delete(){
    		if($_SESSION['admin']==1){

    			if (isset($_GET['id'])){
                    			$this->load->model('annonce_model', 'annonce');
                    			$this->annonce->delete_annonce_by_id($_GET['id']);

                    		}

    		}
    		$this->accueil();

    	}






}
