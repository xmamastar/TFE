<?php
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\"?>\n";
session_start();
echo "<exemple>\n";
$id_client1=$_GET['id_client'];
$num_terrain=$_GET['terrain'];
$id_reservation=$_GET['idReserv'];
$id_reservation1=intval($id_reservation);
#$id_client = preg_replace('/_+/',' ',$id_client);
$id_client=intval($id_client1);
$mysqli= new mysqli('localhost','root','bdTennisTFE','TFE');
$stmt=$mysqli->prepare("SELECT * FROM Bookings WHERE id=? ");
$stmt->bind_param('s',$id_reservation1);
if ($stmt->execute()){
    $result=$stmt->get_result();
    if($result->num_rows>0){
        while($row =$result->fetch_assoc()){
          echo "<id>".$id_client1."</id>";
          echo "<nom>".$row['name']."</nom>";
          $mail_joueur=$row['email'];
          echo "<prenom>".$row['email']."</prenom>";
          

        }
        $stmt->close();
    }


}

echo "<terrain>".$num_terrain."</terrain>";
echo "<id_reservation>".$id_reservation."</id_reservation>";
#$_SESSION['id_cli']="";
echo "</exemple>";







?>
