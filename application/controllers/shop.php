<?php
session_start();
class Shop extends CI_Controller
{
	public function shop_view(){
		$_SESSION['cat']="all";
		$is_null=true;
		$this->load->model('shop_model', 'shop');
		if(isset($_GET['cat'])){

		$_SESSION['cat']=$_GET['cat'];
		}
		if($_SESSION["cat"]=="all"){
			$articles=$this->shop->select_all();
			foreach($articles as $a){
				if (isset($a->id_item)){
					$is_null=false;
				}
			}

			$data['articles']=$articles;
			$data['is_null']=$is_null;
			$this->load->view("shop_view",$data);

		}
		else{
			$articles=$this->shop->get_by_cat($_SESSION['cat']);
			foreach($articles as $a){
				if (isset($a->id_item)){
					$is_null=false;
				}
			}

			$data['articles']=$articles;
			$data['is_null']=$is_null;
			$this->load->view("shop_view",$data);

		}






	}
	public function ajout_item(){

		if (isset($_GET["msg"])){
			if($_GET["msg"]==1){
				$message=$_SESSION['message'];
				$msg= "<div class='alert alert-success' role='alert'>".$message."</div>";
				$data["msg"]=$msg;
				$this->load->view("ajouter_item_view",$data);
				$_SESSION['message']="";
			}




				if($_GET["msg"]==2){
					$message=$_SESSION['message'];
					$msg= "<div class='alert alert-danger' role='alert'>".$message."</div>";
					$data["msg"]=$msg;
					$this->load->view("ajouter_item_view",$data);
					$_SESSION['message']="";
				}

			}



		else{
			$this->load->view("ajouter_item_view");
		}


	}
	public function ajout_item_verif(){

		 if (isset($_POST['nom_item'])||isset($_POST["cat_item"])||isset($_POST["descri_item"])||isset($_POST["prix_item"])||isset($target_file)||isset($img_item))
                {
                	$this->load->model('shop_model', 'shop');
                    $nom_item=htmlspecialchars($_POST["nom_item"]);
                    $cat_item=htmlspecialchars($_POST["cat_item"]);
                    $descri_item=htmlspecialchars($_POST["descri_item"]);
                    $prix_item=$_POST["prix_item"];
                    $qte_item=0;
                    if(isset($_POST["quantite_item"])){
                    	$qte_item=$_POST["quantite_item"];
                    }
                    var_dump($qte_item);
                    var_dump($_POST['quantite_item']);


                    $target_dir = "./css/images/items/";
                    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    $img_item = basename($_FILES["fileToUpload"]["name"]);
                    if ($_POST['nom_item']!="" && $_POST['cat_item']!=""&& $_POST["descri_item"]!="" && $_POST["prix_item"]!="")
                    {
                        if(preg_match("#^[a-zA-Z0-9- ]{2,30}$#", $nom_item))
                        {
                            if(preg_match("#^[a-zA-Z0-9]{2,30}$#", $cat_item))
                            {
                                if(preg_match("#^[a-zA-Z0-9 \'\.\,\,\;\-\_\+\!\?\&\é\@\"\#\è\à\ç\€\$\ù\%\:\)\(\* ]{1,1000}$#", $descri_item))
                                {
                                    if(preg_match("#^[0-9]{1,30}$#", $prix_item))
                                    {
                                    	$articles=$this->shop->get_by_nom($nom_item);
                                    	$is_in_db=false;
                                    	var_dump($articles);
                                    	if($articles!=null){
                                    		var_dump($articles->nom_item);

												if ($articles->nom_item==$nom_item)
													{
														$is_in_db=true;
														$_SESSION['message']="L'objet que vous essayez de créer existe déjà";
														redirect(base_url()."shop/ajout_item?msg=2");

													}


										}

                                        if($is_in_db==false)
                                        {

                                        if(isset($_POST["submit"])) {
                                          $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                                          if($check !== false) {
                                            echo "File is an image - " . $check["mime"] . ".";
                                            $uploadOk = 1;
                                          } else {
                                            $_SESSION['message']="File is not an image.";
                                            $uploadOk = 0;
                                          }
                                        }
                                        /*if (file_exists($target_file)) {
                                          echo "Sorry, file already exists.";
                                          $uploadOk = 0;
                                        }*/
                                        if ($_FILES["fileToUpload"]["size"] > 5000000) {
                                          $_SESSION['message']="Sorry, your file is too large.";
                                          $uploadOk = 0;
                                        }
                                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                                        && $imageFileType != "gif" ) {
                                          $_SESSION['message']="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                                          $uploadOk = 0;
                                        }
                                        if ($uploadOk == 0) {
                                          echo "Sorry, your file was not uploaded.";
                                        } else {
                                          if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                                            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                                            $_SESSION['message']="Votre article a été correctement ajouté";
                                          $this->shop->insert_article($nom_item, $cat_item, $descri_item,$prix_item, $img_item,$qte_item);


                                          $nom_item ="";
                                          $cat_item="";
                                          $descri_item="";
                                          $prix_item="";
                                          redirect(base_url()."shop/ajout_item?msg=1");
                                          } else {
                                           $_SESSION['message']="Sorry, there was an error uploading your file.";
                                           redirect(base_url()."shop/ajout_item?msg=2");
                                          }
                                        }

                                        }


                                    }
                                    else
                                    {
                                        $_SESSION['message']="Complètez un prix valide";
                                        redirect(base_url()."shop/ajout_item?msg=2");
                                    }

                                }
                                else
                                {
                                    $_SESSION['message']="Complètez la description avec des caractères valides";
                                    redirect(base_url()."shop/ajout_item?msg=2");
                                }
                            }

                        }
                        else
                        {
                            $_SESSION['message']="Le nom doit contenir entre 2 et 30 caractères";
                            redirect(base_url()."shop/ajout_item?msg=2");
                        }

                    }
                    else
                    {
                        $_SESSION['message']="Veillez remplir tout les champs.";
                        redirect(base_url()."shop/ajout_item?msg=2");
                    }



                }

	}
	public function suppritem(){


    	$id_item=$_POST['id_item'];
    	$this->load->model('shop_model', 'shop');
 		$this->shop->delete_article($id_item);

       redirect(base_url()."shop/shop_view");





	}
	public function quantitem(){

		$this->load->model('shop_model', 'shop');
		$id_item=$_POST['id_item'];
        $qte_item=$_POST['qte_item'];
        $item=$this->shop->get_by_id($id_item);
        var_dump($item);
		$this->shop->update_qte_item($id_item,$item->nom_item,$qte_item,$item->cat_item,$item->descri_item,$item->prix_item,$item->img_item);



        redirect(base_url()."shop/shop_view");

	}
	public function ajout_panier(){

		$id_item=$_POST['id_item'];
        $qte_item=1;
        $is_in_panier=false;
        $count=0;
        $taille_panier=count($_SESSION['panier']);

        if ($taille_panier>0){

            for($i=0;$i<$taille_panier;$i++){
                $item=$_SESSION['panier'][$i];
                if($item[0]==$id_item){

                    $qte_item=$item[1];
                    $_SESSION['test']=$item[0];
                    $_SESSION['test1']=$item[1];

                    $is_in_panier=true;
                    $count=$i;
                }

            }
            if ($is_in_panier==true)
                  {

                    $item=array();
                    $qte_item+=1;
                    array_push($item,$id_item);
                    array_push($item,$qte_item);
                    $_SESSION['panier'][$count]=$item;
                    //array_push($_SESSION['panier'],$item);
                    //$_SESSION['panier'][$positionProduit] = $_SESSION['panier']['qte'][$positionProduit] + $qte_item ;
                  }
            else
                  {
                     //Sinon on ajoute le produit

                    $item=array();
                    array_push($item,$id_item);
                    array_push($item,$qte_item);
                    $qte_item=1;
                    array_push($_SESSION['panier'],$item);
                  }

                  var_dump($_SESSION['panier']);
                  //redirect(base_url()."shop/shop_view");
        }


        else{
                     //Sinon on ajoute le produit
                    $qte_item=1;
                    $item=array();
                    array_push($item,$id_item);
                    array_push($item,$qte_item);
                    $_SESSION['test']=$id_item;
                     $_SESSION['test1']=$qte_item;
                    array_push($_SESSION['panier'],$item);
                  }

       var_dump($_SESSION['panier']);
       redirect(base_url()."shop/shop_view");




	}



	public function panier(){
        $this->load->model('shop_model', 'shop');
        $nbArticles=count($_SESSION['panier']);
        $data=array();
        $liste=array();
        if ($nbArticles <= 0){

		}
		else{

			for ($i=0 ;$i < $nbArticles ; $i++)
			{


				$item=$_SESSION['panier'][$i];
				$id=$item[0];
				$qte=$item[1];

				$resultat=$this->shop->get_by_id($id);
				if ($resultat!=null){
					array_push($liste,$resultat);


					echo $resultat->prix_item;


				}






			}


        //$this->check_pannier();
		}
		$data['liste']=$liste;
		$this->load->view('panier_view',$data);
	}
	public function plus_panier(){

		$panier=$_SESSION['panier'];
        $id_item=$_POST['id_item'];
        $taille_panier=count($_SESSION['panier']);
            for($i=0;$i<$taille_panier;$i++){
                $item=$_SESSION['panier'][$i];
                if($item[0]==$id_item){
                    echo "test";
                    $qte_item = $item[1]+1;
                    echo $qte_item;
                    var_dump($panier);
                    var_dump($item);
                    $remplace = array(1 => $qte_item);
                    var_dump($remplace);
                    $newpa = array_replace($item, $remplace);
                    var_dump($newpa);
                    $panier=$newpa;
                    //array_splice($panier, $i, 1, $newpa);
                    var_dump($panier);
                    $_SESSION['panier'][$i]=$panier;

                }


            }
        redirect(base_url()."shop/panier");

	}
	public function moins_panier(){

		$panier=$_SESSION['panier'];
        $id_item=$_POST['id_item'];
        $taille_panier=count($_SESSION['panier']);
            for($i=0;$i<$taille_panier;$i++){
                $item=$_SESSION['panier'][$i];
                if($item[0]==$id_item){
                    echo "test";
                    $qte_item = $item[1]-1;
                    echo $qte_item;
                    var_dump($panier);
                    var_dump($item);
                    $remplace = array(1 => $qte_item);
                    var_dump($remplace);
                    $newpa = array_replace($item, $remplace);
                    var_dump($newpa);
                    $panier=$newpa;
                    //array_splice($panier, $i, 1, $newpa);
                    var_dump($panier);
                    $_SESSION['panier'][$i]=$panier;

                }


            }
            redirect(base_url()."shop/panier");

	}
	public function suppr_panier(){

		$id_item=$_POST['id_item'];
        $taille_panier=count($_SESSION['panier']);
            for($i=0;$i<$taille_panier;$i++){
                $panier=$_SESSION['panier'];
                $item=$_SESSION['panier'][$i];
                if($item[0]==$id_item){
                    echo "test";
                    var_dump($panier);
                    array_splice ($panier , $i, 1);
                    //array_splice($_SESSION['panier'][$i]);
                    var_dump($panier);
                    $_SESSION['panier']=$panier;
                }


            }

		redirect(base_url()."shop/panier");
	}
	public function commander(){

		$total=0;
		$this->load->model('shop_model', 'shop');
		$nbArticles=count($_SESSION['panier']);
		$id_cli = $_SESSION['id'];
		$nom_client = $_SESSION['nom'];
		$com= date('ymdHis');
		$bon_com = $id_cli.$com;
		echo $bon_com;

			for ($i=0 ;$i < $nbArticles ; $i++)
			{


				$item=$_SESSION['panier'][$i];
				//echo $str;
				$id=$item[0];
				//echo $id;
				$qte=$item[1];
				$reponse=$this->shop->get_by_id($id);
				$prix=$reponse->prix_item;
				$mul=$prix*$qte;
				$total=$total+$mul;
				$this->load->model('commande_model', 'commande');
				$this->commande->ajouter_commande($bon_com,$id,$qte,$reponse->prix_item);

				unset($_SESSION['panier'][$i]);
			}
			$this->load->model('commande_admin_model', 'commandeadmin');
			$this->commandeadmin->ajouter_commande($bon_com,$id_cli,$nom_client,date('y-m-d'),$total);
			$_SESSION['panier']=array();
			redirect(base_url()."shop/panier");




	}


}
