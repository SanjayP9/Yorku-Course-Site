<?php






				ini_set('error_reporting', E_ALL);
				ini_set('display_errors', 'On');  //On or Off


				if(isset($_POST['id'])){
					$id = $_POST['id'];
				 $conn = mysqli_connect('localhost','user','password','courses');
				 $sql = "select Description from info where ID = $id;";
				 $results = mysqli_query($conn,$sql);
				 while($row = mysqli_fetch_assoc($results)){
					 

                     $description = $row['Description'];
					 ?>
					 
					 <div class="resultr card">
                    <h1></h1>
                         <h2> <?php echo $_POST['title'];?></h2>
                    <p><?php echo $description;?></p>
				</div><?php }};?>

