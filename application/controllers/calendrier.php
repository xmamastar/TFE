<?php
session_start();
class Calendrier extends CI_Controller
{
	function calendar(){

			$data=array();
			$dateComponents=getdate();
			if(isset($_GET["month"])){
				$month=$_GET["month"];
				if(isset($_GET["year"])){
					$year=$_GET["year"];

				}
				else{

					$year=$dateComponents['year'];
				}

			}
			else{

				$month=$dateComponents['mon'];
				if(isset($_GET["year"])){
					$year=$_GET["year"];

				}
				else{

					$year=$dateComponents['year'];
				}
			}

			$data["calendar"]=$this->build_calendar($month,$year);
			$this->load->view('calendrier_view',$data);


		}
	function build_calendar($month,$year){


    	//Créer une liste avec tous les jours de la semaine
        $daysOfWeek= array('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche');

        //On récupère le premier jour du mois en question
        $firstDayOfMonth= mktime(0,0,0,$month,1,$year);

        //On récupère le nombre de jour que le mois contient
        $numberDays=date('t',$firstDayOfMonth);

        //On cherche à savoir des infos sur le premier jour du mois
        $dateComponents=getdate($firstDayOfMonth);

        //On recherche le nom du mois
        $monthName= $dateComponents['month'];

        $dayOfWeek=$dateComponents['wday'];

        //getting the current day
        $dateToday=date('Y-m-d');

        if($dayOfWeek==0){
          $dayOfWeek=6;
        }
        else{
          $dayOfWeek=$dayOfWeek-1;
        }

        //Now creating the html table
        $calendar="<table class='table table-bordered'>";
        $calendar.="<center><h2>$monthName $year </h2>";
        $calendar.="<a class='btn btn-xs btn-primary' href='?month=".date('m',mktime(0,0,0,$month-1,1,$year))."&year=".date('Y',mktime(0,0,0,$month-1,1,$year))."'>Previous Month </a>";

        $calendar.="<a class='btn btn-xs btn-primary' href='?month=".date('m')."&year=".date('Y')."'>Current Month </a>";

        $calendar.="<a class='btn btn-xs btn-primary' href= '?month=".date('m',mktime(0,0,0,$month+1,1,$year))."&year=".date('Y',mktime(0,0,0,$month+1,1,$year))."'>Next Month </a></center><br>";

        $calendar.="<tr>";

        //Creating the calendar header
        foreach ($daysOfWeek as $day) {

        	$calendar.="<th class='header'>$day</th>";

        }

        $calendar.="</tr><tr>";
        if($dayOfWeek>0){

        	for($k=0;$k<$dayOfWeek;$k++){

        		$calendar.="<td></td>";
        	}
        }
        $currentDay=1;

        //remplit la chaine $month avec un 0 par la gauche pour les 9 premiers mois
        $month=str_pad($month,2,"0",STR_PAD_LEFT);

        while($currentDay<=$numberDays){

        	if($dayOfWeek==7){
        		$dayOfWeek=0;
        		$calendar.="</tr><tr>";
        	}

            //pareil que pour le mois
        	$currentDayRel=str_pad($currentDay,2,"0",STR_PAD_LEFT);
        	$date="$year-$month-$currentDayRel";

            $dayname=strtolower(date('I',strtotime($date)));
            $eventNum=0;

            $today=$date==date("Y-m-d")?"today":"";

            if($date<date("Y-m-d")){

                $calendar.="<td><h4>$currentDay</h4><button class='btn btn-danger btn-xs'>N/A</button>";
            }
            /*elseif(in_array($date,$bookings)){

                $calendar.="<td class='$today'><h4>$currentDay</h4><button class='btn btn-danger btn-xs'>Already booked </button>";

            }*/
            else{
              $totalBookings=$this->checkSlots($date);
              $all_booked=7*28;

              if($totalBookings==$all_booked){
                $calendar.="<td class=$today><h4>$currentDay</h4> <a href='#'class='btn btn-danger btn-xs'>AllBooked</a>";
              }
              if($this->check_date($date)==false){
              	$calendar.="<td class=$today><h4>$currentDay</h4> <a href='#'class='btn btn-danger btn-xs'>N/A</a>";
              }
              else{
				$url=base_url()."reservation/book";
				//var_dump($date);
				$date2=str_replace('-', "/", $date);
                $calendar.="<td class=$today><h4>$currentDay</h4> <a href='".$url."?date=".$date2."'class='btn btn-success btn-xs'>Book</a>";
              }


            }


        	$calendar.="</td>";

        	$currentDay++;
        	$dayOfWeek++;



        }

        if($dayOfWeek !=7){

        	$remainingDays=7-$dayOfWeek;
        	for($i=0;$i<$remainingDays;$i++){
        		$calendar.="<td></td>";
        	}
        }

        $calendar.="</tr>";
        $calendar.="</table>";

        return $calendar;





    }
    public function check_date($date){
    	//var_dump($date);
    	$is_ok=false;
		$today=date('Y/m/d');
		$jour2 = str_replace('-', "", $date);
        $jour2=intval($jour2);

        $jour_max=date('Y/m/d',strtotime($today.'+ 1 months'));
		$jour_max = str_replace('/', "", $jour_max);
		$jour_max=intval($jour_max);
		if($jour2>$jour_max){
			$is_ok=false;
		}
		else{
			$is_ok=true;
		}
		return $is_ok;

    }

    function checkSlots($date){
    	$this->load->model('reservation_model', 'reservation');
		$resultat=$this->reservation->get_element_by_date($date);

  		$totalBookings=0;
  		if ($resultat!=null){
  			foreach($resultat as $r){
             	$totalBookings++;
       		}
  		}


  	return $totalBookings;
	}


}
