<?php

$TableName="patients";
$TableName2="Patients2";
$WhereField="Name"; 
$WhereValue="Charlie Epps";
$OrderField="";
$Sortql="";
$isClsed="is DB closed : ";

$servername = "";
$username = "";
$password = "";
$useDB = $username;
	
// Arrays

$FieldNames = array ('name','number','age','DEC_Bav');
$DataTypes = array ('varchar','varchar','int','decimal');
$Sizes =	array (25,25,3,3);
$Decimal =	array (null,null,null,2);
$Values = array ('bob','555-1234',25,3.14);	
	
	
		
$db = OpenConnectionAndDatabase($servername, $username, $password, $useDB);
//CreateTable ( $TableName2, $FieldNames, $DataTypes, $Sizes, $Decimal);
//InsertIntoTable ($TableName2, $Values, $DataTypes);

$test = BuildAndIssueSelectStatement ( $TableName, $WhereField, $WhereValue, $OrderField, $Sortql);
//echo $test;
echo "<br>";
$row = GetOneRow($test);

echo $row["IDNum"]." ". $row["HealthCardNbr"]." ".$row["Name"]." ".$row["BirthDate"];

//patientQuery ($db , $row  );




/* echo $db . "---<br>";
//OpenConnectionAndDatabase();
patientQuery ($db);
echo '<br>';
 
echo '<br>';
echo 'testing and build issue';
echo '<br>';
testBuild ($test);
echo '<br>';


echo '<br>';
$test3 = BuildAndIssueSelectStatement ( $TableName2, $WhereField, $WhereValue, $OrderField, $Sortql);

echo $test3;
echo '<br>';
echo 'testing get one row  : <br>'; */




//$FieldNames = array ('name','number','age','DEC_Bav');

//GetOneRow($test3);

//while ($r=GetOneRow($test3)
//echo $r['name'] . " " . $r['number'] . " " . $r['age'] . " " .$r['DEC_Bav'] . " end" . ;


// echo $db . " is still open <br>";
//CloseConnection ($servername, $username, $password, $useDB);


 

Function OpenConnectionAndDatabase($servername, $username, $password , $useDB){


// Create connection and check
$conn = mysql_connect($servername, $username, $password);
		if (!$conn) {
				die('Could not connect: ' . mysql_error());
		}
		echo 'Connected successfully  to <br>';

		mysql_select_db($useDB);
 
 return $conn;
 
 }


Function patientQuery ($conn2, $result) {
 //$sql = "SELECT * FROM patients";
//$result = $conn2->query($sql);

//$result = mysql_query("SELECT * FROM Patients2") or die(mysql_error());

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
				} 
 return $result;
 
 }


 Function testBuild ($result){
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
				} 
 
 }
 
 

Function CloseConnection ($servername, $username, $password, $useDB){

$conn2=OpenConnectionAndDatabase($servername, $username, $password, $useDB);
echo " the database wanker $conn2 is ";
 if (mysql_close($conn2)) 
 { echo " closed <br>"; 
  } else 
  echo " still open" ;
  //$db=null;
  //return $db;
}                       

Function BuildAndIssueSelectStatement ( $TableName, $WhereField, $WhereValue, $OrderField, $Sortql){

		$Query= "SELECT * FROM $TableName";
			if ($WhereField != null && $WhereField != "" ) { 
					if (is_string($WhereValue)) { 
							$WhereValue = "'$WhereValue'";
							$Query .= " WHERE " . $WhereField . " = " . $WhereValue ;
					}
			}	 
	
			if 	($OrderField != null && $OrderField != "" ){
	
				$Query .= " ORDER BY " . $OrderField . " " . $Sortql;
			} 
	  
           echo $Query;
			if (mysql_query($Query)){
					$result = mysql_query($Query) or die(mysql_error());
					echo "<br>";
					echo "return result";
					return $result;
				} else{
			
						echo "build query shit the bed<br>";
					}
			
			
		
}
 

Function CreateTable ( $TableName2, $FieldNames, $DataTypes, $Sizes, $Decimal){

// where $db is the database connection

	mysql_query("DROP TABLE IF EXISTS " .$TableName2) or die(mysql_error());
  
			$CreateQuery= "CREATE TABLE $TableName2 (";
			for($i = 0, $l = count($FieldNames); $i < $l; $i++) {
			
			$CreateQuery.= $FieldNames[$i] . " " .$DataTypes[$i];  
				if ($DataTypes[$i]== "varchar" ||  $DataTypes[$i] == "int"){
					$CreateQuery .= "(" . $Sizes[$i] . ")";
				}else if ($DataTypes[$i]== "decimal"){
					//$CreateQuery .=  " ( " . $Sizes[$i] . " , " . $Decimal[$i] . " ) ";
				$CreateQuery .=   " ( " . $Sizes[$i] . " , " . $Decimal[$i]  . " ) " ;
				}

			    if ( $i+1 < $l){
					$CreateQuery.=  ",";
				}
				
				
			}

			$CreateQuery.=  ")";
		
			
	if (mysql_query($CreateQuery)) {
			echo "create suceeded";
		return mysql_query($CreateQuery);
		}else{ echo "create failed";};
} 


Function InsertIntoTable ($TableName2, $Values, $DataTypes){


			$AddRecord= "INSERT INTO " .  $TableName2 ." VALUES ("  ;
			for($i = 0, $l = count( $Values); $i < $l; $i++) {
								
				if ($DataTypes[$i] == "varchar" || $DataTypes[$i] == "date"){
						$AddRecord .= "'". $Values[$i] . "'"; 
				}		
				else if ($DataTypes[$i] == null){
				  $AddRecord .= "'0'";
				}
				else { $AddRecord .= "'". $Values[$i] . "'"; }
				
				if ($i+1 < $l){
						$AddRecord .= ",";
				}else { $AddRecord .= ")";}
			} 
			
			echo '<br>';
			echo $AddRecord;
	//return mysql_query($AddRecord);
	
	//if (mysql_query($AddRecord)) {
	 //echo "add suceeded";
	 return mysql_query($AddRecord);
	 // }else{ echo "add failed";};
	
	
}

		
Function GetOneRow($result) {

	return mysql_fetch_array($result);
	
} 		
				   
				   ?>
