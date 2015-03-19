<?php
/*
$db = new PDO('mysql:host=localhost:3306;dbname=travel;charset=utf8', 'root', 'mysql');

foreach($db->query('SELECT * FROM person') as $row) {
    echo "id: " . $row["personid"]. " - Name: " . $row["name"]. " " . $row["jobtitle"]. "<br>"; //etc...
}

$db= CloseConnection ($db);

foreach($db->query('SELECT * FROM person') as $row) {
    echo "id: " . $row["personid"]. " - Name: " . $row["name"]. " " . $row["jobtitle"]. "<br>"; //etc...
}

//$result = mysql_query("SELECT * FROM person", $db) or die(mysql_error($db));
//echo travQuery ($db)

function getData($db) {
   $stmt = $db->query("SELECT * FROM person");
   return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
*/
$TableName="Patients";
$WhereField=""; 
$WhereValue="";
$OrderField="";
$Sortql="";
$useDB = "travel";
$db=OpenConnectionAndDatabase($useDB);
//echo  var_dump ($db);
 

echo BuildAndIssueSelectStatement ( $db, $TableName, $WhereField, $WhereValue, $OrderField, $Sortql); 

			//$result = mysql_query("Select * from person");
			//echo $result;
 
Function OpenConnectionAndDatabase($useDB){
 // PDO open
 // $con = new PDO('mysql:host=localhost:3306;dbname=travel;charset=utf8', 'root', 'mysql');
        $servername = "localhost:3306";
        $username = "root";
        $password = "mysql";
       // $Database = $Database;
 //msqli_connect Create connection and check
 //   $con = mysqli_connect($servername, $username, $password , $Database);
		$con = mysql_connect($servername, $username, $password );
                if (!$con) {
                        die('Could not connect: ' . mysql_error());
                }
                        echo 'Connected successfully'. "<br>";
						mysql_select_db($useDB);
        return $con;       
 }
 
 
 Function travQuery ($conn2) {
 $sql = "SELECT * FROM person";
$result = $conn2->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["personid"]. " - Name: " . $row["name"]. " " . $row["jobtitle"]. "<br>";
    }
} else {
    echo "0 results";
}
 
 }
 
                         
Function CloseConnection ($conn2){

 if (mysql_close($conn2)) 
 { echo " closed "; 
  } else 
  echo " still open" ;
  //$db=null;
  //return $db;
}                        
 
Function BuildAndIssueSelectStatement ($db, $TableName, $WhereField, $WhereValue, $OrderField, $Sortql){
//mysql_select_db("travel", $db);
		$Query= "Select * FROM $TableName";
			if ($WhereField != null && $WhereField != "" ) { 
					if (is_string ($WhereValue)) { 
							$WhereValue = "'$WhereValue'";
							$Query .= " WHERE " . $WhereField . " = " . $WhereValue ;
					}
			}	 
	
			if 	($OrderField != null && $OrderField != "" ){
	
				$Query .= " ORDER BY " . $OrderField . " " . $Sortql;
			} 
	  
			//$sql = $Query;
			//$result = $db->query($Query);
			//mysql_query( "use $Database");
			$result = mysql_query( $Query);
			var_dump($result);
			return $result;
			//while($row = mysql_fetch_assoc($result)){
			 //echo $result;
			
			//}
			
			//----------works ish
			/*
			$num_rows = mysql_num_rows($result);
			$num_fields = mysql_num_fields($result);
			if ($num_rows > 0) {
					// output data of each row
				while($row = mysql_fetch_row($result)) {
						for ($i = 0; $i <= $num_fields-1; $i++) {
								echo $row[$i]." ";
							}
					echo "<br>";
				}
			} else { 
					echo "0 results";
				} */
		
}
                   
Function CreateTable ($TableName, $FieldNames, $DataTypes, $Sizes, $Decimal){

	mysql_query("DROP TABLE IF EXISTS " .$TableName) or die(mysql_error());
  
			$CreateQuery= "Create Table $TableName";
			for($i = 0, $l = count($FieldNames); $i < $l; $i++) {
			
			$CreateQuery.= $FieldNames[$i] . " " .$DataTypes[$i];  
				if ($DataTypes[$i]== "varchar" ){
					$CreateQuery.= "(" . $Sizes[$i] . ")";
				}else if ($DataTypes[$i]== "decimal"){
					$CreateQuery.= "(" . $Sizes[$i] . $Decimal[$i]")";
				}
			    if ( $i < $l){
					$CreateQuery.= ",";
				}
			} 
			
	return mysql_query($CreateQuery);
}

Function InsertIntoTable ($TableName, $Values, $DataTypes){


			$AddRecord= "INSERT INTO " .  $TableName ." values ("  ;
			for($i = 0, $l = count( $Values); $i < $l; $i++) {
								
				if ($DataTypes[$i] == "varchar" || $DataTypes[$i] == "date"){
						$AddRecord .= "'". $Values[$i] . "'"; 
				}		
				else if ($DataTypes[$i] == null){
				  $AddRecord .= "'0'";
				}
				else { $AddRecord .= "'". $Values[$i] . "'"; }
				
				if ($DataTypes[$i] <$l-1){
						$AddRecord .= ",";
				}else { $AddRecord .= ")";}
			} 
			
	return mysql_query($AddRecord);
}
		
function GetOneRow($result) 
{
	$row = mysql_fetch_array($result);
		
	return $row;
} 		
				   
				   ?>