<?php
$nbTerrains=7;
$terrain=0;
$_SESSION['ts']="";
if (isset($_POST["terrain"])){

	$terrain= $_POST["terrain"];
	$terrain=intVal($terrain);
	//echo $terrain;

}

if(isset($_GET['date'])){

	$date=$_GET['date'];
	$resultat=$this->reservation->get_element_by_date($date);
	$date=$_GET['date'];
	$resultat=$this->reservation->get_element_by_date($date);

	if ($resultat!=null){
		foreach($resultat as $r){
			//$test=implode($row);
			//echo $test;
			$liste=array($r->terrain,$r->timeslot,$r->id_client,$r->id);
			$bookings[]=$liste;
		}
	}

}
if(isset($_POST['submitAdmin'])){
$id_reservation=$_POST['id_reservation'];
$this->reservation->delete_element($id_reservation);
$msg="<div class='alert alert-success'>Reservation Supprimée</div>";
$stmt->execute();
$stmt->close();
header('Location: ' . $_SERVER['HTTP_REFERER']);

}
if(isset($_POST['submit'])){

	$name=$_POST['name'];
	$email=$_POST['email'];
	$timeslot=$_POST['timeslot'];
	echo $name;
	echo $email;
	echo $timeslot;

	$id_reservation=0;
	$id_client=0;
	if($resultat!=null){

		$msg="<div class='alert alert-danger'>Already Reserved</div>";

	}
	else{

		if(isset($_POST['timeslotFin'])){
			$ts=$timeslot;
			for($i=0;$i<=$_POST['timeslotFin'];$i++){
				$timeslot=$ts;
				$time_s=explode("-",$timeslot);
				$start= new DateTime($time_s[0]);
				$end=new DateTime($time_s[1]);
				if ($i==0){
					$duration=0;
				}
				if($i!=0){

					$duration=30;
				}
				$interval =new DateInterval("PT".$duration."M");
				$start->add($interval);
				$end->add($interval);
				$timeslot=$start->format("H:i")."-".$end->format("H:i");
				echo $timeslot;
				if (isset($_SESSION['admin'])){
					$resultat=$this->reservation->get_element_by_mail($email);

					if ($resultat!=null){
						foreach($resultat as $r){
							//$test=implode($row);
							//echo $test;
							$id_client=$r->id;

						}
					}
					$this->reservation->insert($name,$timeslot,$email,$date,$terrain,$id_client);
					echo $name;
					echo $timeslot;
					echo $email;
					echo $date;
					echo $terrain;
					echo $id_client;

				}
				if (!isset($_SESSION['admin'])){
					echo $name;
					echo $timeslot;
					echo $email;
					echo $date;
					echo $terrain;
					echo $id_client;
					$this->reservation->insert($name,$timeslot,$email,$date,$terrain,$id_client);
					$msg="<div class='alert alert-success'>Booking Successfull</div>";




				}
				$resultat=$this->reservation->get_element_by_name_mail_timeslot($name,$timeslot,$email,$date,$terrain,$_SESSION['id']);
				var_dump($resultat);
				if($resultat!=null){
					foreach($resultat as $r){

						$id_reservation=$r->id;
						var_dump($r);
					}

				}
				if($id_client=0){

					$liste=array($terrain,$timeslot,$_SESSION['id'],$id_reservation);
					$bookings[]=$liste;
				}
				elseif($id_client!=0){
					$liste=array($terrain,$timeslot,$id_client,$id_reservation);
					$bookings[]=$liste;

				}



				$ts=$timeslot;




			}




		}




	}

	header('Location: ' . $_SERVER['HTTP_REFERER']);
}





function timeslots(){
	$duration=30;
    $cleanup=0;
    $start="09:00";
    $end="23:00";
	$start=new DateTime($start);
	$end=new DateTime($end);
	$interval =new DateInterval("PT".$duration."M");
	$cleanupInterval= new DateInterval("PT".$cleanup."M");
	$slots=array();


	for($intStart=$start;$intStart<$end;$intStart->add($interval)->add($cleanupInterval)){
		$endPeriod=clone $intStart;
		$endPeriod->add($interval);
		if($endPeriod>$end){
			break;
		}
		$slots[]=$intStart->format("H:i")."-".$endPeriod->format("H:i");
	}
	return $slots;


}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale1.0">
	<title></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css" />
</head>

<body>

	<div class="container">

		<div class="row">
			<?php

				$jour=$date;
				$jour_suivant=date('Y/m/d',strtotime($date.'+ 1 days'));
				$jour_precedent=date('Y/m/d',strtotime($date.'- 1 days'));

			?>

				<h1 class="text-center">
					<a class='btn btn-xs btn-primary' href= "<?php echo '?date='.$jour_precedent ;?>">Jour Précédent </a>
					<?php echo date('d/m/Y',strtotime($date)) ?>

					<a class='btn btn-xs btn-primary' href= "<?php echo '?date='.$jour_suivant ;?>">Jour Suivant </a>
				</h1>

					<hr>

				<div class="col-md-12">

					<?php echo isset($msg)?$msg:"";?>
				</div>

			<?php
			$timeslots=timeslots();
			$id_client="";
			$x=0;
			array_unshift($timeslots,$x);
			foreach ($timeslots as $ts) {

				?>
				<div class="column">
				<?php
				for($j=1;$j<=$nbTerrains;$j++){

			?>
			<div>
				<div>
					<?php
					if($ts==$timeslots[0]){

						?>
						<div class="titre">
							<h5>Terrain<?php echo $j; ?></h5>
						</div>
						<?php
					}
					else{
						$liste_ts=array();
						$is_in_liste=false;
						$id_reservation=0;

						for ($i=0;$i<count($bookings);$i++){

							if($bookings[$i][1]==$ts && $j==$bookings[$i][0]){

								$is_in_liste=true;
								$id_client=$bookings[$i][2];
								$id_cli=$bookings[$i][2];
								if (isset ($bookings[$i][3])){
									$id_reservation=$bookings[$i][3];
								}

							}
						}
						if($is_in_liste){
						//affiche le bouton en rouge si il est réservé $ts=différent timeslot
							if (strlen($id_client)<11){
								#$nb_char=11-strlen($nom);
								$id_client=str_pad($id_client, 11, "_", STR_PAD_BOTH);

							}
							if (strlen($id_client)>11){
								$id_client=substr($id_client,0,12);


							}

							if ($_SESSION['admin']==1){



					?>
						<button class="btn-danger bookAdmin" id-reservation= "<?php echo $id_reservation; ?>" data-client = "<?php echo $id_cli; ?>" data-terrain="<?php echo $j; ?>"><?php $_SESSION['ts']=$ts;$_SESSION['terrain']=$j;echo $id_cli;?></button>
					<?php
					}
					if ($_SESSION['admin']==0){
						?>

							<button class="btn-danger"><?php echo $ts;?></button>
						<?php
					}

				}else{ ?>
						<button class="btn-success book" data-terrain="<?php echo $j; ?>" data-timeslot="<?php echo $ts;?>"><?php echo $ts;?></button>
					<?php }
				} ?>
				</div>


			</div>
		<?php }
		?>
		</div>
		<?php
				}

		?>
	</div>
		</div>
	</div>

<!-- The Modal -->
<div class="modal fade" id="modalClient" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Réservation le <?php echo date('d/m/Y',strtotime($_GET['date']));?> sur le Terrain <span id="slot"> </span></h4>
      </div>

      <div class="modal-body">
      	<div class="row">
					<div class="col-md-12">
						<form action="" method="post">
							<div class="form-group timeslot">
								<label>De:</label>
								<input required type="text" readonly name="timeslotstart" id="timeslotstart" class="form-control">
								<input required type="hidden" readonly name="timeslot" id="timeslot" class="form-control">
								<input required type="hidden" readonly name="terrain" id="terrain" class="form-control">
								<label>Jusque:</label>
								<select required name="timeslotFin" id="timeslotfin" class="form-control">
									<option id="ts1"></option>
									<option id="ts2"></option>
									<option id="ts3"></option>
								</select>



						</div>
						<div class="form-group">
							<label for="">Name</label>
							<input required type="text" name="name" class="form-control">

						</div>
						<div class="form-group">
							<label for="">Email</label>
							<input required type="email" name="email" class="form-control">

						</div>
						<div class="form-group pull-right">
							<button class="btn btn-primary" type="submit" name="submit">Submit</button>

						</div>
					</form>

					</div>

				</div>
      </div>
		</div>
	</div>
</div>
			<!-- The Modal -->
<div class="modal fade" id="BookAdminModal" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">

	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Réservation le <?php echo date('d/m/Y',strtotime($_GET['date']));?> sur le Terrain <span id="slotAdmin"> </span></h4>
	      </div>

	      <div class="modal-body">
	      	<div class="row">
						<div class="col-md-12">
							<form action="" method="post">
								<div class="form-group timeslot">
									<label>Plage de reservation:</label>
									<input required type="text" readonly name="timeslotAdmin" id="timeslotAdmin" class="form-control">
									<input required type="hidden" readonly name="id_reservation" id="id_reservation" class="form-control">



							</div>
							<div class="form-group">
								<label for="">Id du joueur:</label>
								<input required type="text" readonly name="id_joueur" id="id_joueur" class="form-control">

							</div>
							<div class="form-group">
								<label for="">Name</label>
									<input required type="text" readonly name="nom_joueur" id="nom_joueur" class="form-control">

							</div>
							<div class="form-group">
								<label for="">E-mail</label>
								<input required type="text" readonly name="prenom_joueur" id="prenom_joueur" class="form-control">

							</div>
							<div class="form-group pull-right">
								<button class="btn btn-primary" id= "bouton-admin" type="submit" name="submitAdmin">Supprimer une réservation</button>

							</div>
						</form>

						</div>

					</div>
	      </div>



    </div>
  </div>
</div>
	<script src="js/jquery-3.4.1.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquerry/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
	<script>
	$(".book").click(function(){

		var timeslot=$(this).attr('data-timeslot');
		var terrain=$(this).attr('data-terrain');
		var heures=timeslot.split('-');
		var hstart=heures[0];
		var heure=hstart.split(':');
		var h=heure[0];
		var h=parseInt(h,10);
		var min=heure[1];
		var min=parseInt(min,10)
		var ts1=0;
		var ts2=0;
		var ts3=0;
		if(min==30){
			ts1=h+1;
			ts3=h+2
			ts1=ts1.toString()+':30';
			ts2=ts3.toString()+':00';
			ts3=ts3.toString()+':30';
		}

		else{
			min=min.toString()+'0';
			ts1=h+1;
			ts2=ts1.toString()+':30';
			ts3=h+2
			ts1=ts1.toString()+':00';
			ts3=ts3.toString()+':00';
		}

		h=h.toString()+':'+min.toString();
		$("#slot").html(terrain);
		$("#timeslot").val(timeslot);
		$("#terrain").val(terrain);
		$("#timeslotstart").val(h);
		$("#ts1").html(ts1);
		$("#ts2").html(ts2);
		$("#ts3").html(ts3);
		$("#ts1").val(1);
		$("#ts2").val(2);
		$("#ts3").val(3);
		$("#modalClient").modal("show");

	});


	$(".bookAdmin").click(function ajax(){

    var xhr=null;
    var id_client=$(this).attr('data-client');
    var terrains=$(this).attr('data-terrain');
    var id_reservation=$(this).attr('id-reservation');

    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject)
    {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    //on définit l'appel de la fonction au retour serveur
    xhr.onreadystatechange = function() { alert_ajax(xhr); };
    //xhr.open('GET', 'http://mon_site_web.com/ajax.php&param2=valeur2');
    //on appelle le fichier reponse.txt
    id_client=id_client.toString();
    terrains=terrains.toString();
    id_reservation=id_reservation.toString();
    xhr.open("GET", "reponseAjax.php?id_client="+id_client+"&terrain="+terrains+"&idReserv="+id_reservation, true);
    xhr.send(null);
	});
	function alert_ajax(xhr)
{
		var docXML= xhr.responseXML;
		var items = docXML.getElementsByTagName("id");
		var id=items.item(0).firstChild.data;
		var items = docXML.getElementsByTagName("nom");
		var nom=items.item(0).firstChild.data;


		var items = docXML.getElementsByTagName("prenom");
		var prenom=items.item(0).firstChild.data;

		var items = docXML.getElementsByTagName("terrain");
		var terrain=items.item(0).firstChild.data;

		var items = docXML.getElementsByTagName("id_reservation");
		var id_reservation=items.item(0).firstChild.data;

		var timeslot="<?php echo $_SESSION['ts'];?>";
		//alert (timeslot);

		$("#slotAdmin").html(terrain);
		$("#timeslotAdmin").val(timeslot);
		$("#id_joueur").val(id);
		$("#nom_joueur").val(nom);
		$("#prenom_joueur").val(prenom);
		$("#id_reservation").val(id_reservation);
		$("#BookAdminModal").modal("show");
}



		</script>
</body>
</html>

