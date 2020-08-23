<?php
session_start();
class Reservation_control extends CI_Controller
{

	public function __construct()
	{

		parent::__construct();

	 }

	 function timeslots($duration=30,$cleanup=0,$start="09:00",$end="23:00"){
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
     public function book(){
     	$nbTerrains=7;
     	$terrain=0;
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
									$liste=array($row['terrain'],$row['timeslot'],$row['id_client'],$row['id']);
									$bookings[]=$liste;
							}
							$stmt->close();
					}
			}
		 }
		 if(isset($_POST['submitAdmin'])){
			$id_reservation=$_POST['id_reservation'];
			$stmt=$mysqli->prepare("DELETE FROM bookings WHERE id = ?");
			$stmt->bind_param('s',$id_reservation);
			$msg="<div class='alert alert-success'>Reservation Supprimée</div>";
			$stmt->execute();
			$stmt->close();
			header('Location: ' . $_SERVER['HTTP_REFERER']);

		 }
		if(isset($_POST['submit'])){
			$name=$_POST['name'];
			$email=$_POST['email'];
			$timeslot=$_POST['timeslot'];
			$id_reservation=0;
			$id_client=0;
			if ($stmt->execute()){
				$result=$stmt->get_result();
				if($result->num_rows>0){
						$msg="<div class='alert alert-danger'>Already Reserved</div>";
				}
				else{
					if(isset($_POST['timeslotFin'])){
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

								$stmt=$mysqli->prepare("SELECT * FROM Utilisateurs WHERE mail=? ");
								$stmt->bind_param('s',$email);
								if ($stmt->execute()){
									$result=$stmt->get_result();
									if($result->num_rows>0){
										while($row =$result->fetch_assoc()){
										  $id_client=$row['id'];


										}
										$stmt->close();
									}


								}





							}
							$stmt=$mysqli->prepare("INSERT INTO bookings(name,timeslot,email,date,terrain,id_client) VALUES (?,?,?,?,?,?)");
							$stmt->bind_param('ssssss',$name,$timeslot,$email,$date,$terrain,$id_client);
							$stmt->execute();

						}
						if (!isset($_SESSION['admin'])){
							$stmt=$mysqli->prepare("INSERT INTO bookings(name,timeslot,email,date,terrain,id_client) VALUES (?,?,?,?,?,?)");
							$stmt->bind_param('ssssss',$name,$timeslot,$email,$date,$terrain,$_SESSION['id']);
							$stmt->execute();
							$msg="<div class='alert alert-success'>Booking Successfull</div>";
							$stmt->close();



						}
						$stmt=$mysqli->prepare("SELECT * FROM bookings WHERE name=? AND timeslot=? AND email=? AND date=? AND terrain=? AND id_client=?");
						$stmt->bind_param('ssssss',$name,$timeslot,$email,$date,$terrain,$_SESSION['id']);
						if ($stmt->execute()){
							$result=$stmt->get_result();
							if($result->num_rows>0){
								while($row =$result->fetch_assoc()){
									$id_reservation=$row['id'];
							//echo $test;

								}

							}
						}
						$stmt->close();
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
					$mysqli->close();


				}





			}

     	}
     	$data["bookings"]=$bookings;
		$data["timeslots"]=$this->timeslots($this->$duration,$this->$cleanup,$this->$start,$this->$end);
		$this->load->view('reservation_view',$data);
		header('Location: ' . $_SERVER['HTTP_REFERER']);
     	echo "coucou";
     }
}
