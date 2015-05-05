<?php
//Open a new connection to the MySQL server
$mysqli = new mysqli('127.0.0.1','albafo','','menus');

//Output any connection error
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}

//MySqli Select Query
$results = $mysqli->query("SELECT * FROM temp_alergenos");


while($row = $results->fetch_object()) {
  
   $mysqli->query("INSERT into ingredientes values (".$row->id.", '".$row->ingrediente."', NOW(), NOW())");
   
   for($i=1; $i<=14; $i++) {
       $name="alerg".$i;
      
       if($row->$name>0){
            
           $mysqli->query("insert into alergeno_ingrediente (ingrediente_id, alergeno_id) values (".$row->id.", ".$row->$name.")");
       }
   }
   
}  



// close connection 
$mysqli->close();
?>