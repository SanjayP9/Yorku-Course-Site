<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'On');  //On or Off
				
				
				
$conn = mysqli_connect('localhost', 'user','password','courses');

$text = file_get_contents('courseinfo.txt');

$textarray=explode("\n",$text);


$description=''; $id =''; $code='';
$i = 0;

while($i<2600){
  while(((strlen($description)<1 OR strlen($code)<1) AND $i<2600)){

     
     if(strpos($textarray[$i], '[') !== false){
		$description = str_replace('[','',$textarray[$i]);
		$description = str_replace(']','',$description);
	 $i++; continue;
	 }
	 else{
		 $code = $textarray[$i];
		 $i++;
	 }


  };
  $code = substr($code,0,12);
  $sql =  "select ID from courses where Course like \"%$code%\"  ";
   $result = mysqli_query($conn,$sql);
   
  $row = mysqli_fetch_assoc($result);
  
  $resultID = $row['ID'];
  echo $resultID."<br>";
  if(!is_null($resultID)){
  $description = mysqli_real_escape_string($conn,$description);
  $sql1 = "insert into info (Description,ID) VALUES(\"".$description."\",$resultID)";
  $result1 = mysqli_query($conn,$sql1);
  };
  echo mysqli_error($conn);
  
  $code='';$description='';
};


?>