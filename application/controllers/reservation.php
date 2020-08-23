<?php
session_start();
class Reservation extends CI_Controller
{


	public function __construct()
	{

		parent::__construct();
		$ts=null;


	 }

	public function admin_booking()
	{
		foreach ($_GET as $key => $value) {
			 $GET[$key]=htmlentities($value, ENT_QUOTES);
		 }

		$this->load->model('reservation_model', 'reservation');



		if(isset($_GET["id"])){


			$data=$this->reservation->get_element_by_id($_GET["id"]);
			if($data!=null){
			foreach($data as $r){

				$data2=array('id'=>$r->id_client,'date'=>$r->date,'name'=>$r->name,'mail'=>$r->email,'timeslot'=>$r->timeslot,'terrain'=>$r->terrain,'id_reservation'=>$r->id);

			}


			}


			$this->load->view('bookAdmin_view',$data2);

		}




	}

	public function check_abonnement($abonnement,$fin,$debut){
		$this->load->model('abonnement_model', 'abonnement');
		$heure_max=0;
		$ts_fin=0;
		$ts_fin_minute=0;
		$ts=$debut;
		var_dump($fin);
		for($i=0;$i<=$fin;$i++){
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
			$ts_fin=$end->format("H");
			$ts_fin=intval($ts_fin);
			$ts_fin_minute=$end->format("i");
			if(intval($ts_fin_minute)==30){

				$ts_fin+=1;
			}
			$timeslot=$start->format("H:i")."-".$end->format("H:i");
			$ts=$timeslot;

		}

		$resultat=$this->abonnement->get_by_id($abonnement);
		foreach($resultat as $r){
			$heure_max=$r->heure_max;

		}
		if ($ts_fin<=$heure_max){
			return true;

		}
		else{
			return false;
		}

	}
	public function delete_reservation($date,$terrain,$ts){
		$numero_reservation=0;
		$this->load->model('reservation_model', 'reservation');
		$resultat=$this->reservation->get_element_by_ts_date_terrain($ts,$date,$terrain);
		foreach($resultat as $r){
			$numero_reservation=$r->numero_reservation;

		}
		$this->reservation->delete_booking_numeroReservation($numero_reservation);

	}

	public function delete_element(){
		foreach ($_GET as $key => $value) {
					 $GET[$key]=htmlentities($value, ENT_QUOTES);
				 }

		$this->load->model('reservation_model', 'reservation');
		$id_reservation=$_POST['id_reservation'];
        $this->delete_reservation($_POST["date"],$_POST["terrain"],$_POST["timeslotAdmin"]);
        $date=$_POST['date'];
        $date= str_replace("-", "/", $date);

        //$date=strtotime($_POST['date']);

        redirect(base_url()."reservation/book?date=".$date);

	}
	public function redirect(){
	foreach ($_GET as $key => $value) {
                 $GET[$key]=htmlentities($value, ENT_QUOTES);
             }
		$data["timeslots"]=$_GET["timeslot"];
        $data["date"]=$_GET["date"];
        $msg="<div class='alert alert-danger'>Already Reserved</div>";
        if($_GET["msg"]==1){
        	$msg="<div class='alert alert-success'>Booking Successfull</div>";
        }
		$data["msg"]=$msg;

		$data["nbTerrains"]=$_GET["nbTerrains"];
		$this->load->view('reservation_view',$data);


	}
	public function check_available($debut,$fin,$date,$terrain){
		$this->load->model('reservation_model', 'reservation');
		$ts=$debut;
		$is_available=true;
		for($i=0;$i<=$fin;$i++){
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

			$resultat=$this->reservation->get_element_by_ts_date_terrain($timeslot,$date,$terrain);

			if ($resultat ==null){

				echo "ok";

			}
			else{
				$is_available=false;
				return $is_available;
			}
			$ts=$timeslot;
		}
		return $is_available;
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
         $bool=0;
         foreach ($_GET as $key => $value) {
             $GET[$key]=htmlentities($value, ENT_QUOTES);
         }

         	if(isset($_GET["inf"])){

				$bool=1;


         	}
         	if($bool==0){
         		$_SESSION['msg']="";
         	}
         	$bookings=array();
			$this->load->model('reservation_model', 'reservation');
			$this->load->model('utilisateurs_model', 'user');
			$nbTerrains=7;
			$terrain=0;
			$msg="";
			$_SESSION['ts']="";
			$booked=false;
			$date;
			//$_SESSION['msg']="";

			if (isset($_POST["terrain"])){

				$terrain= $_POST["terrain"];
				$terrain=intVal($terrain);


			 }
			 if(isset($_GET['date'])){

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
				 if(isset($_POST['submitAdmin'])){
					$id_reservation=$_POST['id_reservation'];
					$this->reservation->delete_element($id_reservation);
					$msg="<div class='alert alert-success'>Reservation Supprimée</div>";
					$stmt->execute();
					$stmt->close();
					$data["bookings"]=$bookings;
					$data["timeslots"]=$this->timeslots();
					$data["date"]=$date;
					$data["msg"]=$msg;
					$data["nbTerrains"]=$nbTerrains;
					$this->output->set_output(base_url()."reservation/book?date=".$date);

				 }
				 if(isset($_POST['submit'])){

					$name=$_POST['name'];
					$email=$_POST['email'];
					$timeslot=$_POST['timeslot'];
					echo $name;
					echo $email;
					echo $timeslot;
					$resultat2=$this->reservation->get_element_by_date_timeslot_terrain($date,$timeslot,$terrain);
					$id_reservation=0;
					$id_client=0;
					$numero_reservation=0;
					if($resultat2!=null){

						$msg="<div class='alert alert-danger'>Already Reserved</div>";

					}
					else{

						if(isset($_POST['timeslotFin'])){
							$ts=$timeslot;
							$is_available=$this->check_available($ts,$_POST['timeslotFin'],$date,$terrain);
							$is_in_abonnement=$this->check_abonnement($_SESSION['abonnement'],$_POST['timeslotFin'],$ts);


							$date_num=$today = date("YmdHis");

							$numero_reservation=strval($_SESSION['id']).$date_num;
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
								if ($_SESSION['admin']==1){
									$resultat=$this->user->get_by_mail($email);


									if ($resultat!=null){

										$id_client=$resultat->id;


									}

									if($is_available==true){

                                    	$this->reservation->insert($name,$timeslot,$email,$date,$terrain,$id_client,$numero_reservation);
                                    	$msg="<div class='alert alert-success'>Booking Successfull</div>";

                                    }
                                    if($is_available==false){

                                    	$msg="<div class='alert alert-danger'>Already Reserved</div>";
                                    }

									echo $name;
									echo $timeslot;
									echo $email;
									echo $date;
									echo $terrain;
									echo $id_client;

									$_SESSION['msg']=$msg;
									$booked=true;
									//redirect(base_url()."reservation/book?date=".$date);

								}
								if ($_SESSION['admin']==0){

									if($is_available==true&&$is_in_abonnement==true){

										$this->reservation->insert($name,$timeslot,$email,$date,$terrain,$_SESSION['id'],$numero_reservation);
										$msg="<div class='alert alert-success'>Booking Successfull</div>";

									}
									if($is_available==false){

										$msg="<div class='alert alert-danger'>Already Reserved</div>";
									}
									if($is_in_abonnement==false){

										$msg="<div class='alert alert-danger'>Votre abonnement ne vous permet pas de reserver à cette heure là </div>";
									}

									//$msg="<div class='alert alert-success'>Booking Successfull</div>";
									$_SESSION['msg']=$msg;

									$booked=true;

									//redirect(base_url()."reservation/book?date=".$date);




								}

								$resultat=$this->reservation->get_element_by_name_mail_timeslot($name,$timeslot,$email,$date,$terrain,$_SESSION['id']);

								if($resultat!=null){
									foreach($resultat as $r){

										$id_reservation=$r->id;

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


					$data["bookings"]=$bookings;
                    			$data["timeslots"]=$this->timeslots();
                    			$data["date"]=$date;

                    			$data["msg"]=$msg;
								//$_SESSION['msg']=$msg;

                    			$data["nbTerrains"]=$nbTerrains;
                    			//$this->output->set_output(base_url()."reservation/book?date=".$date);
                    			$this->load->view('reservation_view',$data);
                    			redirect((base_url()."reservation/book?date=".$date.'&inf=1'));


					}



					}


			 }

			$data["bookings"]=$bookings;
			$data["timeslots"]=$this->timeslots();
			$data["date"]=$date;

			$data["msg"]=$msg;
			//$_SESSION['msg']=$msg;

			$data["nbTerrains"]=$nbTerrains;
			$this->output->set_output(base_url()."reservation/book?date=".$date."&inf=1");
			//$this->load->view('reservation_view',$data);
			//redirect((base_url()."reservation/book?date=".$date));
			$this->load->view('reservation_view',$data);



			//header('Location: ' . $_SERVER['HTTP_REFERER']);
			echo "coucou";


         }

}
