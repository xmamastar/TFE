<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale1.0">
	<title></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">
</head>
<?php include 'menu_view.php';?>

<body>

	<div class="container">

		<div class="row">
			<?php 

				$jour=$date;
				//var_dump($jour);
				$jour2 = str_replace('/', "", $jour);
                $jour2=intval($jour2);
				$today=date('Y/m/d');
				$today2 = date('Ymd');
                $today2=intval($today2);
                //var_dump($today2);
                //var_dump($jour2);
				if($jour2<$today2){

					redirect(redirect(base_url()."reservation/book?date=".$today));

				}

				$jour_suivant=date('Y/m/d',strtotime($date.'+ 1 days'));
				$jour_suivant2 = str_replace('/', "", $jour_suivant);
				$jour_suivant2=intval($jour_suivant2);
				$jour_max=date('Y/m/d',strtotime($today.'+ 1 months'));
				$jour_max = str_replace('/', "", $jour_max);
				$jour_max=intval($jour_max);
				//var_dump($jour_max);
				//var_dump($jour_suivant);
				$jour_precedent=date('Y/m/d',strtotime($date.'- 1 days'));
				$today = str_replace('/', "", $today);
				$jour_precedent2 = str_replace('/', "", $jour_precedent);
				$jour_precedent2=intval($jour_precedent2);
				$today=intval($today);
				//var_dump($today);
				//var_dump($jour_precedent);
				$jour_precedent_up_today=$jour_precedent2<$today;
				$jour_suivant_up_jour_max=$jour_suivant2>=$jour_max;
				if($jour2>$jour_max){
						redirect(base_url()."reservation/book?date=".$today);
					}
				//var_dump($jour_suivant_up_jour_max);

			?>
			
				<h1 class="text-center">
				<?php if(!$jour_precedent_up_today){?>
					<a class='btn btn-xs btn-primary'  href= "<?php echo '?date='.$jour_precedent ;?>">Jour Précédent </a>
					<?php
					}?>
					<?php echo date('d/m/Y',strtotime($date)) ?>
					<?php if(!$jour_suivant_up_jour_max){?>
					<a class='btn btn-xs btn-primary' href= "<?php echo '?date='.$jour_suivant ;?>">Jour Suivant </a>
					<?php
                    					}?>
				</h1>

					<hr>
				
				<div class="col-md-12">

					<?php if(isset($_SESSION['msg'])){
						echo $_SESSION['msg'];
						//$_SESSION['msg']="";
						}
						else{
							echo "";
						}
					?>
				</div>
			
			<?php

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
						<button class="btn-danger bookAdmin" date="<?php echo $date; ?>" timeslot="<?php echo $ts; ?>" id-reservation= "<?php echo $id_reservation; ?>" data-client = "<?php echo $id_cli; ?>" data-terrain="<?php echo $j; ?>"><?php $_SESSION['ts']=$ts;$_SESSION['terrain']=$j;echo $id_cli;?></button>
					<?php
					}
					if ($_SESSION['admin']==0){

							$client=$id_client;
                            $client=str_replace("_","",$client);

                            $nom=$_SESSION["nom"];
                            if(strlen($nom)>5){
                            	$nom=substr($_SESSION["nom"], 0, 5);
                            }
                             ?>
							<button class="btn-danger"><?php if($client==$_SESSION["id"]) {echo $nom;}else{echo $ts;}?></button>
						<?php
					}

				}else{ ?>
						<button class="btn-success book" data-terrain="<?php echo $j; ?>" data-timeslot="<?php echo $ts;?>"><?php
						//var_dump($id_client);



						echo $ts;?></button>
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

							<?php if (isset($_SESSION['admin'])){

								if($_SESSION['admin']==1){

								?>
								<input  required type="text" name="name" class="form-control" >

							<?php
							}else{?>
								<input  readonly type="text" name="name" class="form-control" value=<?php echo $_SESSION['nom'];?>>
							<?php
							}
							}

							?>


						</div>
						<div class="form-group">
							<label for="">Email</label>
							<?php if (isset($_SESSION['admin'])){
							if($_SESSION['admin']==1){?>
							<input required type="email" name="email" class="form-control">
							<?php
							}else{?>
								<input readonly type="email" name="email" class="form-control" value=<?php echo $_SESSION['mail'];?>>
							<?php
							}
							}
							?>
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
	<?php $url=base_url()."js/jquery.js";?>
	<script src= <?php echo $url;?> type="text/javascript" charset="utf-8"</script>
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


	$(".bookAdmin").click(function test(){
	var id_reservation=$(this).attr('id-reservation');
	var date=$(this).attr('date');
	var terrain= $(this).attr('data-terrain');
	var ts= $(this).attr('timeslot');
	var url="http://localhost/codeIgniter/reservation/admin_booking?id="+id_reservation.toString()+"?ts="+ts+"?terrain="+terrain+"?date="+date;
	window.location.replace(url);

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
