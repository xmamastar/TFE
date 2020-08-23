<?php
function build_calendar($month,$year){

    $mysqli= new mysqli('localhost','root','tfe1234','bookings');
    /*$stmt=$mysqli->prepare("SELECT * FROM bookings WHERE MONTH(date)=? AND YEAR(date)=?");
    $stmt->bind_param('ss',$month,$year);
    $bookings=array();
    if ($stmt->execute()){
        $result=$stmt->get_result();
        if($result->num_rows>0){
            while($row =$result->fetch_assoc()){
                $bookings[]=$row['date'];
            }
            $stmt->close();
        }
    */



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
          $totalBookings=checkSlots($mysqli,$date);
          if($totalBookings==2){
            $calendar.="<td class=$today><h4>$currentDay</h4> <a href='#'class='btn btn-danger btn-xs'>AllBooked</a>";
          }
          else{

            $calendar.="<td class=$today><h4>$currentDay</h4> <a href='book.php?date=".$date."'class='btn btn-success btn-xs'>Book</a>";
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

    echo $calendar;





}

function checkSlots($mysqli,$date){

  $stmt=$mysqli->prepare("SELECT * FROM bookings WHERE date=?");
  $stmt->bind_param('s',$date);
  $totalBookings=0;
  if ($stmt->execute()){
      $result=$stmt->get_result();
      if($result->num_rows>0){
          while($row =$result->fetch_assoc()){
              $totalBookings++;
          }
          $stmt->close();
      }
  }
  return $totalBookings;
}
?>

<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

	<title>Test</title>
	<style>
		table{
			table-layout: fixed;

		}
		td{

			width:33%;
		}
		.today{
			background: yellow;
		}
	</style>
</head>
<?php include "menu.php"; ?>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php
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


					echo build_calendar($month,$year);

				?>
			</div>
		</div>
	</div>


</body>
</html>
