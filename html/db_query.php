<?php
				ini_set('error_reporting', E_ALL);
				ini_set('display_errors', 'On');  //On or Off
				if(isset($_POST['input']))
				{
				$inp = 'EECS 1012';

				
				 $conn = mysqli_connect('localhost','user','password','courses');
				 $sql = "select Description from info where Course like \"%$inp%\"";
				 $results = mysqli_query($conn,$sql);
				 while($row = mysqli_fetch_assoc($results)){
					 

                     $description = $row['Description'];
					 ?>
					 
					 <div class="resultr card">
                    <h1><?php echo $inp;?></h1>
                         <h2> </h2>
                    <p><?php echo $description;?></p>
                    </div>

?>