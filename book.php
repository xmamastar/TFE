<?php
include "menu.php"; 
$mysqli= new mysqli('localhost','root','bdTennisTFE','bookingcalendar');
$nbTerrains=7;
$terrain=0;
echo $_SESSION['id'];
if (isset($_POST["terrain"])){

	$terrain= $_POST["terrain"];
	$terrain=intVal($terrain);
	//echo $terrain;

}

if(isset($_GET['date'])){

	$date=$_GET['date'];
	$stmt=$mysqli->prepare("SELECT * FROM bookings WHERE date=?");
	$stmt->bind_param('s',$date);
	$bookings=array();
	if ($stmt->execute()){
			$result=$stmt->get_result();
			if($result->num_rows>0){
					while($row =$result->fetch_assoc()){
							$test=implode($row);
							//echo $test;
							$liste=array($row['terrain'],$row['timeslot']);
							$bookings[]=$liste;
					}
					$stmt->close();
			}
	}
}
if(isset($_POST['submit'])){
	$name=$_POST['name'];
	$email=$_POST['email'];
	$timeslot=$_POST['timeslot'];

	//echo $_POST['timeslotFin'];
	//echo $_POST['timeslotstart'];
	$stmt=$mysqli->prepare("SELECT * FROM bookings WHERE date=? AND timeslot=? AND terrain=?");
	$stmt->bind_param('sss',$date,$timeslot,$terrain);
	if ($stmt->execute()){
			$result=$stmt->get_result();
			if($result->num_rows>0){
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
						else{

							$duration=30;
						}
						$interval =new DateInterval("PT".$duration."M");
						$start->add($interval);
						$end->add($interval);
						$timeslot=$start->format("H:i")."-".$end->format("H:i");
						echo $timeslot;
						$stmt=$mysqli->prepare("INSERT INTO bookings(name,timeslot,email,date,terrain) VALUES (?,?,?,?,?)");
						$stmt->bind_param('sssss',$name,$timeslot,$email,$date,$terrain);
						$stmt->execute();
						$msg="<div class='alert alert-success'>Booking Successfull</div>";
						$liste=array($terrain,$timeslot);
						$bookings[]=$liste;

						$ts=$timeslot;


					}
					$stmt->close();
					$mysqli->close();
				}


			}
	}



}

$duration=30;
$cleanup=0;
$start="09:00";
$end="23:00";
function timeslots($duration,$cleanup,$start,$end){
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
			<h1 class="text-center"><?php echo date('d/m/Y',strtotime($date)) ?></h1><hr>
			<div class="col-md-12">
				<?php echo isset($msg)?$msg:"";?>
			</div>
			<?php
			$timeslots=timeslots($duration,$cleanup,$start,$end);
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
						for ($i=0;$i<count($bookings);$i++){

							if($bookings[$i][1]==$ts && $j==$bookings[$i][0]){

								$is_in_liste=true;
							}
						}
						if($is_in_liste){
						//affiche le bouton en rouge si il est réservé $ts=différent timeslot
					?>

						<button class="btn-danger"><?php echo $ts;?></button>
					<?php }else{ ?>
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
<div class="modal fade" id="myModal" role="dialog">
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
			$("#myModal").modal("show");

		})
		</script>
</body>
</html>
