<!DOCTYPE html>
<html>
    
	
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
        <title>York University | Course Selection</title>
        <link rel="stylesheet" type="text/css" href="normalize.css" />
        <link rel="stylesheet" type="text/css" href="style.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Playfair+Display|Roboto" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- Steacie Hackfest -->
    </head>
    
    <body>
        <header>
		
<script type="text/javascript">
            $(document).ready(function($) {
                $('#accordioncontainer').find('.accordion').click(function(){
                    this.classList.toggle("activeaccordion");

                    //Expand or collapse this panel
                    $(this).next().slideToggle('fast');
                });
            });
        </script>
        </header>
        
        <div id="sidepanel">
            <img src="Logo_York_University.png" alt="YU">
            <h2>Course selection</h2>
			<form method ="POST" >
            <input type="text" name="input" placeholder="Search for a course"/>
			<input type ="submit"/>
			</form>
			<div id="accordioncontainer">
                <h4 class="accordion">Filters</h4>
                <div class="panel">
                    <p>EECS</p>
                    <p>ADMS</p>
                    <p>ACTG</p></div>
                </div>
            <footer>
                <small>
                    <p>Steacie Hackfest 2018 </p>
                </small>
            </footer>
        </div>
        
        <div id="container">
            <section id="content-left">
                <h2>Your results</h2>
				<?php
				ini_set('error_reporting', E_ALL);
				ini_set('display_errors', 'On');  //On or Off
				if(isset($_POST['input']))
				{
				$inp = $_POST['input'];

				
				 $conn = mysqli_connect('localhost','user','password','courses');
				 $sql = "select * from courses where Course like \"%$inp%\"";
				 $results = mysqli_query($conn,$sql);
				 while($row = mysqli_fetch_assoc($results)){
					 
					 $term = $row['Term'];
					 $course = $row['Course'];
					 $title = $row['Title'];
					 $subject = $row['Subject'];
					 ?>
					 
					 <div class="resultl card">
                    <h2><?php echo $course;?></h2>
                    <p><?php echo $title;?></p>
                </div>
					 
					 <?php
				}};
				?>
                <div class="resultl card">
                    <h2></h2>
                    <p></p>
                </div>

            </section>
            <section id="content-right">
                <h2>Preview</h2>
                <div class="resultr card">
                    <h1>EECS 1012</h1>
                    <h2>Net-centric Introduction to Computing</h2>
                    <p>This course introduces students to computing through technologies used for client-side and server-side web development. Students will be introduced to the basics of HTML, CSS, PHP, Javascript, and (tentatively) SQL. This course provides a "big picture" of how these technologies work together to realize the world wide web (WWW).</p>
                </div>
            </section>
            

        </div> <!-- div: container -->
        
    </body>
    
</html>
